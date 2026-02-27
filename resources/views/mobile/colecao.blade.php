<?php
$paginaTitulo = $colecao[0]->title.' - DentalGo';
$padinaDescricao = '';

$tipoTopo = 'topoAzul';
?>
@extends('layouts.master')

@section('content')



<?php
//$colecaoOrdenada = $colecao->orderBy('products->publishDate', 'desc');
// INFORMAÇÃO DAS COLECOES
$todasColecoes = $colecoes;
// INFORMAÇÃO DA ESPECIFICA COLECAO
$recebidoC = $colecao;
$colecoes = collect($colecao[1])->sortBy('count')->reverse()->toArray();

$linguagem = request('language');
if($linguagem == null){
  $linguagem = 'pt';
}

$produtosIds = array('857', '886', '850', '826','895','963','998','1044', '1056', '1050', '1044');
?>



<div class="container-fluid produtoTopo produtoTopo{{$recebidoC[0]->id}}">
    <div class="container containerColecao">
        <div class="row">
            <img src="{{ $recebidoC[0]->cover }}">
        </div>
    </div>
</div>

<div class="container-fluid revistaApoiadoresFundoCol">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 revistaApoiadoresCol">
                        <div class="row">
                            <!--
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/apoio_institucional.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/biologix(1).png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/fgm.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/sulzer(1).png">
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>{{ $colecao[0]->title }}</h1>
        </div>
    </div>

  

    @foreach ($colecoes as $keyAno => $colecaof)
        <div class="row">
            <div class="col-sm-12">
                <h3 class="sombraAno">{{ $keyAno }}</h3>
            </div>

            @foreach ($colecaof as $key => $revista)
          
                <article class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                        <h1 class="colecaoRound">
                            {{ $revista->title }}
                        </h1>
                        @if($keyAno >= '2023' && ($colecao[0]->id == '5'))
                        <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <div class="d-flex" >
                                <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"  class="img-fluid logo-abor-revista-colecao mostrar-imagem imagem-portugues imagem-ingles"  style=" @if($linguagem == 'es') display:none; @endif">
                                <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"  class="img-fluid logo-alado-revista-colecao mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" >
                            </div>
                        @elseif($colecao[0]->id)
                        <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                        @endif
                    </a>
                        @foreach($revista->availableLanguages as $linguagensDisponiveis)
                            @if($linguagensDisponiveis == 'pt')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=pt" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/pt.png') }}" >
                                </a>    
                            @elseif($linguagensDisponiveis == 'es')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=es" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/esp.png') }}">
                                </a>    
                            @elseif($linguagensDisponiveis == 'en')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=en" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/ing.png') }}">
                                </a>
                            @endif
                        @endforeach
                       
                        <p style="display: none !important;">{{ $revista->brief }}</p>
                    
                </article>
            @endforeach

            @if($keyAno == '2024')
                @if($colecao[0]->id == '5')
                <!-- Revista Clínica de Ortodontia Dental Press -->
                    @php
                    $empresasComercial = [
                        [
                            'nome' => 'Easy3d',
                            'link' => 'https://www.easy3d.com.br/',
                            'imagem' => 'bannersComercial/Easy-3D-Mobile-1024x1024.png'
                        ],
                        [
                            'nome' => 'ID-Logical',
                            'link' => 'https://www.id-logical.com/',
                            'imagem' => 'bannersComercial/Banner-idlogical-mobile.png'
                        ],
                        [
                            'nome' => 'ORTHOMETRIC',
                            'link' => 'https://www.orthometric.com.br/',
                            'imagem' => 'bannersComercial/orthometricmobile.jpg'
                        ]
                    ];

                    $institutions = [
                        
                    ];
                    shuffle($empresasComercial);
                    shuffle($institutions);
                    $arrayFinal = array();

                    while (count($empresasComercial)>0 || count($institutions)>0) {
                        if (count($empresasComercial)>0) {
                            $randomEmpresa = array_shift($empresasComercial);
                            $arrayFinal[] = [
                                'nome' => $randomEmpresa['nome'],
                                'link' => $randomEmpresa['link'],
                                'imagem' => $randomEmpresa['imagem'],
                                'tipo' => 'empresa'
                            ];
                        }
                        if (count($institutions)>0) {
                            $randomInstituicao = array_shift($institutions);
                            $arrayFinal[] = [
                                'nome' => $randomInstituicao['nome'],
                                'link' => $randomInstituicao['link'],
                                'imagem' => $randomInstituicao['imagem'],
                                'tipo' => 'instituicao'
                            ];
                        }
                    }
                    @endphp
                    <div class="col-sm-12">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                 <a href="{{ $empresa['link'] }}" target="_blank">
                                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
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
                    </div> 
                    </div>
                @elseif($colecao[0]->id == '6')
                <!-- Revista Clínica de Ortodontia Dental Press -->
                    @php
                    $empresasComercial = [
                        [
                            'nome' => 'Easy3d',
                            'link' => 'https://www.easy3d.com.br/',
                            'imagem' => 'bannersComercial/Easy-3D-Mobile-1024x1024.png'
                        ],
                        [
                            'nome' => 'ID-Logical',
                            'link' => 'https://www.id-logical.com/',
                            'imagem' => 'bannersComercial/Banner-idlogical-mobile.png'
                        ],
                        [
                            'nome' => 'ORTHOMETRIC',
                            'link' => 'https://www.orthometric.com.br/',
                            'imagem' => 'bannersComercial/orthometricmobile.jpg'
                        ]
                    ];

                    $institutions = [
                        
                    ];
                    shuffle($empresasComercial);
                    shuffle($institutions);
                    $arrayFinal = array();

                    while (count($empresasComercial)>0 || count($institutions)>0) {
                        if (count($empresasComercial)>0) {
                            $randomEmpresa = array_shift($empresasComercial);
                            $arrayFinal[] = [
                                'nome' => $randomEmpresa['nome'],
                                'link' => $randomEmpresa['link'],
                                'imagem' => $randomEmpresa['imagem'],
                                'tipo' => 'empresa'
                            ];
                        }
                        if (count($institutions)>0) {
                            $randomInstituicao = array_shift($institutions);
                            $arrayFinal[] = [
                                'nome' => $randomInstituicao['nome'],
                                'link' => $randomInstituicao['link'],
                                'imagem' => $randomInstituicao['imagem'],
                                'tipo' => 'instituicao'
                            ];
                        }
                    }
                    @endphp
                    <div class="col-sm-12">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                 <a href="{{ $empresa['link'] }}" target="_blank">
                                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
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
                    </div> 
                    </div>

                    @elseif($colecao[0]->id == '4')
                <!-- Revista Estética -->
                    @php
                    $empresasComercial = [
                        [
                            'nome' => 'CVdentus',
                            'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press?utm_source=direct&utm_medium=link&utm_campaign=dental-press',
                            'imagem' => 'bannersComercial/BANNERDENTALPRES1080X1080MOBILE(1).jpg'
                        ]
                    ];

                    $institutions = [
                        
                    ];
                    shuffle($empresasComercial);
                    shuffle($institutions);
                    $arrayFinal = array();

                    while (count($empresasComercial)>0 || count($institutions)>0) {
                        if (count($empresasComercial)>0) {
                            $randomEmpresa = array_shift($empresasComercial);
                            $arrayFinal[] = [
                                'nome' => $randomEmpresa['nome'],
                                'link' => $randomEmpresa['link'],
                                'imagem' => $randomEmpresa['imagem'],
                                'tipo' => 'empresa'
                            ];
                        }
                        if (count($institutions)>0) {
                            $randomInstituicao = array_shift($institutions);
                            $arrayFinal[] = [
                                'nome' => $randomInstituicao['nome'],
                                'link' => $randomInstituicao['link'],
                                'imagem' => $randomInstituicao['imagem'],
                                'tipo' => 'instituicao'
                            ];
                        }
                    }
                    @endphp
                    <div class="col-sm-12">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                 <a href="{{ $empresa['link'] }}" target="_blank">
                                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
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
                    </div> 
                    </div>
                    @elseif($colecao[0]->id == '50')
                        <!-- Revista Clínica de Ortodontia Dental Press -->
                            @php
                            $empresasComercial = [
                                [
                                    'nome' => 'CVdentus',
                                    'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press?utm_source=direct&utm_medium=link&utm_campaign=dental-press',
                                    'imagem' => 'bannersComercial/BANNERDENTALPRES1080X1080MOBILE(1).jpg'
                                ]
                            ];

                            $institutions = [
                                
                            ];
                            shuffle($empresasComercial);
                            shuffle($institutions);
                            $arrayFinal = array();

                            while (count($empresasComercial)>0 || count($institutions)>0) {
                                if (count($empresasComercial)>0) {
                                    $randomEmpresa = array_shift($empresasComercial);
                                    $arrayFinal[] = [
                                        'nome' => $randomEmpresa['nome'],
                                        'link' => $randomEmpresa['link'],
                                        'imagem' => $randomEmpresa['imagem'],
                                        'tipo' => 'empresa'
                                    ];
                                }
                                if (count($institutions)>0) {
                                    $randomInstituicao = array_shift($institutions);
                                    $arrayFinal[] = [
                                        'nome' => $randomInstituicao['nome'],
                                        'link' => $randomInstituicao['link'],
                                        'imagem' => $randomInstituicao['imagem'],
                                        'tipo' => 'instituicao'
                                    ];
                                }
                            }
                            @endphp

                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="sombraAno">{{__("messages.ArtigoBladePublicidade")}}</h3>
                                </div>  

                            <div class="col-sm-12">
                            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach ($arrayFinal as $keyBanner => $empresa)
                                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                                    @endforeach
                                </div>

                                <div class="carousel-inner">
                                    @foreach ($arrayFinal as $keyBanner => $empresa)
                                        <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                        <a href="{{ $empresa['link'] }}" target="_blank">
                                            <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
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
                            </div> 
                            </div>
                @endif
            @endif

        </div>
    @endforeach
</div>
@endsection
