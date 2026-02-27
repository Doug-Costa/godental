@extends('layouts.master')

@section('content')
<style>
  /* Sticky filter em desktop */
  @media (min-width: 992px){
    .filter-sticky{ position: sticky; top: 90px; z-index: 2; }
  }
  /* Ocultar paginação tradicional quando infinite ativo */
  .dg-infinite-pagination{ display: none !important; }
</style>
<div class="container" style="margin-top:125px;">
    <h2>Resultados para: "{{ $query }}"</h2>

    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @php
        $resultsArray = is_array($results ?? null) ? $results : [];
        // Separar os resultados por tipo de produto (para exibição em abas)
        $articles = [];
        $videos = [];
        $books = [];

        foreach ($resultsArray as $item) {
            $type = $item['product']['productType'] ?? 'article'; // Padrão para 'article'
            
            if ($type === 'magazine') {
                $articles[] = $item;
            } elseif ($type === 'video') {
                $videos[] = $item;
            } elseif ($type === 'book') {
                $books[] = $item;
            }
        }

        // Totais globais via agregações (fallback seguro)
        $totaisTipos = isset($totaisPorTipo) ? $totaisPorTipo : [
            'magazine' => $contadorFelipino->productTypes->magazine ?? count($articles),
            'video' => $contadorFelipino->productTypes->video ?? count($videos),
            'book' => $contadorFelipino->productTypes->book ?? count($books),
        ];
    @endphp
    <div class="row">
        <div class="col-sm-3 filter-sticky" style="position: relative !important;">
            <form action="{{ route('busca-elastic-filtrada') }}" method="GET" enctype="multipart/form-data">
                <div class="form-group mb-4">
                    <label for="busca">Search:</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" style="width: 70%;" id="busca" name="busca" placeholder="Buscar" value="{{ request()->input('busca', $query) }}" autocomplete="off">
                        <button type="submit" id="search-submit" class="btn btn-primary ms-2">
                            Pesquisar
                        </button>
                    </div>
                    <input type="hidden" name="size" value="{{ (int)($size ?? 10) }}">
                </div>

                <!-- Resumo de totais -->
                <div class="mb-3 small text-muted">
                    <span class="me-3">📄 {{ number_format($totaisTipos['magazine'] ?? 0, 0, ',', '.') }} Artigos</span>
                    <span class="me-3">🎥 {{ number_format($totaisTipos['video'] ?? 0, 0, ',', '.') }} Vídeos</span>
                    <span>📚 {{ number_format($totaisTipos['book'] ?? 0, 0, ',', '.') }} Livros</span>
                </div>

                <button class="btn btn-primary d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filtroMobile" aria-expanded="false" aria-controls="filtroMobile" style="margin-bottom:15px;">
                    Filtros <span class="fas fa-filter"></span>
                </button>

                <div class="collapse d-md-block" id="filtroMobile">
                    <button type="submit" class="btn btn-primary w-100 mb-3">Filtrar</button>

                    <!-- Ordem -->
                    <div class="form-group">
                        <label class="fw-bold">Ordem:</label>
                        <div>
                            <label><input type="radio" name="publishOrder" value="" {{ request('publishOrder') == '' ? 'checked' : '' }}> Mais relevantes primeiro</label><br>
                            <label><input type="radio" name="publishOrder" value="desc" {{ request('publishOrder') == 'desc' ? 'checked' : '' }}> Mais recentes primeiro</label><br>
                            <label><input type="radio" name="publishOrder" value="asc" {{ request('publishOrder') == 'asc' ? 'checked' : '' }}> Mais antigos primeiro</label>
                        </div>
                        <hr>
                    </div>

                    <!-- Tipo de Produto -->
                    <div class="form-group">
                        <label class="fw-bold">Buscar Por:</label><br>
                        @foreach(['magazine' => 'Revistas', 'book' => 'Capítulos de livros', 'video' => 'Vídeos'] as $type => $label)
                            @php $count = $contadorFelipino->productTypes->$type ?? 0; @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="{{ $type }}" name="q[productTypes][]" value="{{ $type }}" {{ in_array($type, (array) request()->input('q.productTypes', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $type }}">{{ $label }} ({{ $count }})</label>
                            </div>
                        @endforeach
                        <hr>
                    </div>

                    <!-- Coleções (somente via API) -->
                    <div class="form-group">
                        <label class="fw-bold">Coleções (Revistas):</label><br>
                        @php
                            // Somente usar a lista retornada pela API; ignorar fallbacks de agregações
                            $collectionsCounter = $contadorFelipino->collections ?? [];
                            if (is_object($collectionsCounter)) { $collectionsCounter = (array)$collectionsCounter; }
                            $selectedCollectionIds = (array) request()->input('q.collectionIds', []);
                            $hasSelection = count($selectedCollectionIds) > 0;
                            $renderedAny = false;
                        @endphp
                        @if(isset($buscaColecoes) && is_iterable($buscaColecoes))
                            @foreach ($buscaColecoes as $colecao)
                                @php
                                    $id = is_object($colecao) ? ($colecao->id ?? null) : (is_array($colecao) ? ($colecao['id'] ?? null) : null);
                                    $title = is_object($colecao) ? ($colecao->title ?? null) : (is_array($colecao) ? ($colecao['title'] ?? null) : null);
                                    if (!$id || !$title) { continue; }
                                    $quantidade = $collectionsCounter[$id] ?? 0;
                                    $isChecked = $hasSelection ? in_array($id, $selectedCollectionIds) : ($quantidade > 0);
                                    $renderedAny = true;
                                @endphp
                                <div class="form-check mb-2" style="border-bottom: 1px dashed #b3b3b3;">
                                    <input class="form-check-input" type="checkbox" id="colecao{{ $id }}" name="q[collectionIds][]" value="{{ $id }}" {{ $isChecked ? 'checked' : '' }}>
                                    <label class="form-check-label" for="colecao{{ $id }}">{{ $title }} ({{ $quantidade }})</label>
                                </div>
                            @endforeach
                        @endif
                        @if(!$renderedAny)
                            <div class="text-muted small">Nenhuma coletânea encontrada pela API.</div>
                        @endif
                        <hr>
                    </div>

                    <!-- Idiomas -->
                    <div class="form-group mb-3">
                        <label class="fw-bold">Idiomas:</label>
                        @foreach(['en' => 'Inglês', 'es' => 'Espanhol', 'pt' => 'Português'] as $lang => $label)
                            @php $countLang = $contadorFelipino->languages->$lang ?? 0; @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="language{{ ucfirst($lang) }}" name="q[languages][]" value="{{ $lang }}" {{ in_array($lang, (array) request()->input('q.languages', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="language{{ ucfirst($lang) }}">{{ $label }} ({{ $countLang }})</label>
                            </div>
                        @endforeach
                        <hr>
                    </div>
                </div>
            </form>
    </div>

    <div class="col-sm-9">
        <!-- Navegação das abas -->
        <ul class="nav nav-tabs" id="resultTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="true" data-total="{{ (int)($totaisTipos['magazine'] ?? count($articles)) }}">📄 {{ $totaisTipos['magazine'] ?? count($articles) }} Artigos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false" data-total="{{ (int)($totaisTipos['video'] ?? count($videos)) }}">🎥 {{ $totaisTipos['video'] ?? count($videos) }} Vídeos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="books-tab" data-bs-toggle="tab" data-bs-target="#books" type="button" role="tab" aria-controls="books" aria-selected="false" data-total="{{ (int)($totaisTipos['book'] ?? count($books)) }}">📚 {{ $totaisTipos['book'] ?? count($books) }} Livros</button>
            </li>
        </ul>

        <!-- Conteúdo das abas -->
        <div class="tab-content mt-3" id="resultTabsContent" data-size="{{ (int)($size ?? 10) }}">
            <div class="tab-pane fade show active" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                @if(count($articles) === 0)
                    <div class="alert alert-warning">Nenhum resultado encontrado.</div>
                @endif
                @foreach($articles as $item)
                    @include('partials.result_item', ['item' => $item])
                @endforeach
            </div>
            <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                @foreach($videos as $item)
                    @include('partials.result_item', ['item' => $item])
                @endforeach
            </div>
            <div class="tab-pane fade" id="books" role="tabpanel" aria-labelledby="books-tab">
                @foreach($books as $item)
                    @include('partials.result_item', ['item' => $item])
                @endforeach
            </div>
        </div>
    </div>
</div>

    @if(isset($total) && $total > 0)
    <div class="row mt-3 dg-infinite-pagination">
        <div class="col-sm-12 d-flex justify-content-between align-items-center">
            <div>
                Mostrando página {{ $page ?? 1 }} de {{ $lastPage ?? 1 }} — {{ $total }} resultados
            </div>
            <div class="btn-group" role="group" aria-label="Paginação">
                @php
                    $currentPage = (int)($page ?? 1);
                    $prevPage = max(1, $currentPage - 1);
                    $nextPage = min((int)($lastPage ?? 1), $currentPage + 1);
                    $baseParams = request()->all();
                    $baseParams['page'] = $prevPage;
                @endphp
                <a class="btn btn-outline-secondary {{ $currentPage <= 1 ? 'disabled' : '' }}"
                   href="{{ route('busca-elastic-filtrada', array_merge(request()->except('page'), ['page' => $prevPage])) }}">Anterior</a>
                <a class="btn btn-outline-secondary {{ $currentPage >= ($lastPage ?? 1) ? 'disabled' : '' }}"
                   href="{{ route('busca-elastic-filtrada', array_merge(request()->except('page'), ['page' => $nextPage])) }}">Próxima</a>
            </div>
        </div>
    </div>
    @endif
</div>
<style>
  /* Filtro lateral sticky para a página de resultados da busca */
  @media (min-width: 768px) {
    .filter-sticky {
      position: sticky;
      top: 80px; /* ajuste se a navbar/header tiver outra altura */
      align-self: flex-start;
      z-index: 1010; /* acima do conteúdo para evitar sobreposição de cards */
    }
  }
</style>
@include('busca.partials.scripts')
@endsection
