<?php
$paginaTitulo = 'Coleções de Revistas - DentalGo';
$padinaDescricao = '';

$tipoTopo = 'topoAzul';
$tipoBanner = 'bannerOrto';

$atigosUltimaRevista = $ultimaRevista[1]->productItems;
if (count($atigosUltimaRevista) < 3) {
    $key = array_rand($atigosUltimaRevista, 2);
    $ultimoArtigo1 = $atigosUltimaRevista[$key[0]];
    $ultimoArtigo2 = $atigosUltimaRevista[$key[1]];
    $ultimoArtigo3 = null;
}else{
    $key = array_rand($atigosUltimaRevista, 3); 
    $ultimoArtigo1 = $atigosUltimaRevista[$key[0]];
    $ultimoArtigo2 = $atigosUltimaRevista[$key[1]];
    $ultimoArtigo3 = $atigosUltimaRevista[$key[2]]; 
}


function limita_caracteres($texto, $limite, $quebra = true){
   $tamanho = strlen($texto);
   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
      $novo_texto = $texto;
   }else{ // Se o tamanho do texto for maior que o limite
      if($quebra == true){ // Verifica a opção de quebrar o texto
         $novo_texto = trim(substr($texto, 0, $limite))."...";
      }else{ // Se não, corta $texto na última palavra antes do limite
         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
         $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
      }
   }
   return $novo_texto; // Retorna o valor formatado
}
$linguagem = request('language');
if($linguagem == null){
  $linguagem = 'pt';
}

$produtosIds = array('857', '886', '850', '826','895','963','998','1044', '1056', '1050', '1044');

?>

@extends('layouts.master')

@section('content')


@php
$revistaBanner = [
    [
        'link' => '1001/Endodontics-2024-v14n1',
        'imagem' => 'BannerENDOMobile2024.fw.png',
        'titulo' => '',
        'conteudo' => '',
        'botao' => '',
        'css' => ''
    ],
    [
        'link' => '1054/Journal-2024-v29n5',
        'imagem' => 'BANNERDPJOMOBILEV24N4.png',
        'titulo' => '', 
        'conteudo' => '', 
        'botao' => '',
        'css' => ''
    ],
    [
        'link' => '1002/Orofacial-Harmony-2023-v1n3',
        'imagem' => 'BannerHOFMobile2024.fw.png',
        'titulo' => '',
        'conteudo' => '',
        'botao' => '',
        'css' => ''
    ],
    [
        'link' => '1056/Clínical-2024-v23n04',
        'imagem' => 'BannerClinical1Mobile2024.fw.png', 
        'titulo' => '',
        'conteudo' => '',
        'botao' => '',
        'css' => ''
    ],
    [
        'link' => '1057/Estética-%7C-JCDR-2024-v21n2/4',
        'imagem' => 'estetica2024NOVO---mobile.fw.png',
        'titulo' => '',
        'conteudo' => '',
        'botao' => '',
        'css' => ''
    ],
];

$videoBanner = [
    
];
shuffle($revistaBanner);
shuffle($videoBanner);
$arrayFinal = array();

while (count($revistaBanner)>0 || count($videoBanner)>0) {
    if (count($revistaBanner)>0) {
        $randomEmpresa = array_shift($revistaBanner);
        $arrayFinal[] = [
            'link' => $randomEmpresa['link'],
            'imagem' => $randomEmpresa['imagem'],
            'titulo' => $randomEmpresa['titulo'],
            'conteudo' => $randomEmpresa['conteudo'],
            'botao' => $randomEmpresa['botao'],
            'css' => $randomEmpresa['css'],
            'tipo' => 'revista'

        ];
    }
    if (count($videoBanner)>0) {
        $randomInstituicao = array_shift($videoBanner);
        $arrayFinal[] = [
            'link' => $randomInstituicao['link'],
            'imagem' => $randomInstituicao['imagem'],
            'titulo' => $randomInstituicao['titulo'],
            'conteudo' => $randomInstituicao['conteudo'],
            'botao' => $randomInstituicao['botao'],
            'css' => $randomInstituicao['css'],
            'tipo' => 'video'
        ];
    }
}
@endphp
<!-- <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach ($arrayFinal as $keyBanner => $empresa)
            <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach ($arrayFinal as $keyBanner => $empresa)
            <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                @if($empresa['tipo'] == 'revista')
                <a href="{{ route('revista') }}/{{ $empresa['link'] }}">
                @elseif($empresa['tipo'] == 'video')
                <a href="{{ route('video') }}/{{ $empresa['link'] }}">
                @endif
                    <img src="{{ asset('imagens') }}/banners/{{ $empresa['imagem'] }}" class="d-block w-100" alt="clinical">
                    <div class="carousel-caption conteudoBanner">
                    </div>
                </a>
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
</div> -->


