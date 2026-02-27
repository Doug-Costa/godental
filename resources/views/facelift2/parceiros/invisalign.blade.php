<?php
$paginaTitulo = 'Canal Invisalign - DentalGo';
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
@extends('facelift2.master')

@section('content')
   <style>
      body {
         background-image: url("{{ asset('imagens/canais/invisalign/jpg-suave.jpg') }}");
      }
      .background-align{
      background-image: url("{{ asset('imagens/canais/invisalign/background-invisalign.fw (2).fw.png') }}");
      background-size: cover; 
      background-position: center; 
      height: 460px;
      display: flex; 
      align-items: center; 
      justify-content: center;
    }

    .imgDvi{
      width: 100%;
      margin-top: 100px;
      transition: transform 0.5s; /* Animation */
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
    font-family: neue-haas;
    font-size: 30px;
    color: #3D3935;
    font-weight: bold;
    text-align: left;
    word-spacing: 5px;
    margin-right: 50px;
  }
  .caixaSubArtigo {
    font-family: neue-haas;
    font-weight: lighter;
    color: #959595;
    text-align: justify;
    font-size: 20px;
    word-spacing: 0px;
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
    background-color: #009ACE;
    color: #fff;
    font-family: neue-haas;
    border-radius: 10px;
    text-decoration: none !important;
    transition: background-color 0.3s;
    transition: ease 0.5s;
    float: left;
    margin-bottom:50px !important;
    border: 2px solid #009ACE !important; 
   }
  
  .leia-mais-btn:hover {
    background-color: #fff;
    color: #009ACE;
   }

   .leia-mais-btn:active {
      border: 2px solid #009ACE !important; 
      color: #fff !important;
      background-color: #009ACE !important;
   }

   .background-public{
      background-image: url("{{ asset('imagens/canais/invisalign/BannerALIGN.png') }}");
      -webkit-background-size: cover;
      -moz-background-size: cover;
      background-size: cover;
      -o-background-size: cover;
      display: table;
      width: 100%;
      height: 460px;
      padding: 100px 0;
      text-align: center;
      color: white;
   }

    .titulo{
      font-size:30px;
      color: #3D3935;
      font-family: neue-haas;
      letter-spacing: 2px;
      margin-top:50px;
      font-weight: bold;
    }


    .subTitulo{
      font-size:23px;
      color:  #009ACE;
      font-family: neue-haas;
      font-weight:bold;
      letter-spacing: 2px;
      margin-top:20px;
      margin-bottom:20px;
    }

    .lead2{
      color: #959595;
      margin-bottom:150px;
      font-size:20px;
      font-family: neue-haas;
    }

    .lead4 {
      color: #959595;
      font-size:16px;
      font-family: neue-haas;
    }

    .lead3 {
      color: #959595;
      font-size:20px;
      font-family: neue-haas;
    }

    .fotoVideo{
      height:200px;
      margin-top:50px;
    }
    
    .noticia{
      /*width: 80%;
      height: 90%;*/
      /*box-shadow: -7px 7px 25px 0px rgba(0, 0, 0, 0.75);*/ 
    }

    .espacamentoParceiro{
      margin-top:40px;
    }

    
    .videoDVI{
      margin-top:50px;
      margin-left:50px;
    }

    .tituloVideo{
      font-family: neue-haas;
      font-size: 30px;
      color: #3D3935;
      font-weight: bold;
      margin-top:0px;
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

      .background-align{
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
      color:#383838;
      text-align: center !important;
      font-family: neue-haas;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }

    .tituloVideo{
      font-family: neue-haas;
      font-size: 30px;
      text-align:center !important;
      color: gray;
      font-weight: bold;
      margin-top:10px;
      margin-bottom: 30px;
    }

    .botaoDvi{
      display:inline-block;
      text-align: center !important;
      padding: 5px 20px 5px 20px;
    }

    }

    @media (min-width: 400px) and (max-width: 576px){
      .background-align{
         height:400px;
         width:100% !important;
      }
      
      .videoPlayer{
      margin-top: -50px;
      margin-bottom: 100px;
      } 
      .background-public{
         height:300px;
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
      color: #383838;
      text-align: center !important;
      font-family: neue-haas;
      letter-spacing: 2px;
      margin-top:50px;
      margin-left: 0px;
    }
    }

    @media (min-width:400px) and (max-width:575px) {
      .titulo{
      font-size:23px;
      color: #383838;
      text-align: center !important;
      font-family: neue-haas;
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
      color: #383838;
      text-align: center !important;
      font-family: neue-haas;
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
      color: #383838;
      text-align: center !important;
      font-family: neue-haas;
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
   border-color: #009ACE;
   color: #009ACE;
   align-items: left;
   border-radius: 10px;
   border: 2px solid;
   transition: 0.5s ease-in-out;
}

.btn-background-public:hover {
   border-color: #009ACE;
   background-color: #009ACE;
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

@font-face {
   font-family: neue-haas;
   src: url("{{ asset('imagens/canais/invisalign/fonte/nhaasgroteskdspro-55rg-webfont.woff') }}")format("woff");
   src: url("{{ asset('imagens/canais/invisalign/fonte/nhaasgroteskdspro-55rg-webfont.woff2') }}")format("woff");
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

.VideoRecente {
   margin-top: 10px;
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

.logos {
   margin-top: 370px;
   bottom: 0;
   margin-bottom: 0;
   width: 80%;
   position: relative;
   float: right;
   right: 0;
}

@media (max-width: 600px) {
   .itero{
      margin-top: 150px;
   }
   .mobilealigneducation{
      margin-top:0px;
   }
   .mobilebanner{
   height: 250px;
  }
   .logos{
   width: 60%;
   margin-top: 50px;
  }
   .mobiledivbutton{
   flex-direction: column;

   align-content: center;
   margin: auto;

  }
  .mobileinvisalignmargin{
   margin-bottom:-150px !important;
  }
  .mobilebutton{
   width: 90% !important;
   margin: auto !important;
   margin-top: 15px !important;

  }
  .mobilesmiles{
   width: 100%;
   }
   .background-public{
         height:200px;
      }

} 
   .modal-body img {
   max-width: 100%;
   height: auto;
}

.videoButaum{
      border: none;
      border-radius: 20px;

    }
   .videoImagem{
      width:100%;
      border-radius: 20px;
   }
/* garante que o modal fique acima de overlays/backdrop */
#videoModalJulho { z-index: 2000; }


/* centraliza e impede scroll */
#videoModalJulho .modal-dialog{
  max-width: none;                 /* deixa a gente controlar pelo frame */
  margin: 0 auto;
  padding: 1rem;
}

/* modal sem "caixa branca" (opcional, fica só o video) */
#videoModalJulho .modal-content{
  background: transparent;
  border: 0;
  box-shadow: none;
}

/* body centralizado */
#videoModalJulho .modal-body{
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}

/* nosso frame 9:16 com tamanho baseado na viewport */
#videoModalJulho .video-frame{
  --w: min(90vw, 420px);              /* largura máxima */
  width: var(--w);
  max-height: calc(100vh - 140px);    /* sobra pra navbar/margens */
  border-radius: .75rem;
  overflow: hidden;
  background: #000;
}

