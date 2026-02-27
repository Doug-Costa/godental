<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ElasticSearchService;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;

class BuscaElasticController extends Controller
{
    protected $elastic;

    public function __construct(ElasticSearchService $elastic)
    {
        $this->elastic = $elastic;
        $this->thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
    }

    public function buscar(Request $request)
    {
        $query = trim((string)($request->input('busca', $request->input('query', $request->input('q', '')))));
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);

        if (!$query) {
            return response()->json(['error' => 'A consulta não pode estar vazia.'], 400);
        }

        try {
            // 🔍 1️⃣ Faz a busca no Elasticsearch
            $elasticService = new ElasticSearchService();
            $result = $elasticService->searchBoolean($query, $page, $size);

            // Processa os resultados para extrair apenas o conteúdo de _source
            $results = [];
            foreach ($result['hits']['hits'] as $item) {
                $article = $item['_source'];

                // 📷 2️⃣ Otimiza as imagens via Thumbor
                $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');

                $results[] = $article;
            }

            //BUSCA COLEÇÕES NO SISTEMA DO PALIARI
            $token = $this->ensureToken();
            $colecoes = [];
            if ($token) {
                $ch = curl_init('https://api.dentalgo.com.br/subscription/search/collections');
                $authorization = "Authorization: Bearer " . $token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $colecoes = json_decode($server_output) ?: [];
            }

            if (is_array($colecoes)) {
                foreach ($colecoes as $key => $value) {
                    if (!empty($value->cover)) {
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($value->cover);
                        $value->cover = $thumbor->get();
                    }
                }
            } else {
                $colecoes = [];
            }

            // 🧮 Contadores e totais a partir das agregações do Elasticsearch
            $aggs = $result['aggregations'] ?? [];
            $productTypesAgg = $aggs['productTypes']['buckets'] ?? [];
            $languagesAgg = $aggs['languages']['buckets'] ?? [];
            $collectionsAgg = $aggs['collections']['buckets'] ?? [];

            $totaisPorTipo = [
                'magazine' => 0,
                'book' => 0,
                'video' => 0,
            ];
            foreach ($productTypesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (isset($totaisPorTipo[$key])) {
                    $totaisPorTipo[$key] = $count;
                }
            }

            $idiomas = [ 'pt' => 0, 'en' => 0, 'es' => 0 ];
            foreach ($languagesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (array_key_exists($key, $idiomas)) {
                    $idiomas[$key] = $count;
                }
            }

            $colecoesCount = [];
            foreach ($collectionsAgg as $bucket) {
                $id = (int)($bucket['key'] ?? 0);
                $count = (int)($bucket['doc_count'] ?? 0);
                if ($id) {
                    $colecoesCount[$id] = $count;
                }
            }

            $contadorFelipino = (object) [
                'productTypes' => (object) $totaisPorTipo,
                'collections' => $colecoesCount,
                'languages' => (object) $idiomas,
            ];

            // 🔄 3️⃣ Retorna a view com os dados processados
            $total = (int)($result['hits']['total']['value'] ?? 0);

            // Suporte a AJAX: retorna apenas itens da aba solicitada para scroll infinito
            if ($request->ajax()) {
                $tab = (string)$request->input('tab', 'articles');
                $map = ['articles' => 'magazine', 'videos' => 'video', 'books' => 'book'];
                $productType = $map[$tab] ?? null;

                $filters = (array)$request->input('q', []);
                if ($productType) {
                    $existing = (array)($filters['productTypes'] ?? []);
                    $filters['productTypes'] = array_values(array_unique(array_merge($existing, [$productType])));
                }

                $ajaxSize = (int)$request->input('size', (int)$size);
                $ajaxPage = (int)$request->input('page', (int)$page);

                $ajaxResult = $this->elastic->searchBooleanWithFilters($query, $filters, $ajaxPage, $ajaxSize, null);

                $ajaxItems = [];
                foreach (($ajaxResult['hits']['hits'] ?? []) as $hit) {
                    $article = $hit['_source'] ?? [];
                    $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                    if (isset($article['product'])) {
                        $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                    }
                    $ajaxItems[] = $article;
                }

                $html = view('busca._result_items', ['items' => $ajaxItems])->render();
                $totalType = (int)($ajaxResult['hits']['total']['value'] ?? 0);
                $lastPageType = (int) max(1, ceil($totalType / max(1, $ajaxSize)));

                return response()->json([
                    'html' => $html,
                    'page' => $ajaxPage,
                    'lastPage' => $lastPageType,
                    'hasMore' => $ajaxPage < $lastPageType,
                ]);
            }

            return view('busca.resultado', [
                'query' => $query,
                'results' => $results,
                'buscaColecoes' => $colecoes,
                'contadorFelipino' => $contadorFelipino,
                'totaisPorTipo' => $totaisPorTipo,
                'total' => $total,
                'page' => (int)$page,
                'size' => (int)$size,
                'lastPage' => (int) max(1, ceil($total / max(1, (int)$size)))
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }









    //Buscar do facelift


    
      public function buscar25(Request $request)
    {
        $query = trim((string)($request->input('busca', $request->input('query', $request->input('q', '')))));
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);

        if (!$query) {
            return response()->json(['error' => 'A consulta não pode estar vazia.'], 400);
        }

        try {
            // 🔍 1️⃣ Faz a busca no Elasticsearch
            $elasticService = new ElasticSearchService();
            $result = $elasticService->searchBoolean($query, $page, $size);

            // Processa os resultados para extrair apenas o conteúdo de _source
            $results = [];
            foreach ($result['hits']['hits'] as $item) {
                $article = $item['_source'];

                // 📷 2️⃣ Otimiza as imagens via Thumbor
                $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');

                $results[] = $article;
            }

            //BUSCA COLEÇÕES NO SISTEMA DO PALIARI
            $token = $this->ensureToken();
            $colecoes = [];
            if ($token) {
                $ch = curl_init('https://api.dentalgo.com.br/subscription/search/collections');
                $authorization = "Authorization: Bearer " . $token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $colecoes = json_decode($server_output) ?: [];
            }

            if (is_array($colecoes)) {
                foreach ($colecoes as $key => $value) {
                    if (!empty($value->cover)) {
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($value->cover);
                        $value->cover = $thumbor->get();
                    }
                }
            } else {
                $colecoes = [];
            }

            // 🧮 Contadores e totais a partir das agregações do Elasticsearch
            $aggs = $result['aggregations'] ?? [];
            $productTypesAgg = $aggs['productTypes']['buckets'] ?? [];
            $languagesAgg = $aggs['languages']['buckets'] ?? [];
            $collectionsAgg = $aggs['collections']['buckets'] ?? [];

            $totaisPorTipo = [
                'magazine' => 0,
                'book' => 0,
                'video' => 0,
            ];
            foreach ($productTypesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (isset($totaisPorTipo[$key])) {
                    $totaisPorTipo[$key] = $count;
                }
            }

            $idiomas = [ 'pt' => 0, 'en' => 0, 'es' => 0 ];
            foreach ($languagesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (array_key_exists($key, $idiomas)) {
                    $idiomas[$key] = $count;
                }
            }

            $colecoesCount = [];
            foreach ($collectionsAgg as $bucket) {
                $id = (int)($bucket['key'] ?? 0);
                $count = (int)($bucket['doc_count'] ?? 0);
                if ($id) {
                    $colecoesCount[$id] = $count;
                }
            }

            $contadorFelipino = (object) [
                'productTypes' => (object) $totaisPorTipo,
                'collections' => $colecoesCount,
                'languages' => (object) $idiomas,
            ];

            // 🔄 3️⃣ Retorna a view com os dados processados
            $total = (int)($result['hits']['total']['value'] ?? 0);

            // Suporte a AJAX: retorna apenas itens da aba solicitada para scroll infinito
            if ($request->ajax()) {
                $tab = (string)$request->input('tab', 'articles');
                $map = ['articles' => 'magazine', 'videos' => 'video', 'books' => 'book'];
                $productType = $map[$tab] ?? null;

                $filters = (array)$request->input('q', []);
                if ($productType) {
                    $existing = (array)($filters['productTypes'] ?? []);
                    $filters['productTypes'] = array_values(array_unique(array_merge($existing, [$productType])));
                }

                $ajaxSize = (int)$request->input('size', (int)$size);
                $ajaxPage = (int)$request->input('page', (int)$page);

                $ajaxResult = $this->elastic->searchBooleanWithFilters($query, $filters, $ajaxPage, $ajaxSize, null);

                $ajaxItems = [];
                foreach (($ajaxResult['hits']['hits'] ?? []) as $hit) {
                    $article = $hit['_source'] ?? [];
                    $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                    if (isset($article['product'])) {
                        $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                    }
                    $ajaxItems[] = $article;
                }

                $html = view('facelift2.busca._result_items', ['items' => $ajaxItems])->render();
                $totalType = (int)($ajaxResult['hits']['total']['value'] ?? 0);
                $lastPageType = (int) max(1, ceil($totalType / max(1, $ajaxSize)));

                return response()->json([
                    'html' => $html,
                    'page' => $ajaxPage,
                    'lastPage' => $lastPageType,
                    'hasMore' => $ajaxPage < $lastPageType,
                ]);
            }

            return view('facelift2.busca.resultado', [
                'query' => $query,
                'results' => $results,
                'buscaColecoes' => $colecoes,
                'contadorFelipino' => $contadorFelipino,
                'totaisPorTipo' => $totaisPorTipo,
                'total' => $total,
                'page' => (int)$page,
                'size' => (int)$size,
                'lastPage' => (int) max(1, ceil($total / max(1, (int)$size)))
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }













    // NOVO: Busca com filtros aplicados no Elasticsearch
    public function buscarFiltrada(Request $request)
    {
        $query = trim((string)($request->input('busca', $request->input('query', $request->input('q', '')))));
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);
        $publishOrder = $request->input('publishOrder'); // '', 'asc', 'desc'
        $filters = (array)$request->input('q', []);

        if ($query === '') {
            return response()->json(['error' => 'A consulta não pode estar vazia.'], 400);
        }

        try {
            // 1) Resultados filtrados para exibição
            $result = $this->elastic->searchBooleanWithFilters($query, $filters, $page, $size, $publishOrder);

            // 2) Agregações globais SEM filtros para contadores
            $resultGlobal = $this->elastic->searchBoolean($query, 1, 0); // size=0: queremos só as agregações

            $results = [];
            foreach (($result['hits']['hits'] ?? []) as $item) {
                $article = $item['_source'] ?? [];
                $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                if (isset($article['product'])) {
                    $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                }
                $results[] = $article;
            }

            // Coleções (via API DentalGO)
            $token = $this->ensureToken();
            $colecoes = [];
            if ($token) {
                $ch = curl_init('https://api.dentalgo.com.br/subscription/search/collections');
                $authorization = "Authorization: Bearer " . $token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $colecoes = json_decode($server_output) ?: [];
            }

            if (is_array($colecoes)) {
                foreach ($colecoes as $key => $value) {
                    if (!empty($value->cover)) {
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($value->cover);
                        $value->cover = $thumbor->get();
                    }
                }
            } else {
                $colecoes = [];
            }

            // Contadores: usar agregações do resultado GLOBAL (sem filtros)
            $aggsGlobal = $resultGlobal['aggregations'] ?? [];
            $productTypesAgg = $aggsGlobal['productTypes']['buckets'] ?? [];
            $languagesAgg = $aggsGlobal['languages']['buckets'] ?? [];
            $collectionsAgg = $aggsGlobal['collections']['buckets'] ?? [];

            $totaisPorTipo = [ 'magazine' => 0, 'book' => 0, 'video' => 0 ];
            foreach ($productTypesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (isset($totaisPorTipo[$key])) { $totaisPorTipo[$key] = $count; }
            }

            $idiomas = [ 'pt' => 0, 'en' => 0, 'es' => 0 ];
            foreach ($languagesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (array_key_exists($key, $idiomas)) { $idiomas[$key] = $count; }
            }

            $colecoesCount = [];
            foreach ($collectionsAgg as $bucket) {
                $id = (int)($bucket['key'] ?? 0);
                $count = (int)($bucket['doc_count'] ?? 0);
                if ($id) { $colecoesCount[$id] = $count; }
            }

            $contadorFelipino = (object) [
                'productTypes' => (object) $totaisPorTipo,
                'collections' => $colecoesCount,
                'languages' => (object) $idiomas,
            ];

            $total = (int)($result['hits']['total']['value'] ?? 0);

            // Suporte a AJAX: retorna apenas itens da aba solicitada para scroll infinito
            if ($request->ajax()) {
                $tab = (string)$request->input('tab', 'articles');
                $map = ['articles' => 'magazine', 'videos' => 'video', 'books' => 'book'];
                $productType = $map[$tab] ?? null;

                $filtersAjax = (array)$request->input('q', []);
                if ($productType) {
                    $existing = (array)($filtersAjax['productTypes'] ?? []);
                    $filtersAjax['productTypes'] = array_values(array_unique(array_merge($existing, [$productType])));
                }

                $ajaxSize = (int)$request->input('size', (int)$size);
                $ajaxPage = (int)$request->input('page', (int)$page);
                $publishOrderAjax = $request->input('publishOrder');

                $ajaxResult = $this->elastic->searchBooleanWithFilters($query, $filtersAjax, $ajaxPage, $ajaxSize, $publishOrderAjax);

                $ajaxItems = [];
                foreach (($ajaxResult['hits']['hits'] ?? []) as $hit) {
                    $article = $hit['_source'] ?? [];
                    $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                    if (isset($article['product'])) {
                        $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                    }
                    $ajaxItems[] = $article;
                }

                $html = view('busca._result_items', ['items' => $ajaxItems])->render();
                $totalType = (int)($ajaxResult['hits']['total']['value'] ?? 0);
                $lastPageType = (int) max(1, ceil($totalType / max(1, $ajaxSize)));

                return response()->json([
                    'html' => $html,
                    'page' => $ajaxPage,
                    'lastPage' => $lastPageType,
                    'hasMore' => $ajaxPage < $lastPageType,
                ]);
            }

            return view('busca.resultado', [
                'query' => $query,
                'results' => $results,
                'buscaColecoes' => $colecoes,
                'contadorFelipino' => $contadorFelipino,
                'totaisPorTipo' => $totaisPorTipo,
                'total' => $total,
                'page' => (int)$page,
                'size' => (int)$size,
                'lastPage' => (int) max(1, ceil($total / max(1, (int)$size)))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }








    //busca filtrada do facelift


    public function buscarFiltrada25(Request $request)
    {
        $query = trim((string)($request->input('busca', $request->input('query', $request->input('q', '')))));
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);
        $publishOrder = $request->input('publishOrder'); // '', 'asc', 'desc'
        $filters = (array)$request->input('q', []);

        if ($query === '') {
            return response()->json(['error' => 'A consulta não pode estar vazia.'], 400);
        }

        try {
            // 1) Resultados filtrados para exibição
            $result = $this->elastic->searchBooleanWithFilters($query, $filters, $page, $size, $publishOrder);

            // 2) Agregações globais SEM filtros para contadores
            $resultGlobal = $this->elastic->searchBoolean($query, 1, 0); // size=0: queremos só as agregações

            $results = [];
            foreach (($result['hits']['hits'] ?? []) as $item) {
                $article = $item['_source'] ?? [];
                $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                if (isset($article['product'])) {
                    $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                }
                $results[] = $article;
            }

            // Coleções (via API DentalGO)
            $token = $this->ensureToken();
            $colecoes = [];
            if ($token) {
                $ch = curl_init('https://api.dentalgo.com.br/subscription/search/collections');
                $authorization = "Authorization: Bearer " . $token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $colecoes = json_decode($server_output) ?: [];
            }

            if (is_array($colecoes)) {
                foreach ($colecoes as $key => $value) {
                    if (!empty($value->cover)) {
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($value->cover);
                        $value->cover = $thumbor->get();
                    }
                }
            } else {
                $colecoes = [];
            }

            // Contadores: usar agregações do resultado GLOBAL (sem filtros)
            $aggsGlobal = $resultGlobal['aggregations'] ?? [];
            $productTypesAgg = $aggsGlobal['productTypes']['buckets'] ?? [];
            $languagesAgg = $aggsGlobal['languages']['buckets'] ?? [];
            $collectionsAgg = $aggsGlobal['collections']['buckets'] ?? [];

            $totaisPorTipo = [ 'magazine' => 0, 'book' => 0, 'video' => 0 ];
            foreach ($productTypesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (isset($totaisPorTipo[$key])) { $totaisPorTipo[$key] = $count; }
            }

            $idiomas = [ 'pt' => 0, 'en' => 0, 'es' => 0 ];
            foreach ($languagesAgg as $bucket) {
                $key = $bucket['key'] ?? '';
                $count = (int)($bucket['doc_count'] ?? 0);
                if (array_key_exists($key, $idiomas)) { $idiomas[$key] = $count; }
            }

            $colecoesCount = [];
            foreach ($collectionsAgg as $bucket) {
                $id = (int)($bucket['key'] ?? 0);
                $count = (int)($bucket['doc_count'] ?? 0);
                if ($id) { $colecoesCount[$id] = $count; }
            }

            $contadorFelipino = (object) [
                'productTypes' => (object) $totaisPorTipo,
                'collections' => $colecoesCount,
                'languages' => (object) $idiomas,
            ];

            $total = (int)($result['hits']['total']['value'] ?? 0);

            // Suporte a AJAX: retorna apenas itens da aba solicitada para scroll infinito
            if ($request->ajax()) {
                $tab = (string)$request->input('tab', 'articles');
                $map = ['articles' => 'magazine', 'videos' => 'video', 'books' => 'book'];
                $productType = $map[$tab] ?? null;

                $filtersAjax = (array)$request->input('q', []);
                if ($productType) {
                    $existing = (array)($filtersAjax['productTypes'] ?? []);
                    $filtersAjax['productTypes'] = array_values(array_unique(array_merge($existing, [$productType])));
                }

                $ajaxSize = (int)$request->input('size', (int)$size);
                $ajaxPage = (int)$request->input('page', (int)$page);
                $publishOrderAjax = $request->input('publishOrder');

                $ajaxResult = $this->elastic->searchBooleanWithFilters($query, $filtersAjax, $ajaxPage, $ajaxSize, $publishOrderAjax);

                $ajaxItems = [];
                foreach (($ajaxResult['hits']['hits'] ?? []) as $hit) {
                    $article = $hit['_source'] ?? [];
                    $article['cover'] = $this->getOptimizedImage($article['cover'] ?? '');
                    if (isset($article['product'])) {
                        $article['product']['cover'] = $this->getOptimizedImage($article['product']['cover'] ?? '');
                    }
                    $ajaxItems[] = $article;
                }

                $html = view('facelift2.busca._result_items', ['items' => $ajaxItems])->render();
                $totalType = (int)($ajaxResult['hits']['total']['value'] ?? 0);
                $lastPageType = (int) max(1, ceil($totalType / max(1, $ajaxSize)));

                return response()->json([
                    'html' => $html,
                    'page' => $ajaxPage,
                    'lastPage' => $lastPageType,
                    'hasMore' => $ajaxPage < $lastPageType,
                ]);
            }

            return view('facelift2.busca.resultado', [
                'query' => $query,
                'results' => $results,
                'buscaColecoes' => $colecoes,
                'contadorFelipino' => $contadorFelipino,
                'totaisPorTipo' => $totaisPorTipo,
                'total' => $total,
                'page' => (int)$page,
                'size' => (int)$size,
                'lastPage' => (int) max(1, ceil($total / max(1, (int)$size)))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }








    /**
     * 🔄 Função para otimizar imagens com o Thumbor
     */
    private function getOptimizedImage($imageUrl)
    {
        if (!empty($imageUrl)) {
            $this->thumbor->resize(Resize::ORIG, 450);
            $this->thumbor->fit(Fit::FIT_IN);
            $this->thumbor->imageUrl($imageUrl);
            return $this->thumbor->get();
        }
        return $imageUrl; // Se não houver imagem, mantém o original
    }

    // Garante que o tokenGlobal exista, tentando inicializar via PagesController quando ausente
    private function ensureToken()
    {
        $token = Cache::get('tokenGlobal');
        if (!empty($token)) {
            return $token;
        }

        try {
            if (class_exists(\App\Http\Controllers\PagesController::class)) {
                $pages = app(\App\Http\Controllers\PagesController::class);
                if (method_exists($pages, 'initializeToken')) {
                    $pages->initializeToken();
                } elseif (method_exists($pages, 'initToken')) {
                    $pages->initToken();
                } elseif (method_exists($pages, 'index')) {
                    // Tenta chamar index para acionar a inicialização do token
                    $pages->index(request());
                }
            }
        } catch (\Throwable $e) {
            // Ignora erros e retorna null se não conseguir obter o token
        }

        return Cache::get('tokenGlobal');
    }

}