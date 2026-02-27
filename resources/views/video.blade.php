<?php
$paginaTitulo = $video->title.' - DentalGo';
$padinaDescricao = '';

$tipoTopo = 'topoVermelho';
/*
function array_para_csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function cabecalho_download_csv($filename) {
    // desabilitar cache
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // forçar download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposição do texto / codificação
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

$videoContent = array();
foreach ($video->productItems as $key => $value) {
    $videoContent[$key]['id'] = $value->id;
    $videoContent[$key]['content'] = $value->content;
}

cabecalho_download_csv($video->title . date("Y-m-d") . ".csv");
echo array_para_csv($videoContent);
die();*/

foreach ($videos as $key => $value) {
    if($value->id == $video->id){
        $imagemBanner = $value->cover;
    }
}


$permicao = 7;

if(session()->get('usuarioPermissao') == 'naotem'){
    $modalConteudo = 'espacoParaAssinantes';
}elseif(session()->get('usuarioPermissao') == 'naotemVencido'){
    $dataVencimento = date(session()->get('usuario')->subscription->isValidUntil);
    $dataVencimento = explode('UTC', $dataVencimento);

    $dataAtual = date("Y-m-d");
    if($dataVencimento[0] >= $dataAtual){
        $modalConteudo = 'permitido';
    }else{
        $modalConteudo = 'renoveOplano';
    }
}elseif(session()->get('usuarioPermissao') == 'naotemSemPlano'){
    $modalConteudo = 'vamosAssinar';
}elseif(is_array(session()->get('usuarioPermissao'))){
    if(in_array($permicao, session()->get('usuarioPermissao'))){
        $modalConteudo = 'permitido';
    }else{
        $modalConteudo = 'espacoParaAssinantes';
    }
}else{
    $modalConteudo = 'espacoParaAssinantes';
}



$briefVideo = explode('™', $video->brief);
$briefVideoTexto = explode('ŧ', strval($briefVideo[0]));

?>

@extends('layouts.master')

@section('content')

<div class="container-fluid produtoTopo videoBanner" style="background-image: url('{{ asset($imagemBanner) }}') !important;">
    <div class="container-fluid containerColecao" style="display: block;">
        <div class="row" style="display: block;"> 
            <div class="col-sm-12">
                <h1 style="font-size: 30px; font-weight: 900; margin-top:70px !important;">{{$video->title}}</h1>
                <h2 style="font-size: 26px; font-weight: 900; color:#fff">@foreach ($briefVideoTexto as $bfTexto){{ $bfTexto }}<br/>@endforeach</h2>
                <i class="fa-solid fa-stopwatch" style="color: #fff;"></i>	&#32;<label style="color:#fff">{{$briefVideo[1]}}</label>
                <br/>
                <i class="fa-solid fa-file-lines" style="color: #fff;"></i>	&#32;<label style="color:#fff">{{$briefVideo[2]}}</label>
                <br/>
                <i class="fa-solid fa-circle-play" style="color: #fff;"></i>	&#32;<label style="color:#fff">{{$briefVideo[3]}}</label>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid canaisBanner">
    <div class="container-fluid">
        <div class="row">
            <section id="slider2D">
                <div class="container-fluid">
                    <div class="slider">
                        <div class="owl-carousel owl-carousel-trinta" style="padding-left: 30px;">
                            @foreach ($videos as $videosCat)
                                <?php
                                    $classeCor = 'catFundo'.$videosCat->id;
                                ?>
                            
                                <a href="{{ route('video')}}/{{ $videosCat->id }}" style="text-decoration: none">
                                    <div class="slider-card catFundoVideo {{ $classeCor }}">
                                        <div class="d-flex justify-content-center align-items-center" style="text-align: center;">
                                            {{$videosCat->title}}
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

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h1>{{ $video->title }}</h1>
        </div>
   
    <div class="row">
    	@foreach ($video->productItems as $key => $video)
            <?php

            if (empty($video->content)) {
                $hashVideo = '';
            }else{
                $hashVideo = explode('/', $video->content);
                $hashVideo = $hashVideo[2];
            }
            
            ?>
            <div class="col-6 col-sm-4 col-md-2" style="margin-bottom: 25px;">
                <?php
                //print_r($video);
                ?>
                @if($modalConteudo == 'permitido')
                    <button id="VideoId{{$video->id}}" class="video-btn videoButaum" data-bs-toggle="modal" data-bs-target="#modalVideo" data-src="{{ $hashVideo }}">
                @else
                    <button class="videoButaum" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                @endif
                        <img src="{{ $video->cover }}" class="videoImagem" alt="{{ $video->title }}">
                
                        <label style="display: none;">
                            {{ $video->title }}
                        </label>
                    </button>
            </div>

        @endforeach

        <div class="modal fade" id="modalVideo" tabindex="-1" aria-labelledby="modalVideoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modalCentraliza">
              <div class="modal-content modalRedondinho" style="background: transparent; border: 0;">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: -25px; color: #fff; border: 2px solid #1a1a1a;"></button>
                    <iframe class="embed-responsive-item" src="{{ route('loadingvideo') }}" id="video"  allowscriptaccess="always" allow="autoplay" width="100%" height="450px" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen="" data-ready="true" loading="lazy"></iframe>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>





<style type="text/css">

    #modalVideo .modal-dialog {
      max-width: 800px;
      margin: 30px auto;
    }

    #modalVideo .modal-body {
      position:relative;
      padding:0px;
    }
    #modalVideo .close {
      position:absolute;
      right:-30px;
      top:0;
      z-index:999;
      font-size:2rem;
      font-weight: normal;
      color:#fff;
      opacity:1;
    }

    .conteudoCentro{
        background-color:#515151;
    }
    .conteudoCentro h1{ 
        color:#fff;
        margin-top: 35px;
        margin-bottom: 15px;
    }
    .conteudoCentro h3{
        color:#fff;
    }
    .conteudoCentro a{
        color:#fff;
    }
</style>


@endsection


