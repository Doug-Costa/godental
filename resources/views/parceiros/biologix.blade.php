<?php
$paginaTitulo = 'Canal Biologix - DentalGo';
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
      body {
         background-color: white;

      }
      .background-align{
      background-image: url("{{ asset('imagens/canais/biologix/ativo-1.svg') }}");
      
      background-color:rgba(0, 155, 119, 0.94);
      background-position: bottom center;
      background-repeat: no-repeat; 
      
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
      margin-bottom: 20px;
      font-weight: bold;
    }


    .subTitulo{
      font-size:23px;
      color:#3D3935;
      font-family: neue-haas;
      font-weight:bold;
      letter-spacing: 2px;
      margin-bottom:5px;
    }
    .subsubTitulo{
      font-size:18px;
      color:rgb(99, 99, 99);
      font-family: neue-haas;
      font-weight:bold;
      letter-spacing: 2px;
      margin-bottom:15px;
    }
    .lead2{
      color:rgb(140, 140, 140);
      margin-bottom:10px;
      font-size:16px;
    }
    .demo-1 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
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
    .tituloArtigos{
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
   .fill {
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden
   }
   .fill img {

      width:100%;
      height: auto;
   }
   .btn-primary{
      background-color: #009b77 !important;
      border-color: #009b77 !important;
      border-radius:2px !important;
   }



      

    
.content {
  display: grid;

  margin: 0;
  list-style: none;
  
}



.pagination {
  text-align: center; 
  justify-self: center !important;
  margin-top: 100px;
  margin-bottom: 100px;
}

.pagination button {
  padding: 5px 10px;
  margin: 0 5px;
  cursor: pointer;
  color: white;
  border-radius: 1px;
  background-color: #009b77;
  border: none;

 
}

.hidden {
  clip: rect(0 0 0 0);
  clip-path: inset(50%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}

.pagination button.active {
  background-color:rgb(0, 108, 83);
  color: white;
}

a {
  color: #2196F3;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
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
   background-position: bottom center;
   background-size: cover;
   background-repeat: no-repeat;
   width: 110%;
   
}
#mask {
   filter: drop-shadow(0 0 0.75rem rgb(255, 255, 255));
}
@media (max-width: 1024px) {
   .background-align{
      background-size: 200%;
      
   }
   .pagination {
  text-align: center; 
  justify-self: center !important;
  margin-top: 150px;
  margin-bottom: 100px;
}
   .logos{
      width: 150%;
   }

}
@media (max-width: 768px) {
   .mobilealigneducation{
      margin-top:0px;
   }
   .imgDvi{
      margin-top: 50px ;
   }
   .mobilebanner{
   height: 400px;
   
  }
  .pagination{
   margin-top: 100px;
  }

  #a h4{margin-top: 0px !important}
  #b img {
   margin-top: 50px
  }
  .primeiromargin img {
   margin-top: 50px !important;
  }
  .ultimomargin {
   margin-top: 100px !important;
  }



   .logos{
   display: none;

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

   #parent {display:table;}
   #a {display:table-footer-group;}
   #b {display:table-header-group;}

   .fill img {
   width:100% !important;
   height: auto !important;
   border-radius: 20px;
   margin-top: 50px;
   }
   #b {
      height: 150px !important;
   }
   .tituloVideo{
      margin-bottom: 30px ;
   }
   .tituloArtigos{
      margin-bottom: 0px !important;
   }
} 
   .modal-body img {
   max-width: 100%;
   height: auto;
}


   </style>

   <div class="container-fluid background-align mobilebanner">
      <div class="container">
        <div class="row parent">
          <div class="col-12 col-lg-6 col-md-6 text-center mobilealigneducation">
          <a href="https://www.biologix.com.br/" target="_blank"><img id="mask" src="{{ asset('imagens/canais/biologix/biologixlogo.png') }}" alt="dvi-banner" class="imgDvi image1"></a>
          </div>
          <div class="col-12 col-lg-6 col-md-6 col-sm-6">
            <img class="logos" src="{{ asset('imagens/canais/biologix/bio-case-device.png') }}" alt="">
               <!--<div class="col-12 text-center" style= "text-align: center !important;">
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">VÍDEOS</button>
                  <button type="button" class="btn btn-primary btn-sm botaoDvi">Artigos</button>
               </div>-->
          </div>
        </div>
      </div>
   </div>
   <!--2img2txt desktop-->
