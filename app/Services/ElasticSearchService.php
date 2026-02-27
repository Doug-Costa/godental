<?php
namespace App\Services;

use Exception;

class ElasticSearchService
{
    protected $host;
    protected $user;
    protected $password;

    public function __construct()
    {
        $this->host = env('ELASTIC_HOST', 'https://elastic-dentalgo.es.us-east-1.aws.found.io');
        $this->user = env('ELASTIC_USER', 'elastic');
        $this->password = env('ELASTIC_PASSWORD');
        
        if (!$this->password) {
            throw new \Exception('ELASTIC_PASSWORD não configurado no arquivo .env');
        }
    }

    // Método genérico para enviar requisições via cURL
    private function sendRequest($method, $endpoint, $body = null)
    {
        $url = "{$this->host}{$endpoint}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

        // Se houver um corpo na requisição (ex: busca no Elasticsearch)
        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
        }

        // Autenticação básica
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->user}:{$this->password}");

        // Desativa verificação SSL (se necessário)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Executa a requisição
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("Erro no cURL: $error");
        }

        return json_decode($response, true);
    }

    // Testa a conexão com o Elasticsearch
    public function testConnection()
    {
        return $this->sendRequest('GET', '/');
    }

    // Busca simples no Elasticsearch
    public function search($query, $page = 1, $size = 10)
    {
        $body = [
            'query' => [
                'match' => [
                    'title' => $query
                ]
            ],
            'from' => ($page - 1) * $size,
            'size' => $size
        ];

        return $this->sendRequest('POST', '/product-items/_search', $body);
    }

    public function searchBoolean($query, $page = 1, $size = 10)
    {
        return $this->searchBooleanWithFilters($query, [], $page, $size, null);
    }

    // Helper: normaliza acentuação para uma versão "folded" (ASCII)
    private function foldAccents(string $text): string
    {
        // Tenta transliterar para ASCII
        $folded = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        if ($folded === false || $folded === null) {
            $folded = $text;
        }
        // Remove marcas combinantes remanescentes
        $folded = preg_replace('/[\x{0300}-\x{036f}]/u', '', $folded);
        // Normaliza espaços
        $folded = preg_replace('/\s+/', ' ', $folded);
        return trim((string)$folded);
    }

    // Escapa caracteres especiais para query_string do Lucene
    private function escapeForQueryString(string $text): string
    {
        // Substitui caracteres especiais do Lucene por espaço sem regex para evitar erros de modificadores
        $escaped = strtr($text, [
            '+' => ' ', '-' => ' ', '&' => ' ', '|' => ' ', '!' => ' ',
            '(' => ' ', ')' => ' ', '{' => ' ', '}' => ' ', '[' => ' ', ']' => ' ',
            '^' => ' ', '"' => ' ', '~' => ' ', '*' => ' ', '?' => ' ', ':' => ' ',
            '\\' => ' ', '/' => ' '
        ]);
        // Normaliza múltiplos espaços
        $escaped = preg_replace('/\s+/u', ' ', $escaped);
        return trim((string)$escaped);
    }

    // Busca booleana com filtros e ordenação + agregações
    public function searchBooleanWithFilters($query, array $filters = [], $page = 1, $size = 10, $publishOrder = null)
    {
        $url = env('ELASTIC_HOST') . "/product-items/_search";

        $elasticUser = env('ELASTIC_USER', 'elastic');
        $elasticPass = env('ELASTIC_PASSWORD');
        
        if (!$elasticPass) {
            throw new \Exception('ELASTIC_PASSWORD não configurado no arquivo .env');
        }

        // Mantém a consulta original (com acentuação) para match/match_phrase
        $queryOriginal = trim((string)$query);
        // Versão dobrada (sem acento) para query_string e campos não acentuados
        $queryFolded = $this->foldAccents($queryOriginal);
        $queryStringSafe = $this->escapeForQueryString($queryFolded);

        // Monta filtros
        $filterClauses = [];
        $productTypes = array_values(array_filter($filters['productTypes'] ?? [], function ($v) { return (string)$v !== ''; }));
        if (!empty($productTypes)) {
            $filterClauses[] = ['terms' => ['product.productType.keyword' => $productTypes]];
        }
        $collectionIds = array_values(array_filter($filters['collectionIds'] ?? [], function ($v) { return $v !== '' && $v !== null; }));
        if (!empty($collectionIds)) {
            $filterClauses[] = ['terms' => ['collections' => array_map('intval', $collectionIds)]];
        }
        $languages = array_values(array_filter($filters['languages'] ?? [], function ($v) { return (string)$v !== ''; }));
        if (!empty($languages)) {
            $filterClauses[] = ['terms' => ['language.keyword' => $languages]];
        }

        // Query base com function_score
        $boolQuery = [
            'should' => [
                ['match_phrase' => ['title' => ['query' => $queryOriginal, 'boost' => 3]]],
                ['match' => ['title' => ['query' => $queryOriginal, 'fuzziness' => 'AUTO', 'boost' => 2]]],
                ['query_string' => ['default_field' => 'title', 'query' => "*{$queryStringSafe}*", 'boost' => 2]],

                ['match_phrase' => ['brief' => ['query' => $queryOriginal, 'boost' => 2]]],
                ['match' => ['brief' => ['query' => $queryOriginal, 'fuzziness' => 'AUTO', 'boost' => 1.5]]],
                ['query_string' => ['default_field' => 'brief', 'query' => "*{$queryStringSafe}*", 'boost' => 1.5]],

                ['match_phrase' => ['keywords' => ['query' => $queryOriginal, 'boost' => 2]]],
                ['match' => ['keywords' => ['query' => $queryOriginal, 'fuzziness' => 'AUTO', 'boost' => 1.5]]],
                ['query_string' => ['default_field' => 'keywords', 'query' => "*{$queryStringSafe}*", 'boost' => 1.5]],

                ['match_phrase' => ['unaccentedTitle' => ['query' => $queryFolded, 'boost' => 2]]],
                ['match' => ['unaccentedTitle' => ['query' => $queryFolded, 'fuzziness' => 'AUTO', 'boost' => 1.5]]],
                ['query_string' => ['default_field' => 'unaccentedTitle', 'query' => "*{$queryStringSafe}*", 'boost' => 1.5]],

                ['match_phrase' => ['authors.name' => ['query' => $queryOriginal, 'boost' => 4]]],
                ['match' => ['authors.name' => ['query' => $queryOriginal, 'fuzziness' => 'AUTO', 'boost' => 3]]],
                ['query_string' => ['default_field' => 'authors.name', 'query' => "*{$queryStringSafe}*", 'boost' => 3]]
            ],
            'minimum_should_match' => 1
        ];

        if (!empty($filterClauses)) {
            $boolQuery['filter'] = $filterClauses;
        }

        $searchParams = [
            'size' => (int)$size,
            'from' => ((int)$page - 1) * (int)$size,
            'query' => [
                'function_score' => [
                    'query' => [ 'bool' => $boolQuery ],
                    'functions' => [
                        [
                            'field_value_factor' => [
                                'field' => 'views',
                                'factor' => 1.2,
                                'modifier' => 'log1p',
                                'missing' => 1
                            ]
                        ]
                    ],
                    'score_mode' => 'sum',
                    'boost_mode' => 'sum'
                ]
            ],
            'track_total_hits' => true,
            // Agregações globais para contagens de filtros/abas
            'aggs' => [
                'productTypes' => [
                    'terms' => [ 'field' => 'product.productType.keyword', 'size' => 10 ]
                ],
                'languages' => [
                    'terms' => [ 'field' => 'language.keyword', 'size' => 10 ]
                ],
                'collections' => [
                    'terms' => [ 'field' => 'collections', 'size' => 1000 ]
                ]
            ]
        ];

        // Ordenação
        $sort = [[ '_score' => 'desc' ]];
        if ($publishOrder === 'asc' || $publishOrder === 'desc') {
            $sort = [ ['publishDate' => ['order' => $publishOrder]], ['_score' => 'desc'] ];
        }
        $searchParams['sort'] = $sort;

        // Execução via cURL (mantendo padrão do arquivo)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($searchParams));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$elasticUser:$elasticPass")
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception("Erro na requisição Elasticsearch: " . $response);
        }

        return json_decode($response, true);
    }

}