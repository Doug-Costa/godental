<?php
$tipoTopo = 'topoAzul';


$atigosUltimaRevista = $ultimaRevista[1]->productItems;
$key = array_rand($atigosUltimaRevista, 3);
$ultimoArtigo1 = $atigosUltimaRevista[$key[0]];
$ultimoArtigo2 = $atigosUltimaRevista[$key[1]];
$ultimoArtigo3 = $atigosUltimaRevista[$key[2]];


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


?>

@extends('layouts.master')

@section('content')



<div id="carouselExampleIndicators" class="carousel slide container-fluid" data-bs-ride="true" data-bs-interval="true">

        <div class="carousel-indicators  d-none d-md-flex">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

    
        <div class="carousel-item active" data-bs-interval="5000">
            <img src="http://novo.dentalgo.com.br/imagens/BANNER-ULTIMA-REVISTA-CLINICA.png" class="d-block w-100" alt="jcdr">
            <div class="carousel-caption conteudoBanner">
                <h1><b>Clinical Orthodontics</b></h1><br>
                <p style="font-family:prompt; font-size:20px; color:#414141;"><b> Venha ler a nova 
                 edição da revista<br>
                clinica mais completa do Brasil.</b></p> <br>
                <a href="{{ route('revista') }}/744/Clinical-2022-v21-n4/5" class="btn btn-dark">Leia Agora !</a>

           </div>
        </div>

        <div class="carousel-item" data-bs-interval="5000">
            <img src="http://novo.dentalgo.com.br/imagens/Banner-Perio.png" class="d-block w-100" alt="perio">
            <div class="carousel-caption conteudoBanner">
                <h1><b>Brazilian journal of periodontology</b></h1><br>
                <p style="font-family:prompt; font-size:20px; color:#ffffff;"><b> Aprofunde-se ainda mais
                 seu conhecimento em periodontologia<br>
                 o journal mais indispensável da área, já está disponivel !.</b></p> <br>
                <a href="{{ route('revista') }}/745/Periodontology-2022-v32n3/50" class="btn btn-success">Leia Agora !</a>
            </div>
        </div>

        
        <div class="carousel-item" data-bs-interval="5000">
            <img src="http://novo.dentalgo.com.br/imagens/BANNER-NOVA-JCDR.png" class="d-block w-100" alt="JCDR">
            <div class="carousel-caption conteudoBanner">
                <h1><b>Journal of Clinical Dentistry and Research </b></h1><br>
                <p style="font-family:prompt; font-size:20px; color:#414141;"><b> Estética odontológica discutida por quem entende.</b></p> <br>
                <a href="{{ route('revista') }}/745/Periodontology-2022-v32n3/50" class="btn btn-dark">Leia Agora !</a>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

<div class="container-fluid revistaApoiadoresFundoCol2">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 revistaApoiadoresCol2  d-none d-md-block">
                <div class="row">
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/quandoeondequiser.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Vídeos.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Descontos.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Livros.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/especialistas.png" style="width: 100%;">
                    </div>
                    <div class="col-4 col-sm-2">
                        <img src="{{ route('home') }}/imagens/iconVantagens/Novosconteúdos.png" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    
<!--
<div class="container-fluid revistaApoiadoresFundoCol3" style="background: #e5e5e5; filter: drop-shadow(0px 2px 2px #9999); margin-bottom: 10px;">
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
</div>
-->


<div class="container colecoesArtigos">
    <div class="row">
        <div class="col-lg-12 col-md-6">
                <h1 style="color:gray">Últimas Revistas</h1>
           <div class="row">
                @foreach ($colecoes[0]->collections->magazines as $revista)
                    <div class="col-lg-2 col-md-4 artigoFavContainer">
                        <div class="artigoFavSombra">
                            <div class="imagemRevistaCol">
                            <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none">
                                <img src="{{ $revista->lastProductCover }}" class="w-100" alt="{{ $ultimoArtigo1->title }}">
                                </a>
                              <!--  <h5 class="mb-0 text-center" style="color:#565656; font-family: prompt;">{{ $revista->title }}</h5> -->
                            </div>                                   
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<br>


<div class="container-fluid merchandiseContainer">
    <div class="container">
        <div class="row">

            <section id="slider2D">
                <div class="container">
                  <div class="slider col-md-12">
                       <h1 style="color:gray; margin-top: 50px;">Parceiros Apoiadores</h1>

                        <div class="owl-carousel owl-carousel-quatro">
                            
                        
                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/fgm-blanco.png" alt="fgm" >
                                    </a>            
                                </div>
                            </div>
                            
                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/SULZER.png" alt="Sulzer" >
                                    </a>            
                                </div>
                            </div>

                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/BIOLOGIX.png" alt="" >
                                    </a>            
                                </div>
                            </div>

                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/Dentsply.png" alt="" >
                                    </a>            
                                </div>
                            </div>

                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/IVOCLAR.png" alt="" >
                                    </a>            
                                </div>
                            </div>
                        
                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/STRAUMANN.png" alt="" >
                                    </a>            
                                </div>
                            </div>

                            <div class=" apoioPatrocionio col-md-6 d-flex justify-content-center align-items-center">
                                <div class="slider-card ">
                                    <a href="#" style="text-decoration: none">
                                        <img src="http://novo.dentalgo.com.br/imagens/3M.png" alt="" >
                                    </a>            
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>