/* cria o 9:16 (altura = 177.78% da largura) */
#videoModalJulho .ratio-9x16{
  --bs-aspect-ratio: 177.78%;
}

/* o vídeo preenche o frame corretamente */
#videoModalJulho video{
  width: 100%;
  height: 100%;
  object-fit: contain;     /* contain evita cortar; use cover se quiser cortar */
  display: block;
  background: #000;
}
/* sobe modal e backdrop acima de overlays custom */


/* se o backdrop não for "irmão" do modal (varia), use: */

#videoModalJulho.modal{
  position: fixed !important;
  inset: 0 !important;      /* top/right/bottom/left 0 */
}
#videoModalJulho .modal-dialog,
#videoModalJulho .modal-content,
#videoModalJulho .modal-body{
  pointer-events: none !important;
}

/* mas o frame do vídeo e o vídeo precisam continuar clicáveis */
#videoModalJulho .video-frame,
#videoModalJulho .video-frame *,
#videoModalJulho video{
  pointer-events: auto !important;
}
   </style>

   <div class="container-fluid background-align mobilebanner" style="margin-top: 30px;">
      <div class="container">
        <div class="row">
          <div class="col-12 col-lg-6 col-md-6 col-sm-6 text-center mobilealigneducation">
          <a href="http://learn.aligntech.com/" target="_blank"><img src="{{ asset('imagens/canais/invisalign/alignEducation_RGB_REV_2c.png') }}" alt="dvi-banner" class="imgDvi"></a>
          </div>
          <div class="col-12 col-lg-6 col-md-6 col-sm-6">
            <img class="logos" src="{{ asset('imagens/canais/invisalign/4-logo-lockup-1c-REVERSE[1].png') }}" alt="">
               <!--<div class="col-12 text-center" style= "text-align: center !important;">
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">VÍDEOS</button>
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">Artigos</button>
               </div>-->
          </div>
        </div>
      </div>
   </div>
   <div class="container" style="margin-top: 30px; ">
         <div class="row" style="justify-content: center;">
               <img class="img-fluid" style="width: 30%; margin-bottom: 20px;" src="{{asset('imagens/canais/invisalign/ADP_horizontal_RGB_charcoal_2c.png') }}" alt="">
               <img class="img-fluid" src="{{ asset('imagens/canais/invisalign/4c_ADW_DIGITAL-RGB _7labels-descriptions-below.jpg') }}" alt="">
         </div>
      </div>
      <div style="text-align:center; justify-content:center;" class="container">
         <div style="text-align:center; justify-content:center;" class="row mobiledivbutton">
            <a class="btn btn-primary mobilebutton" style="text-decoration:none; width: 20%; margin-bottom: 20px; margin-right: 25px; margin-top:30px; background-color:#009ACE; border-color:#009ACE; font-family:neue-haas; padding-block: 20px;" href="http://learn.aligntech.com/" target="_blank">Conecte-se ao Align Education Site</a>
            <a class="btn btn-primary mobilebutton" style="text-decoration:none; width: 20%; margin-bottom: 20px; margin-top:30px; background-color:#009ACE; border-color:#009ACE; font-family:neue-haas; padding-block: 20px;" href="https://www.invisalign.com.br/doutor/seja-um-invisalign-doctor-go" target="_blank">Torne-se um Invisalign doctor</a>
         </div>
      </div>
   <div class="container VideoRecente">
      <div class="col-sm-12">
         <div class="row">
            <h3 class="tituloVideo">{{__("messages.VideosTitulo")}}<a href="#" target="_blank" style="color:#707372; text-decoration: none;"><small style="font-size: 13px; margin-left: 30px;"> {{__("messages.HomeBladeVeja")}} <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></small></a></h3>
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



         <!-- ITERO -->
          <script>
  function playVideo() {
    const thumb = document.getElementById('thumbnail');
    const video = document.getElementById('videoPlayer');

    // Esconde o thumbnail
    thumb.style.display = 'none';

    // Define a fonte APENAS agora (evita preload/autoplay indesejado)
    if (!video.src) {
      video.src = "{{ asset('imagens/parceirosvideos/itero.mp4') }}";
      video.load();
    }

    // Mostra e tenta reproduzir
    video.style.display = 'block';
    video.play().catch(() => {
      // Alguns navegadores bloqueiam autoplay com som;
      // o usuário pode apertar play.
    });
  }

  // Opcional: pausar ao sair da aba
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      const v = document.getElementById('videoPlayer');
      if (!v.paused) v.pause();
    }
  });
