<?php
$paginaTitulo = $revista[0]->title . ' - DentalGO';
$padinaDescricao = '';
$tipoTopo = 'topoAzul';


$idiomasDisponiveis = is_array($revista[0]->availableLanguages ?? null)
  ? $revista[0]->availableLanguages
  : [];

// Default active language for initial render if needed, though we will render all tabs
if (isset($linguagem) && in_array($linguagem, $idiomasDisponiveis)) {
  $idiomaAtivo = $linguagem;
} else {
  $idiomaAtivo = $idiomasDisponiveis[0] ?? 'pt';
}


$permicao = $revista[1]->collections;
$modalConteudo = 'espacoParaAssinantes';
if ($revista[0]->customerCourtesy == 1) {
  $modalConteudo = 'permitido';
} elseif (session()->get('usuarioPermissao') == 'naotem') {
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

$produtosIds = array('857', '886', '850', '826', '895', '963', '998', '1044', '1056', '1050', '1044', '1067', '1080', '1089', '1095', '1107', '1134', '1138');

?>
@extends('facelift2.master')

@section('content')
  <style>
    /* Facelift 2.0 Revista Specific Styles */
    body {
      background-color: #f8f9fa;
      /* Off-white background for reading comfort */
      color: #1a1a1a;
    }

    .facelift-2-revista {
      font-family: 'Inter', sans-serif;
    }

    .revista-header {
      background-color: #ffffff;
      padding-top: 4rem;
      padding-bottom: 3rem;
      border-bottom: 1px solid #e9ecef;
      margin-bottom: 3rem;
    }

    .revista-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      font-size: 2.5rem;
      line-height: 1.2;
      color: #111;
      letter-spacing: -0.02em;
      text-transform: uppercase;
    }

    .revista-meta {
      font-family: 'poppins', serif;
      color: #666;
      font-size: 1.1rem;
      margin-bottom: 1.5rem;
    }

    .revista-cover-clean {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
      transition: transform 0.3s ease;
    }

    .revista-cover-clean:hover {
      transform: translateY(-5px);
    }

    .action-bar {
      margin-top: 2rem;
    }

    .btn-action-primary {
      background-color: #CA1D53;
      color: white;
      border: none;
      padding: 0.8rem 1.5rem;
      font-weight: 600;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .btn-action-primary:hover {
      background-color: #a31641;
      color: white;
      transform: translateY(-2px);
    }

    .btn-action-ghost {
      background-color: transparent;
      color: #666;
      border: 1px solid #ddd;
      padding: 0.8rem 1.5rem;
      font-weight: 600;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .btn-action-ghost:hover {
      background-color: #f8f9fa;
      border-color: #bbb;
      color: #333;
    }

    /* Layout */
    .content-grid {
      display: grid;
      grid-template-columns: 1fr 340px;
      /* Main content + Fixed Sidebar width */
      gap: 3rem;
    }

    @media (max-width: 991px) {
      .content-grid {
        grid-template-columns: 1fr;
        /* Stack on mobile */
      }
    }

    /* Article Cards */
    .article-card-clean {
      background: white;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      transition: box-shadow 0.2s;
    }

    .article-card-clean:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      border-color: #dee2e6;
    }

    .article-kicker {
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #CA1D53;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .article-title-link {
      text-decoration: none;
      color: #111;
    }

    .article-title-link:hover {
      color: #CA1D53;
    }

    .article-title-h {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1rem;
      line-height: 1.3;
    }

    .article-abstract {
      font-family: 'poppins', serif;
      font-size: 1rem;
      color: #555;
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    .article-authors {
      font-size: 0.9rem;
      color: #888;
      font-style: italic;
    }

    .sidebar-sticky {
      position: sticky;
      top: 2rem;
    }

    .sidebar-card {
      background: white;
      padding: 1.5rem;
      border-radius: 8px;
      border: 1px solid #e9ecef;
      margin-bottom: 1.5rem;
    }

    .sidebar-title {
      font-weight: 700;
      margin-bottom: 1rem;
      font-size: 1.1rem;
      border-bottom: 2px solid #CA1D53;
      display: inline-block;
      padding-bottom: 0.3rem;
    }

    /* Tabs Styling for Facelift key */
    .nav-pills .nav-link {
      color: #555;
      font-weight: 600;
      padding: 0.5rem 1.2rem;
      margin-left: 0.5rem;
      border-radius: 20px;
      transition: all 0.2s;
    }

    .nav-pills .nav-link.active {
      background-color: #1a1a1a;
      color: #fff;
    }

    .nav-pills .nav-link:hover:not(.active) {
      background-color: #e9ecef;
    }

    /* para o language-switcher não encolher */
    @media (max-width: 576px) {
      #language-switcher .nav-link {
        padding: 0.4rem 0.9rem !important;
        font-size: 0.85rem !important;
      }
    }


    /* Modal Fixes (Escalated Z-Index) */
    .modal-backdrop {
      z-index: 99998 !important;
    }

    .modal {
      z-index: 99999 !important;
    }

    .modal:not(.show) {
      display: none !important;
    }

    .modal-dialog {
      transform: none !important;
      /* Prevent new stacking context */
    }

    .modal-almost-fullscreen {
      max-width: 96vw !important;
      margin: 2vh auto !important;
      height: 96vh !important;
    }

    .modal-almost-fullscreen .modal-content {
      height: 100%;
      background-color: #fff !important;
    }

    .modal-almost-fullscreen .modal-body {
      height: calc(100% - 56px);
      overflow-y: hidden;
      padding: 0;
    }

    #gotalk .modal-content {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
    }

    .iframe-container {
      width: 100%;
      height: 500px;
    }

    .iframe-container iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>

  <div class="facelift-2-revista" style="margin-top: 30px;">
    <!-- Clean Header -->
    <header class="revista-header" style="background-image: url('{{ asset('imagens/Facelift/banner-02-cada-revista.png') }}');">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- Logos -->
            @if($idColecao == '5')
              <div class="mb-4 d-flex align-items-center gap-3">
                <a href="https://abor.org.br/" target="_blank"><img src="{{ asset('imagens/Facelift/logo_abor.png') }}"
                    style="height: 50px; opacity: 0.8;" alt="ABOR"></a>
                <span style="height: 20px; width: 1px; background: #ddd;"></span>
                <a href="https://www.alado.org/" target="_blank"><img
                    src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}" style="height: 100px; opacity: 0.8;"
                    alt="ALADO"></a>
              </div>
            @endif

            <div class="revista-meta">
              Volume {{ $revista[0]->volume ?? '24' }} • Número {{ $revista[0]->number ?? '05' }} •
              {{ $revista[0]->year ?? '2025' }}
            </div>

            <h1 class="revista-title mb-4">{{ $revista[0]->title }}</h1>

            <div class="action-bar d-flex flex-wrap gap-3">
              <a href="{{ route('facecolecao') }}/{{ Request()->segment(5) }}">
                <button class="btn-action-primary">
                  <i class="fa-solid fa-layer-group me-2"></i> {{__("messages.BOTAOVerAcervo")}}
                </button>
              </a>

              @if($idColecao == '5')
                <a href="https://clinicalorthodontics.net/instrucoesaosautores" target="_blank">
                  <button class="btn-action-ghost">
                    {{__("messages.BOTAOParaautores")}}
                  </button>
                </a>
              @endif

              <!-- Auto-generated Editorial Button Logic -->
              @foreach ($revista[0]->productItems as $capitulo)
                @if(isset($capitulo->data->corpo) && $capitulo->data->corpo == 'editorial')
                  <!-- Editorial buttons for each available language -->
                  <button class="btn-action-ghost corpoEditorial{{$capitulo->language}}" style="display:none;"
                    data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">
                    {{__("messages.BOTAOCorpoEditorial")}} ({{strtoupper($capitulo->language)}})
                  </button>
                @endif
              @endforeach
            </div>

          </div>
          <div class="col-lg-4 text-center text-lg-end">
            <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="img-fluid revista-cover-clean"
              style="max-height: 420px; width: auto;">
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content Grid -->
    <div class="container pb-5">
      <div class="content-grid">

        <!-- Left Column: Articles -->
        <main>
          <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h3 class="h4 font-weight-bold m-0" style="color: #333;">Artigos nesta edição</h3>

            <!-- Language Settings (TAB BASED) -->
            <ul class="nav nav-pills" id="language-switcher" role="tablist">
              @if(in_array('pt', $revista[0]->availableLanguages))
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($idiomaAtivo == 'pt') active @endif" id="pt-tab" data-bs-toggle="pill"
                    data-bs-target="#tab-pt" type="button" role="tab" aria-controls="tab-pt"
                    aria-selected="true">PT</button>
                </li>
              @endif
              @if(in_array('en', $revista[0]->availableLanguages))
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($idiomaAtivo == 'en') active @endif" id="en-tab" data-bs-toggle="pill"
                    data-bs-target="#tab-en" type="button" role="tab" aria-controls="tab-en"
                    aria-selected="false">EN</button>
                </li>
              @endif
              @if(in_array('es', $revista[0]->availableLanguages))
                <li class="nav-item" role="presentation">
                  <button class="nav-link @if($idiomaAtivo == 'es') active @endif" id="es-tab" data-bs-toggle="pill"
                    data-bs-target="#tab-es" type="button" role="tab" aria-controls="tab-es"
                    aria-selected="false">ES</button>
                </li>
              @endif
            </ul>
          </div>

          <div class="tab-content" id="myTabContent">

            <!-- PORTUGUESE CONTENT -->
            @if(in_array('pt', $revista[0]->availableLanguages))
              <div class="tab-pane fade @if($idiomaAtivo == 'pt') show active @endif" id="tab-pt" role="tabpanel"
                aria-labelledby="pt-tab">
                <div class="articles-list">
                  @foreach ($revista[0]->productItems as $key => $capitulo)
                              @if(isset($capitulo->data->corpo) && $capitulo->data->corpo == 'editorial') @continue @endif
                              @if($capitulo->language != 'pt') @continue @endif
                              <?php 
                                                                        $itensCapitulo = null;
                    if (isset($revista[2])) {
                      foreach ($revista[2] as $objeto) {
                        if ($objeto->id == $capitulo->id) {
                          $itensCapitulo = $objeto;
                          break;
                        }
                      }
                    }
                                                                      ?>
                                                                      
                              <article class="article-card-clean">
                                <div class="d-flex flex-column flex-md-row gap-4">
                                  <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                      <div class="article-kicker">{{ $capitulo->category }}</div>
                                    </div>
                                    <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}"
                                      class="article-title-link">
                                      <h2 class="article-title-h">{{ $capitulo->title }}</h2>
                                    </a>
                                    <div class="article-abstract">{{ limita_caracteres(strip_tags($capitulo->brief ?? ''), 240) }}</div>
                                    @if($itensCapitulo && isset($itensCapitulo->authors))
                                      <div class="article-authors mb-3">
                                        @foreach ($itensCapitulo->authors as $index => $autor) {{ $autor->name }}@if(!$loop->last), @endif
                                        @endforeach
                                      </div>
                                    @endif
                                    @if($itensCapitulo && isset($itensCapitulo->keywords) && count($itensCapitulo->keywords) > 0)
                                      <div class="mb-3">
                                        @foreach ($itensCapitulo->keywords as $kw) <span
                                        class="badge bg-light text-dark fw-normal border">{{ $kw->keyword }}</span> @endforeach
                                      </div>
                                    @endif
                                    <div class="mt-4 d-flex gap-2 flex-wrap">
                                      @if(($modalConteudo == 'permitido') || ($capitulo->customerCourtesy == 1))
                                        <button class="btn btn-sm btn-outline-dark" id="artigoCap{{$capitulo->id}}" data-bs-toggle="modal"
                                          data-bs-target="#leiaCapitulo{{$capitulo->id}}"><i class="fa-regular fa-file-pdf me-1"></i> Ler
                                          PDF</button>
                                        @if(isset($capitulo->data->html))
                                          @if($modalConteudo == 'permitido')
                                            <button class="btn btn-sm btn-outline-dark" id="artigoCapHtml{{ $capitulo->id }}"
                                              data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}"><i
                                                class="fa-solid fa-code me-1"></i> Ler em HTML</button>
                                          @else
                                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                              data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Ler em
                                              HTML</button>
                                          @endif
                                        @endif
                                        <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-sm btn-outline-dark"><i
                                            class="fa-solid fa-download me-1"></i> Download</a>
                                      @else
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                          data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Ler PDF</button>
                                      @endif
                                      @if(isset($capitulo->data->gotalk))
                                        @if(isset($capitulo->data->liberado) && $capitulo->data->liberado == 'true')
                                          <button class="btn btn-sm text-white openModalBtn" style="background-color: #28a745;"
                                             data-audio-url="{{$capitulo->data->gotalk}}"><i
                                              class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                                        @else
                                          @if($modalConteudo == 'permitido')
                                            <button class="btn btn-sm bg-dark text-white openModalBtn"  data-audio-url="{{$capitulo->data->gotalk}}"><i
                                                class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                                          @endif
                                        @endif
                                      @endif
                                    </div>
                                  </div>

                                  @if(isset($capitulo->cover) && $capitulo->cover)
                                    <div class="flex-shrink-0 d-none d-sm-block">
                                      <a
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}">
                                        <img src="{{ $capitulo->cover }}" alt="{{ $capitulo->title }}"
                                          class="img-fluid rounded shadow-sm border"
                                          style="width: 180px; height: 180px; object-fit: cover;">
                                      </a>
                                    </div>
                                  @endif
                                </div>
                              </article>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- ENGLISH CONTENT -->
            @if(in_array('en', $revista[0]->availableLanguages))
              <div class="tab-pane fade @if($idiomaAtivo == 'en') show active @endif" id="tab-en" role="tabpanel"
                aria-labelledby="en-tab">
                <div class="articles-list">
                  @foreach ($revista[0]->productItems as $key => $capitulo)
                              @if(isset($capitulo->data->corpo) && $capitulo->data->corpo == 'editorial') @continue @endif
                              @if($capitulo->language != 'en') @continue @endif
                              <?php 
                                                                        $itensCapitulo = null;
                    if (isset($revista[2])) {
                      foreach ($revista[2] as $objeto) {
                        if ($objeto->id == $capitulo->id) {
                          $itensCapitulo = $objeto;
                          break;
                        }
                      }
                    }
                                                                      ?>
                              <article class="article-card-clean">
                                <div class="d-flex flex-column flex-md-row gap-4">
                                  <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                      <div class="article-kicker">Original Article</div>
                                    </div>
                                    <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}"
                                      class="article-title-link">
                                      <h2 class="article-title-h">{{ $capitulo->title }}</h2>
                                    </a>
                                    <div class="article-abstract">{{ limita_caracteres(strip_tags($capitulo->brief ?? ''), 240) }}</div>
                                    @if($itensCapitulo && isset($itensCapitulo->authors))
                                      <div class="article-authors mb-3">
                                        @foreach ($itensCapitulo->authors as $index => $autor) {{ $autor->name }}@if(!$loop->last), @endif
                                        @endforeach
                                      </div>
                                    @endif
                                    @if($itensCapitulo && isset($itensCapitulo->keywords) && count($itensCapitulo->keywords) > 0)
                                      <div class="mb-3">
                                        @foreach ($itensCapitulo->keywords as $kw) <span
                                        class="badge bg-light text-dark fw-normal border">{{ $kw->keyword }}</span> @endforeach
                                      </div>
                                    @endif
                                    <div class="mt-4 d-flex gap-2 flex-wrap">
                                      @if(($modalConteudo == 'permitido') || ($capitulo->customerCourtesy == 1))
                                        <button class="btn btn-sm btn-outline-dark" id="artigoCap{{$capitulo->id}}" data-bs-toggle="modal"
                                          data-bs-target="#leiaCapitulo{{$capitulo->id}}"><i class="fa-regular fa-file-pdf me-1"></i> Read
                                          PDF</button>
                                        @if(isset($capitulo->data->html))
                                          @if($modalConteudo == 'permitido')
                                            <button class="btn btn-sm btn-outline-dark" id="artigoCapHtml{{ $capitulo->id }}"
                                              data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}"><i
                                                class="fa-solid fa-code me-1"></i> Read in HTML</button>
                                          @else
                                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                              data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Read in
                                              HTML</button>
                                          @endif
                                        @endif
                                        <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-sm btn-outline-dark"><i
                                            class="fa-solid fa-download me-1"></i> Download</a>
                                      @else
                                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                          data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Read PDF</button>
                                      @endif
                                      @if(isset($capitulo->data->gotalk))
                                        @if(isset($capitulo->data->liberado) && $capitulo->data->liberado == 'true')
                                          <button class="btn btn-sm text-white openModalBtn" style="background-color: #28a745;"
                                             data-audio-url="{{$capitulo->data->gotalk}}"><i
                                              class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                                        @else
                                          @if($modalConteudo == 'permitido')
                                            <button class="btn btn-sm bg-dark text-white openModalBtn"  data-audio-url="{{$capitulo->data->gotalk}}"><i
                                                class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                                          @endif
                                        @endif
                                      @endif
                                    </div>
                                  </div>
                                  @if(isset($capitulo->cover) && $capitulo->cover)
                                    <div class="flex-shrink-0 d-none d-sm-block">
                                      <a
                                        href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}">
                                        <img src="{{ $capitulo->cover }}" alt="{{ $capitulo->title }}"
                                          class="img-fluid rounded shadow-sm border"
                                          style="width: 180px; height: 180px; object-fit: cover;">
                                      </a>
                                    </div>
                                  @endif
                                </div>
                              </article>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- SPANISH CONTENT -->
            @if(in_array('es', $revista[0]->availableLanguages))
              <div class="tab-pane fade @if($idiomaAtivo == 'es') show active @endif" id="tab-es" role="tabpanel"
                aria-labelledby="es-tab">
                <div class="articles-list">
                  @foreach ($revista[0]->productItems as $key => $capitulo)
                    @if(isset($capitulo->data->corpo) && $capitulo->data->corpo == 'editorial') @continue @endif
                    @if($capitulo->language != 'es') @continue @endif
                    <?php 
                      $itensCapitulo = null;
                      if (isset($revista[2])) {
                        foreach ($revista[2] as $objeto) {
                          if ($objeto->id == $capitulo->id) {
                            $itensCapitulo = $objeto;
                            break;
                          }
                        }
                      }
                    ?>
                    <article class="article-card-clean">
                      <div class="d-flex flex-column flex-md-row gap-4">
                        <div class="flex-grow-1">
                          <div class="d-flex justify-content-between">
                            <div class="article-kicker">Artículo Original</div>
                          </div>
                          <a href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}"
                            class="article-title-link">
                            <h2 class="article-title-h">{{ $capitulo->title }}</h2>
                          </a>
                          <div class="article-abstract">{{ limita_caracteres(strip_tags($capitulo->brief ?? ''), 240) }}</div>
                          @if($itensCapitulo && isset($itensCapitulo->authors))
                            <div class="article-authors mb-3">
                              @foreach ($itensCapitulo->authors as $index => $autor) {{ $autor->name }}@if(!$loop->last), @endif
                              @endforeach
                            </div>
                          @endif
                          @if($itensCapitulo && isset($itensCapitulo->keywords) && count($itensCapitulo->keywords) > 0)
                            <div class="mb-3">
                              @foreach ($itensCapitulo->keywords as $kw) <span
                              class="badge bg-light text-dark fw-normal border">{{ $kw->keyword }}</span> @endforeach
                            </div>
                          @endif
                          <div class="mt-4 d-flex gap-2 flex-wrap">
                            @if(($modalConteudo == 'permitido') || ($capitulo->customerCourtesy == 1))
                              <button class="btn btn-sm btn-outline-dark" id="artigoCap{{$capitulo->id}}" data-bs-toggle="modal"
                                data-bs-target="#leiaCapitulo{{$capitulo->id}}"><i class="fa-regular fa-file-pdf me-1"></i> Leer
                                PDF</button>
                              @if(isset($capitulo->data->html))
                                @if($modalConteudo == 'permitido')
                                  <button class="btn btn-sm btn-outline-dark" id="artigoCapHtml{{ $capitulo->id }}"
                                    data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}"><i
                                      class="fa-solid fa-code me-1"></i> Leer en HTML</button>
                                @else
                                  <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                    data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Leer en
                                    HTML</button>
                                @endif
                              @endif
                              <a href="{{ $capitulo->content }}" target="_blank" class="btn btn-sm btn-outline-dark"><i
                                  class="fa-solid fa-download me-1"></i> Descargar</a>
                            @else
                              <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                data-bs-target="#{{ $modalConteudo }}"><i class="fa-solid fa-lock me-1"></i> Leer PDF</button>
                            @endif
                            @if(isset($capitulo->data->gotalk))
                              @if(isset($capitulo->data->liberado) && $capitulo->data->liberado == 'true')
                                <button class="btn btn-sm text-white openModalBtn" style="background-color: #28a745;"
                                    data-audio-url="{{$capitulo->data->gotalk}}"><i
                                    class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                              @else
                                @if($modalConteudo == 'permitido')
                                  <button class="btn btn-sm bg-dark text-white openModalBtn"  data-audio-url="{{$capitulo->data->gotalk}}"><i
                                      class="fa-solid fa-headphones me-1"></i> GoTalks</button>
                                @endif
                              @endif
                            @endif
                          </div>
                        </div>
                        @if(isset($capitulo->cover) && $capitulo->cover)
                          <div class="flex-shrink-0 d-none d-sm-block">
                            <a
                              href="{{ route('faceartigo') }}/{{ $revista[0]->id }}/{{ Str::slug($revista[0]->title) }}/{{ $capitulo->id }}/{{ Str::slug($capitulo->title) }}">
                              <img src="{{ $capitulo->cover }}" alt="{{ $capitulo->title }}"
                                class="img-fluid rounded shadow-sm border"
                                style="width: 180px; height: 180px; object-fit: cover;">
                            </a>
                          </div>
                        @endif
                      </div>
                    </article>
                  @endforeach
                </div>
              </div>
            @endif
          </div>
        </main>

        <aside class="d-none d-lg-block">
          <div class="sidebar-sticky">
            <div class="sidebar-card">
              <h5 class="sidebar-title">Sobre esta Edição</h5>
              <div class="d-flex align-items-center mb-3">
                <img src="{{ $revista[0]->cover }}" class="rounded shadow-sm me-3" style="width: 60px; height: auto;">
                <div>
                  <div class="fw-bold">{{ $revista[0]->title }}</div>
                </div>
              </div>
              <div class="d-grid gap-2">
                @if($modalConteudo == 'permitido')
                  <button class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#leiaNaIntegra">Ler Edição
                    Completa</button>
                @endif
                <button class="btn btn-outline-secondary w-100"
                  onclick="navigator.share({title: '{{ $revista[0]->title }}', url: window.location.href})"><i
                    class="fa-solid fa-share-nodes me-2"></i> Compartilhar</button>
              </div>
            </div>
            <div class="sidebar-card">
              <h5 class="sidebar-title">Informações</h5>
              <ul class="list-unstyled mb-0 text-muted small">
                <li class="mb-2"><i class="fa-solid fa-globe me-2"></i> Idiomas: 
                @if(in_array('pt', $revista[0]->availableLanguages))
                PT, 
                @endif
                @if(in_array('en', $revista[0]->availableLanguages))
                EN, 
                @endif
                @if(in_array('es', $revista[0]->availableLanguages))
                ES
                @endif
              </li>
              </ul>
            </div>

            @if(in_array($idColecao, ['5', '4', '6', '1', '2', '50']))
              <div class="sidebar-card">
                <style>
                  .logo-gray {
                    filter: grayscale(100%) opacity(0.7);
                    transition: all 0.3s ease;
                    max-width: 100%;
                    margin-bottom: 15px;
                  }

                  .logo-gray:hover {
                    filter: grayscale(0%) opacity(1);
                  }

                  .logo-gray-invert {
                    filter: invert(1) grayscale(100%) opacity(0.7);
                    transition: all 0.3s ease;
                    max-width: 100%;
                    margin-bottom: 15px;
                  }

                  .logo-gray-invert:hover {
                    filter: invert(1) grayscale(0%) opacity(1);
                  }
                </style>
                <h5 class="sidebar-title">Apoio Institucional</h5>
                <div class="d-flex flex-column gap-3 align-items-start ps-2">

                  @if($idColecao == '5')
                    <img src="{{ asset('imagens/siteRevista/id-logical-cinza-escuro.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 40px;" alt="iD-Logical">
                    <img src="{{ asset('imagens/siteRevista/easy-3d-cinzaescuro.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 35px;" alt="Easy 3D">
                    <img src="{{ asset('imagens/siteRevista/Morelli-logo-cinzaescuro.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 35px;" alt="Morelli">
                    <img src="{{ asset('imagens/siteRevista/dolphin-logo-cinzaescuro.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 45px;" alt="Dolphin">
                    <img src="{{ asset('imagens/siteRevista/logocinzaorthometric.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 35px;" alt="Orthometric">

                  @elseif($idColecao == '6')
                    <img src="{{ asset('imagens/siteRevista/logocinzaorthometric.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 45px;" alt="Orthometric">

                  @elseif($idColecao == '4')
                    <!-- Dentsply, FGM, CV Dentus -->
                    <img src="{{ asset('imagens/Facelift/dentsply.png') }}" class="img-fluid logo-gray"
                      style="max-height: 45px;" alt="Dentsply Sirona">
                    <img src="{{ asset('imagens/siteRevista/LOGO_FGM.png') }}" class="img-fluid logo-gray"
                      style="max-height: 55px;" alt="FGM">
                    <img src="{{ asset('imagens/siteRevista/cvdentuscinza.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 55px;" alt="CV Dentus">

                  @elseif($idColecao == '2')
                    <!-- Biologix -->
                    <img src="{{ asset('imagens/siteRevista/biologix.png') }}" class="img-fluid logo-gray"
                      style="max-height: 50px;" alt="Biologix">

                  @elseif($idColecao == '1')
                    <!-- Traumec -->
                    <img src="{{ asset('imagens/siteRevista/logo-traumec.png') }}" class="img-fluid logo-gray"
                      style="max-height: 50px;" alt="Traumec">

                  @elseif($idColecao == '50')
                    <!-- BJP: Curaprox, Colgate, GUM, Bionnovation, Oral-B, Plenum, Geistlich, CV Dentus -->
                    <img src="{{ asset('imagens/siteRevista/Curaprox-logo-cinza.jpg') }}" class="img-fluid logo-gray"
                      style="max-height: 45px;" alt="Curaprox">
                    <img src="{{ asset('imagens/siteRevista/Colgate-Logo-Cinza.png') }}" class="img-fluid logo-gray"
                      style="max-height: 55px;" alt="Colgate">
                    <img src="{{ asset('imagens/siteRevista/GUM-Logo-Cinza.png') }}" class="img-fluid logo-gray"
                      style="max-height: 45px;" alt="GUM">

                    <img src="{{ asset('imagens/siteRevista/bionnovation.fw.png') }}" class="img-fluid logo-gray-invert"
                      style="max-height: 40px;" alt="Bionnovation">
                    <img src="{{ asset('imagens/siteRevista/oral-b.fw.png') }}" class="img-fluid logo-gray-invert"
                      style="max-height: 45px;" alt="Oral-B">
                    <img src="{{ asset('imagens/siteRevista/plenum.fw.png') }}" class="img-fluid logo-gray-invert"
                      style="max-height: 45px;" alt="Plenum">
                    <img src="{{ asset('imagens/siteRevista/Geistlich.fw.png') }}" class="img-fluid logo-gray-invert"
                      style="max-height: 45px;" alt="Geistlich">

                    <img src="{{ asset('imagens/siteRevista/cvdentuscinza.fw.png') }}" class="img-fluid logo-gray"
                      style="max-height: 50px;" alt="CV Dentus">
                  @endif

                </div>
              </div>
            @endif

          </div>
        </aside>
      </div> <!-- End Content Grid -->
    </div> <!-- End Container -->
  </div> <!-- End Facelift Wrapper -->
  @foreach ($revista[0]->productItems as $key => $capitulo)
    @if($modalConteudo == 'permitido' || isset($capitulo->data->corpo) == 'editorial' || ($capitulo->customerCourtesy == 1))
      <!-- Modal do artigo -->
      <div class="modal fade" id="leiaCapitulo{{$capitulo->id}}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}"
        aria-hidden="true">
        <div class="modal-dialog modal-almost-fullscreen">
          <div class="modal-content" style="background-color: #fff;">
            <div class="modal-header" style="background-color: #fff;">
              <h5 class="modal-title" id="leiaCapitulo{{$capitulo->id}}">{{ $capitulo->title }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <div class="row" style="height: 100%;">
                <div id="adobe-dc-view{{$capitulo->id}}" class="col-md-12" style="height: 100%;"></div>
              </div>
              <script type="text/javascript">
                document.addEventListener("adobe_dc_view_sdk.ready", function () {
                  var btn = document.getElementById("artigoCap{{ $capitulo->id }}");
                  if (btn) {
                    btn.addEventListener("click", function () { showPDF{{ $capitulo->id }}("{{ $capitulo->content }}"); });
                  }
                });
                function showPDF{{ $capitulo->id }}(url) {
                  adobeDCView = null;
                  fetch(url)
                    .then((res) => res.blob())
                    .then((blob) => {
                      adobeDCView = new AdobeDC.View({
                        clientId: "509e95046c654d969e54d6c182aceba0",
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
                          @if (session()->get('usuarioPlanoID') == 274)
                                              showDownloadPDF: false,
                            showPrintPDF: false,
                            showLeftHandPanel: false,
                            showAnnotationTools: false,
                            focusOnRendering: false
                          @else
                                  showDownloadPDF: true,
                                  showPrintPDF: true,
                                  showLeftHandPanel: true,
                                  showAnnotationTools: true,
                                  focusOnRendering: true
                                @endif
                                      }
                    );
                });
                              }
              </script>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
            </div>
          </div>
        </div>
      </div>
      @if(isset($capitulo->data->html))
        <div class="modal fade" id="leiaCapituloHtml{{$capitulo->id}}" tabindex="-1"
          aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
          <div class="modal-dialog modal-almost-fullscreen">
            <div class="modal-content" style="background-color: #fff;">
              <div class="modal-header" style="background-color: #fff;">
                <h5 class="modal-title" id="leiaCapituloHtml{{$capitulo->id}}">{{ $capitulo->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                <p>For a Better Experience</p>
                <p style="position: relative;">Click the button below, to change the language ↓</p>
                <div class="row" style="height: 100%;">
                  <iframe src="{{$capitulo->data->html}}" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">{{__("messages.ProdutoCompradoBladeFechar")}}</button>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endif
  @endforeach

  <div class="modal fade" id="gotalk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="iframe-container">
          <iframe id="audioPlayerIframe" src="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>


  <script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
  <script type="text/javascript">
    var adobeDCView = null;
    document.addEventListener("adobe_dc_view_sdk.ready", function () {
      showPDF("{{ $revista[0]->productItems[0]->content }}");
      @foreach ($revista[0]->productItems as $capitulo)
        var btn = document.getElementById("Cap{{ $capitulo->id }}");
        if (btn) {
          btn.addEventListener("click", function () {
            showPDF("{{ $capitulo->content }}");
          })
        }
      @endforeach
            });

    function showPDF(url) {
      adobeDCView = null;
      fetch(url)
        .then((res) => res.blob())
        .then((blob) => {
          adobeDCView = new AdobeDC.View({
            clientId: "509e95046c654d969e54d6c182aceba0",
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
              @if (session()->get('usuarioPlanoID') == 274)
                            showDownloadPDF: false,
                showPrintPDF: false,
                showLeftHandPanel: false,
                showAnnotationTools: false,
                focusOnRendering: false
              @else
                  showDownloadPDF: true,
                  showPrintPDF: true,
                  showLeftHandPanel: true,
                  showAnnotationTools: true,
                  focusOnRendering: true
                @endif
                    }
        );
    });
            }

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
    document.addEventListener('DOMContentLoaded', function () {
      // Move modals to body to ensure z-index works
      const leiaNaIntegra = document.getElementById('leiaNaIntegra');
      if (leiaNaIntegra) { document.body.appendChild(leiaNaIntegra); }

      const chapterModals = document.querySelectorAll('.modal[id^="leiaCapitulo"]');
      chapterModals.forEach(function (modal) { document.body.appendChild(modal); });

   
      
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Delegação: funciona mesmo se os botões forem carregados depois
      document.addEventListener("click", (ev) => {
        const btn = ev.target.closest(".openModalBtn[data-audio-url]");
        if (!btn) return;

        ev.preventDefault();
        ev.stopPropagation();

        const url = btn.dataset.audioUrl;
        const title = btn.dataset.title || "GoTalks";

        if (!url) return;
        openGoTalksPlayer({ url, title });
      });

      // ---------- Player Universal ----------
      let overlay, audio, playBtn, seekBar, currTimeDisplay, durTimeDisplay, centerTimer, msgHelper, speedSelect, closeBtn, canvas, ctx;
      let audioContext, analyser, sourceNode, bufferLength, dataArray, animationFrameId;
      let isOpen = false;

      function injectStylesOnce() {
        if (document.getElementById("gotalks-player-style")) return;

        const style = document.createElement("style");
        style.id = "gotalks-player-style";
        style.innerHTML = `
        #intro-audio-overlay{
    position:fixed; inset:0; z-index:99999;
    display:flex; align-items:center; justify-content:center;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    opacity:0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .25s ease, visibility .25s ease;
  }
  #intro-audio-overlay.is-open{
    opacity:1;
    visibility: visible;
    pointer-events: auto;
  }

        #intro-audio-card{
          position:relative;
          width:480px; max-width:92vw;
          background: rgba(15,15,15,.90);
          backdrop-filter: blur(25px);
          -webkit-backdrop-filter: blur(25px);
          border: 1px solid rgba(255,255,255,.10);
          box-shadow: 0 30px 80px rgba(0,0,0,.8);
          border-radius: 34px;
          padding: 26px 18px 22px;
          color:#fff;
        }
        .vz-container{
          position:relative;
          width:420px; height:420px; max-width:78vw; max-height:78vw;
          margin: 4px auto 14px;
          display:flex; align-items:center; justify-content:center;
        }
        .title-main{ font: 700 24px/1.1 sans-serif; margin:0; color:#e0f7fa; text-shadow:0 0 16px #CA1D53;}
        .title-sub{ font: 12px/1.2 sans-serif; margin:2px 0 0; color:#b2ebf2; opacity:.75;}
        .timer-main{ font: 700 18px/1 monospace; margin-top:10px; }
        #close-intro-btn{
          position:absolute; top:14px; right:16px;
          background:transparent; border:none; color:rgba(255,255,255,.6);
          font-size:30px; cursor:pointer; line-height:1;
        }
        .time-row{
          display:flex; justify-content:space-between;
          font: 12px/1 monospace; color:#aaa; margin-bottom:8px;
        }
        #seek-bar{
          width:100%; cursor:pointer; height:6px; accent-color:#CA1D53;
          margin-bottom:16px;
        }
        .controls{
          display:flex; align-items:center; justify-content:space-between;
          gap:10px;
        }
        #speed-select{
          background: rgba(255,255,255,.10);
          color:#ccc; border:none; border-radius:10px;
          padding:8px 10px; font-size:13px; outline:none; cursor:pointer;
        }
        #play-btn{
          width:64px; height:64px; border-radius:50%;
          border:none;
          background: linear-gradient(135deg, #CA1D53, #a71946);
          color:#fff; cursor:pointer;
          display:flex; align-items:center; justify-content:center;
          box-shadow: 0 4px 25px #CA1D53;
          font-size: 22px;
        }
        #msg-helper{
          font-size:12px; color:rgba(255,255,255,.5);
          text-align:center; margin:14px 0 0;
        }

        @media (max-width: 600px){
          #intro-audio-card{ border-radius:26px; padding:22px 14px 18px; }
          .vz-container{ width:280px; height:280px; }
          .title-main{ font-size:20px; }
          .timer-main{ font-size:16px; }
          #play-btn{ width:58px; height:58px; font-size:20px; }
        }
      `;
        document.head.appendChild(style);
      }

      function ensureOverlay() {
        if (overlay) return;

        overlay = document.createElement("div");
        overlay.id = "intro-audio-overlay";
        overlay.innerHTML = `
        <div id="intro-audio-card" role="dialog" aria-modal="true">
          <button id="close-intro-btn" aria-label="Fechar">&times;</button>

          <audio id="myAudio" crossorigin="anonymous"></audio>

          <div class="vz-container">
            <canvas id="myCanvas" width="840" height="840" style="width:100%;height:100%;position:absolute;inset:0;z-index:1;"></canvas>

            <div style="z-index:2;text-align:center;pointer-events:none;">
              <h3 class="title-main" id="gotalkTitle">GoTalks</h3>
              <p class="title-sub">by DentalGo</p>
              <div id="center-timer" class="timer-main">00:00</div>
            </div>
          </div>

          <div style="width:100%; padding:0 10px; z-index:10;">
            <div class="time-row">
              <span id="curr-time-display">0:00</span>
              <span id="dur-time-display">--:--</span>
            </div>

            <input type="range" id="seek-bar" value="0" max="100">

            <div class="controls">
              <select id="speed-select" aria-label="Velocidade">
                <option value="1">1.0x</option>
                <option value="1.25">1.25x</option>
                <option value="1.5">1.5x</option>
                <option value="2">2.0x</option>
              </select>

              <button id="play-btn" aria-label="Play/Pause">▶</button>

              <div style="width:44px;"></div>
            </div>

            <p id="msg-helper">Carregando…</p>
          </div>
        </div>
      `;

        document.body.appendChild(overlay);

        // refs
        audio = overlay.querySelector("#myAudio");
        playBtn = overlay.querySelector("#play-btn");
        seekBar = overlay.querySelector("#seek-bar");
        currTimeDisplay = overlay.querySelector("#curr-time-display");
        durTimeDisplay = overlay.querySelector("#dur-time-display");
        centerTimer = overlay.querySelector("#center-timer");
        msgHelper = overlay.querySelector("#msg-helper");
        speedSelect = overlay.querySelector("#speed-select");
        closeBtn = overlay.querySelector("#close-intro-btn");
        canvas = overlay.querySelector("#myCanvas");
        ctx = canvas.getContext("2d");
        const titleEl = overlay.querySelector("#gotalkTitle");

        // Events (uma vez)
        playBtn.addEventListener("click", (e) => {
          e.stopPropagation();
          if (!audio.src) return;
          if (audio.paused) audio.play().then(() => updateUI("playing")).catch(() => updateUI("blocked"));
          else { audio.pause(); updateUI("paused"); }
        });

        speedSelect.addEventListener("change", (e) => {
          e.stopPropagation();
          audio.playbackRate = Number(speedSelect.value) || 1;
        });

        seekBar.addEventListener("click", (e) => e.stopPropagation());
        seekBar.addEventListener("input", (e) => {
          e.stopPropagation();
          if (!audio.duration) return;
          audio.currentTime = (seekBar.value / 100) * audio.duration;
        });

        audio.addEventListener("timeupdate", () => {
          if (!audio.duration) return;
          const f = formatTime(audio.currentTime);
          seekBar.value = (audio.currentTime / audio.duration) * 100;
          currTimeDisplay.textContent = f;
          centerTimer.textContent = f;
        });

        audio.addEventListener("loadedmetadata", () => {
          durTimeDisplay.textContent = formatTime(audio.duration);
          setupAudioGraphOnce(); // cria AudioContext e nodes uma vez
        });

        audio.addEventListener("ended", () => updateUI("paused"));

        overlay.addEventListener("click", (e) => {
          // clique fora do card fecha
          if (e.target === overlay) closeOverlay();
        });

        closeBtn.addEventListener("click", closeOverlay);

        // helper: atualizar título na abertura
        overlay._setTitle = (t) => { titleEl.textContent = t || "GoTalks"; };
      }

      function openGoTalksPlayer({ url, title }) {
        injectStylesOnce();
        ensureOverlay();

        // se já estava aberto, só troca a faixa
        isOpen = true;
        overlay._setTitle(title);

        // reset UI
        stopVisualizer();
        seekBar.value = 0;
        currTimeDisplay.textContent = "0:00";
        centerTimer.textContent = "0:00";
        durTimeDisplay.textContent = "--:--";
        speedSelect.value = "1";
        audio.playbackRate = 1;

        // set source
        audio.pause();
        audio.currentTime = 0;
        audio.src = url;
        audio.load();

        // abrir overlay e travar scroll
        document.body.style.overflow = "hidden";
        requestAnimationFrame(() => { overlay.classList.add("is-open"); });


        // tenta autoplay (pode ser bloqueado)
        audio.play()
          .then(() => updateUI("playing"))
          .catch(() => updateUI("blocked"));
      }

      function closeOverlay() {
        if (!isOpen) return;
        isOpen = false;

        if (audio) { audio.pause(); audio.currentTime = 0; }
        stopVisualizer();

        overlay.classList.remove("is-open");

        document.body.style.overflow = "";

        // não remove do DOM pra reusar (mais leve)
      }

      function formatTime(t) {
        if (isNaN(t)) return "0:00";
        const m = Math.floor(t / 60);
        const s = Math.floor(t % 60);
        return `${m}:${s < 10 ? "0" + s : s}`;
      }

      function updateUI(state) {
        if (state === "playing") {
          playBtn.textContent = "||";
          msgHelper.textContent = "Toque fora do player para fechar";
          msgHelper.style.color = "#aaa";
          startVisualizer();
        } else if (state === "paused") {
          playBtn.textContent = "▶";
          stopVisualizer();
        } else if (state === "blocked") {
          playBtn.textContent = "▶";
          msgHelper.textContent = "TOQUE EM ▶ PARA OUVIR 🔊";
          msgHelper.style.color = "#CA1D53";
          msgHelper.style.fontWeight = "700";
          stopVisualizer();
        } else {
          playBtn.textContent = "▶";
          stopVisualizer();
        }
      }

      // ---------- Visualizer (criar nodes UMA vez) ----------
      function setupAudioGraphOnce() {
        if (audioContext) return;

        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        analyser = audioContext.createAnalyser();

        // IMPORTANTE: createMediaElementSource só pode ser chamado 1x por elemento <audio>
        sourceNode = audioContext.createMediaElementSource(audio);
        sourceNode.connect(analyser);
        analyser.connect(audioContext.destination);

        analyser.fftSize = 128;
        bufferLength = analyser.frequencyBinCount;
        dataArray = new Uint8Array(bufferLength);
      }

      function startVisualizer() {
        if (!audioContext) return;
        if (audioContext.state === "suspended") audioContext.resume().catch(() => { });
        if (animationFrameId) return;
        drawVisualizer();
      }

      function drawVisualizer() {
        animationFrameId = requestAnimationFrame(drawVisualizer);
        if (!analyser) return;

        analyser.getByteFrequencyData(dataArray);
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const cx = canvas.width / 2;
        const cy = canvas.height / 2;
        const radius = 165;
        const maxH = 90;

        for (let i = 0; i < bufferLength; i++) {
          const h = (dataArray[i] / 255) * maxH;
          const ang = (i / bufferLength) * Math.PI * 2;

          const x1 = cx + Math.cos(ang) * radius;
          const y1 = cy + Math.sin(ang) * radius;
          const x2 = cx + Math.cos(ang) * (radius + h);
          const y2 = cy + Math.sin(ang) * (radius + h);

          ctx.beginPath();
          ctx.lineWidth = 8;
          ctx.lineCap = "round";
          ctx.strokeStyle = `#CA1D53`;
          ctx.moveTo(x1, y1);
          ctx.lineTo(x2, y2);
          ctx.stroke();
        }
      }

      function stopVisualizer() {
        if (animationFrameId) {
          cancelAnimationFrame(animationFrameId);
          animationFrameId = null;
        }
        if (ctx && canvas) ctx.clearRect(0, 0, canvas.width, canvas.height);
      }

      // Escape fecha
      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") closeOverlay();
      });
    });

  </script>


@endsection