<div class="edesktop">
   <div class="container" style="margin-top: 50px;margin-bottom: 30px">
      <div class="row">
         <div class="col-6 fill" style="height:400px;">
         <img class="img-fluid" src="{{ asset('imagens/canais/biologix/senhor-com-dentadura-dormindo-cama-casal.png') }}">
         </div>
         <div class="col-6" style="height: 400px; text-align:justify;">
            <div style="padding-top:7%;padding-bottom:7%;padding-left:5%;padding-right:5%;">
            <h4 class="titulo">Dormir com dentadura altera a qualidade do sono?</h4>
            <p class="lead2">A Apneia Obstrutiva do Sono (AOS) piora com a idade. Músculos faríngeos ficam mais flácidos e menos responsivos à ação dos grupos dilatadores durante o sono. Além disso, o efeito adverso de certos medicamentos, comuns nessa etapa da vida, pode comprometer a qualidade do sono.</p>
            <p class="lead2">O estudo de hoje analisou o impacto do uso de Prótese Total (PT) na qualidade do sono. Os 77 participantes foram submetidos à polissonografia e questionários com e sem a PT.</p>
            <div style="text-align: center; margin-top:20px"><a href="https://www.biologix.com.br/2025/03/28/dormir-com-dentadura-altera-a-qualidade-do-sono/" class="btn btn-primary btn-block w-100 active" role="button" aria-pressed="true">Saiba mais</a></div>
            </div>
         </div>
      </div>
   </div>
   
   <div class="container">
      <div class="row">
         
         <div class="col-6" style="height: 400px; text-align:justify;">
            <div style="padding-top:8%;padding-bottom:8%;padding-left:5%;padding-right:5%;">
            <h4 class="titulo">Aparelho intraoral (AIO) é eficaz na apneia posicional (AP)?​</h4>
            <p class="lead2">A escolha de um tratamento deve ser guiada por várias informações; fatores preditivos como IMC, saturação de oxihemoglobina, IAH e presença de comorbidades auxiliam na indicação. </p>
            <p class="lead2">O artigo de hoje, conduzido pela equipe do prof. holandês Nico De Vries, avaliou se pacientes com AP respondem bem ao AIO. AP é definida quando o índice de apneias em posição supina é, no mínimo, o dobro das que ocorrem em outras posições.</p>
            <div style="text-align: center; margin-top:20px"><a href="https://www.biologix.com.br/2022/02/20/aparelho-intraoral-aioe-eficaz-na-apneia-posicional-ap/" class="btn btn-primary btn-block w-100 active" role="button" aria-pressed="true">Saiba mais</a></div>
            </div>
         </div>
         <div class="col-6 fill" style="height:400px;">
         <img class="img-fluid" src="{{ asset('imagens/canais/biologix/capa-blog-odontologia-aparelho-intraoral-aioe-eficaz-na-apneia-posicional-ap.jpg') }}">
         </div>
      </div>
   </div>

   <div class="container" style="margin-top: 50px;margin-bottom: 30px">
      <div class="row">
         <div class="col-6 fill" style="height:400px;">
         <img class="img-fluid" src="{{ asset('imagens/canais/biologix/capa-blog-odontologia-porque-devo-ter-olhos-atentos-para-a-apneia-obstrutiva-do-sono-aos.jpg') }}">
         </div>
         <div class="col-6" style="height: 400px; text-align:justify;">
            <div style="padding-top:7%;padding-bottom:7%;padding-left:5%;padding-right:5%;">
            <h4 class="titulo">Por que devo ter olhos atentos para a apneia obstrutiva do sono (AOS)?</h4>
            <p class="lead2">A Medicina do Sono tem experimentado um enorme crescimento. Junto dela, todas as outras áreas afins também evoluem a passos largos.</p>
            <p class="lead2">Hoje dispomos de métodos de diagnóstico, triagem e monitoramento eficazes. Pesquisas avançam ainda na descoberta de outras causas não visíveis da AOS; os fenótipos individuais podem determinar o sucesso ou falha de algumas terapias. O acesso a esses dados irá aumentar o índice de sucesso.</p>
            <div style="text-align: center; margin-top:20px"><a href="https://www.biologix.com.br/2020/12/05/porque-devo-ter-olhos-atentos-para-a-apneia-obstrutiva-do-sono-aos/" class="btn btn-primary btn-block w-100 active" role="button" aria-pressed="true">Saiba mais</a></div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--mobile-->
