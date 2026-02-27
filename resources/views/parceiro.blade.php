<?php
$paginaTitulo = 'Canal DVI - DentalGo';
$tipoTopo = 'topoPreto';
$assinar = 0;
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

$materias = $canal[4];
$videos = $canal[5];
?>
@extends('layouts.master')

@section('content')
   <style>
      .background-dvi{
      background-image: url("{{ asset('imagens/DVIbanner/background-DVI.png') }}");
      background-size: cover; 
      background-position: center; 
      height: 300px;
      display: flex; 
      align-items: center; 
      justify-content: center;
    }

    .imgDvi{
      width: 200px;
      transition: transform 1.2s; /* Animation */
    }
    .imgDvi:hover {
      transform: scale(1.2);
    }

    .textoDvi{
      color:white;
      padding-bottom: 20px;
      text-align: center !important;
    }

    .botaoDvi{
      background-color: white;
      color:#508d89;
      font-weight: bold;
      margin-right:30px;
      padding:5px 40px 5px 40px;
      border-radius: 20px;
      border:none;
      transition: ease 0.5s;
      text-align: center !important;
      margin-left: 13px !important;
    }

    .botaoDvi:hover{
      background-color: #58b4ae !important;
      color: #fff !important;
    }

    .botaoDvi:active {
      color: #fff !important;
      background-color: #ccc !important;
      border-color: #508d90 !important;
    }

    .slide {
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    margin: 20px;
  
  }
  .caixaArtigo {
    font-family: sans-serif;
    font-size: 30px;
    color: gray;
    font-weight: bold;
    text-align: left;
    word-spacing: 5px;
    margin-right: 50px;
  }
  .caixaSubArtigo {
    font-family: sans-serif;
    font-weight: lighter;
    color: #959595;
    text-align: justify;
    font-size: 25px;
    word-spacing: 5px;
    margin-right: 50px;
  }
  .leia-mais {
    display: block;
    margin-top: 10px;
  }
  
  .boxbordas {
    border-top: 3px solid #ccc;
    padding-top: 50px;
    padding-bottom:15px;
    margin-top: 50px;
  }

  .leia-mais-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #52918d;
    color: #fff;
    font-family: sans-serif;
    border-radius: 10px;
    text-decoration: none !important;
    transition: background-color 0.3s;
    transition: ease 0.5s;
    float: left;
    margin-bottom:50px !important;
    border: 2px solid #52918d !important; 
   }
  
  .leia-mais-btn:hover {
    background-color: #fff;
    color: #52918d;
   }

   .leia-mais-btn:active {
      border: 2px solid #58b4ae !important; 
      color: #fff !important;
      background-color: #58b4ae !important;
   }

   .background-public{
      background-image: url("{{ asset('imagens/DVIbanner/DVI-banner-public.png') }}");
      background-size: cover; 
      background-position: center; 
      height: 500px; 
      display: flex; 
      align-items: center;  
      justify-content: center;
    }

    .titulo{
      font-size:30px;
      color: #ccc;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      font-weight: bold;
      margin-left: 20px;
      transition: 0.5s ease;
    }

    .titulo:hover {
      color: gray;
    }

    .subTitulo{
      font-size:23px;
      color:  #52918d;
      font-family: sans-serif;
      font-weight:bold;
      letter-spacing: 2px;
      margin-top:20px;
      margin-bottom:20px;
    }

    .lead2{
      color: #ccc;
      margin-bottom:150px;
      font-size:20px;
    }

    .fotoVideo{
      height:200px;
      margin-top:50px;
    }
    
    .noticia{
      /*width: 80%;
      height: 90%;*/
      box-shadow: -7px 7px 25px 0px rgba(0, 0, 0, 0.75); 
    }

    .espacamentoParceiro{
      margin-top:40px;
    }

    
    .videoDVI{
      margin-top:50px;
      margin-left:50px;
    }

    .tituloVideo{
      font-family: sans-serif;
      font-size: 30px;
      color: gray;
      font-weight: bold;
      margin-top:50px;
    }
    
    .videoPlayer{
      margin-top: 50px;
      margin-bottom: 100px;
    }
    

    @media (min-width:0px) and (max-width: 400px){

      .videoPlayer{
      margin-top: -50px;
      margin-bottom: 100px;
      } 

      .background-dvi{
         height:500px;
         width:100% !important;
      }

      .textoDvi{
         padding-top:20px;
         text-align: center !important;

      }

      .caixaArtigo{
         font-size:25px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .caixaSubArtigo{
         font-size:20px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .noticia{
         margin-top:20px;
      }

      .background-public{
         height:200px;
      }

      .videoDVI{
         margin-left:0px !important;
         width:520px;
      }
      
      .leia-mais-btn{
         margin-left:100px;
      }

      .titulo{
      font-size:23px;
      color: #ccc;
      text-align: center !important;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }

    .tituloVideo{
      font-family: sans-serif;
      font-size: 30px;
      text-align:center !important;
      color: gray;
      font-weight: bold;
      margin-top:30px;
      margin-bottom: 30px;
    }

    .botaoDvi{
      display:inline-block;
      text-align: center !important;
      padding: 5px 20px 5px 20px;
    }

    }

    @media (min-width: 400px) and (max-width: 576px){
      .background-dvi{
         height:400px;
         width:100% !important;
      }
      
      .videoPlayer{
      margin-top: -50px;
      margin-bottom: 100px;
      } 
   }
    
    @media (min-width: 575px) and (max-width: 700px){

      .videoPlayer{
      margin-top: -50px;
      margin-bottom: 100px;
      margin-left: 0px;
      } 

      .botaoDvi{
      display:inline-block;
      text-align: center !important;
      padding: 5px 15px 5px 15px !important;
      margin-right: 10px;
      margin-left: 0px !important;
    }
    .titulo{
      font-size:23px;
      color: #ccc;
      text-align: center !important;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }
    }

    @media (min-width:400px) and (max-width:575px) {
      .titulo{
      font-size:23px;
      color: #ccc;
      text-align: center !important;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }
    }
    

    @media (min-width: 700px) and (max-width: 991.98px){

      .videoPlayer{
      margin-top: 50px;
      margin-bottom: 100px;
      margin-left: 0px;
      } 

      .caixaArtigo{
         font-size:25px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .caixaSubArtigo{
         font-size:20px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .titulo{
      font-size:23px;
      color: #ccc;
      text-align: center !important;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      font-weight: bold;
      word-spacing: 2px;
      margin-left: 0px;
    }


      /*.noticia{
         height:80%;
         width:100%;
      }*/

      .caixaArtigo{
         font-size:20px;
      }

      .caixaSubArtigo{
         font-size:15px;
      }

      .background-public{
         width:100%;
         height:200px;
      }

      .owl-prev {
      position: absolute;
      left: 10px; /* Posição da seta esquerda */
      top: 50%;
      transform: translateY(-1200%) !important;
      }

      .owl-next {
      position: absolute;
      right: 10px; /* Posição da seta direita */
      top: 50%;
      transform: translateY(-1200%) !important;
      }

      .botaoDvi{
         display: inline-block;
         padding: 5px 20px 5px 20px;
         text-align: center !important;
         margin-left: 8px !important;
         margin-right: 0px;
      }


    }

    @media (min-width: 1024px) and (max-width: 1120px){


      .caixaArtigo{
         font-size:25px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .caixaSubArtigo{
         font-size:20px;
         text-align:justify !important;
         margin-right: 0px;
         word-spacing: -2px !important;
      }

      .titulo{
      font-size:23px;
      color: #ccc;
      text-align: center !important;
      font-family: sans-serif;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }

      .owl-prev {
      position: absolute;
      left: 10px; /* Posição da seta esquerda */
      top: 50%;
      transform: translateY(-550%) !important;
      }

      .owl-next {
      position: absolute;
      right: 10px; /* Posição da seta direita */
      top: 50%;
      transform: translateY(-550%) !important;
      }


    }


    #slider3D {
  /* Estilo para o carousel */
}

.btn-background-public {
   background-color: transparent;
   font-weight: bold;
   margin-top: 0px;
   padding: 5px 10px;
   margin-left: 150px;
   font-size: 18px;
   border-color: #52918d;
   color: #52918d;
   align-items: left;
   border-radius: 10px;
   border: 2px solid;
   transition: 0.5s ease-in-out;
}

.btn-background-public:hover {
   border-color: #52918d;
   background-color: #52918d;
   color: #fff;
}

@media (max-width:768px) {
   .btn-background-public {
      margin-top: 250px;
      padding: 2px 50px;
      margin-left: 50px;
      font-size: 15px;
   }
   .occult-mobile {
      display:none;
   }
}

@media (min-width: 900px) {
   .occult-desktop {
      display:none;
   }
}

.owl-prev,
.owl-next {
  font-size: 30px;
  color: black; /* Setas pretas */
  background-color: transparent;
  border: none;
  outline: none;
  transition: 0.5s ease;
}

.custom-nav {
  position: relative;
  z-index: 1;
}

.owl-prev {
  position: absolute;
  left: 10px; /* Posição da seta esquerda */
  top: 50%;
  transform: translateY(-700%);
}

.owl-next {
  position: absolute;
  right: 10px; /* Posição da seta direita */
  top: 50%;
  transform: translateY(-700%);
}

.owl-prev:hover,
.owl-next:hover {
  cursor: pointer;
  color: gray;
}

.expand-all-items {
   transition: all 0.5s ease-in-out;
}
.expand-all-items:hover {
   transform: scale(1.1, 1.1);
   cursor: pointer;
}
.titulo-ultimas {
   cursor: pointer;
}
   </style>

   <div class="container-fluid background-dvi">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-6 col-md-6 col-sm-6 text-center">
          <a href="https://www.dviradiologia.com.br/" target="_blank"><img src="{{ asset('imagens/DVIbanner/DVI icon.png') }}" alt="dvi-banner" class="imgDvi"></a>
          </div>
          <div class=" col-12 col-lg-6 col-md-6 col-sm-6 ">
            <p class="lead textoDvi">Pioneira em seu segmento, a DVI Radiologia Odontológica, nasceu com o objetivo de contribuir para a melhoria do cotidiano dos cirurgiões dentistas.</p>
               <!--<div class="col-12 text-center" style= "text-align: center !important;">
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">VÍDEOS</button>
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">Artigos</button>
               </div>-->
          </div>
        </div>
      </div>
   </div>

   <div class="container VideoRecente">
      <div class="col-sm-12">
         <div class="row">
            <h3 class="tituloVideo">{{__("messages.VideosTitulo")}}<a href="https://www.youtube.com/@DVIRadiologia" target="_blank" style="color:gray; text-decoration: none;"><small style="font-size: 13px; margin-left: 30px;"> {{__("messages.HomeBladeVeja")}} <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></small></a></h3>
         </div>
      </div>
      <div class="col-12">
         <div class="row">
            @foreach($videos[0]->productItems as $index => $video)
               <?php
                  if (empty($video->content)) {
                      $hashVideo = '';
                  }else{
                      $hashVideo = explode('/', $video->content);
                      $hashVideo = $hashVideo[2];
                  }
                  
               ?>
            
               <div class="col-12 col-md-6" style="margin-bottom: 15px;">
                  <button id="VideoId{{$video->id}}" class="video-btn videoButaum" data-bs-toggle="modal" data-bs-target="#modalVideo" data-src="{{ $hashVideo }}">
                     <img src="{{ $video->cover }}" class="videoImagem" alt="{{ $video->title }}">
                     <label style="display: none;">
                         {{ $video->title }}
                     </label>
                  </button>
               </div>
            @endforeach
         </div>
      </div>
      <!--<div class="container-fluid">
         <section id="slider3D">      
            <div class="slider">
               <div class="owl-carousel owl-carousel-cinco">
                  <div class="slider-card">
                     <div class="d-flex justify-content-center align-items-center">
                        <div class="item"><img src="{{ asset('imagens/DVIbanner/DVI1.jpg') }}"></div>
                     </div>
                  </div>   
                  <div class="slider-card">   
                     <div class="d-flex justify-content-center align-items-center">   
                        <div class="item"><img src="{{ asset('imagens/DVIbanner/DviCarousel2.jpg') }}"></div>
                     </div>
                  </div>
                  <div class="slider-card">   
                     <div class="d-flex justify-content-center align-items-center">   
                        <div class="item"><img src="{{ asset('imagens/DVIbanner/DviCarousel3.jpg') }}"></div>
                     </div>   
                  </div> 
               </div>
            </div>
         </section>

         <div class="custom-nav">
            <button class="carousel-custom-prev owl-prev" type="button">
               <i class="fa fa-chevron-left"></i>
            </button>

            <button class="carousel-custom-next owl-next" type="button">
               <i class="fa fa-chevron-right"></i>
            </button>
         </div>


      </div>-->
   </div>


   <div class="container">
      <div class="row">
        <h1 class="titulo titulo-ultimas">ÚLTIMAS NOTICIAS</h1>
         <div class="container">
            <div class="slide espacamentoParceiro">
               <div class="row">
                  @foreach($materias[0]->productItems as $index => $materia)
                      <div class="col-12 col-lg-6 col-md-8">
                          <h3 class="caixaArtigo">{{$materia->title}}</h3>
                          <p class="caixaSubArtigo">
                              {{ limita_caracteres(strip_tags( strip_tags($materia->contentText) ), 300, false) }}
                          </p>
                          <button type="button" class="btn leia-mais-btn" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$materia->id}}">Leia mais</button>     
                      </div>        
                      <div class="col-12 col-lg-6 col-md-4">
                          <img src="{{$materia->cover}}" alt="{{$materia->title}}" class="img-fluid noticia">
                      </div>      
                      @if (! $loop->last)
                          <div class="boxbordas"></div>
                      @endif
                      <!-- Modal do artigo -->
                      <div class="modal fade" id="leiaCapitulo{{$materia->id}}" aria-labelledby="leiaCapitulo{{$materia->id}}"  tabindex="-1"  aria-hidden="true">
                       <div class="modal-dialog" style="--bs-modal-width: 98%;">
                         <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="leiaCapitulo{{$materia->id}}">{{ $materia->title }}</h5>
                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                           </div>
                           <div class="modal-body" style="text-align: left;">
                              @php
                              echo $materia->contentText;
                             @endphp
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
                           </div>
                         </div>
                       </div>
                     </div>
                  @endforeach
               </div>    
            </div>
         </div>
      </div>
   </div>

   <div class="container-fluid background-public d-flex justify-content-start">
      <a href="https://www.dviradiologia.com.br/" target="_blank"><button class="btn-background-public occult-mobile text-left">ACESSE O </BR> NOSSO SITE</button></a>
      <a href="https://www.dviradiologia.com.br/" target="_blank"><button class="btn-background-public occult-desktop text-left">ACESSE O NOSSO SITE</button></a>
   </div>

<div class="container">
   <div class="row">
      <div class="col-lg-7 col-md-7">
         <a href="https://www.dviradiologia.com.br/" style="text-decoration: none;" target="_blank"><h4 class="titulo">DVI RADIOLOGIA ODONTOLÓGICA</h4></a>
         <h4 class="subTitulo">TEMOS A EXPERIÊNCIA PARA TE LEVAR MAIS ALTO COM SEGURANÇA</h4>
         <p class="lead2">
            Pioneira em seu segmento, a DVI Radiologia Odontológica, nasceu com o objetivo de contribuir para a melhoria do cotidiano dos cirurgiões dentistas, estendendo seus benefícios para pacientes de diversas especialidades odontológicas, oferecendo um serviço diagnóstico de alta qualidade.<br><br>
            Com uma equipe de profissionais altamente qualificada, a DVI é a maior rede de radiologia odontológica do país.<br><br>
            A cultura de gestão e excelência no atendimento aos pacientes e profissionais tem se tornado um grande diferencial do grupo DVI como referência de atendimento e qualidade diagnóstica.
          </p>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 text-center" style="padding-top: 50px;">
         <iframe width="100%" height="315" src="https://www.youtube.com/embed/mVShOaG9Dak" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
   </div>
</div>

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

</style>

@endsection