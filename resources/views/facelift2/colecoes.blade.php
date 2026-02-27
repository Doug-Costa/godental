<?php
$paginaTitulo = 'Coleções - DentalGo';
$pageDescription = 'Explore todas as nossas revistas científicas e coleções exclusivas.';

$tipoTopo = 'topoAzul';

// Helper function logic kept but simplified usage or ensured availability
if (!function_exists('limita_caracteres')) {
  function limita_caracteres($texto, $limite, $quebra = true)
  {
    $tamanho = strlen($texto);
    if ($tamanho <= $limite)
      return $texto;
    if ($quebra == true)
      return trim(substr($texto, 0, $limite)) . "...";
    $ultimo_espaco = strrpos(substr($texto, 0, $limite), " ");
    return trim(substr($texto, 0, $ultimo_espaco)) . "...";
  }
}

// Logic for Recent Articles Selection
$atigosUltimaRevista = $ultimaRevista[1]->productItems ?? [];
$articlesToShow = [];

// Get 3 random articles if available
if (!empty($atigosUltimaRevista)) {
  if (count($atigosUltimaRevista) < 3) {
    $articlesToShow = $atigosUltimaRevista;
  } else {
    $keys = array_rand($atigosUltimaRevista, 3);
    foreach ($keys as $k) {
      $articlesToShow[] = $atigosUltimaRevista[$k];
    }
  }
}
?>

@extends('facelift2.master')