</script>

<div class="row" style="margin-top: 50px;">
  <div class="col-lg-6 col-md-6 mobileinvisalignmargin">
    <h4 class="titulo">iTero Design Suite – o Software CAD da Plataforma Digital Align</h4>
    <p class="lead3">iTero Design Suite é uma solução integrada que permite aos profissionais de odontologia realizar impressões 3D de modelos, aparelhos e restaurações diretamente em suas clínicas. Ele transforma o poder do software exocad em aplicações intuitivas e fáceis de usar, ajudando dentistas a melhorar a experiência do paciente e reduzir custos operacionais.</p>
  </div>

  <!-- Remova o onclick do container inteiro -->
  <div class="col-lg-6 col-md-6 col-sm-12 text-center video-wrapper itero" style="padding-top: 10px;">
    <!-- Coloque o clique APENAS no thumbnail (ou num botão) -->
    <img
      src="{{ asset('imagens/parceirosvideos/iteroplayer.png') }}"
      alt="Thumbnail"
      id="thumbnail"
      class="thumbnail img-fluid"
      style="cursor: pointer; border-radius:19px;"
      onclick="playVideo()"
    >

    <!-- Use <video> no lugar de iframe -->
    <video
      id="videoPlayer"
      width="100%"
      height="315"
      style="display:none; border-radius:19px;"
      controls
      preload="none"
      playsinline
    ></video>
  </div>
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
        <h1 class="titulo titulo-ultimas">Últimas Noticias</h1>
        
         <div class="container">
            
            <div class="slide espacamentoParceiro">
               <div class="row">
               <!-- JULHO LARANJA -->
               <div class="col-12 col-lg-6 col-md-8">
                          <h3 class="caixaArtigo">Julho Laranja</h3>
                          <p class="caixaSubArtigo">
                              Julho Laranja: a prevenção começa na infância. Invisalign First® é o tratamento ideal para crianças a partir dos 6 anos.
                              <br><br>
                           Férias, cuidado e diversão também combinam!
                          </p>
                          <br><br>
                          <button type="button" class="btn leia-mais-btn" data-bs-toggle="modal" data-bs-target="#videoModalJulho">Assista</button>     
                      </div>        
                      <div class="col-12 col-lg-6 col-md-4">
                          <img style="" class="img-fluid" src="{{ asset('imagens/parceirosvideos/julholaranja-2.jpg') }}" alt="" class="img-fluid noticia">
                      </div>
                <!-- Modal -->