<div class="emobile">
   <div class="container" style="margin-top: 25px;margin-bottom: 20px">
      <div class="row">
         <div class="col-12 fill" style="height:400px;">
         <img class="img-fluid" src="{{ asset('imagens/canais/biologix/asraantonieta23-compactado-1.jpg') }}">
         </div>
         <div class="col-12" style="height: 400px; text-align:justify;">
            <div style="padding-top:7%;padding-bottom:7%;padding-left:5%;padding-right:5%;">
            <h4 class="titulo">Conheça o Exame do Sono Biologix®</h4>
            <p class="lead2">O Exame do Sono Biologix® é uma polissonografia domiciliar, utilizada para o diagnóstico e acompanhamento do tratamento de ronco e apneia do sono.  Esta avaliação é feita de maneira descomplicada, utilizando apenas um smartphone e um sensor compacto e sem fios.</p>
            <p class="lead2">Apesar da simplicidade, esse exame tem sensibilidade, especificidade e acurácia acima de 90% quando comparado com outros tipos de polissonografias, domiciliares e ambulatoriais, conforme as três publicações científicas já realizadas.
            </p>
            <div style="text-align: center; margin-top:20px"><a href="https://www.biologix.com.br/exame-do-sono/" class="btn btn-primary btn-block w-100 active" role="button" aria-pressed="true">Saiba mais</a></div>
            </div>
         </div>
      </div>
   </div>
   
   <div class="container">
      <div class="row">
      <div class="col-12 fill" style="height:400px;">
         <img class="img-fluid" src="{{ asset('imagens/canais/biologix/ahomem3sensor27-edit-2.png') }}">
         </div>
         <div class="col-12" style="height: 400px; text-align:justify;">
            <div style="padding-top:6%;padding-bottom:8%;padding-left:5%;padding-right:5%;">
            <h4 class="titulo">Seu paciente ronca?​</h4>
            <p class="lead2">O Teste do Ronco Biologix® permite que você avalie o ronco do seu paciente sem que ele precise ter um sensor Oxistar® em mãos.</p>
            <p class="lead2">Integrado ao app Biologix, o nosso teste capta e classifica os roncos do paciente, de modo a fornecer o nível de intensidade e o percentual de tempo de ronco durante todo o período de sono. Para isso, basta que o paciente utilize seu próprio celular, obtenha uma autorização de exame por meio de um centro credenciado e tenha o aplicativo instalado.</p>
            <div style="text-align: center; margin-top:20px"><a href="https://www.biologix.com.br/teste-do-ronco/" class="btn btn-primary btn-block w-100 active" role="button" aria-pressed="true">Saiba mais</a></div>
            </div>
         </div>
        
      </div>
   </div>