<div class="container-fluid revistaTituloFundo2"> 
    <div class="container colecoesArtigos">
        <div class="row">
            <div class="container">
                <div class="row" style="webkit-box-shadow: 0px 3px 0px 0px rgb(0 0 0 / 41%); -moz-box-shadow: 0px 3px 0px 0px rgba(0,0,0,0.41); box-shadow: 0px 3px 0px 0px rgb(0 0 0 / 41%); margin-bottom: 25px;">
                    <div class="col-sm-12">
                        <h1 style="color:gray;">Artigos Recentes</h1>
                    </div>
                </div>
                <div class="row">
                    <article class="col-12 autorListaArtigo">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo1->title }}</h1>
                                <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo1->brief), 300, false) }}</p>
                                <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo1->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo1->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo1->title)) }}" style="margin-bottom: 25px;">Leia Mais</a>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{ $ultimoArtigo1->cover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid">
                            </div>
                        </div>
                    </article>
                </div>
                <div class="row">
                    <article class="col-12 autorListaArtigo">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo2->title }}</h1>
                                <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo2->brief), 300, false) }}</p>
                                <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo2->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo2->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo2->title)) }}" style="margin-bottom: 25px;">Leia Mais</a>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{ $ultimoArtigo2->cover }}" alt="{{ $ultimoArtigo2->title }}" class="img-fluid">
                            </div>
                        </div>
                    </article>
                </div>
                <div class="row">
                    <article class="col-12 autorListaArtigo" style="box-shadow: none;">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 style="margin-top: 0; margin-top: 0; font-size: 25px; font-weight: bold;">{{ $ultimoArtigo3->title }}</h1>
                                <h2 style="font-size: 20px;">{{ $ultimaRevista[1]->title }}</h2>
                                <p style="padding: 0; max-height: none; min-height: auto;">{{ limita_caracteres(strip_tags($ultimoArtigo3->brief), 300, false) }}</p>
                                <p style="padding: 0; max-height: none; min-height: auto; font-size: 18px; text-align: left;">Autores: @foreach ($ultimoArtigo3->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                <a type="button" class="btn btn-primary" href="{{ route('revista') }}/{{ $ultimaRevista[1]->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title)) }}/{{ $ultimoArtigo3->id }}/{{ str_replace('/', '-', str_replace(' ', '-', $ultimoArtigo3->title)) }}" style="margin-bottom: 25px;">Leia Mais</a>
                            </div>
                            <div class="col-sm-4">
                                <img src="{{ $ultimoArtigo3->cover }}" alt="{{ $ultimoArtigo3->title }}" class="img-fluid">
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="container-fluid revistaTituloFundo2"> 
    <div class="container colecoesArtigos">
         <div class="row">
            <div class="container">
                <div class="row">
                     <h1 style="color:gray">Artigos Recentes</h1>

                <div class="col-md-4 artigoFavContainer">
                    <div class="artigoFavSombra">
                        <div class="imagemArtigoFavorito">
                            <img src="{{ $ultimoArtigo1->cover }}" class="w-100" alt="{{ $ultimoArtigo1->title }}">
                        </div>
                        
                        <div class="fundoArtigo">
                            <h3 style="colecoesArtigos h3">{{ limita_caracteres(strip_tags($ultimoArtigo1->title), 100, false) }}</h3>
                            <p class="colecoesartigoFavTitutlo">{{ limita_caracteres(strip_tags($ultimoArtigo1->brief), 100, false) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 artigoFavContainer">
                    <div class="artigoFavSombra">
                        <div class="imagemArtigoFavorito">
                            <img src="{{ $ultimoArtigo2->cover }}" class="w-100" alt="{{ $ultimoArtigo2->title }}">
                        </div>
                        
                        <div class="fundoArtigo">
                            <h3 style="colecoesArtigos h3">{{ limita_caracteres(strip_tags($ultimoArtigo2->title), 100, false) }}</h3>
                            <p class="colecoesartigoFavTitutlo">{{ limita_caracteres(strip_tags($ultimoArtigo2->brief), 100, false) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 artigoFavContainer">
                    <div class="artigoFavSombra">
                        <div class="imagemArtigoFavorito">
                            <img src="{{ $ultimoArtigo3->cover }}" class="w-100" alt="{{ $ultimoArtigo3->title }}">
                        </div>
                        
                        <div class="fundoArtigo">
                            <h3 style="colecoesArtigos h3">{{ limita_caracteres(strip_tags($ultimoArtigo3->title), 100, false) }}</h3>
                            <p class="colecoesartigoFavTitutlo">{{ limita_caracteres(strip_tags($ultimoArtigo3->brief), 100, false) }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
-->



@endsection