<div class="modal fade video-modal" id="videoModalJulho" tabindex="-1" aria-hidden="true" data-bs-backdrop="true"
     data-bs-keyboard="true"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered videofechar">
    <div class="modal-content">
      <div class="modal-body">
        <div class="ratio ratio-9x16 video-frame">
          <video id="videoJulho"
                 playsinline
                 controls
                 preload="none">
          </video>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  const videoModal = document.getElementById('videoModalJulho');
  const videoEl    = document.getElementById('videoJulho');

  videoModal.addEventListener('show.bs.modal', function () {
    if (!videoEl.src) videoEl.src = "{{ asset('imagens/parceirosvideos/julholaranja.mp4') }}";
    // opcional: tentar reproduzir logo após abrir
    videoEl.play().catch(()=>{ /* navegador pode bloquear; usuário dá play */ });
  });

  videoModal.addEventListener('hidden.bs.modal', function () {
    videoEl.pause();
    videoEl.currentTime = 0;
    videoEl.removeAttribute('src'); // libera memória e evita som fantasma
    videoEl.load();
  });
</script>

                  <div class="boxbordas"></div>
         <!-- end JULHO LARANJA -->
               
                  
                   @foreach(array_reverse($materias[0]->productItems) as $index => $materia)
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
                      <div class="modal fade" id="leiaCapitulo{{$materia->id}}" aria-labelledby="leiaCapitulo{{$materia->id}}"  tabindex="-1"  aria-hidden="true" style="padding-top:50px;">
                       <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="--bs-modal-width: 90%;">
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



<div class="container">
   <div class="row">
      <div class="col-lg-7 col-md-7 mobileinvisalignmargin">
         <a href="#" style="text-decoration: none;" target="_blank"><h4 class="titulo">Sistema Invisalign® Palatal Expander</h4></a>
         <p class="lead3">
         O novo Sistema Invisalign® Palatal Expander é o disjuntor palatal mais inovador do mundo. Com uma abordagem clinicamente eficaz¹ para a disjunção, o Invisalign® Palatal Expander é seguro e clinicamente eficaz. O Invisalign® Palatal Expander pode ser removido para escovar os dentes, favorecendo a higiene bucal². Junto com os alinhadores Invisalign First™ e a tecnologia NIRI iTero™, o disjuntor oferece aos dentistas uma solução completa para o tratamento de intervenção precoce, incluindo a disjunção da arcada dentária e esquelética.
         <br/>   
         </p>
         <p class="lead3">
         Gostaria de saber mais informações sobre esse produto?
         <br/>
         </p>
          <p class="lead3">
          Acesse o Clinical Pills do Dr. André Ferreira, certificado pelo Board Americano de ortodontia e professor adjunto na UAB School of Dentistry (Universidade de odontologia do Alabama em Birmingham):
         <br/>
         </p>
         <a style="text-decoration: none;" href="https://learn.aligntech.com/learn/learning-plans/5114/new-clinical-pills/courses/28431/clinical-pills-invisalignr-palatal-expander/lessons/92444/o-que-e-o-invisalign-palatal-expander"><h4 class="subTitulo">Clinical Pills - Invisalign® Palatal Expander - O que é o Invisalign Palatal Expander</h4></a>
         <p class="lead4">
         1.	Dados de um estudo clínico IDE (Isenção de Dispositivo Investigacional) realizado em diversos centros nos EUA com 29 participantes, com idades entre 7 e 10 anos.
         <br/>
         2.	Pesquisa realizada em agosto de 2023 no Canadá com 10 ortodontistas credenciados no sistema Invisalign que participaram do Technical Design Assessment do Invisalign Palatal Expander e trataram pelo menos 1 paciente com idade entre 6 e 11 anos. Dados em arquivo na Align Technology em 30 de outubro de 2023.
         <br/>
         </p>
      </div>
      <div class="col-lg-5 col-md-5 col-sm-12 text-center" style="padding-top: 10px;">
         <iframe width="100%" style="margin-top: 93px;" height="315" src="{{ asset('imagens/parceirosvideos/Vídeo Inovações_IPE.mp4') }}" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; autoplay 'none';"   autostart="false" autoplay="0" allowfullscreen sandbox></iframe>
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



