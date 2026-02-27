<?php
foreach ($revista[0]->productItems as $key => $capitulo) {
  if ($capitulo->id == Request()->segment(5)) {
    $paginaTitulo = 'Artigo: ' . $capitulo->title . ' - ' . $revista[0]->title . ' - DentalGO';
  }
}
$padinaDescricao = '';
$tipoTopo = 'topoAzul';


$permicao = $revista[1]->collections;
if (session()->get('usuarioPermissao') == 'naotem') {
  $modalConteudo = 'espacoParaAssinantes';
} elseif (session()->get('usuarioPermissao') == 'naotemVencido') {
  $dataVencimento = date(session()->get('usuario')->subscription->isValidUntil);
  $dataVencimento = explode('UTC', $dataVencimento);

  $dataAtual = date("Y-m-d");
  if ($dataVencimento[0] >= $dataAtual) {
    $modalConteudo = 'permitido';
  } else {
    $modalConteudo = 'renoveOplano';
  }
} elseif (session()->get('usuarioPermissao') == 'naotemSemPlano') {
  $modalConteudo = 'vamosAssinar';
} elseif (is_array(session()->get('usuarioPermissao'))) {
  $modalConteudo = 'espacoParaAssinantes';
  foreach ($permicao as $key => $value) {
    if (in_array($value->id, session()->get('usuarioPermissao'))) {
      $modalConteudo = 'permitido';
    }
  }
} else {
  $modalConteudo = 'espacoParaAssinantes';
}

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
if ($linguagem == null) {
  $linguagem = 'pt';
}

?>
@extends('facelift2.master')

