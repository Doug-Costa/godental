<?php
$paginaTitulo = 'Coleções de Videos - DentalGo';
$padinaDescricao = '';

/*facelift*/
$tipoTopo = 'topoVermelho';
/*echo Cache::get('tokenGlobal');
echo '<br>';
print_r($videos);*/
?>


@extends('facelift2.master')

@section('content')
    <div id="PgVideosGo" class="dentalgo-light-theme">
        <!--
    <div class="container-fluid produtoTopo videoBanner">
        <div class="container containerColecao">
            <div class="row">
                <img src="{{ asset('imagens/govideos.webp') }}">
            </div>
        </div>
    </div>
    -->

        <!-- <div id="carouselExampleInterval" class="carousel slide carousel-fade mobile-display-none" data-bs-ride="carousel">,
        <div class="carousel-indicators">
            @foreach ($videos as $key => $videosCat)
                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $key }}" class="<?php if ($key == 0) { ?>active<?php } ?>" aria-current="true" aria-label="Slide {{ $key }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($videos as $key => $videosCat)  
                <div class="carousel-item <?php if ($key == 0) { ?>active<?php } ?>" data-bs-interval="8000">
                    <img src="{{$videosCat->cover}}" class="d-block w-100 BannerajustaMobile" alt="ZUMBIDO E DTM" style="object-fit: none; object-position: top; max-height: 500px; object-fit: cover !important; min-height: 500px; margin-top: 0;">
                    <div class="carousel-caption conteudoBanner" style="max-width: 750px; top: 5%;">
                        <h1   class="titulo-slideVideos">{{$videosCat->title}}</h1>
                        @if($videosCat->id == 681)
                            <h2 class="paragrafo-slideVideos"><br> {{__("messages.conteudoVideoDentalGOAcademy")}} <br> {{__("messages.conteudoVideoDentalGOAcademy2")}} <br> {{__("messages.conteudoVideoDentalGOAcademy3")}}<br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i> 
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i> 
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}} </label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i> 
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 430)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff">{{__("messages.conteudoVideoDrops")}} <br> {{__("messages.conteudoVideoDrops2")}} <br> {{__("messages.conteudoVideoDrops3")}}<br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>  
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}} </label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 432)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"><br>{{__("messages.conteudoVideoHistoricas")}} <br>{{__("messages.conteudoVideoHistoricas2")}} <br>{{__("messages.conteudoVideoHistoricas3")}} <br>{{__("messages.conteudoVideoHistoricas4")}} <br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo2")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato2")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 431)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"><br> {{__("messages.conteudoVideoEntrevista")}} <br>{{__("messages.conteudoVideoEntrevista2")}} <br> {{__("messages.conteudoVideoEntrevista3")}} <br> {{__("messages.conteudoVideoEntrevista4")}} <br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo2")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i> 
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato2")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 433)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"> <br>{{__("messages.conteudoVideoDicas")}}<br> {{__("messages.conteudoVideoDicas2")}}</h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 720)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff">{{__("messages.conteudoVideoWIOC")}} <br>{{__("messages.conteudoVideoWIOC2")}} <br>{{__("messages.conteudoVideoWIOC3")}} <br>{{__("messages.conteudoVideoWIOC_4")}}<br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo4")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema2")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato2")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 721)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"><br>{{__("messages.conteudoVideoCurso")}} <br>{{__("messages.conteudoVideoCurso2")}} <br>{{__("messages.conteudoVideoCurso3")}} <br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo3")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema2")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 719)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"><br>{{__("messages.conteudoVideoSpecialties")}}<br> {{__("messages.conteudoVideoSpecialties2")}}<br> {{__("messages.conteudoVideoSpecialties3")}}<br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosMidia")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato2")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato3")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 506)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff"><br>{{__("messages.conteudoVideoBasic")}} <br>{{__("messages.conteudoVideoBasic2")}} <br>{{__("messages.conteudoVideoBasic3")}}<br> {{__("messages.conteudoVideoBasic4")}}<br><br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @elseif($videosCat->id == 429)
                            <h2 style="font-size: 1.2rem; font-weight: 600; color:#fff">{{__("messages.conteudoVideoCongresso")}} <br> {{__("messages.conteudoVideoCongresso2")}} <br> {{__("messages.conteudoVideoCongresso3")}}<br></h2>
                            <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTempo")}}</label>
                            <br>
                            <i class="fa-solid fa-file-lines" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosTema")}}</label>
                            <br>
                            <i class="fa-solid fa-circle-play" style="color: #fff;"></i>
                            <label style="color:#fff">{{__("messages.conteudoVideosFormato")}}</label>
                            <br/><br/>
                        @endif
                        <a href="{{ route('facevideo')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $videosCat->productItems[0]->title) }}/" class="btn btn-danger" style="padding: 8px 20px; font-size:15px;">{{__("messages.conteudoVideosCanal")}}</a>
                    </div>
                </div>
            @endforeach


        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>  -->


        <!--
    <div class="container-fluid canaisBanner">
        <div class="container">
            <div class="row">

            <section id="slider2D">
                <div class="container">
                    <div class="slider">
                        <div class="owl-carousel owl-carousel-quatro">
                            @foreach ($videos as $videosCat)
                                <?php
    $classeCor = 'catFundo' . $videosCat->id;
                                ?>

                                <a href="{{ route('facevideo')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $videosCat->productItems[0]->title) }}/{{ $videosCat->productItems[0]->id }}" style="text-decoration: none">
                                    <div class="slider-card catFundo {{ $classeCor }}">
                                        <div class="d-flex justify-content-center align-items-center ">
                                            <img src="{{ $videosCat->cover }}" alt="{{ $videosCat->title }}" >
                                        </div>
                                     </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            </div>
        </div>
    </div>


    <div class="container-fluid revistaApoiadoresFundoCol2 mobile-display-none">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 revistaApoiadoresCol2">
                    <div class="row">
                        <div class="col-4 col-md-2">
                            <img src="{{ asset('imagens/iconVantagens/Descontos.png') }}" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

        <style>
            .hero-carousel .carousel-item {
                display: block;
                transition: opacity 1s ease-in-out;
            }

            .hero-carousel .carousel-item img {
                transform: scale(1.05);
                transition: transform 1.5s ease, opacity 1.5s ease;

            }

            .hero-carousel .carousel-item.active img {
                transform: scale(1);
            }
        </style>



        <section class="hero-wrap">
            <div class="container">
                <div class="hero-inner">

                    <div>
                        <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel"
                            data-bs-interval="4000" style="width: 100%;">
                            <div class="carousel-inner">

                                <div class="carousel-item active position-relative">
                                    <a href="https://dentalgo.com.br/video/681">
                                        <img class="d-none d-lg-block" src="{{ asset('facelift2/img/video33219.png') }}"
                                            alt="Banner Desktop 1">
                                        <img class="d-block d-lg-none" src="{{ asset('facelift2/img/video332.png') }}"
                                            alt="Banner Mobile 1">
                                    </a>
                                </div>

                                <div class="carousel-item position-relative">
                                    <a href="https://dentalgo.com.br/facelift25/video/431">
                                        <img class="d-none d-lg-block" src="{{ asset('facelift2/img/video2219.png') }}"
                                            alt="Banner Desktop 2" style="">
                                        <img class="d-block d-lg-none" src="{{ asset('facelift2/img/video232.png') }}"
                                            alt="Banner Mobile 2">
                                    </a>
                                </div>

                                <div class="carousel-item position-relative">
                                    <a href="https://dentalgo.com.br/video/875">
                                        <img class="d-none d-lg-block" src="{{ asset('facelift2/img/video1219.png') }}"
                                            alt="Banner Desktop 3">
                                        <img class="d-block d-lg-none" src="{{ asset('facelift2/img/video132.png') }}"
                                            alt="Banner Mobile 3">
                                    </a>
                                </div>


                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visualmente-hidden"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visualmente-hidden"></span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="slider mt-5 container">
            @php
                $allVideos = collect();

                foreach ($videos as $videosCat) {
                    foreach ($videosCat->productItems as $item) {
                        // GRAVA o ID da coleção dentro do vídeo
                        $item->collection_id = $videosCat->id;
                        $allVideos->push($item);
                    }
                }

                $recentVideos = $allVideos
                    ->unique('id')
                    ->sortByDesc('id')
                    ->values()
                    ->take(15);
            @endphp


            <h3 class="section-title">Videos Recentes</h3>
            <div class="owl-carousel owl-carousel-setenta my-slider">

                @foreach ($recentVideos as $video)
                    <a href="{{ route('facevideo')}}/{{ $video->collection_id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}"
                        style="text-decoration: none">
                        <div class="slider-card-top">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="{{ $video->cover }}" alt="{{ $video->title }}" class="top-slider-img">
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>

        @foreach ($videos as $videosCat)


            <div class="container container-section"> <!-- Added specific container -->
                <div class="row videos-header">
                    <div class="col-sm-12">
                        <a href="{{ route('facevideo')}}/{{ $videosCat->id }}" class="section-link">
                            <h3 class="section-title">{{ $videosCat->title }}
                                <span class="see-more"> Ver todos
                                    <i class="fa-solid fa-chevron-right"></i>
                                </span>
                            </h3>
                        </a>
                        <!-- <hr> Removed HR for cleaner look -->
                    </div>
                </div>

                <div class="row videos-grid">
                    @foreach (array_slice($videosCat->productItems, 0, 6) as $video)


                        <div class="col-6 col-sm-4 col-md-2 card-margin video-card-container"> <!-- Adjusted columns -->
                            <a href="{{ route('facevideo')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}"
                                class="card-link">
                                <div class="video-card-dentalgo">
                                    <div class="img-wrapper">
                                        <img src="{{ $video->cover}}" class="videoImagemMain">
                                        <div class="hover-play">
                                            <i class="fa-solid fa-play"></i>
                                        </div>
                                    </div>
                                    <!-- Optional: Add title below if desired, reference has titles -->
                                </div>
                            </a>
                        </div>


                    @endforeach

                </div>

            </div>


        @endforeach

        <style>
            /* DentalGo Light Theme Variables */
            :root {
                --bg-light: #f4f6f8;
                --text-dark: #333333;
                --text-light: #666666;
                --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                --card-shadow-hover: 0 12px 24px rgba(0, 0, 0, 0.12);
                --accent-dental: #444444;
                /* Dark neutral accent */
            }

            /* Page Reset */
            #PgVideosGo.dentalgo-light-theme {
                background-color: var(--bg-light);
                font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
                padding-bottom: 60px;
                color: var(--text-dark);
            }

            /* New Banner Style */
            .dentalgo-banner {
                background: linear-gradient(135deg, #2c3e50 0%, #000000 100%);
                border-radius: 16px;
                padding: 60px;
                color: #fff;
                text-align: left;
                margin-bottom: 40px;
                position: relative;
                overflow: hidden;
            }

            .dentalgo-banner h1 {
                font-weight: 800;
                font-size: 3rem;
                margin-bottom: 10px;
            }

            .btn-banner {
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.4);
                color: #fff;
                padding: 10px 24px;
                border-radius: 50px;
                margin-top: 20px;
                transition: all 0.3s;
            }

            .btn-banner:hover {
                background: #fff;
                color: #000;
            }

            /* Top Slider */
            .slider-card-top {
                padding: 10px;
                transition: transform 0.3s;
            }

            .top-slider-img {
                border-radius: 12px;
                box-shadow: var(--card-shadow);
            }

            /* Section Layout */
            .container-section {
                padding-top: 40px;
                padding-bottom: 20px;
            }

            .section-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .section-link {
                text-decoration: none;
            }

            .see-more {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--text-light);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Video Cards */
            .video-card-container {
                margin-bottom: 30px;
            }

            .card-link {
                text-decoration: none;
                display: block;
            }

            .video-card-dentalgo {
                border-radius: 12px;
                overflow: hidden;
                background-color: transparent;
                /* Clean look */
                transition: all 0.3s ease;
                position: relative;
            }

            .img-wrapper {
                position: relative;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: var(--card-shadow);
                /* Aspect Ratio for Vertical Cards (like reference) */
                aspect-ratio: 3/4;
                background: #fff;
            }

            .videoImagemMain {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* Use COVER to look premium like reference */
                transition: transform 0.5s ease;
            }

            .video-card-dentalgo:hover .videoImagemMain {
                transform: scale(1.08);
                /* Slow zoom */
            }

            .video-card-dentalgo:hover .img-wrapper {
                box-shadow: var(--card-shadow-hover);
            }

            .hover-play {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s;
            }

            .video-card-dentalgo:hover .hover-play {
                opacity: 1;
            }

            .hover-play i {
                font-size: 30px;
                color: #fff;
                background: rgba(0, 0, 0, 0.5);
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                backdrop-filter: blur(4px);
            }

            /* Responsiveness */
            @media (max-width: 768px) {
                .dentalgo-banner {
                    padding: 30px;
                }

                .dentalgo-banner h1 {
                    font-size: 2rem;
                }

                .section-title {
                    font-size: 1.2rem;
                }

                /* On mobile, show 2 columns */
                .col-6 {
                    width: 50%;
                }
            }
        </style>

        <br>
        <br>
    </div>
@endsection