<div class="container-fluid background-public d-flex justify-content-start mobilesmiles">
   <!--<a href="https://www.dviradiologia.com.br/" target="_blank"><button class="btn-background-public occult-mobile text-left">ACESSE O </BR> NOSSO SITE</button></a>
   <a href="https://www.dviradiologia.com.br/" target="_blank"><button class="btn-background-public occult-desktop text-left">ACESSE O NOSSO SITE</button></a>-->
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const videoModal = document.getElementById('modalVideo');
            const videoIframe = document.getElementById('video');

            // Move modal to body to fix stacking context issues
            if (videoModal) {
                document.body.appendChild(videoModal);
            }

            if (videoModal && videoIframe) {
                // Listen for modal show event
                videoModal.addEventListener('show.bs.modal', function (event) {
                    // Get the button that triggered the modal
                    const button = event.relatedTarget;
                    if (button) {
                        // Get the video hash from data-src attribute
                        const videoSrc = button.getAttribute('data-src');
                        if (videoSrc) {
                            // Update iframe src with the video URL using the proper route
                            videoIframe.src = "{{ route('videoplay') }}/" + videoSrc;
                        }
                    }
                });

                // Stop video when modal starts hiding (before animation completes)
                videoModal.addEventListener('hide.bs.modal', function () {
                    videoIframe.src = "";
                });

                // Reset iframe to loading state when modal is fully hidden
                videoModal.addEventListener('hidden.bs.modal', function () {
                    videoIframe.src = "{{ route('loadingvideo') }}";
                });
            }

            // Auto-open video if URL contains video ID (segment 5)
            @if(null !== Request()->segment(5) && $modalConteudo == 'permitido')
                setTimeout(function() {
                    const videoBtn = document.getElementById('VideoId{{ Request()->segment(5) }}');
                    if (videoBtn) {
                        videoBtn.click();
                    }
                }, 100);
            @endif
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Move modals to body to ensure z-index works
      const leiaNaIntegra = document.getElementById('leiaNaIntegra');
      if (leiaNaIntegra) { document.body.appendChild(leiaNaIntegra); }

      const chapterModals = document.querySelectorAll('.modal[id^="leiaCapitulo"]');
      chapterModals.forEach(function (modal) { document.body.appendChild(modal); });

      const gotalkModal = document.getElementById('gotalk');
      if (gotalkModal) { document.body.appendChild(gotalkModal); }

      // GoTalks Logic
      if (gotalkModal) {
        const iframe = document.getElementById('audioPlayerIframe');
        const buttons = document.querySelectorAll('.openModalBtn');
        buttons.forEach(button => {
          button.addEventListener('click', function () {
            const audioUrl = this.getAttribute('data-audio-url');
            const playerUrl = `https://dentalgo.com.br/audioplayer?url=` + audioUrl;
            iframe.src = playerUrl;
          });
        });
        gotalkModal.addEventListener('hidden.bs.modal', function () {
          iframe.src = "";
        });
      }
    });
  </script>
  <script>
document.addEventListener('DOMContentLoaded', function () {
  const videoModalJulho = document.getElementById('videoModalJulho');
  if (videoModalJulho) document.body.appendChild(videoModalJulho);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const el = document.getElementById('videofechar');
  if (!el) return;

  // move pro body (resolve z-index/centro da tela)
  document.body.appendChild(el);

  // garante que o Bootstrap reconheça backdrop/click fora
  const instance = bootstrap.Modal.getOrCreateInstance(el, {
    backdrop: true,   // permite fechar clicando fora
    keyboard: true    // ESC fecha
  });

  // opcional: se você tiver data-bs-backdrop="static" em algum lugar, isso sobrescreve
});
</script>

@endsection