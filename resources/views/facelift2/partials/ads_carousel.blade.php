@php
    $empresasComercial = [];
    $defaultImg = 'bannersComercial/BANNERDENTALPRESS1920X500.jpg'; // Fallback

    if ($collectionId == '5' || $collectionId == '6') {
        $empresasComercial = [
            ['nome' => 'Easy3d', 'link' => 'https://www.easy3d.com.br/', 'imagem' => 'bannersComercial/Easy-3d-DPJO-e-clinica.png'],
            ['nome' => 'Id-Logical', 'link' => 'https://www.id-logical.com/', 'imagem' => 'bannersComercial/IDLOGICAL1.fw.png'],
            ['nome' => 'ClickAligner', 'link' => 'https://wa.me/5551982586525?text=Oi', 'imagem' => 'bannersComercial/bannerClickAligner.png'],
            ['nome' => 'ORTHOMETRIC', 'link' => 'https://www.orthometric.com.br/', 'imagem' => 'bannersComercial/diminuidocapelozza.fw.png'],
        ];
    } elseif ($collectionId == '4') {
        $empresasComercial = [
            ['nome' => 'CVdentus', 'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press', 'imagem' => 'bannersComercial/BANNERDENTALPRESS1920X500.jpg'],
            ['nome' => 'ultradent', 'link' => 'https://www.ultradent.com.br/', 'imagem' => 'bannersComercial/ULTRADENTBANNER.jpg'],
        ];
    } elseif ($collectionId == '50') {
        $empresasComercial = [
            ['nome' => 'CVdentus', 'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press', 'imagem' => 'bannersComercial/BANNERDENTALPRESS1920X500.jpg']
        ];
    }

    shuffle($empresasComercial);
@endphp

@if(count($empresasComercial) > 0)
    <div class="col-12 mt-5">
        <div class="d-flex align-items-center mb-3">
            <h3 class="h5 fw-bold text-uppercase text-secondary me-3" style="letter-spacing: 1px;">
                {{__("messages.PUBLICIDADE")}}</h3>
            <div class="flex-grow-1 border-bottom"></div>
        </div>

        <div id="carouselAds{{$collectionId}}" class="carousel slide shadow-sm rounded-3 overflow-hidden"
            data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($empresasComercial as $key => $empresa)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="5000">
                        <a href="{{ $empresa['link'] }}" target="_blank">
                            <!-- Use object-fit cover/contain logic or existing styling -->
                            <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100"
                                alt="{{ $empresa['nome'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
            @if(count($empresasComercial) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselAds{{$collectionId}}"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselAds{{$collectionId}}"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    </div>
@endif