<div class="card mb-3">
    <div class="row no-gutters">
        @php
            // Definir a imagem de exibição
            $coverImage = !empty($item['cover']) ? $item['cover'] : ($item['product']['cover'] ?? null);

            // Obter detalhes do produto
            $productId = $item['product']['id'] ?? 'sem-produto';
            $productTitle = isset($item['product']['title']) ? Str::slug($item['product']['title']) : 'sem-titulo';
            $articleId = $item['id'];
            $articleTitle = Str::slug($item['title']);
            $productType = $item['productType'] ?? 'artigo';

            // Montar a URL com base no tipo de produto
            switch ($productType) {
                case 'video':
                    $url = url("video/{$productId}/{$productTitle}/{$articleId}");
                    break;
                case 'livro':
                    $url = url("livro/{$productId}/{$productTitle}");
                    break;
                default:
                    $url = url("artigo/{$productId}/{$productTitle}/{$articleId}/{$articleTitle}");
                    break;
            }
        @endphp

        @if($coverImage)
            <div class="col-md-4">
                <img src="{{ $coverImage }}" class="card-img" alt="Capa">
            </div>
        @endif

        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ $url }}" target="_blank">{{ $item['title'] }}</a>
                </h5>
                <p class="card-text">{{ strip_tags($item['brief'] ?? '') }}</p>

                <p><strong>{{__("messages.BuscaAutores")}}:</strong> {{ implode(', ', array_column($item['authors'], 'name') ?? []) }}</p>
                <p><small>{{__("messages.BuscaPublicadoEm")}}: {{ date('d/m/Y', strtotime($item['publishDate'])) }}</small></p>

                @if(!empty($item['keywords']))
                    <p><strong>{{__("messages.BuscaPalavrasChave")}}:</strong> 
                        @foreach($item['keywords'] as $keyword)
                            <span class="badge-info">{{ $keyword }}</span>
                        @endforeach
                    </p>
                @endif

                <a href="{{ $url }}" class="btn btn-primary" target="_blank">
                    @if($productType === 'video')
                        {{__("messages.BuscaAssistirVideo")}}
                    @elseif($productType === 'book')
                        {{__("messages.BuscaLerCapitulo")}}
                    @else
                        {{__("messages.BuscaLerArtigo")}}
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
