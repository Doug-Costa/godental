<?php
$paginaTitulo = 'Coleções de Videos - DentalGo';
$padinaDescricao = '';

/*facelift*/
$tipoTopo = 'topoVermelho';
/*echo Cache::get('tokenGlobal');
echo '<br>';
print_r($videos);*/
?>

@extends('layouts.master')

@section('content')
<div id="PgVideosGo">
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
            <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $key }}" class="<?php if( $key == 0){?>active<?php } ?>" aria-current="true" aria-label="Slide {{ $key }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach ($videos as $key => $videosCat)  
            <div class="carousel-item <?php if( $key == 0){?>active<?php } ?>" data-bs-interval="8000">
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
                    <a href="{{ route('video')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $videosCat->productItems[0]->title) }}/" class="btn btn-danger" style="padding: 8px 20px; font-size:15px;">{{__("messages.conteudoVideosCanal")}}</a>
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
                                $classeCor = 'catFundo'.$videosCat->id;
                            ?>
                        
                            <a href="{{ route('video')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $videosCat->productItems[0]->title) }}/{{ $videosCat->productItems[0]->id }}" style="text-decoration: none">
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
                        <img src="{{ route('home') }}/imagens/iconVantagens/Livros.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-md-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Vídeos.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-md-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/quandoeondequiser.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-md-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Novosconteúdos.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-md-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/especialistas.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-md-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Descontos.png" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<br>
<br>

<div class="container-fluid mobile-display-none" style="margin-top:40px">
    <div class="row">
        <section id="slider4DVideo">
            <div class="container-fluid">
              <h3 class="text-center" style="color: #ffffff;"><b>{{__("messages.VideosTitulo")}}</b></h3>
                <br>
                <h5 class="text-center"><b>{{__("messages.VideosSubPag")}}</b></h5>
                <br>
                <br>
                <div class="slider">
                    <div class="owl-carousel owl-carousel-setenta">
                        @foreach ($videos as $videosCat)
                            <a href="{{ route('video')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $videosCat->productItems[0]->title) }}/{{ $videosCat->productItems[0]->id }}" style="text-decoration: none">
                                <div class="slider-card">
                                    <div class="d-flex justify-content-center align-items-center mb-4">
                                        <img src="{{ $videosCat->productItems[0]->cover }}" alt="{{ $videosCat->title }}" >
                                    </div>
                                  <!--  <h5 class="mb-0 text-center"><b>{{ $videosCat->title }}</b></h5>
                                    <p> </p>-->
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@foreach ($videos as $videosCat)


<div class="container-fluid">
    <div class="row videos">
        <div class="col-sm-12"> 
            <a href="{{ route('video')}}/{{ $videosCat->id }}" style="color: transparent;">
                <h3>{{ $videosCat->title }} <small style="font-size: 13px;"> {{__("messages.conteudoVideosVeja")}}  <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></small></h3>
            </a>
            <hr>
        </div>

        @foreach (array_slice($videosCat->productItems, 0, 6) as $video)
        

        <div class="col-6 col-md-2 card-margin">
            <a href="{{ route('video')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}">
                <img src="{{ $video->cover}}" style="width: 100%;" class="videoImagemMain">
            </a>
        </div>


        @endforeach

    </div>
    
</div>
  

@endforeach

<style>
    .conteudoCentro{
        background-color:#515151;
    }
    .conteudoCentro h1{ 
        color:#fff;
    }
    .conteudoCentro h5{
        color:#fff;
    }
</style>

<br>
<br>
</div>

@endsection

@section('api')
<?php
//print_r($videos);
?>
@endsection