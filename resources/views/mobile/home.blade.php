<?php
$tipoTopo = 'topoPreto';

$atigosUltimaRevista = $ultimaRevista[1]->productItems;
if (count($atigosUltimaRevista) < 2) {
    $key = array_rand($atigosUltimaRevista, 1);
    $ultimoArtigo1 = $atigosUltimaRevista[0];
    $ultimoArtigo2 = null;
    $ultimoArtigo3 = null;
}elseif (count($atigosUltimaRevista) < 3) {
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

$todosLivrosG = $livros['livrosG']->rows;
$todosLivros = $livros['livros']->books->rows;
$minhaBiblioteca = $livrosComprados;

//mobile
function limita_caracteres($texto, $limite, $quebra = true)
{
    $tamanho = strlen($texto);
    if ($tamanho <= $limite) { //Verifica se o tamanho do texto é menor ou igual ao limite
        $novo_texto = $texto;
    } else { // Se o tamanho do texto for maior que o limite
        if ($quebra == true) { // Verifica a opção de quebrar o texto
            $novo_texto = trim(substr($texto, 0, $limite)) . "...";
        } else { // Se não, corta $texto na última palavra antes do limite
            $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
            $novo_texto = trim(substr($texto, 0, $ultimo_espaco)) . "..."; // Corta o $texto até a posição localizada
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
$conteudoClinicaV21 = __("messages.TopoBannerClinica");
$conteudoClinicaV21_2 = __("messages.TopoBannerClinica2");
$conteudoClinicaV21_3 = __("messages.TopoBannerClinica3");
$conteudoClinicaV21_4 = __("messages.TopoBannerLeia");
  $conteudoClinicaV27 = __("messages.TopoBannerOrtho");
$conteudoClinicaV27_2 = __("messages.TopoBannerOrtho2");
$conteudoClinicaV27_3 = __("messages.TopoBannerLeia");
$conteudoPeridontoV32 = __("messages.TopoBannerPeridonto");
$conteudoPeridontoV32_2 = __("messages.TopoBannerPeridonto2");
$conteudoPeridontoV32_3 = __("messages.TopoBannerPeridonto3");
$conteudoPeridontoV32_4 = __("messages.TopoBannerLeia");
$conteudoHarmonyV1 = __("messages.TopoBannerLeia");
$conteudoEsteticaV19 = __("messages.TopoBannerEstetica");
$conteudoEsteticaV19_2 = __("messages.TopoBannerLeia");
$conteudoEndoV12 = __("messages.TopoBannerEndo");
$conteudoEndoV12_2 = __("messages.TopoBannerLeia");
$revistaBanner = [
    [
        'link' => '854/Journal-2023-v28n1',
        'imagem' => 'capa-djo.png',
        'titulo' => 'Nova DPJO',
        'conteudo' => "<b> $conteudoClinicaV27
                        
                           $conteudoClinicaV27_2</b>",
        'botao' => "$conteudoClinicaV27_3",
        'css' => 'font-family:prompt; font-size:20px; color:#ffffff;'
    ],
    [
        'link' => '850/Clínical-2023-v22n2',
        'imagem' => 'Banners/Banner-Clinical---setembro-2023.png',
        'titulo' => 'Clinical Orthodontics',
        'conteudo' => "<b> $conteudoClinicaV21
                            $conteudoClinicaV21_2
                            $conteudoClinicaV21_3</b>",
        'botao' => "$conteudoClinicaV21_4",
        'css' => 'font-family:prompt; font-size:20px; color:#ffffff;'
    ],
    [
        'link' => '785/Orofacial-Harmony-2023-v1n1',
        'imagem' => 'BannerHof07-03-223.jpg',
        'titulo' => '',
        'conteudo' => '',
        'botao' => "$conteudoHarmonyV1",
        'css' => 'font-family:prompt; font-size:20px; color:#ffffff;'
    ],

];
$conteudoBannerClinicalGo = __("messages.conteudoBannerClinicalGo");
$conteudoBannerClinicalGo_2 = __("messages.TopoBannerAssista");
$conteudoBannerDentalAcademy = __("messages.conteudoBannerDentalAcademy");
$conteudoBannerDentalAcademy_2 = __("messages.TopoBannerAssista");
$videoBanner = [
    [
        'link' => '681/Tratando-hábitos-bucais-deletérios-com-alinhadores-ortodônticos-Invisalign/10080',
        'imagem' => 'gUILHERME-tHIERSSEN---DENTALGO-academy.png',
        'titulo' => 'Dental GO Academy',
        'conteudo' => "$conteudoBannerClinicalGo",
        'botao' => "$conteudoBannerClinicalGo_2",
        'css' => 'font-family:prompt; font-size: 16px;'
    ],
    [
        'link' => '681/Biomecânica-com-Alinhadores/9756',
        'imagem' => 'VideoLuizRota.png',
        'titulo' => 'Dental GO Academy',
        'conteudo' => "$conteudoBannerDentalAcademy",
        'botao' => "$conteudoBannerDentalAcademy_2",
        'css' => 'font-family:prompt; font-size: 16px;'
    ]
];
shuffle($revistaBanner);
shuffle($videoBanner);
$arrayFinal = array();


@endphp
<style>
  body{
    background-color: #000000;
  }
</style>
<div class="fundo-clinical img-fluid blackground" id="fundo-clinical">
  <div class="imagem-sombreamento">
          <div class="container-fluid d-inline-block "></div> 
            <img src="{{ asset('imagens/Facelift/teste.fw.png') }}" alt="" class="img-fluid logo-Banner logo clinical clinical-logo" data-image-class="logo1">
            <p class="text-clinical paragrafo-abaixoimagem">ㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤㅤ</p>        
            <a class="btn btn-link btn-vejamais botao-banner botao-link" href="" target="_blank">Veja mais</a>
            <a class="btn btn-link btn-minhalista botao-banner2" href="#" style="display:none !important;">Minha Lista</a>
  </div>
</div>
<div class="container-fluid canaisBannerHome">
  <div class="row">
      <section id="slider3DVideo" class="pt-5">
          <div class="container-fluid ">
                <div class="col-lg-12 col-md-6 novidadeslink">
                  </div> 
              <div class="slider">
                  <div class="owl-carousel owl-carousel-tres">
                  @php
                        // Filtra as revistas que não possuem id == 80
                        $magazinesFiltradas = array_values(array_filter($colecoes[0]->collections->magazines, function($magazine) {
                            return $magazine->id != 80;
                        }));

                        // Define o número máximo de itens a exibir com base nos arrays filtrados
                        $maxItems = min(count($ultimasRevistas), count($magazinesFiltradas));
                    @endphp

                    @for ($i = 0; $i < $maxItems; $i++)
                        @php
                            $revista = $magazinesFiltradas[$i];
                            $ultima  = $ultimasRevistas[$i];
                        @endphp

                        <div style="width: 200px;">
                            <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;"   data-image-class="imagem{{ $i + 1 }}">
                                <a href="{{ route('revista') }}/{{ $ultima->id }}/{{ str_replace(' ', '-', $ultima->title) }}/{{ $revista->id }}" style="text-decoration: none;">
                                    <img src="{{ $revista->lastProductCover }}" alt="{{ $ultima->title }}" class="img-fluid img-selecao img-grow">
                                </a>
                            </div>
                        </div>
                    @endfor


                    <!-- fim das revistas -->

                  <div class="slide-info">
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem14">
                              <a href="https://www.dentalpressbooks.com/books/imunologia-aplicada-a-odontologia/" style="text-decoration: none;">
                                <img src="{{ asset('imagens/Facelift/CAPA-IMUNOLOGIA-APLICADA-A-ODONTOLOGIA.jpg') }}" alt="" class="img-fluid img-selecao img-grow">
                              </a>
                          </div>
                      </div>

                      <div class="paragrafo-botoes">
                          <p class="paragrafo-abaixoimagem paragrafo" ></p>
                      </div>
                  </div>
                  <div class="slide-info">
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem13">
                              <a href="https://www.dentalgo.com.br/video/681/Recomenda%C3%A7%C3%B5es-Cl%C3%ADnicas-Para-Uso-de-Implantes-de-Di%C3%A2metro%C2%A0Reduzido/14240" style="text-decoration: none;">
                                  <img src="{{ asset('imagens/Facelift/romulolustosa.jpg') }}" alt="" class="img-fluid img-selecao  img-grow">
                              </a>
                          </div>
                      </div>

                      <div class="paragrafo-botoes">
                            <p class="paragrafo-abaixoimagem paragrafo" ></p>
                      </div>
                  </div>
                  <div class="slide-info">
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem10" >
                              <a href="https://www.dentalgo.com.br/video/681/Revisitando-as-indica%C3%A7%C3%B5es-do-tratamento-da-classe-II-em%C2%A0duas%C2%A0fases/14121" style="text-decoration: none;">
                                  <img src="{{ asset('imagens/Facelift/Bruno-Furquim.png') }}" alt="" class="img-fluid img-selecao  img-grow">
                              </a>
                          </div>
                      </div>

                      <div class="paragrafo-botoes">
                          <p class="paragrafo-abaixoimagem paragrafo" ></p>
                      </div>
                  </div>

                  <div class="slide-info">   
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem12">
                              <a href="https://www.dentalpressbooks.com/books/3058/" style="text-decoration: none;">
                                  <img src="{{ asset('imagens/Facelift/Capa_Estetica-Em-Ortodontia.jpg') }}" alt="" class="img-fluid img-selecao  img-grow">
                              </a>
                          </div>
                      </div>
                  </div>

                  <div class="slide-info">
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem9">
                              <a href="https://novo.dentalpresscursos.com.br/livro_maxilares/" style="text-decoration: none;">
                                  <img src="{{ asset('imagens/Facelift/consolaro.jpg') }}" alt="" class="img-fluid img-selecao  img-grow">
                              </a>
                          </div>
                      </div>

                      <div class="paragrafo-botoes">
                          <p class="paragrafo-abaixoimagem paragrafo" ></p>
                      </div>
                  </div>
                  <div class="slide-info">   
                      <div style="width: 200px;">
                          <div class="slider-card imagemRevistaCol imagem slider-card-grow" style="transform: scale(.9) !important;" data-image-class="imagem11">
                              <a href="https://www.dentalgo.com.br/video/719/Entrevista---Daniel-Machado/9272" style="text-decoration: none;">
                                  <img src="{{ asset('imagens/Facelift/Daniel Machado.png') }}" alt="" class="img-fluid img-selecao  img-grow">
                              </a>
                          </div>
                      </div>
                      <div class="paragrafo-botoes">
                          <p class="paragrafo-abaixoimagem paragrafo" ></p>
                      </div>
                  </div>
                  </div>
              </div>
      </section>
  </div>
</div>

@if($colecaoSchoolar !== null)
    <div class="container-fluid text-center depoimentos-box">
        <div class="container" style="margin-top: 20px;">
            <p style="font-family: poppins; font-size: 30px; color: #474747 ;">Apostilas</p>
            <div class=" owl-carousel owl-carousel-schoolar ">
                    @foreach ($colecaoSchoolar[0]->products as $revista)
                        <div class=" text-center">
                            <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                <div class="row">
                                    <div class="col-sm-4 pe-5 pb-3">
                                        <img src="{{ $revista->cover }}" alt="" class="img-fluid imgteste img-selecao">
                                    </div>
                                    <div class="col-sm-8 ps-2">
                                        <h3 class="corTextoDepoimento corTextoDepoimentoTitulo">{{ $revista->title }}</h3>
                                        <p class="corTextoDepoimento texto-depoimento">{{ $revista->brief }}</p>
                                        <button class="botao-scholar me-4" style="margin-bottom: 20px;" href="{{ route('livro') }}/{{ $revista->id }}">leia mais</button>
                                    </div>
                                </div>  
                            </a>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
  @endif
<style>
.owl-carousel-schoolar .owl-nav button.owl-prev,
.owl-carousel-schoolar .owl-nav button.owl-next {
    background: transparent;
    top:50%;
}
</style> 
  <div class="container" style="display: none;">
            <style>

        #countdown {
            display: block;
            font-size: 24px;
            text-align: center;
            margin-top: 50px;
        }

        #countdown label {
            font-size: 18px;
            color: #666;
        }

        #countdown input[type="date"],
        #countdown input[type="time"],
        #countdown button {
            font-size: 16px;
            padding: 6px 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #countdown button {
            background-color: #4CAF50;
            color: #b7b7b7;
            cursor: pointer;
        }

        #countdown button:hover {
            background-color: #45a049;
        }

        #timer {
            font-size: 48px;
            font-weight: bold;
            color: #fff;
            margin-top: 20px;
        }
 
        #hidden-content {
            display: none;
            margin-top: 50px;
        }

        #hidden-content h2 {
            color: #333;
        }

        #hidden-content p {
            color: #666;
        }
        </style>
        <div class="row">
          <div class="col-12">
              <h1 style="text-align: center; margin-top: 40px; color:#ffffff; font-size:20px">
              live dia 08/05 às 20h, com Dr. Rafael Decurcio, Dra.Paula Cardoso e nosso mediador Fabiano Marson.
              </h1>
          </div>
          <div class="col-12" style="">
              <div id="countdown">
                  <img src="{{ asset('https://live.dentalpress.com.br/wp-content/uploads/2024/04/e9922d6c-e0ba-431a-a599-f54bda35c95b-1024x1024.jpg') }}" class="img-fluid .imagemVideoCapaHome" />
                  <div id="timer"></div>
              </div>
          </div>
          <div id="hidden-content">
            <div class="row">
              {{-- {{<@if(isset(session()->get("usuario")->subscription->status))
                  @if(session()->get("usuario")->subscription->status == 'active') }}--}}
                      <div class="col-sm-12 col-md-12" style="" >
                          <iframe width="100%" height="650" src="https://www.youtube.com/embed/8OQSy_f-Uyg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>
                      
                      <div class="col-sm-12 col-md-4" style="">
                          <iframe allowfullscreen="" frameborder="0" height="650" src="https://www.youtube.com/live_chat?v=8OQSy_f-Uyg&embed_domain=dentalgo.com.br" width="100%"></iframe>
                      </div>
                  {{--@endif 
              @endif--}}
            </div>
          </div>


          <div class="col-12 text-center" style="margin-top: 40px;">
             <p style="color:#fff; display: ;">
             Nossa live será uma oportunidade única para que você entenda mais dos temas que serão abordados no 3° Congresso Specialties.
                <br/><br/>
              </p>
          </div>
              
          <script>
              // Defina a data e hora desejadas no formato (ano, mês + 1, dia, hora, minuto, segundo)
              var targetDate = new Date(2024, 3, 23, 20, 00, 0);

              function startCountdown() {
                  var now = new Date().getTime();
                  var distance = targetDate.getTime() - now;

                  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                  document.getElementById("timer").innerHTML =
                      days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                  if (distance < 0) {
                      clearInterval(x);
                      document.getElementById("countdown").style.display = "none";
                      document.getElementById("hidden-content").style.display = "block";
                  }
              }

              // Iniciar a contagem regressiva imediatamente
              startCountdown(10);

              // Atualizar a contagem regressiva a cada segundo
              var x = setInterval(startCountdown, 1000);
          </script>
      </div>
    </div>