<!-- <div class="container-fluid revistaApoiadoresFundoCol3" style="background: #e5e5e5; filter: drop-shadow(0px 2px 2px #9999); margin-bottom: 10px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 revistaApoiadoresCol3"> 
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
    </div>
</div> -->



<div class="container colecoesArtigos">
    <div class="row">
        <div class="col-lg-12 col-md-12">
                <h1 style="color:gray">{{__("messages.HomeBannerUltimasRevistas")}}</h1>
        </div>
    </div>
    <style>
      @media (max-width: 767px) {
        /* Para dispositivos móveis, coloque as imagens em 2 colunas */
        .imagem-col {
          flex: 0 0 50%; /* Cada imagem ocupa metade da largura */
          max-width: 50%;
          margin-bottom: 15px; /* Adicione margem inferior para separar as imagens */
          box-sizing: border-box; /* Certifique-se de que as margens e preenchimentos não aumentem a largura */
        }
        /* .primeira-imagem {
          flex: 0 0 100%;       A primeira imagem ocupa a largura inteira 
          max-width: 100%;
        }
        .primeira-imagem img {
          width: 100%;          Ajuste o tamanho da imagem para preencher a largura
          height: auto;         Garanta que a altura seja ajustada automaticamente
          margin-bottom: 0;     Remova a margem inferior da primeira imagem
        } */
        }
    </style>
    <div class="row">
      @foreach ($colecoes[0]->collections->magazines as $index => $revista)
        <div class="col imagem-col"> <!--imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}-->
          <div class="artigoFavSombraRevistas">
            <div class="imagemultimaRevistaCol">
              <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none;">
                    <img src="{{ $revista->lastProductCover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid">
                    @if($index === 0 ? ' primeira-imagem' : '' )
                        <div class="d-flex" style="position: absolute; max-width: 50%; ">
                            <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"  class="img-fluid logo-abor-revista-mobile mostrar-imagem imagem-portugues imagem-ingles"  style=" @if($linguagem == 'es') display:none; @endif max-height: 25px; margin: -45px 0 0 25px;">
                            <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"  class="img-fluid logo-alado-revista-mobile mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" style="max-height: 75px; margin: -70px 0 0 20px;">                            
                        </div>
                    @endif
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

<br>


<div class="container-fluid revistaTituloFundo2"> 
    <div class="container colecoesArtigos">
        <div class="row">
            <div class="container">
                <div class="row" style="webkit-box-shadow: 0px 3px 0px 0px rgb(0 0 0 / 41%); -moz-box-shadow: 0px 3px 0px 0px rgba(0,0,0,0.41); box-shadow: 0px 3px 0px 0px rgb(0 0 0 / 41%); margin-bottom: 25px;">
                    <div class="col-sm-12">
                        <h1 style="color:gray;">{{__("messages.HomeArtigosRecentes")}}</h1>
                    </div>
                </div>
                <div class="row">
                    <article class="col-12 autorListaArtigo">
                        <div class="row">
                            <div class="col-sm-4">
                                <img src="{{ $ultimoArtigo1->cover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid">
                            </div>
                            <div class="col-sm-8">
                                <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo1->title }}</h1>
                                <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo1->brief), 300, false) }}</p>
                                <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo1->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo1->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo1->title)) }}" style="margin-bottom: 25px;">{{__("messages.ColecoesLeia")}}</a>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="row">
                    <article class="col-12 autorListaArtigo">
                        <div class="row">
                            <div class="col-sm-4">
                                <img src="{{ $ultimoArtigo2->cover }}" alt="{{ $ultimoArtigo2->title }}" class="img-fluid">
                            </div>
                            <div class="col-sm-8">
                                <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo2->title }}</h1>
                                <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo2->brief), 300, false) }}</p>
                                <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo2->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo2->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo2->title)) }}" style="margin-bottom: 25px;">{{__("messages.ColecoesLeia")}}</a>
                            </div>
                        </div>
                    </article>
                </div>
                @if($ultimoArtigo3 !== null)
                    <div class="row">
                        <article class="col-12 autorListaArtigo" style="box-shadow: none;">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="{{ $ultimoArtigo3->cover }}" alt="{{ $ultimoArtigo3->title }}" class="img-fluid">
                                </div>
                                <div class="col-sm-8">
                                    <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo3->title }}</h1>
                                    <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                    <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo3->brief), 300, false) }}</p>
                                    <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo3->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                    <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo3->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo3->title)) }}" style="margin-bottom: 25px;">{{__("messages.ColecoesLeia")}}</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