</div>


   <div class="container VideoRecente" style="margin-top: 100px;">
      <div class="col-sm-12">
         <div class="row">
            <h3 class="tituloVideo" style="text-align: center; margin-bottom:40px;">Histórias de sucesso com a Biologix
            </h3>
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
            
               <div class="col-12 col-md-4" style="margin-bottom: 15px;">
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
   <!--desktop-->
   <div class="container">
      <div class="row">
         <h3 class="tituloArtigos" style="text-align: center; margin-top:100px; margin-bottom:50px">Artigos</h3>              
      </div>
      <ul class="content" style="padding-left: 10px; padding-right: 10px;">
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%">
            <h4 class="subTitulo">Apneia obstrutiva do sono (AOS) e sua correlação com a disfunção têmporomandibular (DTM)</h4>
            <p class="subsubTitulo">Estudo avalia pacientes com bruxismo, DTM e apneia obstrutiva do sono</p>
            <p class="lead2 demo-1">O sono reparador tem papel fundamental na dor. A produção de endorfina, o reparo muscular e a redução da síntese dos agentes inflamatórios são algumas das possíveis explicações. A presença da apneia obstrutiva do sono (AOS), por sua vez, pode agravar os quadros álgicos por meio de diversos mecanismos, como: maior sensitização neuronal, ativação do sistema simpático, produção de agentes inflamatórios, fragmentação do sono, etc. O bruxismo é também prevalente em pacientes apneicos; estudos apontam que a metade dos portadores de AOS tem bruxismo. </p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2025/02/28/apneia-obstrutiva-do-sono-aos-e-sua-correlacao-com-a-disfuncao-temporomandibular-dtm/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill primeiromargin" style="height: 250px; border-radius: 20px">
         <img style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/apneia-do-sono-disfuncao-temporomandibular.png') }}">
         </div>
      </div>
         </li>
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%">
            <h4 style="margin-top: 50px;" class="subTitulo">O que os movimentos mandibulares (MM) durante o sono podem indicar?</h4>
            <p class="subsubTitulo">Estudo acerca das características dos movimentos mandibulares durante o sono busca ampliar o diagnóstico da apneia do sono</p>
            <p class="lead2 demo-1">Muitas pesquisas estão sendo feitas para ampliar o diagnóstico da Apneia Obstrutiva do Sono (AOS). Grupos espalhados por todo o mundo, com pesquisadores altamente capacitados, não se cansam de buscar opções confiáveis e que permitam acesso a um número maior de pessoas, haja vista a enorme prevalência da AOS. Um dos estudos mais bem feitos, vastamente citado, foi o realizado em São Paulo em 2010 sob a coordenação do Dr. Sergio Tufik (mundialmente um dos mais reconhecidos pesquisadores da área do sono). Numa amostra de mais de 1.000 participantes submetidos à polissonografia, cerca de 33%, ou seja 1 a cada 3, tinham AOS. Alguns anos depois, estudo parecido foi feito na Suíça onde a prevalência foi ainda maior.</p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2025/02/14/o-que-os-movimentos-mandibulares-mm-durante-o-sono-podem-indicar/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill" style="height: 250px; border-radius: 20px">
         <img class="ultimomargin" style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/movimentos-mandibulares-durante-sono.png') }}">
         </div>
      </div>
         </li>
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%">
            <h4 class="subTitulo">O sono como aliado contra o câncer</h4>
            <p class="subsubTitulo">Entenda a relação entre sono e câncer</p>
            <p class="lead2 demo-1">Segundo o Instituto Nacional de Câncer (INCA), entre 2023 e 2025, estima-se que no Brasil haja 704 mil casos de câncer por ano. Diante de tamanha prevalência, você sabia da relação do sono com o surgimento ou a progressão de tumores?  Câncer é um termo que engloba mais de 100 (cem) variações patológicas e ocorre a partir de uma mutação genética da célula, que cresce desordenadamente e multiplica-se de maneira aleatória. Com toda essa complexidade, o câncer apresenta diferentes causas, incluindo fatores genéticos, ambientais e de estilo de vida.</p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2025/02/05/o-sono-como-aliado-contra-o-cancer/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill primeiromargin" style="height: 250px; border-radius: 20px">
         <img style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/sono-aliado-combate-cancer.png') }}">
         </div>
      </div>
         </li>
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%">
            <h4 class="subTitulo">Como melhorar os resultados do aparelho intraoral (AIO) para o tratamento da apneia obstrutiva do sono (AOS)</h4>
            <p class="subsubTitulo">Entenda a evolução do aparelho intraoral e como ele ajuda no tratamento da AOS</p>
            <p class="lead2 demo-1">Se você deseja saber como melhorar os resultados do aparelho intraoral (AIO) durante o tratamento da apneia obstrutiva do sono (AOS), saiba que a grande evolução do AIO tem relação com o projeto (design), material usado e sistema de calibração. Além disso, altura vertical reduzida, mínimo avanço e estabilidade (retenção) ajudarão no sucesso terapêutico. Diversos estudos comprovam a eficácia da terapia com aparelho intraoral no tratamento da AOS. Segundo o último guideline da Academia Americana de Sono, o AIO pode ser usado para qualquer grau de severidade. Dessa maneira, ao paciente deve ser dada a opção de escolha entre o CPAP e AIO. Na prática, o dentista capacitado deve orientar a melhor escolha para cada situação, levando em conta os benefícios. Muitas vezes, o doente pode ser beneficiado por mais de uma terapia ou por uma combinação destas.</p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2025/01/27/como-melhorar-os-resultados-do-aparelho-intraoral-aio-para-o-tratamento-da-apneia-obstrutiva-do-sono-aos/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill" style="height: 250px; border-radius: 20px">
         <img style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/capa-blog-como-melhorar-os-resultados-do-aparelho-intraoral-aio-para-o-tratamento-da-apneia-obstrutiva-do-sono-aos.png') }}">
         </div>
      </div>
         </li>
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%; margin-bottom:30px">
            <h4 class="subTitulo">Consequências cardiovasculares da apneia do sono em homens de meia-idade</h4>
            <p class="subsubTitulo">Entenda como a apneia do sono não tratada configura um risco acentuado para homens de meia-idade</p>
            <p class="lead2 demo-1">A apneia do sono é uma condição que afeta milhões de pessoas ao redor do mundo e, quando não tratada, pode acarretar consequências graves para a saúde cardiovascular. Caracterizada por interrupções recorrentes na respiração durante o sono, a apneia do sono tem se mostrado um fator de risco significativo para o desenvolvimento de doenças cardíacas. Em homens de meia-idade, especialmente entre 40 e 60 anos, esse risco é ainda mais acentuado devido a fatores como obesidade, tabagismo, consumo excessivo de álcool e sedentarismo.</p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2024/11/19/consequencias-cardiovasculares-da-apneia-do-sono-em-homens-de-meia-idade/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill primeiromargin" style="height: 250px; border-radius: 20px">
         <img style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/medica-avaliando-consequencias-cardiovasculares-da-aos-em-paciente-homem-de-meia-idade.png') }}">
         </div>
      </div>
         </li>
         <li>
      <div id="parent" class="row" style="margin-bottom: 50px;">
         <div class="col-12 col-md-8" style="height: 250px; padding-top:10px">
            <div id="a" style="padding-left: 5%; padding-right: 5%">
            <h4 style="margin-top: 50px;" class="subTitulo">Apneia do sono e resistência à insulina em mulheres na pós-menopausa</h4>
            <p class="subsubTitulo">Entenda como a apneia do sono não tratada pode acelerar a progressão da resistência à insulina em mulheres na pós-menopausa</p>
            <p class="lead2 demo-1">Você sabia que a apneia do sono não tratada pode acelerar a progressão da resistência à insulina em mulheres na pós-menopausa? Essa associação tem ganhado atenção crescente na comunidade médica, pois ambas as condições estão relacionadas ao aumento do risco de doenças crônicas. Com a chegada da menopausa, diversas transformações ocorrem no corpo feminino. Uma delas é o aumento do risco de apneia do sono, um distúrbio caracterizado por interrupções repetidas da respiração durante o sono. Essa condição, muitas vezes subestimada, tem um impacto significativo na saúde geral da mulher, especialmente na pós-menopausa.</p>
            <div style="text-align: left; margin-top:20px"><a href="https://www.biologix.com.br/2024/12/19/apneia-do-sono-e-resistencia-a-insulina-em-mulheres-na-pos-menopausa/" class="btn btn-primary btn-block  active" role="button" aria-pressed="true">Ver mais</a></div>
            </div>
         </div>
         <div id="b" class="col-12 col-md-4 fill" style="height: 250px; border-radius: 20px">
         <img class="ultimomargin" style="width: 150%;" src="{{ asset('imagens/canais/biologix/artigos/apneia-do-sono-nao-tratada-progressao-resistencia-insulina-mulheres-pos-menopausa.jpg') }}">
         </div>
      </div>
      </li>
      </ul>
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