<!-- <div class="container-fluid p-0">
  <a href="https://www.dentalpressbooks.com/books/"><img class="img-fluid" style="background-repeat: no-repeat;" src="{{ asset('imagens/Facelift/black-friday-capa-black-friday.png') }}"></a>
</div> -->

<div class="modal fade" id="gotalk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="iframe-container">
                <iframe id="audioPlayerIframe" src="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('gotalk');
        const iframe = document.getElementById('audioPlayerIframe');
        const buttons = document.querySelectorAll('.openModalBtn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const audioUrl = this.getAttribute('data-audio-url'); // Obtém a URL do áudio do botão
                const playerUrl = `https://dentalgo.com.br/audioplayer?url=` + audioUrl;
                
                console.log("Carregando Iframe com URL:", playerUrl); // Log para depuração
                iframe.src = playerUrl;
            });
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            iframe.src = ""; // Limpa o iframe ao fechar o modal
            console.log("Iframe removido.");
        });
    });
</script>
 <style>
    .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .modal-backdrop {
        backdrop-filter: blur(10px);
        background: rgba(100, 0, 0, 0.5); /* Tom avermelhado */
    }

    .iframe-container {
        width: 100%;
        height: 500px; /* Defina a altura conforme necessário */
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
</style>
<!-- <div class="container-fluid p-0">
    <a href="https://www.dentalpressbooks.com/">
  <img class="img-fluid" src="{{ asset('imagens/Facelift/black-friday-mobile.png') }}">
  </a>
</div> -->
<div class="container-fluid" id="SessionGotalks" style="background-color:#2b2b2b; padding-block: 40px; padding-bottom: 140px; margin-top: px;">
    <div class="container" >
      <div class="row">
          <div class="col-md-6">
           
                    <img class="img-fluid" id="LogoGotalks" style="width: 50%;" src="{{ asset('imagens/Facelift/selo-go-talks-branco.png') }}" alt="">
                    <h2 style="color:#fff; font-family: raleway; font-size: 20px;  text-align: left; margin-bottom: 5px;">{{__("messages.GOTALKSDia")}}</h2>
                    <p style="color: #d0d0d0; font-size: 15px;">{{__("messages.GOTALKSRevista")}}</p>
                    <img src="{{ asset('imagens/Facelift/exp.png') }}" style="margin-top: 10px; margin-bottom: 10px; width: 60%; display: block; margin: 10px auto;" alt="">
              <h1 class="revistaImagemArtigoh1" style="font-family: 'Montserrat'; text-decoration:none !important; color:#fff;">{{__("messages.GOTALKSTitulo")}}</h1>
                <p class="revistaImagemArtigop" style="color:#fff;">	
                {{__("messages.GOTALKSParagrafo")}}
                </p>
                <p class="revistaImagemArtigop1" style="color:#fff;">{{__("messages.GOTALKSAutores")}}</p>
                <div class="d-flex justify-content-center" style="padding-bottom: 20px;">

                <button type="button" class="btn btn-primary openModalBtn" 
                    data-audio-url="https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n5/gotalks/Expans%C3%A3o_r%C3%A1pida_da_maxila_e_seu_impacto_na_apneia_do_sono_em_crian%C3%A7as_de_5_a_8_anos_um_estudo_retrospectivo.mp3" 
                    data-bs-toggle="modal" 
                    data-bs-target="#gotalk" 
                    style="background-color: transparent; border: 1px solid #fff; padding: 10px 40px; 
                        border-radius: 18px; display: flex; align-items: center; 
                        justify-content: center; gap: 10px; width: 100%; max-width: 300px;">
                    
                    <i class="fa-solid fa-play letra" style="color:#fff; font-size: 23px;"></i>
                    <span style="color:#fff; font-size: 23px; text-transform: none !important; margin-bottom: 0;">Clique e Ouça</span>
                </button>
                <!--<div class="col-12">
                    <button type="button" class="btn btn-primary openModalBtn " 
                        data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/Pt-Entrevista_com_Ravindra_Nanda.mp3" 
                        data-bs-toggle="modal" 
                        data-bs-target="#gotalk" 
                        style="background-color: transparent; border: 1px solid #fff; padding: 10px 40px; 
                            border-radius: 18px; display: flex; align-items: center; 
                            justify-content: center; gap: 10px; width: 100%; max-width: 300px; margin-bottom: 20px;">
                            <img style="  height: 16px; border-radius: 3px;" src="https://upload.wikimedia.org/wikipedia/commons/0/05/Flag_of_Brazil.svg" alt="BR">
                        <i class="fa-solid fa-play letra" style="color:#fff; font-size: 23px;"></i>
                        <span style="color:#fff; font-size: 15px; text-transform: none !important; margin-bottom: 0;">Clique e Ouça</span>
                    </button>
                    <button type="button" class="btn btn-primary openModalBtn " 
                        data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/En-Interview_with_Ravindra_Nanda.mp3" 
                        data-bs-toggle="modal" 
                        data-bs-target="#gotalk" 
                        style="background-color: transparent; border: 1px solid #fff; padding: 10px 40px; 
                            border-radius: 18px; display: flex; align-items: center; 
                            justify-content: center; gap: 10px; width: 100%; max-width: 300px; margin-bottom: 20px;">
                            <img style="  height: 16px; border-radius: 3px;" src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg" alt="EN">
                        <i class="fa-solid fa-play letra" style="color:#fff; font-size: 23px;"></i>
                        <span style="color:#fff; font-size: 15px; text-transform: none !important; margin-bottom: 0;">Click and Listen</span>
                    </button>
                    <button type="button" class="btn btn-primary openModalBtn " 
                        data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/Es-Entrevista_con_Ravindra_Nanda.mp3" 
                        data-bs-toggle="modal" 
                        data-bs-target="#gotalk" 
                        style="background-color: transparent; border: 1px solid #fff; padding: 10px 40px; 
                            border-radius: 18px; display: flex; align-items: center; 
                            justify-content: center; gap: 10px; width: 100%; max-width: 300px; margin-bottom: 20px;">
                        <img style="  height: 16px; border-radius: 3px;" src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Flag_of_Spain.svg" alt="ES">
                        <i class="fa-solid fa-play letra" style="color:#fff; font-size: 23px;"></i>
                        <span style="color:#fff; font-size: 15px; text-transform: none !important; margin-bottom: 0;">Haz clic y Escucha</span>
                    </button>
            </div>-->
          </div>
            
      </div>
    </div>
</div>

<section class="section2 container-fluid" style="background-color:#131313; padding-bottom: 60px;">
        <div class="container">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-11 top text-left mb-4">
                    <!--<h2 class="title">Conheça o <span>GoTalks</span> Uma nova maneira de <span>Ouvir a ciência</span></h2> -->
                </div>
                <div class="col-1"></div>
            </div>

            <div class="row align-items-center"> <!-- Mantém os elementos alinhados verticalmente -->
                
                <div class="col-md-12">
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/1R0SQA5Z68OGGIpcYXiV0s?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                </div>

             </div>
          
        </div>
    </section>
<!--
<div class="container-fluid novidades2">
    <section id="slider"> 
            <h3 class="videosPalavra d-inline-block" style="font-size: 1.75rem !important; color: #aaaaaa !important;">{{__("messages.VideosDestaque")}}</h3>   
            <a href="#" class="videosVejaMais ">{{__("messages.VejaMaisAll")}} <b>></b></a>     
                <div class="slider carousel-no-inspect">
                    <div class="owl-carousel owl-carousel-seis">
                        <div class="slider-card d-flex justify-content-center align-items-center"> 
                            <div>
                              <div class="item "><a href="https://dentalgo.com.br/video/875/GoCast/10455"><img src="{{ asset('imagens/Facelift/GOcast-HD.png') }}" alt="Imagem 1" class="img-carousel img-fluid"></a> <p style="color: #fff; font-family: 'Open Sans'; font-weight: bold; margin-top:20px;">Podcast com Dra. Cibele Dal Fabbro</p></div>
                            </div>
                          </div>   
                        <div class="slider-card d-flex justify-content-center align-items-center">   
                            <div>   
                              <div class="item"><a href="https://dentalgo.com.br/video/431/Dr.-Alberto-Consolaro/6189"><img src="{{ asset('imagens/Facelift/entrevista-alberto-consolaro HD.png') }}" alt="Imagem 2" class="img-carousel img-fluid"></a> <p style="color: #fff; font-family: 'Open Sans'; font-weight: bold; margin-top:20px;">Entrevista Alberto Consolaro</p></div>
                            </div>
                          </div>
                        <div class="slider-card d-flex justify-content-center align-items-center">   
                            <div>   
                              <div class="item"><a href="https://dentalgo.com.br/video/431/Dr.-Marcos-Janson/6181"><img src="{{ asset('imagens/Facelift/Entrevistas-Marcos-Janson-HD.png') }}" alt="Imagem 1" class="img-carousel img-fluid"></a> <p style="color: #fff; font-family: 'Open Sans'; font-weight: bold; margin-top:20px;">Entrevista Marcos Jason</p></div>
                            </div>   
                          </div>
                          <div class="slider-card d-flex justify-content-center align-items-center">   
                            <div>   
                              <div class="item"><a href="https://dentalgo.com.br/video/719/Entrevista---Ana-Cec%C3%ADlia/10159"><img src="{{ asset('imagens/Facelift/ENTREVISTA-ANA-CECILIA.jpg') }}" alt="Imagem 1" class="img-carousel img-fluid"></a> <p style="color: #fff; font-family: 'Open Sans'; font-weight: bold; margin-top:20px;">Entrevista Ana Cecília</p></div>
                            </div>   
                          </div> 
                          <div class="slider-card d-flex justify-content-center align-items-center">   
                            <div>   
                              <div class="item"><a href="https://dentalgo.com.br/video/719/Entrevista---Paulo-Vinicius/9271"><img src="{{ asset('imagens/Facelift/ENTEVISTA-PAULO-VINICIUS.jpg') }}" alt="Imagem 1" class="img-carousel img-fluid"></a> <p style="color: #fff; font-family: 'Open Sans'; font-weight: bold; margin-top:20px;">Entrevista Paulo Vinicius</p></div>
                            </div>   
                          </div> 
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
      </section>
  </div>
                
  <div class="container-fluid background-meio d-inline-block text-center">
  <div class="container ">
    <div class="col-12 ">
        <div class="row">
            <div class="col-12 col-sm-4 box-inside " style="margin-right:0px;">
              <h1 class="title-encontraAqui">{{__("messages.OqueVoceEncontra")}} <br><strong>{{__("messages.EncontraAqui")}}</strong></h1>
            </div>
            <div class="col-sm-2 juntar-letrasNumeros" id="numero-autores">
                <div class="numero-container">
                  <p class="mini-mais">+</p>
                  <p class="texto-numerosCima contagem">1000</p>
                </div>
                <p class="texto-paragrafoLetras borda-inferior" >{{__("messages.AutoresAqui")}}</p>
              </div>    
            <div class="col-sm-2 juntar-letrasNumeros" id="numero-autores">
                <div class="numero-container">
                  <p class="mini-mais">+</p>
                  <p class="texto-numerosCima contagem">6000</p>
                </div>
                <p class="texto-paragrafoLetras borda-inferior">{{__("messages.ArtigosAqui")}}</p>
            </div>
            <div class="col-sm-2 juntar-letrasNumeros" id="numero-autores">
                <div class="numero-container">
                  <p class="mini-mais">+</p>
                  <p class="texto-numerosCima contagem ">300</p>
                </div>
                <p class="texto-paragrafoLetras borda-inferior">{{__("messages.VideosAqui")}}</p>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
-->
<div class="container-fluid" style=" margin-bottom: 10px; padding-right: 0px; padding-left: 0px;">
    <div class="carousel-container">
        <!-- Vídeo em Segundo Plano -->
                <div class="container-fluid">
                    <section id="slider3DVideo" class="pt-5 slides-espaco carouselPatrocinadoresHome">
                        <div class="thumbnails-container">
                            <div class="slider">
                                <div class="owl-carousel owl-carousel-slidesparceiros">
                                    <div class="slide-info">
                                        <div class="">
                                            <div class="slider-card" >
                                                <a href="https://www.dentalgo.com.br/clinicorp" style="text-decoration: none;">
                                                    <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/clinicorp.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>       
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://www.dentsplysirona.com/pt-br" target="_blank" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/dentsply.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <!-- <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://www.dentalgo.com.br/ultradent" target="_blank" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/ultradentbranco.fw.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div> -->
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://dentalgo.com.br/invisalign" target="_blank" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/alignbranco.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://dentalgo.com.br/biologix" target="_blank" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/biologixbranco.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card">
                                            <a href="https://www.dentalgo.com.br/parceiro/73/dvi" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/dvi.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card">
                                            <a href="https://www.orthometric.com.br/" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/testando123.fw.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://easy3d.com.br/" style="text-decoration: none;" target="_blank">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/easy3d.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://www.id-logical.com/" style="text-decoration: none;" target="_blank">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/id-logicallogo.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://dentalgo.com.br/shining3d" style="text-decoration: none;" target="_blank">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/shininglogobranca.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <!-- <div class="slide-info">    
                                        <div class="slider-card" >
                                            <a href="https://www.dentalgo.com.br/cvdentus" target="_blank" style="text-decoration: none;">
                                                <div style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/cvdentuslogo-1.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div> -->
                                    <!--<div class="slide-info">    
                                        <div class="slider-card video2" id="slide2" >
                                            <a href="#" style="text-decoration: none;">
                                                <div class="item-video" style="margin-left: 20px; margin-right: 20px;"><img src="{{ asset('imagens/Facelift/congresso.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>-->
                                    <!--<div class="slide-info">    
                                        <div class="slider-card video3" id="slide3" data-video-id="gnHZ2-w2p5I" data-title="DentalGo: + de 25 anos de ciência" data-button="Acessar" data-description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae neque minima natus, consectetur ex reiciendis aperiam, sint dolor odit necessitatibus voluptatibus, minus incidunt harum aliquid soluta maiores hic adipisci similique!">
                                            <a href="#" style="text-decoration: none;">
                                                <div class="item-video" style="margin-left: 110px;"><img src="{{ asset('imagens/Facelift/dentalGoo.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>-->    
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
    </div>
</div>

<!--
<div class="container-fluid espaço-shorts">
    <div class="row">
      <div class="container" style="margin-bottom:0;">
        <div class="row">
          <div class="test d-flex justify-content-center align-items-center" id="dentalgoacademylogo">
            <a href="{{ route('video')}}/681">
              <img src="{{ asset('imagens/Facelift/DentalGO - Academy - black.png') }}" alt="" class="img-fluid logoHomeVideo" style="margin-top:70px !important;">
            </a>
          </div> 
          <div class="test d-flex justify-content-center align-items-center">
            <a href="{{ route('video')}}/681/Como-escolher-entre-Alinhadores-Terceirizados%C2%A0e%C2%A0In-House/10471">
              <img src="{{ asset('imagens/Facelift/videoCapa.png') }}" alt="" class="img-fluid imagemVideoCapaHome">
            </a>
          </div>
          <div class="test2 d-flex justify-content-center align-items-center">
            <p class="paragrafo-abaixoacademy">{{__("messages.AssistaAulaMelhores")}}</p>
          </div> 
        </div>
      </div>
        -->
        <div class="tab-slider--container ">
            @foreach ($videos as $key => $videosCat)
                @if($videosCat->id == '681')
                    <div id="DentalGO-Videos-{{ $videosCat->id }}" class="tab-slider--body">
                        <h3 style="color:#aaaaaa;">{{$videosCat->title}}</h3>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="owl-carousel owl-theme owl-carousel-cinco">
                                    @foreach (array_slice($videosCat->productItems, 0, 10) as $video)
                                    <div class="item">
                                        <a href="{{ route('video')}}/{{ $videosCat->id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}">
                                        <img src="{{ $video->cover}}" alt="{{ $video->title }}"> 
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
      </div>
    </div>
    <div class="container text-center altura-mobile-aulas" style="margin-bottom:20px !important;">
      <div class="col-12">
        <button type="button" class="btn btn-secondary botaoVejaAula">{{__("messages.VejaTodasAulas")}}</button>
      </div>
    </div>
  </div>



<!--<div class="container-fluid text-center depoimentos-box" style="background: #ffffff;">
    <div class="container" style="margin-top: 50px;">
      <div class=" owl-carousel owl-carousel-um owl-autoHeightClass">
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/clinical-orthodontics.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Clinical Orthodontics</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/dpjo.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Dental Press Journal of Orthodontics</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/OROFACIAL-HARMONY.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Orofacial Harmony</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/Estética.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Estética</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/JBCOMS.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">College of Oral and Maxillofacial Surgery</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/Endodontics.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Endodontics</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
        <div class="item text-center">
          <div class="row">
            <div class="col-sm-4">
              <img src="{{ asset('imagens/Facelift/Periodontology.jpg') }}" alt="" class="img-fluid imgteste">
            </div>
            <div class="col-sm-8">
              <h1 class="corTextoDepoimento corTextoDepoimentoTitulo">Brazilian Journal of Periodontology</h1>
              <p class="corTextoDepoimento texto-depoimento">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores veroLorem, ipsum dolor sit amet consectetur adipisicing elit. Velit aspernatur dignissimos fugiat delectus repudiandae inventore molestias fugit ducimus, culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero culpa temporibus reiciendis nam reprehenderit quibusdam expedita maxime dolore magnam asperiores vero...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>-->

  <div class="container-fluid novidades2" style="-webkit-box-shadow: inset 10px -1px 205px 106px rgba(0,0,0,0.95);
  -moz-box-shadow: inset 10px -1px 205px 106px rgba(0,0,0,0.95);
  box-shadow: inset 10px -1px 205px 106px rgba(0,0,0,0.95);">
    <h3 class="videosPalavra d-inline-block" style="margin-top: 100px; margin-bottom: 8px !important; font-size: 1.75rem;">{{__("messages.Tecnologia")}}</h3>
    <a href="#" class="videosVejaMais" style="display:none;">{{__("messages.VejaMaisAll")}} <b>></b></a>  
    <div class="container-fluid">
      <section id="slider">    
        <div class="slider carousel-no-inspect">
            <div class="owl-carousel owl-carousel-tecnologia"> 
                <div class="slider-card d-flex justify-content-center align-items-center">
                  <div>
                    <div class="item ">
                      <a href="https://www.dentalgo.com.br/parceiro/73/dvi">
                        <img src="{{ asset('imagens/Facelift/comercial/canais/CANAL-DVI.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                      </a>
                    </div>
                  </div>
                </div>   
                <div class="slider-card d-flex justify-content-center align-items-center">   
                  <div>   
                    <div class="item "> 
                      <a href="https://www.dentalgo.com.br/clinicorp">
                        <img src="{{ asset('imagens/Facelift/comercial/canais/CANAL-clinicorp.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                      </a>
                    </div>
                  </div>
                </div>
                <div class="slider-card d-flex justify-content-center align-items-center">   
                <div>   
                  <div class="item "> 
                    <a href="https://www.dentsplysirona.com/pt-br" target="_blank">
                      <img src="{{ asset('imagens/Facelift/comercial/canais/canal-dentsply.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                    </a>
                  </div>
                </div>   
              </div> 

              <div class="slider-card d-flex justify-content-center align-items-center">   
                <div>   
                  <div class="item "> 
                    <a href="https://www.dentalgo.com.br/invisalign" target="_blank">
                      <img src="{{ asset('imagens/Facelift/comercial/canais/align-education-square.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                    </a>
                  </div>
                </div>   
              </div>
              <div class="slider-card d-flex justify-content-center align-items-center">   
                <div>   
                  <div class="item "> 
                    <a href="https://dentalgo.com.br/biologix" target="_blank">
                      <img src="{{ asset('imagens/Facelift/comercial/canais/biologixhome.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                    </a>
                  </div>
                </div>   
              </div> 
              <div class="slider-card d-flex justify-content-center align-items-center">   
                <div>   
                  <div class="item "> 
                    <a href="https://dentalgo.com.br/shining3d" target="_blank">
                      <img src="{{ asset('imagens/Facelift/comercial/canais/shining3dblock.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                    </a>
                  </div>
                </div>   
              </div> 
              <!-- <div class="slider-card d-flex justify-content-center align-items-center">   
                    <div>   
                        <div class="item "> 
                        <a href="https://www.dentalgo.com.br/cvdentus" target="_blank">
                            <img src="{{ asset('imagens/Facelift/comercial/canais/CANALcvdentus.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                        </a>
                        </div>
                    </div>   
                </div>
                <div class="slider-card d-flex justify-content-center align-items-center">   
                <div>   
                  <div class="item "> 
                    <a href="https://www.dentalgo.com.br/ultradent" target="_blank">
                      <img src="{{ asset('imagens/Facelift/comercial/canais/ultradentHOME.png') }}" alt="Imagem 1" class="img-carousel img-fluid" style="border-radius: 10%;">
                    </a>
                  </div>
                </div>   
              </div> -->
            </div>
          </div>
        </section>
    </div>
  </div>

  <!-- ASSINE DENTALGO -->
<div class="container-fluid revistaApoiadoresFundoCol3 " style="background: #212121; filter: drop-shadow(0px 0px 0px #9999); margin-bottom: 0px; margin-top: 20px !important;">
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
        <div class="col-md-12">
            <div class="row ">
              <div class="col-sm-12 revistaApoiadoresCol3"> 
                <div class="row ">
                  <div class="col-4 col-md-2">
                      <img src="{{ asset('imagens/Facelift/Livros.png') }}" style="width: 100%;">
                  </div>
                  <div class="col-4 col-md-2">
                      <img src="{{ asset('imagens/Facelift/Vídeos.png') }}" style="width: 100%;">
                  </div>
                  <div class="col-4 col-md-2">
                      <img src="{{ asset('imagens/Facelift/quandoeondequiser.png') }}" style="width: 100%;">
                  </div>
                  <div class="col-4 col-md-2">
                      <img src="{{ asset('imagens/Facelift/Novosconteúdos.png') }}" style="width: 100%;">
                  </div>
                  <div class="col-4 col-md-2">
                    <img src="{{ asset('imagens/Facelift/especialistas.png') }}" style="width: 100%;">
                  </div>
                  <div class="col-4 col-md-2">
                      <img src="{{ asset('imagens/Facelift/Descontos.png') }}" style="width: 100%;">
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</div>
<!--pode dar erro um dia-->
@if(null == session()->get('token'))
<div class="container-fluid AssinaturaDentalgo">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 preco text-center" style="padding-top:150px !important;">
        <h1 style="color: #ffff; white-space: nowrap; font-family: 'Montserrat'; margin-top:40px;" class="DVITexto assine-hoje">{{__("messages.AssinaturaApenas")}}</h1>
        <div class="price-container DVITexto">
          <h1 class="preço">R$ <strong>89</strong>,00</h1>    
        </div>
        <!-- <a data-bs-toggle="modal" data-bs-target="#modalCadastro">
          <button class="btn btn-link queroAdquirir DVITexto">{{__("messages.AssinaturaQueroAdquirir")}}</button>
        </a> -->
        <a href="https://www.dentalgo.com.br/checkoutnovo">
          <button class="btn btn-link queroAdquirir DVITexto">{{__("messages.AssinaturaQueroAdquirir")}}</button>
        </a>
      </div>
        <div class="col-sm-6  ">
          <div class="container infoAssinatura text-center rodape-mobiletotalmentesumido">
          <div class="row textoAssinatura">
              <div class="icone-container">
                <i class="fa-solid fa-check fa-xl icone-check" style="color: #cfcfcf; height:auto; font-weight:bold;"></i>
                <p class="paragrafo-check">@php echo __("messages.AssinaturaInfo") @endphp</p>
              </div>
 
              <div class="icone-container">
                <i class="fa-solid fa-check fa-xl icone-check" style="color: #cfcfcf; height:auto;"></i>
                <p class="paragrafo-check" >@php echo __("messages.AssinaturaInfo2") @endphp</p>
              </div>

              <div class="icone-container">
                <i class="fa-solid fa-check fa-xl icone-check" style="color: #cfcfcf; height:auto;"></i>
                <p class="paragrafo-check" >@php echo __("messages.AssinaturaInfo3") @endphp</p>
              </div>

 
              <div class="icone-container">
                <i class="fa-solid fa-check fa-xl icone-check" style="color: #cfcfcf; height:auto;"></i>
                <p class="paragrafo-check" >@php echo __("messages.AssinaturaInfo4") @endphp</p>
              </div>


              <div class="icone-container">
                <i class="fa-solid fa-check fa-xl icone-check" style="color: #cfcfcf; height:auto;"></i>
                <p class="paragrafo-check" >@php echo __("messages.AssinaturaInfo5") @endphp</p>
              </div>
            </div>
          </div>  
        </div>       
      </div>
    </div>
  </div>
</div>
@endif

<!-- VIDEOZÃO -->


<div class="container-fluid" style="padding-right: 0px; padding-left: 0px;">
    <div class="carousel-container">
        <!-- Vídeo em Segundo Plano -->
        <div class="video-container">
            <div id="player"></div>
            <video id="video-frame" class="video-iframe" preload="auto" autoplay muted loop></video>
            <div class="video-gradient-overlay"></div>
            <div class="video-overlay d-inline-block ">
                <h1 class="video-title"></h1>
                <p class="video-description"></p>
                <a class="btn-link video-button video-link" value='href' target="_blank" href="#"></a>
                <div class="container-fluid">
                    <section id="slider3DVideo" class="pt-5 slides-espaco">
                        <div class="thumbnails-container">
                            <div class="slider">
                                <div class="owl-carousel owl-carousel-sete">
                                    <div class="slide-info img-mobile">
                                        <div class="">
                                            <div class="slider-card video1" id="slide1" data-video-id="WYzckagYVAE" data-title="Specialties 2023" data-button="Acessar" data-description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae neque minima natus, consectetur ex reiciendis aperiam, sint dolor odit necessitatibus voluptatibus, minus incidunt harum aliquid soluta maiores hic adipisci similique!">
                                                <a href="#" style="text-decoration: none;">
                                                    <div class="item-video" style="margin-left: 20px; margin-right:20px;"><img src="{{ asset('imagens/Facelift/Logo-horizontal.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>       
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slide-info img-mobile">    
                                        <div class="slider-card video2" id="slide2" data-video-id="tQU0jUVkm3A" data-title="Ortodontia Infantil Dental Press 2023" data-button="Acessar" data-description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae neque minima natus, consectetur ex reiciendis aperiam, sint dolor odit necessitatibus voluptatibus, minus incidunt harum aliquid soluta maiores hic adipisci similique!">
                                            <a href="#" style="text-decoration: none;">
                                                <div class="item-video" style="margin-left: 20px; margin-right:20px;"><img src="{{ asset('imagens/Facelift/ortodontia2.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>
                                    <!--<div class="slide-info img-mobile">    
                                        <div class="slider-card video3" id="slide3" data-video-id="gnHZ2-w2p5I" data-title="DentalGo: + de 25 anos de ciência" data-button="Acessar" data-description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae neque minima natus, consectetur ex reiciendis aperiam, sint dolor odit necessitatibus voluptatibus, minus incidunt harum aliquid soluta maiores hic adipisci similique!">
                                            <a href="#" style="text-decoration: none;">
                                                <div class="item-video" style="margin-left: 110px;"><img src="{{ asset('imagens/Facelift/dentalGoo.png') }}" alt="thumbnail1" class="img-fluid img-carousel-sete"></div>
                                            </a>
                                        </div>   
                                    </div>-->    
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>







<!--<div class="container-fluid Assinatura">
    <div class="row">
      <div class="col-sm-5 preco">
        <small class="subTitulo">Ciência de ponta pelo preço de um cafézinho por dia</small>
        <p style="color: #ffffff; width: 450px; text-align: justify;">A DentalGo é o maior acervo odontológico mundial onde você tem acesso a milhares de artigos e centenas de vídeos para aumentar ainda mais seu conhecimento.</p>
        <h1 style="color: #ffff; white-space: nowrap;">Assine hoje por apenas:</h1>
        <div class="price-container">
          <h1 style="color: #ffff; white-space: nowrap; display: inline-block; font-size: 80px; font-weight: bold; font-family: prompt; margin-right: 5px;">R$ 78,00</h1>
          <p style="color: #ffff; font-size: 30px; display: inline-block; vertical-align: middle;">/mês.</p>
        </div>
        <button class="btn btn-link Assineja">Assine Já</button>
        <button class="btn btn-link queroAdquirir">Saiba Mais</button>
      </div>
  
      <div class="col-sm-7"></div>
    </div>
  </div>
</div>-->

<!-- Banner publicidade -->
<!--<div class="owl-carousel owl-carousel-nove owl-autoHeightClass">
    <div class="item">
        <div class="container-fluid Assinatura-alado">
            <div class="row">
                <div class="col-sm-5 preco">
                    <h1 class="titulo-Slides-banners">Titulo Para Teste 2</h1>
                    <p class="paragrafo-Slides-banners">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer arcu elit, bibendum sit amet odio et, euismod maximus sem. Morbi volutpat lorem lectus, vel ornare nulla cursus a.</p>
                    <div class="alinhamento-botoes">
                        <button class="btn btn-link Acessar-teste DVITexto">Acessar</button>
                        <button class="btn btn-link Adquirir-teste DVITexto">Saiba Mais</button>
                    </div>
                </div>
                <div class="col-sm-7"></div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="container-fluid Assinatura-SBO">
            <div class="row">
                <div class="col-sm-5 preco">
                    <h1 class="titulo-Slides-banners">Titulo Para Teste 2</h1>
                    <p class="paragrafo-Slides-banners">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer arcu elit, bibendum sit amet odio et, euismod maximus sem. Morbi volutpat lorem lectus, vel ornare nulla cursus a.</p>
                    <div class="alinhamento-botoes">
                        <button class="btn btn-link Acessar-teste DVITexto">Acessar</button>
                        <button class="btn btn-link Adquirir-teste DVITexto">Saiba Mais</button>
                    </div>
                </div>
                <div class="col-sm-7"></div>
            </div>
        </div>
    </div>

    <div class="item">
        <div class="container-fluid AssinaturaDVI">
            <div class="row">
                <div class="col-sm-5 preco">
                    <small class="subTituloDVI">Canal de Radiologia DVI</small>
                    <p class="DVITexto DVI-CLASSE">Venha conhecer o canal da DVI Assista o PodCast inédito Saiba mais sobre franquias de radiologia Fique por dentro das novidades do setor</p>
                    <button class="btn btn-link AcessarCanal DVITexto">Acessar Canal</button>
                </div>
                <div class="col-sm-7"></div>
            </div>
        </div>
    </div>
</div>-->

<!-- ESPAÇO LEITURA -->
<div class="BgBlackHome">
  <!-- REVISTAS -->

    <div class="container HomeUltimasRevistas">
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <h3 class="ultimas-revistas">{{__("messages.HomeBladeLast")}} <a href="#" class="videosVejaMais-ultimasrevistas ">{{__("messages.VejaMaisAll")}}<b>></b></a></h3>  
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
            .primeira-imagem {
              flex: 0 0 100%; /* A primeira imagem ocupa a largura inteira */
              max-width: 100%;
            }
            .primeira-imagem img {
              width: 100%; /* Ajuste o tamanho da imagem para preencher a largura */
              height: auto; /* Garanta que a altura seja ajustada automaticamente */
              margin-bottom: 0; /* Remova a margem inferior da primeira imagem */
            }
          }
        </style>
        <div class="row">
            @foreach ($colecoes[0]->collections->magazines as $index => $revista)
                <div class="col imagem-col{{ $index === 0 ? ' primeira-imagem' : '' }}">
                    <div class="artigoFavSombraRevistas">
                        <div class="imagemultimaRevistaCol">
                            <a href="{{ route('colecao') }}/{{ $revista->id }}" style="text-decoration: none;">
                            <img src="{{ $revista->lastProductCover }}" alt="{{ $ultimoArtigo1->title }}" class="img-fluid">
                            @if($index === 0 ? ' primeira-imagem' : '' )
                                <div class="d-flex" >
                                    <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"  class="img-fluid logo-abor-revista-home mostrar-imagem imagem-portugues imagem-ingles"  style=" @if($linguagem == 'es') display:none; @endif">
                                    <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"  class="img-fluid logo-alado-revista-home mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" >
                                </div>
                            @endif
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container"> 
        <h3 class="livros-cortesia" style="color: #aaaaaa;">{{__("messages.HomeBladeCortesia")}}</h3>
    </div>
    <div class="container-fluid text-center depoimentos-box">
        <div class="container" style="margin-top: 0px;">
            <div class=" owl-carousel owl-carousel-um owl-autoHeightClass">
                @foreach ($todosLivrosG as $key => $revista)
                    @if($revista->subscriberCourtesy == 1)
                        <div class="item text-center">
                            <a href="{{ route('livro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="{{ $revista->cover }}" alt="" class="img-fluid imgteste" style="margin-bottom: 100px !important;">
                                    </div>
                                    <div class="col-sm-8">
                                        <h3 class="corTextoDepoimento corTextoDepoimentoTitulo">{{ $revista->title }}</h3>
                                        <p class="corTextoDepoimento texto-depoimento">{{ $revista->brief }}</p>
                                    </div>
                                </div>  
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    
    @php
    $empresasComercial = [
        [
            'nome' => 'ID-Logical',
            'link' => 'https://www.id-logical.com/',
            'imagem' => 'bannersComercial/Banner-id-logical.png'
        ],
        [
            'nome' => 'Aqua Alinhadores',
            'link' => 'http://alinhadoresaqua.com',
            'imagem' => 'bannersComercial/BannerAQUAALINHADORES1920X500.png'
        ],
        [
            'nome' => 'ORTHOMETRIC',
            'link' => 'https://www.orthometric.com.br/',
            'imagem' => 'bannersComercial/capelozzabanner.jpg'
        ],
        [
            'nome' => 'AngelAligner',
            'link' => 'https://www.orthoeducation.com.br/eventos',
            'imagem' => 'bannersComercial/ANGELALIGNERDMOBILE.jpg'    
        ],
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
    <div class="col-sm-12" >
    <div id="carouselExampleInterval2" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($arrayFinal as $keyBanner => $empresa)
                <button type="button" data-bs-target="#carouselExampleInterval2" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner testeCarousel">
            @foreach ($arrayFinal as $keyBanner => $empresa)
                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                 <a href="{{ $empresa['link'] }}" target="_blank">
                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }} ">
                    <div class="carousel-caption conteudoBanner">
                    </div>
                 </a>
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval2" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval2" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> 
    </div>