@section('content')

  <style>
    /* Scoped Styles for Collections List */
    .hero-collections {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 60px 0;
      text-align: center;
      margin-bottom: 60px;
      border-bottom: 1px solid #dee2e6;
    }

    .hero-collections h1 {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      color: #333;
      margin-bottom: 15px;
    }

    .hero-collections p {
      font-family: 'Open Sans', sans-serif;
      color: #666;
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0 auto;
    }

    /* Magazine Cards */
    .collection-card {
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      background: white;
      height: 100%;
      display: block;
      text-decoration: none;
    }

    .collection-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }

    .img-collection {
      width: 100%;
      height: auto;
      display: block;
      transition: opacity 0.2s;
    }

    .collection-card:hover .img-collection {
      opacity: 0.95;
    }

    /* Hero Styles from Home - Matched EXACTLY */
    .hero-carousel .carousel-item {
      display: block;
      transition: opacity 1s ease-in-out;
    }

    .hero-carousel .carousel-item img {
      transform: scale(1.05);
      /* Zoom effect */
      transition: transform 1.5s ease, opacity 1.5s ease;
      width: 100%;
    }

    .hero-carousel .carousel-item.active img {
      transform: scale(1);
    }

    .hero-wrap {
      margin-bottom: 50px;
    }

    /* Logos Carousel Restoration */
    .logocolecao img {
      height: auto !important;
      /* Allow height to adjust */
      max-height: 80px !important;
      /* Cap max height for desktop */
      max-width: 100% !important;
      /* Ensure it fits in the slot */
      width: auto !important;
      /* Maintain aspect ratio */
      margin: 0 auto;
      display: block;
      opacity: 0.8;
      transition: all 0.3s;
      object-fit: contain;
      /* Prevent distortion */
    }

    .logocolecao img:hover {
      opacity: 1;
      transform: scale(1.05);
    }

    /* Recent Articles */
    .section-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      color: #333;
      margin-bottom: 40px;
      position: relative;
      display: inline-block;
    }

    .section-title::after {
      content: '';
      display: block;
      width: 40px;
      height: 4px;
      background-color: #d21d5b;
      margin-top: 8px;
      border-radius: 2px;
    }

    .article-card-horizontal {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
      margin-bottom: 30px;
      transition: transform 0.2s;
      border: 1px solid #f0f0f0;
    }

    .article-card-horizontal:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    }

    .article-img-wrap {
      height: 100%;
      min-height: 250px;
      background-color: #f8f9fa;
      position: relative;
      overflow: hidden;
    }

    .article-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .article-content {
      padding: 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
    }

    .article-badge {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #999;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .article-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
      font-size: 1.25rem;
      color: #222;
      margin-bottom: 15px;
      line-height: 1.4;
    }

    .article-excerpt {
      font-family: 'Open Sans', sans-serif;
      color: #666;
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 25px;
    }

    .btn-read-more {
      align-self: flex-start;
      background-color: #d21d5b;
      color: white;
      border: none;
      padding: 10px 24px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background 0.2s;
      text-decoration: none;
    }

    .btn-read-more:hover {
      background-color: #b0154a;
      color: white;
    }

    @media(max-width: 768px) {
      .logocolecao img {
        height: 40px;
        margin: 10px;
      }

      .article-img-wrap {
        min-height: 200px;
      }
    }
    @media(min-width: 1440px) {
      .logocolecao img{
        max-height: 150px !important;
      }
}
  </style>

  <!-- HEADER BANNER (From Home) -->
  <section class="hero-wrap">
    <div class="container">
      <div class="hero-inner">
        <div>
          <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel"
            data-bs-interval="4000" style="width: 100%;">
            <div class="carousel-inner">

              <div class="carousel-item active position-relative">
                <a href="https://congressosdentalpress.com.br/3-congresso-ortodontia-infantil/">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/banner-orto-21-9.png') }}"
                    alt="Banner Desktop 1">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/banner-orto-2-3.png') }}"
                    alt="Banner Mobile 1">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://congressosdentalpress.com.br/3-congresso-ortodontia-infantil/">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/clinical1219.png') }}"
                    alt="Banner Desktop 2" style="">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/testecl.png') }}" alt="Banner Mobile 2">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="#">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/estetica1219.png') }}"
                    alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/banner-orto-2-3.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visualmente-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MAGAZINE COLLECTIONS GRID -->
  <div class="container mb-5" style="margin-top: 50px;">
    <div class="row g-4">
      @if(isset($colecoes[0]->collections->magazines))
        @php
          $magazines = collect($colecoes[0]->collections->magazines)->sortBy(function ($revista) {
                return in_array($revista->id, [79, 80]) ? 1 : 0;
            });
        @endphp

        <div class="d-none d-lg-block col-lg-1"></div>
        @foreach ($magazines as $revista)
          @if($revista->id == '79' || $revista->id == '80' || $revista->id == '50' || $revista->id == '67') @continue @endif
          <div class="col-6 col-md-4 col-lg-2">
            <a href="/facelift25/colecao/{{ $revista->id }}" class="collection-card"
              title="{{ $revista->description ?? 'Coleção' }}">
              <img src="{{ $revista->lastProductCover }}" alt="Capa {{ $revista->id }}" class="img-collection">
            </a>
          </div>
        @endforeach
        <div class="d-none d-lg-block col-lg-1"></div>

        <div class="d-none d-lg-block col-lg-2"></div>
        @foreach ($magazines as $revista)
          @if($revista->id == '1' || $revista->id == '2' || $revista->id == '4' || $revista->id == '5' || $revista->id == '6') @continue @endif
          <div class="col-6 col-md-4 col-lg-2">
            <a href="/facelift25/colecao/{{ $revista->id }}" class="collection-card"
              title="{{ $revista->description ?? 'Coleção' }}">
              <img src="{{ $revista->lastProductCover }}" alt="Capa {{ $revista->id }}" class="img-collection">
            </a>
          </div>
        @endforeach
        <div class="d-none d-lg-block col-lg-2"></div>
      @endif
    </div>

    <!-- Partner Logos Carousel (Restored) -->
    <div class="container">
      <div class="my-slider16 carrossellogocanais2 logocolecao" style="margin-top: 80px; margin-bottom: 20px">
        <a href="#"><img src="{{ asset('facelift2/img/clinical52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/dpjo52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/oh52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/jcdr52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/jbcoms52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/endodontics52.png') }}"></a>
        <a href="#"><img src="{{ asset('facelift2/img/perio52.png') }}"></a>
      </div>
    </div>

  </div>

  <!-- RECENT ARTICLES SECTION -->
  <div class="container py-5">
    <div class="row mb-4">
      <div class="col-12">
        <h2 class="section-title">Novos Artigos</h2>
      </div>
    </div>

    @foreach($articlesToShow as $artigo)
      @php
        // Skip if it is 'editorial' (mimicking old logic)
        if (isset($artigo->data->corpo) && $artigo->data->corpo === 'editorial')
          continue;

        // Build Link
        $link = route('facerevista') . '/'
          . ($ultimaRevista[1]->id) . '/'
          . str_replace('/', '-', str_replace(' ', '-', $ultimaRevista[1]->title ?? 'Revista')) . '/'
          . ($artigo->id) . '/'
          . str_replace('/', '-', str_replace(' ', '-', $artigo->title));
      @endphp

      <div class="article-card-horizontal">
        <div class="row g-0 h-100">
          <div class="col-md-4">
            <div class="article-img-wrap">
              <img src="{{ $artigo->cover }}" alt="{{ $artigo->title }}">
            </div>
          </div>
          <div class="col-md-8">
            <div class="article-content">
              <span class="article-badge">{{ $ultimaRevista[1]->title ?? 'Revista Científica' }}</span>
              <h3 class="article-title">{{ $artigo->title }}</h3>
              <p class="article-excerpt">
                {{ limita_caracteres(strip_tags($artigo->brief), 220, false) }}
              </p>
              <a href="{{ $link }}" class="btn-read-more">
                {{__("messages.ColecoesLeia")}}
              </a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

@endsection