<script>
document.addEventListener('DOMContentLoaded', function () {
  const content = document.querySelector('.content'); 
  const itemsPerPage = 2; // set number of items per page
  let currentPage = 0;
  const items = Array.from(content.getElementsByTagName('li')).slice(0);

function showPage(page) {
  const startIndex = page * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  items.forEach((item, index) => {
    item.classList.toggle('hidden', index < startIndex || index >= endIndex);
  });
  updateActiveButtonStates();
}

function createPageButtons() {
  const totalPages = Math.ceil(items.length / itemsPerPage);
  const paginationContainer = document.createElement('div');
  const paginationDiv = document.body.appendChild(paginationContainer);
  paginationContainer.classList.add('pagination');

  // Add page buttons
  for (let i = 0; i < totalPages; i++) {
    const pageButton = document.createElement('button');
    pageButton.textContent = i + 1;
    pageButton.addEventListener('click', () => {
      currentPage = i;
      showPage(currentPage);
      updateActiveButtonStates();
    });

      content.appendChild(paginationContainer);
      paginationDiv.appendChild(pageButton);
    }
}

function updateActiveButtonStates() {
  const pageButtons = document.querySelectorAll('.pagination button');
  pageButtons.forEach((button, index) => {
    if (index === currentPage) {
      button.classList.add('active');
    } else {
      button.classList.remove('active');
    }
  });
}

  createPageButtons(); // Call this function to create the page buttons initially
  showPage(currentPage);
});
</script>

@endsection