</div>
  
  <div class="BgBrancoHOme">        
    <div class="container-fluid"> 
        <h3 class="comprar-livros">{{__("messages.LivrosParaComprar")}}</h3>
    </div>
    <div class="container-fluid text-center depoimentos-box">
        <div class="container" style="margin-top: 0px;">
            <div class=" owl-carousel owl-carousel-livros-comprar">
                @foreach ($todosLivros as $key => $revista)
                    <?php
                    if($revista->id == '1109') {
                    ?>
                    @continue
                    <?php 
                        }
                    ?>
                    @if($revista->subscriberCourtesy == null)

                        <div class="item text-start">
                            <a href="https://www.dentalpressbooks.com/{{$revista->id}}" target="_blank" class="tiraUnderline">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="{{ $revista->cover }}" alt="" class="img-fluid img-livros-fisicos">
                                    </div>
                                    <div class="col-sm-8">
                                        <button class="categoria">{{ $revista->internalCode}}</button>
                                        <h3 class="titulo-livros-fisicos">{{ $revista->title }}</h3>
                                        <h4 class="livros-nome">Nome Autor</h4>   
                                        <p class="livro-preco">R${{number_format($revista->price / 100, 2, ',', '.')}}</p>
                                    </div>
                                </div>  
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

  </div>
  
    <!-- NEWSLETTER -->
