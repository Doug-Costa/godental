@extends('facelift2.master')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    red: {
                        400: '#E04F75',
                        500: '#CA1D53', // Brand color
                        600: '#A31743',
                    }
                }
            }
        },
        corePlugins: {
           preflight: false, // Disable preflight to avoid conflict with Bootstrap
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Scoped Styles for New Design elements */
    .new-design-scope {
        font-family: 'Poppins', sans-serif;
        background-color: #f7f7f7;
    }
    .new-design-scope .checkbox-custom {
        appearance: none;
        background-color: #fff;
        margin: 0;
        font: inherit;
        color: currentColor;
        width: 1.15em;
        height: 1.15em;
        border: 1px solid #d1d5db;
        border-radius: 0.25em;
        display: grid;
        place-content: center;
    }
    .new-design-scope .checkbox-custom::before {
        content: "";
        width: 0.65em;
        height: 0.65em;
        transform: scale(0);
        transition: 120ms transform ease-in-out;
        box-shadow: inset 1em 1em white;
        background-color: white;
        transform-origin: center;
        clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
    }
    .new-design-scope .checkbox-custom:checked {
        background-color: #CA1D53;
        border-color: #CA1D53;
    }
    .new-design-scope .checkbox-custom:checked::before {
        transform: scale(1);
    }
    /* Sticky sidebar override */
    @media (min-width: 992px){
        .filter-sticky{ position: sticky; top: 90px; z-index: 2; align-self: flex-start; }
    }
</style>

<div class="new-design-scope" style="margin-top: 100px; min-height: 80vh;">
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Resultados para: "<span class="text-red-500">{{ $query }}</span>"</h2>

        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ $error }}</div>
        @endif

        @php
            // Restore Original Logic for Data grouping
            $resultsArray = is_array($results ?? null) ? $results : [];
            $articles = [];
            $videos = [];
            $books = [];

            foreach ($resultsArray as $item) {
                $type = $item['product']['productType'] ?? 'article'; 
                if ($type === 'magazine') { $articles[] = $item; }
                elseif ($type === 'video') { $videos[] = $item; }
                elseif ($type === 'book') { $books[] = $item; }
                else { $articles[] = $item; } // Fallback
            }

            // Totals
            $totaisTipos = isset($totaisPorTipo) ? $totaisPorTipo : [
                'magazine' => $contadorFelipino->productTypes->magazine ?? count($articles),
                'video' => $contadorFelipino->productTypes->video ?? count($videos),
                'book' => $contadorFelipino->productTypes->book ?? count($books),
            ];
        @endphp

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="w-full lg:w-1/4 filter-sticky">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Filtros</h2>
                    
                    <form action="{{ route('busca-elastic-filtrada25') }}" method="GET" id="filtersForm">
                        <input type="hidden" name="busca" value="{{ request()->input('busca', $query) }}">
                        <input type="hidden" name="size" value="{{ (int)($size ?? 10) }}">

                        <!-- Order -->
                        <div class="mb-8">
                            <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Ordenar por</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="publishOrder" value="" class="hidden peer" {{ !request()->input('publishOrder') ? 'checked' : '' }}>
                                    <div class="w-4 h-4 border border-gray-300 rounded-full flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-colors"></div>
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">Mais relevantes</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="publishOrder" value="desc" class="hidden peer" {{ request()->input('publishOrder') == 'desc' ? 'checked' : '' }}>
                                    <div class="w-4 h-4 border border-gray-300 rounded-full flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-colors"></div>
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">Mais recentes</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="publishOrder" value="asc" class="hidden peer" {{ request()->input('publishOrder') == 'asc' ? 'checked' : '' }}>
                                    <div class="w-4 h-4 border border-gray-300 rounded-full flex items-center justify-center peer-checked:bg-red-500 peer-checked:border-red-500 transition-colors"></div>
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">Mais antigos</span>
                                </label>
                            </div>
                        </div>

                        <!-- Product Types -->
                        <div class="mb-8">
                            <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Tipo de Conteúdo</h3>
                            <div class="space-y-2">
                                @foreach(['magazine' => 'Revistas', 'book' => 'Capítulos de livros', 'video' => 'Vídeos'] as $type => $label)
                                    @php $count = $contadorFelipino->productTypes->$type ?? 0; @endphp
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="q[productTypes][]" value="{{ $type }}" class="checkbox-custom" {{ in_array($type, (array) request()->input('q.productTypes', [])) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">{{ $label }} <span class="text-gray-400 text-xs ml-1">({{ $count }})</span></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>


                        <!-- Collections (Revistas) -->
                        <div class="mb-8">
                            <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Coleções (Revistas)</h3>
                            @php
                                $collectionsCounter = $contadorFelipino->collections ?? [];
                                if (is_object($collectionsCounter)) { $collectionsCounter = (array)$collectionsCounter; }
                                $selectedCollectionIds = (array) request()->input('q.collectionIds', []);
                                $hasSelection = count($selectedCollectionIds) > 0;
                                $renderedAny = false;
                            @endphp
                            
                            <div class="space-y-2">
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
                                        <label class="flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" name="q[collectionIds][]" value="{{ $id }}" class="checkbox-custom" {{ $isChecked ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-600">{{ $title }} <span class="text-gray-400 text-xs ml-1">({{ $quantidade }})</span></span>
                                        </label>
                                    @endforeach
                                @endif

                                @if(!$renderedAny)
                                    <div class="text-sm text-gray-400 italic">Nenhuma coletânea encontrada.</div>
                                @endif
                            </div>
                        </div>

                        <!-- Languages -->
                         <div class="mb-8">
                            <h3 class="text-xs font-bold text-gray-500 uppercase mb-3">Idioma</h3>
                            <div class="space-y-2">
                                @foreach(['pt' => 'Português', 'en' => 'Inglês', 'es' => 'Espanhol'] as $lang => $label)
                                    @php $countLang = $contadorFelipino->languages->$lang ?? 0; @endphp
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="q[languages][]" value="{{ $lang }}" class="checkbox-custom" {{ in_array($lang, (array) request()->input('q.languages', [])) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">{{ $label }} <span class="text-gray-400 text-xs ml-1">({{ $countLang }})</span></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition-colors shadow-sm">
                            Atualizar Resultados
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Results -->
            <div class="w-full lg:w-3/4">
                
                @if(count($resultsArray) === 0)
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                        <p class="text-gray-500">Nenhum resultado encontrado para sua pesquisa.</p>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach($resultsArray as $item)
                        @php
                            $coverImage = !empty($item['cover']) ? $item['cover'] : ($item['product']['cover'] ?? null);
                            $productId = $item['product']['id'] ?? 'sem-produto';
                            $productTitle = isset($item['product']['title']) ? Str::slug($item['product']['title']) : 'sem-titulo';
                            $articleId = $item['id'];
                            $articleTitle = Str::slug($item['title']);
                            $productType = $item['productType'] ?? 'artigo';
                            $typeLabel = 'ARTIGO';
                            
                            switch ($productType) {
                                case 'video':
                                    $url = url("facelift25/video/{$productId}/{$productTitle}/{$articleId}");
                                    $typeLabel = 'VÍDEO';
                                    break;
                                case 'livro':
                                case 'book':
                                    $url = url("facelift25/livro/{$productId}/{$productTitle}");
                                    $typeLabel = 'LIVRO';
                                    break;
                                case 'gotalks':
                                     $url = "#";
                                     $typeLabel = 'GOTALKS';
                                     break;
                                default:
                                    $url = url("facelift25/artigo/{$productId}/{$productTitle}/{$articleId}/{$articleTitle}");
                                    $typeLabel = 'ARTIGO';
                                    break;
                            }
                        @endphp

                        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row gap-6">
                            <div class="w-full md:w-48 h-32 md:h-auto bg-gray-200 rounded-lg shrink-0 overflow-hidden relative group cursor-pointer" onclick="window.location='{{ $url }}'">
                                @if($coverImage)
                                    <img src="{{ $coverImage }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">Sem imagem</div>
                                @endif

                                @if($productType === 'video')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-colors">
                                        <i class="fa-solid fa-play text-white text-2xl drop-shadow-md"></i>
                                    </div>
                                @endif
                                @if($productType === 'gotalks')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                                        <i class="fa-solid fa-microphone-lines text-white text-3xl opacity-80"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 py-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2 hover:text-red-600 cursor-pointer">
                                        <a href="{{ $url }}">{{ $item['title'] }}</a>
                                        <span class="inline-block align-middle ml-2 px-2 py-0.5 rounded text-[10px] font-bold bg-red-500 text-white uppercase">{{ $typeLabel }}</span>
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                        {{ strip_tags($item['brief'] ?? '') }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500">
                                        @if(!empty($item['authors']))
                                            <div class="flex items-center gap-1">
                                                <i class="fa-regular fa-user"></i>
                                                <span>{{ implode(', ', array_column($item['authors'], 'name') ?? []) }}</span>
                                            </div>
                                        @endif
                                        @if(!empty($item['publishDate']))
                                            <div class="flex items-center gap-1">
                                                <i class="fa-regular fa-calendar"></i>
                                                <span>{{ date('d/m/Y', strtotime($item['publishDate'])) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 flex justify-end">
                                    <a href="{{ $url }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-lg hover:bg-red-500 hover:border-red-500 hover:text-white transition-all">
                                        @if($productType === 'video')
                                            Assistir Agora
                                        @elseif($productType === 'livro' || $productType === 'book')
                                            Ler Capítulo
                                        @else
                                            Ler Artigo
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(isset($total) && $total > 0)
                    <div class="mt-10 pb-10">
                         @php
                            $currentPage = (int)($page ?? 1);
                            $lastPageNum = (int)($lastPage ?? 1);
                            $prevPage = max(1, $currentPage - 1);
                            $nextPage = min($lastPageNum, $currentPage + 1);
                            
                            // Sliding window: always show 4 pages at a time
                            $pageWindow = (int)(request()->input('pageWindow', 0)); // Which set of 4 pages (0 = 1-4, 1 = 5-8, etc)
                            $startPage = ($pageWindow * 4) + 1;
                            $endPage = min($startPage + 3, $lastPageNum);
                            
                            // Adjust window if current page is outside current range
                            if ($currentPage < $startPage || $currentPage > $endPage) {
                                $pageWindow = floor(($currentPage - 1) / 4);
                                $startPage = ($pageWindow * 4) + 1;
                                $endPage = min($startPage + 3, $lastPageNum);
                            }
                            
                            $hasMorePages = $endPage < $lastPageNum;
                            $nextWindow = $pageWindow + 1;
                        @endphp
                        
                        <!-- Page Count Display -->
                        <div class="text-center mb-6">
                            <p class="text-sm text-gray-600">
                                Página <span class="font-bold text-red-500">{{ $currentPage }}</span> de <span class="font-bold">{{ $lastPageNum }}</span>
                                <span class="text-gray-400 ml-2">({{ $total }} resultados)</span>
                            </p>
                        </div>

                        <!-- Navigation Controls -->
                        <div class="flex flex-col items-center gap-4">
                            <nav class="flex items-center gap-2">
                                <a href="{{ route('busca-elastic-filtrada25', array_merge(request()->except('page'), ['page' => $prevPage, 'pageWindow' => $pageWindow])) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50 {{ $currentPage <= 1 ? 'opacity-50 pointer-events-none' : '' }}">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                </a>
                                
                                @for($i = $startPage; $i <= $endPage; $i++)
                                    <a href="{{ route('busca-elastic-filtrada25', array_merge(request()->except('page'), ['page' => $i, 'pageWindow' => $pageWindow])) }}" 
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-bold transition-all {{ $i == $currentPage ? 'bg-red-500 text-white shadow-sm' : 'border border-gray-300 text-gray-500 hover:bg-gray-50' }}">
                                        {{ $i }}
                                    </a>
                                @endfor
                                
                                <a href="{{ route('busca-elastic-filtrada25', array_merge(request()->except('page'), ['page' => $nextPage, 'pageWindow' => $pageWindow])) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-50 {{ $currentPage >= $lastPageNum ? 'opacity-50 pointer-events-none' : '' }}">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            </nav>

                            <!-- Load More Button (conditional) -->
                            @if($hasMorePages)
                                @php
                                    $remainingPages = $lastPageNum - $endPage;
                                    $nextSetStart = $endPage + 1;
                                    $nextSetEnd = min($nextSetStart + 3, $lastPageNum);
                                @endphp
                                <a href="{{ route('busca-elastic-filtrada25', array_merge(request()->all(), ['pageWindow' => $nextWindow, 'page' => $nextSetStart])) }}" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm"
                                   title="Mais resultados ({{ $remainingPages }} páginas restantes)">
                                    <i class="fa-solid fa-angles-down"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('busca.partials.scripts')
@endsection