@section('content')
  <style>
    /* Ensure modal is above topbar (z-index 1200) */
    .modal-backdrop {
      z-index: 2050 !important;
    }

    .modal {
      z-index: 2060 !important;
    }

    .modal:not(.show) {
      display: none !important;
    }

    /* Almost Fullscreen specific adjustments */
    .modal-almost-fullscreen {
      max-width: 96vw !important;
      margin: 2vh auto !important;
      height: 96vh !important;
    }

    .modal-almost-fullscreen .modal-content {
      height: 100%;
    }

    .modal-almost-fullscreen .modal-body {
      height: calc(100% - 56px);
      /* Subtract header height */
      overflow-y: hidden;
      padding: 0;
    }
  </style>
  <div class="container" style="margin-top: 100px;">
    <div class="row">
      @foreach ($revista[0]->productItems as $key => $capitulo)
            <?php
          if ($capitulo->id == Request()->segment(5)) {
                                              ?>
            <!--MODAL CompraLerAssine-->
            <div class="modal fade" id="compraLerAssine" tabindex="-1" aria-labelledby="compraLerAssine" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modalCentraliza">
                <div class="modal-content conteudoDoModal modalRedondinho">
                  <div class="modal-head modal-head-Vantagem1">
                    <button type="button" class="btn-close botaomodal-fechar" data-bs-dismiss="modal" aria-label="Close"
                      style="top: 10px; position:absolute; right: 10px;"></button>
                    <div class="logo-modal">
                      <img style="max-height:39px; margin: 20px auto;display:block"
                        src="https://novo.dentalgo.com.br/imagens/logo_dentalgo_branco_site.png">
                      <div class="modal-title tituloModal">
                        <h5 class="modal-title" id="compraLerAssine" style="text-align:center; font-family:prompt;">
                          {{__("messages.ModTopo")}}
                        </h5>
                        <p class="modal-title" style="text-align:center; font-family:prompt;">{{__("messages.ModVenha")}}</p>
                        <br>
                        <p class="title-price">{{__("messages.ModAssineApenas")}}</p>
                        <h2 class="mb-3 title-price2">R$ 89,00</h2>
                        <a href="{{ route('cadastrar') }}" class="btn btn-danger"
                          style="margin-right: 25px; text-align:center; margin-left:15px; font-family:prompt;" alt="assinar"
                          data-bs-toggle="modal" data-bs-target="#modalCadastro">{{__("messages.ModAssine")}}</a>
                        <a href="{{ route('logar') }}" style="item-align:center; font-family:prompt "
                          class="btn btn-primary btn-assinante" data-bs-toggle="modal"
                          data-bs-target="#modalLogin">{{__("messages.ModAssine2")}}</a>
                      </div>
                      <div class="row">
                        <div class="col-4 iconeVantagem"> <i class="fa-solid fa-book-open modal-icons"></i>
                          <h6 class="textoModal">{{__("messages.IconsBook")}}</h6>
                        </div>
                        <div class="col-4 iconeVantagem"><i class="fa-solid fa-house-laptop modal-icons"></i>
                          <h6 class="textoModal">{{__("messages.IconsHouse")}}</h6>
                        </div>
                        <div class="col-4 iconeVantagem"> <i class="fa-solid fa-calendar-days modal-icons"></i></i>
                          <h6 class="textoModal">{{__("messages.IconsCalendar")}}</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-body color-modalbody">
                    <div class="row">
                      <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('compraartigo') }}/{{ $revista[0]->id }}/{{$capitulo->id}}"
                          class="btn btn-primary btn-assinante1 text-center">
                          <span class="d-inline-block align-middle">{{__("messages.ArtigoBladeComprarArtigo")}}</span>
                        </a>
                      </div>
                      <p class="modal-title"
                        style="color:#fff; text-align:center; font-family:prompt; word-spacing: 1px; font-size:13px;">
                        {{__("messages.ArtigoBladeModalCompra")}}
                      </p>
                      <p class="modal-title"
                        style="color:#fff; text-align:center; font-family:prompt; word-spacing: 1px; font-size:13px;">
                        S{{__("messages.ArtigoBladeModalCompra2")}}</p>
                      <p class="saibamais-duvida2">{{__("messages.ArtigoBladeDuvida")}} <a href="#"
                          class="saibamais-duvida">{{__("messages.ArtigoBladeSaibaMais")}}</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
          }
                                            ?>
      @endforeach

  <div class="container-fluid blue-line2">
  </div>

  <div class="container mt-3">
    <div class="col-sm-12">
      <div class="row text-center">
        <div class="col-md-12 d-inline justify-content-left">
          <?php
  $permissao = session()->get('usuarioPermissao');
  if (is_array($permissao) && !empty($permissao) && count($permissao) > 1) {
                                  ?>
          <div class="dentalgo">
            <a href="https://www.dentalgo.com.br/" target="_blank" class="abor-margin">
            </a>
          </div>
          <?php
  }
                                  ?>
        </div>
      </div>
    </div>
  </div>


  @if($modalConteudo == 'permitido')
    <!-- Modal Leia na integra -->
    <div class="modal fade" id="leiaNaIntegra" tabindex="-1" aria-labelledby="leiaNaIntegraLabel" aria-hidden="true">
      <div class="modal-dialog" style="--bs-modal-width: 98%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="leiaNaIntegraLabel">{{ $revista[0]->title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">

            <nav class="navbar navbar-expand-lg p-3 d-lg-none " aria-label="Offcanvas navbar large">
              <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
                  aria-controls="offcanvasNavbar2">
                  Capitulos
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2"
                  aria-labelledby="offcanvasNavbar2Label">
                  <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbar2Label">{{__("messages.RevistaBladeCap")}}</h5>
                    <hr>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                      @foreach ($revista[0]->productItems as $capitulo)
                        <li id="CapM{{ $capitulo->id }}"
                          style="color: #444444; text-decoration: none; font-weight: bold; cursor: pointer;">
                          {{ $capitulo->title }}
                          <br>
                          <hr>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </nav>

            <div class="container-fluid" style="height: 100vh;">
              <div class="row" style="height: 100vh;">
                <div class="col-md-3 d-none d-lg-block" style="height: 100vh; overflow-y: auto;">
                  @foreach ($revista[0]->productItems as $capitulo)
                    <span id="Cap{{ $capitulo->id }}"
                      style="color: #444444; text-decoration: none; font-weight: bold; cursor: pointer;">
                      {{ $capitulo->title }}
                    </span>
                    <br>
                    <hr>
                  @endforeach
                </div>
                <div class="col-md-12 col-lg-9" style="height: 100vh;">
                  <div id="adobe-dc-view"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
              data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- gotalk modal -->
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
      background: rgba(100, 0, 0, 0.5);
      /* Tom avermelhado */
    }

    .iframe-container {
      width: 100%;
      height: 500px;
      /* Defina a altura conforme necessário */
    }

    .iframe-container iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    .openModalBtn {
      margin: 10px 15px 0 0;
      border: 0;

      border-radius: var(--bs-btn-border-radius);
      background-color: #1d96aa !important;
      font-family: prompt;
    }
  </style>
  <!--   -->


  <div class="container">
    <div class="row">
      <?php
  //if($capitulo->id == Request()->segment(5)){



  // ID do produto atual no loop foreach
  $idArtigo = Request()->segment(5);

  // Procurar o item correspondente no segundo array pelo ID
  $itensCapitulo = null;

  foreach ($revista[2] as $objeto) {
    if ($objeto->id == $idArtigo) {
      $itensCapitulo = $objeto;
      break;
    }
  }

                ?>

      @foreach ($revista[0]->productItems as $key => $capitulo)
          <?php
        if ($capitulo->id == Request()->segment(5)) {
          if ($capitulo->cover != null) {
            $semImagem = 0;
          } else {
            $semImagem = 1;
          }            
                                      ?>
          @if($semImagem == 0)
            <div class="col-12 col-lg-6 col-sm-4">
              <div class="col">
                <p class="h5 vol">{{ $revista[0]->title }}</p>
                <a href="{{ $capitulo->doiLink }}" class="h5 date" target="_blank">{{ $capitulo->doiLink }}</a>
              </div>
              <div class="image-container">
                <img src="{{ $capitulo->cover }}" alt="{{ $revista[0]->title}}">
              </div>
              <?php
              $anterior = null;
              $posterior = null;
              $encontrado = false;
              $capitulos = $revista[0]->productItems;
              foreach ($capitulos as $key => $capitulo2) {
                if ($capitulo2->id == Request()->segment(5)) {
                  $linguagem = $capitulo2->language;
                  $arrayLanguage = array();
                  foreach ($capitulos as $key => $capitulo3) {
                    if ($linguagem == $capitulo3->language) {
                      $arrayLanguage[] = $capitulo3;
                    } else {
                      continue;
                    }
                  }
                }
              }
              foreach ($arrayLanguage as $key => $capitulo4) {
                if ($capitulo4->id == Request()->segment(5)) {
                  $encontrado = true;

                  $anterior = null;
                  if (isset($arrayLanguage[$key - 1])) {
                    $anterior = $arrayLanguage[$key - 1]->id;
                  }

                  $posterior = null;
                  if (isset($arrayLanguage[$key + 1])) {
                    $posterior = $arrayLanguage[$key + 1]->id;
                  }

                  break;
                }
              }
                                                    ?>

              <div class="col mt-4">
                <?php      if ($encontrado && $anterior): ?>
                <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$anterior}}/"
                  class="btn btn-secondary btn-prox-artigo button-pagearticle">{{__("messages.ArtigoBladeAnterior")}}</a>
                <?php      endif; ?>
                <?php      if ($encontrado && $posterior): ?>
                <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$posterior}}/"
                  class="btn btn-secondary btn-prox-artigo button-pagearticle1">{{__("messages.ArtigoBladeProximo")}}</a>
                <?php      endif; ?>
              </div>
              <div class="col">
              </div>
            </div>
          @else
            <div class="col-12 col-lg-6 col-sm-4">
              <div class="col">
                <p class="h5 vol">{{ $revista[0]->title }}</p>
                <a href="{{ $capitulo->doiLink }}" class="h5 date" target="_blank">{{ $capitulo->doiLink }}</a>
              </div>
              <div class="image-container">
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}">
              </div>
              <?php
              $anterior = null;
              $posterior = null;
              $encontrado = false;
              $capitulos = $revista[0]->productItems;
              foreach ($capitulos as $key => $capitulo2) {
                if ($capitulo2->id == Request()->segment(5)) {
                  $linguagem = $capitulo2->language;
                  $arrayLanguage = array();
                  foreach ($capitulos as $key => $capitulo3) {
                    if ($linguagem == $capitulo3->language) {
                      $arrayLanguage[] = $capitulo3;
                    } else {
                      continue;
                    }
                  }
                }
              }
              foreach ($arrayLanguage as $key => $capitulo4) {
                if ($capitulo4->id == Request()->segment(5)) {
                  $encontrado = true;

                  $anterior = null;
                  if (isset($arrayLanguage[$key - 1])) {
                    $anterior = $arrayLanguage[$key - 1]->id;
                  }

                  $posterior = null;
                  if (isset($arrayLanguage[$key + 1])) {
                    $posterior = $arrayLanguage[$key + 1]->id;
                  }

                  break;
                }
              }
                                                    ?>

              <div class="col mt-4">
                <?php      if ($encontrado && $anterior): ?>
                <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$anterior}}/"
                  class="btn btn-secondary btn-prox-artigo button-pagearticle">{{__("messages.ArtigoBladeAnterior")}}</a>
                <?php      endif; ?>
                <?php      if ($encontrado && $posterior): ?>
                <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$posterior}}/"
                  class="btn btn-secondary btn-prox-artigo button-pagearticle1">{{__("messages.ArtigoBladeProximo")}}</a>
                <?php      endif; ?>
              </div>
              <div class="col">
              </div>
            </div>
          @endif

























          <div class="col-12 col-lg-6 col-sm-8">
            </br></br>
            <p class="h4 text-paragraph textstyle-h4">{{ $capitulo->title }}</p>
            <p class="h4 text-paragraph textstyle-h4-1"> {{ $capitulo->category }}</p>
            <p class="lead text-paragraph textstyle-h4-2">
              {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 600, false) }}
            </p>
            <p class="revistaImagemArtigop1 text-paragraph textstyle-h4-2">{{__("messages.RevistaBladeAutores")}}:
              @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
            @if($modalConteudo == 'permitido')
              <div class="col mt-4">
                <div class="d-flex flex-wrap align-items-center gap-2">
                  <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-secondary btn-lerArtigo"
                    data-bs-toggle="modal"
                    data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.SearchBladeRead")}}</button>
                  @if(isset($capitulo->data->gotalk))
                    @if(isset($capitulo->data->liberado))
                      @if($capitulo->data->liberado == 'true')
                        <button type="button" class="btn btn-secondary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}"
                          data-bs-toggle="modal" data-bs-target="#gotalk"
                          style="background-color: #CA1D53 !important; border: 1px solid #CA1D53 !important; color: #fff !important; margin: 0 !important;">GoTalks</button>
                      @else
                        <button type="button" class="btn btn-secondary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}"
                          data-bs-toggle="modal" data-bs-target="#gotalk"
                          style="background-color: #CA1D53 !important; border: 1px solid #CA1D53 !important; color: #fff !important; margin: 0 !important;">GoTalks</button>
                      @endif
                    @else
                      <button type="button" class="btn btn-secondary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}"
                        data-bs-toggle="modal" data-bs-target="#gotalk"
                        style="background-color: #CA1D53 !important; border: 1px solid #CA1D53 !important; color: #fff !important; margin: 0 !important;">GoTalks</button>
                    @endif
                  @endif
                  <?php      if ($encontrado && $anterior): ?>
                  <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$anterior}}/"
                    class="btn btn-secondary btn-prox-artigo">{{__("messages.ArtigoBladeAnterior")}}</a>
                  <?php      endif; ?>
                  <?php      if ($encontrado && $posterior): ?>
                  <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$posterior}}/"
                    class="btn btn-secondary btn-prox-artigo">{{__("messages.ArtigoBladeProximo")}}</a>
                  <?php      endif; ?>
                  @if(session()->get('usuarioPlanoID') != 274)
                    <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-secondary"
                      style="background-color: #CA1D53 !important; border: 1px solid #CA1D53 !important; color: #fff !important; margin: 0 !important;">
                      <i class="fa-solid fa-download"></i> Download
                    </a>
                  @endif
                </div>
              </div>
            @else
              <div class="col mt-4">
                <div class="d-flex flex-wrap align-items-center gap-2">
                  <button type="button" class="btn btn-secondary btn-lerArtigo" data-bs-toggle="modal"
                    data-bs-target="#{{ $modalConteudo }}">{{__("messages.SearchBladeRead")}}</button>
                  @if(isset($capitulo->data->gotalk))
                    <button type="button" class="btn btn-secondary openModalBtn"
                      data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}"
                      style="background-color: #6c757d !important; border: 1px solid #6c757d !important; color: #fff !important; margin: 0 !important;">GoTalks <i class="fa-solid fa-lock"></i></button>
                  @endif
                  <?php      if ($encontrado && $anterior): ?>
                  <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$anterior}}/"
                    class="btn btn-secondary btn-prox-artigo">{{__("messages.ArtigoBladeAnterior")}}</a>
                  <?php      endif; ?>
                  <?php      if ($encontrado && $posterior): ?>
                  <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{$posterior}}/"
                    class="btn btn-secondary btn-prox-artigo">{{__("messages.ArtigoBladeProximo")}}</a>
                  <?php      endif; ?>
                </div>
              </div>
            @endif
          </div>
          <?php
        }
                                      ?>
      @endforeach
    </div>
  </div>
















  <div class="container" style="margin-top: 20px;">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
            <ul class="nav nav-tabs centerTab" id="myTab" role="tablist">
              <li class="nav-item centerTab" role="presentation">
                @if(in_array('pt', $revista[0]->availableLanguages))
                  <button class="nav-link buscaLink @if($linguagem == 'pt') active @endif" id="portugues-tab"
                    data-bs-toggle="tab" data-bs-target="#portugues" type="button" role="tab" aria-controls="portugues"
                    aria-selected="true">{{__("messages.IdiomaBladePt")}}</button>
                @else
                  <button class="nav-link buscaLink disabled button-off" id="portugues-tab" type="button" role="tab"
                    aria-disabled="true">{{__("messages.IdiomaBladePt")}}</button>
                @endif
              </li>
              <li class="nav-item centerTab" role="presentation">
                @if(in_array('es', $revista[0]->availableLanguages))
                  <button class="nav-link buscaLink @if($linguagem == 'es') active @endif" id="espanhol-tab"
                    data-bs-toggle="tab" data-bs-target="#espanhol" type="button" role="tab" aria-controls="espanhol"
                    aria-selected="false">{{__("messages.IdiomaBladeEs")}}</button>
                @else
                  <button class="nav-link buscaLink disabled button-off" id="espanhol-tab" type="button" role="tab"
                    aria-disabled="true">{{__("messages.IdiomaBladeEs")}}</button>
                @endif
              </li>
              <li class="nav-item centerTab" role="presentation">
                @if(in_array('en', $revista[0]->availableLanguages))
                  <button class="nav-link buscaLink @if($linguagem == 'en') active @endif" id="ingles-tab"
                    data-bs-toggle="tab" data-bs-target="#ingles" type="button" role="tab" aria-controls="ingles"
                    aria-selected="false">{{__("messages.IdiomaBladeEn")}}</button>
                @else
                  <button class="nav-link buscaLink disabled button-off" id="ingles-tab" type="button" role="tab"
                    aria-disabled="true">{{__("messages.IdiomaBladeEn")}}</button>
                @endif
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <!-- TAB PORTUGUES -->
              <div class="tab-pane fade @if($linguagem == 'pt') show active @endif" id="portugues" role="tabpanel"
                aria-labelledby="portugues-tab">
                <!-- Conteúdo da aba em português -->
                @foreach ($revista[0]->productItems as $key => $capitulo)
                  @if(isset($capitulo->data))
                    @if(isset($capitulo->data->corpo))
                      @if($capitulo->data->corpo == 'editorial')
                        @continue
                      @endif
                    @endif
                  @endif
                  @if($capitulo->language == 'pt')
                              <?php
                    if ($capitulo->cover != null) {
                      $semImagem = 0;
                    } else {
                      $semImagem = 1;
                    }
                    $idArtigo = $capitulo->id; // ID do produto atual no loop foreach         
                    // Procurar o item correspondente no segundo array pelo ID
                    $itensCapitulo = null;
                    foreach ($revista[2] as $objeto) {
                      if ($objeto->id == $idArtigo) {
                        $itensCapitulo = $objeto;
                        break;
                      }
                    }
                                                                                                          ?>
                              @if($semImagem == 0)
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $capitulo->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary"
                                        style="margin-left: auto;background: #CA1D53; margin:unset;"
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @else
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $revista[0]->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary" style="margin-left: auto;background: #CA1D53; "
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @endif
                  @endif
                @endforeach
              </div>

              <!-- TAB Espanhol -->
              <div class="tab-pane fade @if($linguagem == 'es') show active @endif" id="espanhol" role="tabpanel"
                aria-labelledby="espanhol-tab">
                <!-- Conteúdo da aba em espanhol -->
                @foreach ($revista[0]->productItems as $key => $capitulo)
                  @if(isset($capitulo->data))
                    @if(isset($capitulo->data->corpo))
                      @if($capitulo->data->corpo == 'editorial')
                        @continue
                      @endif
                    @endif
                  @endif
                  @if($capitulo->language == 'es')
                              <?php
                    if ($capitulo->cover != null) {
                      $semImagem = 0;
                    } else {
                      $semImagem = 1;
                    }
                    $idArtigo = $capitulo->id; // ID do produto atual no loop foreach    
                    // Procurar o item correspondente no segundo array pelo ID
                    $itensCapitulo = null;
                    foreach ($revista[2] as $objeto) {
                      if ($objeto->id == $idArtigo) {
                        $itensCapitulo = $objeto;
                        break;
                      }
                    }
                                                                                                          ?>
                              @if($semImagem == 0)
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $capitulo->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary" style="margin-left: auto;background: #CA1D53; "
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @else
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $revista[0]->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary" style="margin-left: auto;background: #CA1D53; "
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @endif
                  @endif
                @endforeach
              </div>
              <!-- TAB INGLÊS -->
              <div class="tab-pane fade @if($linguagem == 'en') show active @endif" id="ingles" role="tabpanel"
                aria-labelledby="ingles-tab">
                <!-- Conteúdo da aba em inglês -->
                @foreach ($revista[0]->productItems as $key => $capitulo)
                  @if(isset($capitulo->data))
                    @if(isset($capitulo->data->corpo))
                      @if($capitulo->data->corpo == 'editorial')
                        @continue
                      @endif
                    @endif
                  @endif
                  @if($capitulo->language == 'en')
                              <?php
                    if ($capitulo->cover != null) {
                      $semImagem = 0;
                    } else {
                      $semImagem = 1;
                    }
                    $idArtigo = $capitulo->id; // ID do produto atual no loop foreach                     
                    // Procurar o item correspondente no segundo array pelo ID
                    $itensCapitulo = null;
                    foreach ($revista[2] as $objeto) {
                      if ($objeto->id == $idArtigo) {
                        $itensCapitulo = $objeto;
                        break;
                      }
                    }
                                                                                                          ?>
                              @if($semImagem == 0)
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $capitulo->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary" style="margin-left: auto;background: #CA1D53; "
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @else
                                <div class="row boxbordas1"
                                  style="background: #FFF;padding-block: 24px;padding-inline: 12px;margin-block: 8px;border-radius: 0.75rem;border: 1px solid #dee2e2;margin-inline: unset;">
                                  <div class="col-12 col-lg-2 col-sm-4 image-container image-mobile">
                                    <img src="{{ $revista[0]->cover }}" alt="{{$capitulo->title}}" class="img-fluid">
                                  </div>
                                  <div class="col-12 col-lg-10 col-sm-8"
                                    style="display: flex;flex-direction: column;justify-content: space-between;">
                                    <a class="nav-link p-1 article-content-options text-title text-title-1 mb-0"
                                      href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{$capitulo->title}}</a>
                                    <p class="lead text-paragraph">
                                      {{ limita_caracteres(strip_tags(strip_tags($capitulo->brief)), 500, false) }}
                                    </p>
                                    <div style="display:flex;">
                                      <a class="lerartigobotao btn btn-secondary" style="margin-left: auto;background: #CA1D53; "
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}">{{__("messages.ColecoesLeia")}}</a>
                                    </div>
                                  </div>
                                </div>
                              @endif
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if($modalConteudo == 'permitido')
      <!-- Modal do artigo -->
      <div class="modal fade" id="leiaCapitulo{{$capitulo->id}}" tabindex="-1"
        aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
        <div class="modal-dialog modal-almost-fullscreen">
          <div class="modal-content">
            <div class="modal-header"
              style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); color: #fff; padding: 1rem 1.5rem;">
              <h5 class="modal-title" id="leiaCapitulo{{$capitulo->id}}"
                style="font-weight: 600; max-width: calc(100% - 50px); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                {{ $capitulo->title }}
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"
                style="opacity: 1;"></button>
            </div>
            <div class="modal-body" style="padding: 0; height: calc(100% - 120px); overflow: hidden;">
              <div id="adobe-dc-view{{$capitulo->id}}" style="height: 100%;">
              </div>
              <script type="text/javascript">
                document.addEventListener("adobe_dc_view_sdk.ready", function () {
                  document.getElementById("artigoCap{{ $capitulo->id }}").addEventListener("click", function () {
                    showPDF{{ $capitulo->id }}("{{ $capitulo->content }}");
                  })
                });
                function showPDF{{ $capitulo->id }}(url) {
                  adobeDCView = null;
                  fetch(url)
                    .then((res) => res.blob())
                    .then((blob) => {
                      adobeDCView = new AdobeDC.View({
                        clientId: "509e95046c654d969e54d6c182aceba0",
                        //clientId: "2aed258cc30e450db5bc65309da1ad25",
                        locale: "pt-BR",
                        divId: "adobe-dc-view{{$capitulo->id}}"
                      });
                      adobeDCView.previewFile(
                        {
                          content: { location: { url: "{{ $capitulo->content }}" } },
                          metaData: { fileName: "{{ $capitulo->title }}.pdf" }
                        },
                        {
                          embedMode: "FULL_WINDOW",
                          defaultViewMode: "FIT_WIDTH",
                          enablePDFAnalytics: true,
                          showDownloadPDF: true,
                          showPrintPDF: true,
                          showLeftHandPanel: true,
                          showAnnotationTools: true,
                          focusOnRendering: true
                        }
                      );
                    });
                }
              </script>
            </div>
            <div class="modal-footer" style="background: #fff; border-top: 1px solid #e9ecef; padding: 0.75rem 1.5rem;">
              <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-outline-primary"
                style="margin-right: auto;">
                <i class="fa-solid fa-download"></i> Download PDF
              </a>
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
            </div>
          </div>
        </div>
      </div>

    @endif
    @foreach ($revista[0]->productItems as $key => $capitulo)
      @if($modalConteudo == 'permitido')
        <!-- Modal do artigo -->
        <div class="modal fade" id="leiaCapitulo{{$capitulo->id}}" tabindex="-1"
          aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
          <div class="modal-dialog modal-almost-fullscreen">
            <div class="modal-content">
              <div class="modal-header"
                style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); color: #fff; padding: 1rem 1.5rem;">
                <h5 class="modal-title" id="leiaCapitulo{{$capitulo->id}}"
                  style="font-weight: 600; max-width: calc(100% - 50px); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                  {{ $capitulo->title }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"
                  style="opacity: 1;"></button>
              </div>
              <div class="modal-body" style="padding: 0; height: calc(100% - 120px); overflow: hidden;">
                <div id="adobe-dc-view{{$capitulo->id}}" style="height: 100%;">
                </div>
                <script type="text/javascript">
                  document.addEventListener("adobe_dc_view_sdk.ready", function () {
                    document.getElementById("artigoCap{{ $capitulo->id }}").addEventListener("click", function () {
                      showPDF{{ $capitulo->id }}("{{ $capitulo->content }}");
                    })
                  });
                  function showPDF{{ $capitulo->id }}(url) {
                    adobeDCView = null;
                    fetch(url)
                      .then((res) => res.blob())
                      .then((blob) => {
                        adobeDCView = new AdobeDC.View({
                          clientId: "509e95046c654d969e54d6c182aceba0",
                          //clientId: "2aed258cc30e450db5bc65309da1ad25",
                          locale: "pt-BR",
                          divId: "adobe-dc-view{{$capitulo->id}}"
                        });
                        adobeDCView.previewFile(
                          {
                            content: { location: { url: "{{ $capitulo->content }}" } },
                            metaData: { fileName: "{{ $capitulo->title }}.pdf" }
                          },
                          {
                            embedMode: "FULL_WINDOW",
                            defaultViewMode: "FIT_WIDTH",
                            enablePDFAnalytics: true,
                            showDownloadPDF: true,
                            showPrintPDF: true,
                            showLeftHandPanel: true,
                            showAnnotationTools: true,
                            focusOnRendering: true
                          }
                        );
                      });
                  }
                </script>
              </div>
              <div class="modal-footer" style="background: #fff; border-top: 1px solid #e9ecef; padding: 0.75rem 1.5rem;">
                <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-outline-primary"
                  style="margin-right: auto;">
                  <i class="fa-solid fa-download"></i> Download PDF
                </a>
                <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endforeach
  </div>
  <!--javascript-->
  <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
  <script type="text/javascript">
    var adobeDCView = null;
    document.addEventListener("adobe_dc_view_sdk.ready", function () {
      showPDF("{{ $revista[0]->productItems[0]->content }}");
      @foreach ($revista[0]->productItems as $capitulo)
        document.getElementById("Cap{{ $capitulo->id }}").addEventListener("click", function () {
          showPDF("{{ $capitulo->content }}");
        })
      @endforeach
      @foreach ($revista[0]->productItems as $capitulo)
        document.getElementById("CapM{{ $capitulo->id }}").addEventListener("click", function () {
          showPDF("{{ $capitulo->content }}");
        })
      @endforeach
            });

    function showPDF(url) {
      adobeDCView = null;
      fetch(url)
        .then((res) => res.blob())
        .then((blob) => {
          adobeDCView = new AdobeDC.View({
            clientId: "509e95046c654d969e54d6c182aceba0",
            //clientId: "2aed258cc30e450db5bc65309da1ad25",
            locale: "pt-BR",
            divId: "adobe-dc-view"
          });
          adobeDCView.previewFile(
            {
              content: { promise: Promise.resolve(blob.arrayBuffer()) },
              metaData: { fileName: url.split("/").slice(-1)[0] }
            },
            {
              embedMode: "FULL_WINDOW",
              defaultViewMode: "FIT_WIDTH",
              enablePDFAnalytics: true,
              showDownloadPDF: true,
              showPrintPDF: true,
              showLeftHandPanel: true,
              showAnnotationTools: true,
              focusOnRendering: true
            }
          );
        });
    }

    // Add arrayBuffer if necessary i.e. Safari
    (function () {
      if (Blob.arrayBuffer != "function") {
        Blob.prototype.arrayBuffer = myArrayBuffer;
      }

      function myArrayBuffer() {
        return new Promise((resolve) => {
          let fileReader = new FileReader();
          fileReader.onload = () => {
            resolve(fileReader.result);
          };
          fileReader.readAsArrayBuffer(this);
        });
      }
    })();
  </script>


  <script>

    document.addEventListener("DOMContentLoaded", function () {

      // --- CONFIGURAÇÃO ---
      const audioData = {
        url: "https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n5/gotalks/Expans%C3%A3o_r%C3%A1pida_da_maxila_e_seu_impacto_na_apneia_do_sono_em_crian%C3%A7as_de_5_a_8_anos_um_estudo_retrospectivo.mp3",
        id: "15934",
        liberado: true
      };

      // --- VERIFICAÇÃO ---
      if (!window.location.pathname.includes("/" + audioData.id + "/") || !audioData.liberado) {
        return;
      }

      console.log("[DentalGo Intro] Iniciando Player Responsivo...");

      // --- 1. INJEÇÃO DE CSS (ESTILOS RESPONSIVOS) ---
      // Criamos uma tag style para poder usar Media Queries (@media)
      const style = document.createElement('style');
      style.innerHTML = `
                  /* ESTILOS BASE (DESKTOP) */
                  #intro-audio-card {
                      position: relative;
                      width: 480px;
                      max-width: 95%;
                      background: rgba(15, 15, 15, 0.90);
                      backdrop-filter: blur(25px);
                      -webkit-backdrop-filter: blur(25px);
                      border: 1px solid rgba(255, 255, 255, 0.1);
                      box-shadow: 0 30px 80px rgba(0,0,0,0.8);
                      border-radius: 40px;
                      padding: 40px 20px;
                      display: flex;
                      flex-direction: column;
                      align-items: center;
                      color: #fff;
                      transition: all 0.3s ease;
                  }

                  .vz-container {
                      position: relative;
                      width: 420px;
                      height: 420px;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      margin-bottom: 20px;
                  }

                  .title-main { font-size: 26px; }
                  .title-sub { font-size: 14px; }
                  .timer-main { font-size: 20px; }
                  .play-btn-size { width: 70px; height: 70px; font-size: 28px; }

                  /* ESTILOS MOBILE (Telas menores que 600px) */
                  @media (max-width: 600px) {
                      #intro-audio-card {
                          width: 90%; /* Ocupa quase toda a largura */
                          padding: 30px 15px;
                          border-radius: 30px;
                      }

                      .vz-container {
                          width: 280px; /* Reduz a bolinha para caber no celular */
                          height: 280px;
                          margin-bottom: 15px;
                      }

                      .title-main { font-size: 22px; }
                      .title-sub { font-size: 12px; }
                      .timer-main { font-size: 18px; }

                      .play-btn-size { 
                          width: 60px; 
                          height: 60px; 
                          font-size: 24px; 
                      }
                  }
              `;
      document.head.appendChild(style);

      // --- CRIAÇÃO DO OVERLAY ---
      const overlay = document.createElement('div');
      overlay.id = "intro-audio-overlay";

      Object.assign(overlay.style, {
        position: 'fixed',
        top: '0',
        left: '0',
        width: '100%',
        height: '100%',
        zIndex: '99999',
        backgroundColor: 'rgba(0, 0, 0, 0.6)',
        backdropFilter: 'blur(4px)',
        webkitBackdropFilter: 'blur(4px)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        opacity: '0',
        transition: 'opacity 0.5s ease'
      });

      // --- HTML DO PLAYER ---
      overlay.innerHTML = `
                  <div id="intro-audio-card">
                      <button id="close-intro-btn" style="
                          position: absolute; top: 20px; right: 25px;
                          background: transparent; border: none; color: rgba(255,255,255,0.6);
                          font-size: 30px; cursor: pointer; line-height: 1; z-index: 20;
                      ">&times;</button>

                      <audio id="myAudio" src="${audioData.url}" crossorigin="anonymous"></audio>

                      <div class="vz-container">
                          <canvas id="myCanvas" width="840" height="840" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 1;"></canvas>

                          <div style="z-index: 2; text-align: center; pointer-events: none;">
                              <h3 class="title-main" style="font-family: sans-serif; color: #e0f7fa; margin: 0; font-weight: 700; text-shadow: 0 0 20px rgba(0,188,212,0.7);">GoTalks</h3>
                              <p class="title-sub" style="font-family: sans-serif; color: #b2ebf2; margin: 0; opacity: 0.8;">by DentalGo</p>
                              <div id="center-timer" class="timer-main" style="font-family: monospace; font-weight: bold; color: #fff; margin-top: 10px;">00:00</div>
                          </div>
                      </div>

                      <div style="width: 100%; padding: 0 10px; z-index: 10;">

                          <div style="display: flex; justify-content: space-between; font-family: monospace; font-size: 12px; color: #aaa; margin-bottom: 8px;">
                              <span id="curr-time-display">0:00</span>
                              <span id="dur-time-display">--:--</span>
                          </div>

                          <input type="range" id="seek-bar" value="0" max="100" style="width: 100%; cursor: pointer; margin-bottom: 25px; accent-color: #00bcd4; height: 6px;">

                          <div style="display: flex; justify-content: space-between; align-items: center;">
                              <select id="speed-select" style="background: rgba(255,255,255,0.1); color: #ccc; border: none; border-radius: 8px; padding: 8px; font-size: 13px; outline: none; cursor: pointer;">
                                  <option value="1" style="color:#000">1.0x</option>
                                  <option value="1.25" style="color:#000">1.25x</option>
                                  <option value="1.5" style="color:#000">1.5x</option>
                                  <option value="2" style="color:#000">2.0x</option>
                              </select>

                              <button id="play-btn" class="play-btn-size" style="
                                  border-radius: 50%; border: none;
                                  background: linear-gradient(135deg, #00bcd4, #008ba3); color: white;
                                  cursor: pointer; display: flex; align-items: center; justify-content: center;
                                  box-shadow: 0 4px 25px rgba(0, 188, 212, 0.5);
                                  transition: transform 0.1s;
                              ">||</button>

                              <div style="width: 50px;"></div> 
                          </div>

                          <p id="msg-helper" style="font-size: 12px; color: rgba(255,255,255,0.5); text-align: center; margin-top: 20px;">
                              Carregando...
                          </p>
                      </div>
                  </div>
              `;

      document.body.appendChild(overlay);
      document.body.style.overflow = 'hidden';
      requestAnimationFrame(() => { overlay.style.opacity = '1'; });

      // --- JS LÓGICO (Mantido idêntico) ---
      const audio = document.getElementById('myAudio');
      const playBtn = document.getElementById('play-btn');
      const seekBar = document.getElementById('seek-bar');
      const currTimeDisplay = document.getElementById('curr-time-display');
      const durTimeDisplay = document.getElementById('dur-time-display');
      const centerTimer = document.getElementById('center-timer');
      const msgHelper = document.getElementById('msg-helper');
      const speedSelect = document.getElementById('speed-select');
      const closeBtn = document.getElementById('close-intro-btn');
      const canvas = document.getElementById('myCanvas');
      const ctx = canvas.getContext('2d');

      let audioContext, analyser, source, bufferLength, dataArray, animationFrameId;

      const setupAudioVisualizer = () => {
        if (!audioContext) {
          audioContext = new (window.AudioContext || window.webkitAudioContext)();
          source = audioContext.createMediaElementSource(audio);
          analyser = audioContext.createAnalyser();
          source.connect(analyser);
          analyser.connect(audioContext.destination);

          analyser.fftSize = 128;
          bufferLength = analyser.frequencyBinCount;
          dataArray = new Uint8Array(bufferLength);
        }
        drawVisualizer();
      };

      const drawVisualizer = () => {
        animationFrameId = requestAnimationFrame(drawVisualizer);
        analyser.getByteFrequencyData(dataArray);
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = 165;
        const maxBarHeight = 90;

        for (let i = 0; i < bufferLength; i++) {
          const barHeight = (dataArray[i] / 255) * maxBarHeight;
          const angle = (i / bufferLength) * Math.PI * 2;

          const x1 = centerX + Math.cos(angle) * radius;
          const y1 = centerY + Math.sin(angle) * radius;
          const x2 = centerX + Math.cos(angle) * (radius + barHeight);
          const y2 = centerY + Math.sin(angle) * (radius + barHeight);

          ctx.beginPath();
          ctx.lineWidth = 8;
          ctx.lineCap = 'round';
          ctx.strokeStyle = `rgba(0, 188, 212, ${0.2 + (dataArray[i] / 255)})`;
          ctx.moveTo(x1, y1);
          ctx.lineTo(x2, y2);
          ctx.stroke();
        }
      };

      const stopVisualizer = () => {
        if (animationFrameId) {
          cancelAnimationFrame(animationFrameId);
          animationFrameId = null;
          ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
      };

      const formatTime = (t) => {
        if (isNaN(t)) return "0:00";
        const m = Math.floor(t / 60);
        const s = Math.floor(t % 60);
        return `${m}:${s < 10 ? '0' + s : s}`;
      };

      const closeOverlay = () => {
        if (audio) { audio.pause(); audio.currentTime = 0; }
        stopVisualizer();
        overlay.style.opacity = '0';
        document.body.style.overflow = '';
        setTimeout(() => { if (overlay.parentNode) overlay.parentNode.removeChild(overlay); }, 500);
      };

      const updateUI = (state) => {
        if (state === "playing") {
          playBtn.innerHTML = "||";
          msgHelper.innerText = "Clique no fundo escuro para fechar";
          msgHelper.style.color = "#aaa";
          if (audioContext && audioContext.state === 'suspended') {
            audioContext.resume().then(() => setupAudioVisualizer());
          } else {
            setupAudioVisualizer();
          }
        } else if (state === "paused") {
          playBtn.innerHTML = "▶";
          stopVisualizer();
        } else if (state === "blocked") {
          playBtn.innerHTML = "▶";
          msgHelper.innerText = "TOQUE NA TELA PARA OUVIR 🔊";
          msgHelper.style.color = "#00bcd4";
          msgHelper.style.fontWeight = "bold";
          stopVisualizer();
        } else {
          playBtn.innerHTML = "▶";
          stopVisualizer();
        }
      };

      playBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (audio.paused) audio.play().then(() => updateUI("playing"));
        else { audio.pause(); updateUI("paused"); }
      });

      speedSelect.addEventListener('change', function (e) { e.stopPropagation(); audio.playbackRate = this.value; });
      seekBar.addEventListener('click', (e) => e.stopPropagation());
      seekBar.addEventListener('input', (e) => { e.stopPropagation(); audio.currentTime = (seekBar.value / 100) * audio.duration; });

      audio.addEventListener('timeupdate', () => {
        if (audio.duration) {
          const fTime = formatTime(audio.currentTime);
          seekBar.value = (audio.currentTime / audio.duration) * 100;
          currTimeDisplay.innerText = fTime;
          centerTimer.innerText = fTime;
        }
      });

      audio.addEventListener('loadedmetadata', () => {
        durTimeDisplay.innerText = formatTime(audio.duration);
        if (!audioContext) {
          audioContext = new (window.AudioContext || window.webkitAudioContext)();
          source = audioContext.createMediaElementSource(audio);
          analyser = audioContext.createAnalyser();
          source.connect(analyser);
          analyser.connect(audioContext.destination);
          analyser.fftSize = 128;
          bufferLength = analyser.frequencyBinCount;
          dataArray = new Uint8Array(bufferLength);
        }
      });

      audio.play().then(() => updateUI("playing")).catch(() => updateUI("blocked"));

      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
          if (audio.paused && audio.readyState > 0) {
            audio.play().then(() => updateUI("playing"));
          } else {
            closeOverlay();
          }
        }
      });

      closeBtn.addEventListener('click', closeOverlay);
    });




  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Move modals to body to fix stacking context issues
      const modalsToMove = [
        'compraLerAssine',
        'leiaNaIntegra',
        'gotalk'
      ];

      modalsToMove.forEach(id => {
        const el = document.getElementById(id);
        if (el) document.body.appendChild(el);
      });

      // Move all dynamic chapter modals
      const chapterModals = document.querySelectorAll('.modal[id^="leiaCapitulo"]');
      chapterModals.forEach(modal => {
        document.body.appendChild(modal);
      });

      // --- Auto-open Article Logic ---
      @if(null !== Request()->segment(5) && $modalConteudo == 'permitido')
        setTimeout(function () {
          const articleId = "{{ Request()->segment(5) }}";
          const articleBtn = document.getElementById('artigoCap' + articleId);

          if (articleBtn) {
            console.log("[DentalGo] Auto-opening article:", articleId);
            articleBtn.click();
          } else {
            // fallback if ID is slightly different or not found
            console.warn("[DentalGo] Article button not found for ID:", articleId);
          }
        }, 500); // 500ms to ensure Adobe SDK and scripts are ready
      @endif
              });
  </script>

@endsection