<!--
    <div class="container-fluid background-newsletter" >
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 col-sm-4">
                    <h1 class="novidadesh1">@php echo __("messages.FiquePorDentro") @endphp
                    <p class="newsletter-color">{{__("messages.AssineNewsletter")}}</p>
                </div>
                <div class="col-12 col-lg-6 col-sm-8">
                    <div role="main" id="sites-revistas-clinical-124042a77f6190b8522c"></div><script type="text/javascript" src="https://d335luupugsy2.cloudfront.net/js/rdstation-forms/stable/rdstation-forms.min.js"></script><script type="text/javascript"> new RDStationForms('sites-revistas-clinical-124042a77f6190b8522c', 'UA-47544877-1').createForm();</script>
                </div>
              </div>
          </div>
    </div>
-->

     <!-- DUVIDAS FREQUENTES -->
     <div class="container" style="min-height: 400px;">
        <div class="row text-center">
            <h1 class="tituloDuvidas">{{__("messages.DuvidasFrequentes")}}</h1>
        </div>
        <div class="container-fluid text-center">
            <div class="accordion accordion-flush"  id="accordionFlushExample" >
                <div class="accordion-item fundo-accordion">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed text-center sem-sublinhado" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <span class="corTexto">{{__("messages.DuvidasFrequentesTitle")}}</span>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body fundo-accordion">
                            <p class="texto-accordion">{{__("messages.DuvidasFrequentesDetalhes")}} </p>
                        </div>
                    </div>
                </div>
                <!-- <div class="accordion-item fundo-accordion">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <span class="corTexto">{{__("messages.DuvidasFrequentesTitle2")}}</span>
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body fundo-accordion">
                          <p class="texto-accordion">{{__("messages.DuvidasFrequentesDetalhes2")}} </p>
                        </div>
                    </div>
                </div> -->
                <div class="accordion-item fundo-accordion">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed text-center" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            <span class="corTexto">{{__("messages.DuvidasFrequentesTitle3")}}</span>
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body fundo-accordion">
                            <p class="texto-accordion">{{__("messages.DuvidasFrequentesDetalhes3")}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


      <!-- BASES INDEXADORAS -->
      <div class="container-fluid carousel-bases" style="margin-bottom: 0;">
        <div class="container-fluid">
            <div class="row">
                <section id="slider2D">
                    <div class="container-fluid">
                        <div class="slider col-md-12">
                            <h1 class="base-indexadora">{{__("messages.HomeBladeIndex")}}</h1>
                            <div class="owl-carousel owl-carousel-quatro">
                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/3.png" alt="bbo" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>

                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/6.png" alt="EBSCO" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>

                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/7.png" alt="IBICT" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>

                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/8.png" alt="LATINDEX" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>

                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/9.png" alt="LILACS" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>



                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="http://novo.dentalgo.com.br/imagens/13.png" alt="Scopus" class="imagemCinza">
                                        </a>
                                    </div>
                                </div>

0
                                <div class=" apoioPatrocionio2 col-md-6 d-flex justify-content-center align-items-center">
                                    <div class="slider-card ">
                                        <a href="#" target="_blank" style="text-decoration: none">
                                            <img src="{{ asset('imagens/Facelift/ulrichsbranco.fw.png') }}" alt="ULRICHSWEB" class="imagemCinza">
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
  </div>

<script src="https://www.youtube.com/iframe_api"></script>


@endsection