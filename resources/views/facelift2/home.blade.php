@extends('facelift2.master')

@section('content')
  <style>
    .hero-carousel .carousel-item {
      display: block;
      transition: opacity 1s ease-in-out;
    }

    .hero-carousel .carousel-item img {
      transform: scale(1.05);
      transition: transform 1.5s ease, opacity 1.5s ease;

    }

    .hero-carousel .carousel-item.active img {
      transform: scale(1);
    }
  </style>


  <section class="hero-wrap">
    <div class="container">
      <div class="hero-inner">

        <div>
          <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel"
            data-bs-interval="4000" style="width: 100%;">
            <div class="carousel-inner">

              <div class="carousel-item active position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1138/Clinical-2025-v24n05/5">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/clinical1219.png') }}"
                    alt="Banner Desktop 1">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/clinical32.png') }}"
                    alt="Banner Mobile 1">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://congressosdentalpress.com.br/3-congresso-ortodontia-infantil/">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/banner-orto-21-9.png') }}"
                    alt="Banner Desktop 2" style="">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/banner-orto-2-3.png') }}"
                    alt="Banner Mobile 2">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1140/Est%C3%A9tica-%7C-JCDR-2025-v22n3/4">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/estetica1219.png') }}"
                    alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/estetica32.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1137/Periodontology-2025-v35n3/50">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/perio1219.png') }}" alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/perio32.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1141/Orofacial-Harmony-2025-v3n2/67">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/hof1219.png') }}" alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/hof32.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1142/Journal-2025-v30n6/6">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/dpjo1219.png') }}" alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/dpjo32.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1133/Endodontics-2025-v15n2/2">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/endodontics1219.png') }}"
                    alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/endodontics32.png') }}"
                    alt="Banner Mobile 3">
                </a>
              </div>

              <div class="carousel-item position-relative">
                <a href="https://dentalgo.com.br/facelift25/revista/1139/JBCOMS-2025-V11N4/1">
                  <img class="d-none d-lg-block" src="{{ asset('facelift2/img/jbcoms1219.png') }}" alt="Banner Desktop 3">
                  <img class="d-block d-lg-none" src="{{ asset('facelift2/img/jbcoms32.png') }}"
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
              <span class="visualmente-hidden"></span>
            </button>

          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- novidades -->
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <h2 class="h4 mb-3 titulogeral">Novidades</h2>
    </div>

    <div class="my-slider">

      @php
        // Filtra as revistas que não possuem id == 80 E id != 79
        $magazinesFiltradas = array_values(array_filter($colecoes[0]->collections->magazines, function ($magazine) {
          return $magazine->id != 80 && $magazine->id != 79;
        }));

        // Define o número máximo de itens a exibir com base nos arrays filtrados
        $maxItems = min(count($ultimasRevistas), count($magazinesFiltradas));
      @endphp

      @for ($i = 0; $i < $maxItems; $i++)
        @php
          $revista = $magazinesFiltradas[$i];
          $ultima = $ultimasRevistas[$i];
        @endphp

        {{-- O bloco PHP com @continue foi removido daqui --}}


        <a href="{{ route('facerevista') }}/{{ $ultima->id }}/{{ str_replace(' ', '-', $ultima->title) }}/{{ $revista->id }}"
          style="text-decoration: none;">
          <img src="{{ $revista->lastProductCover }}" alt="{{ $ultima->title }}" class="img-fluid img-selecao img-grow">
        </a>

      @endfor
    </div>
  </div>




  <!-- cards -->
  <div class="container">
    <div class="my-slider4 cardcss">
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/Livros.png"></a>
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/Vídeos.png"></a>
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/quandoeondequiser.png"></a>
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/Novosconteúdos.png"></a>
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/especialistas.png"></a>
      <a><img src="https://facelift.dentalgo.com.br/imagens/Facelift/Descontos.png"></a>
    </div>
  </div>


  <!-- videos recentes -->
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <h2 class="h4 mb-3 mt-5 titulogeral">Videos Recentes</h2>
    </div>

  
                    @php
                        $allVideos = collect();

                        foreach ($videos as $videosCat) {
                            foreach ($videosCat->productItems as $item) {
                                // GRAVA o ID da coleção dentro do vídeo
                                $item->collection_id = $videosCat->id;
                                $allVideos->push($item);
                            }
                        }

                        $recentVideos = $allVideos
                            ->unique('id')
                            ->sortByDesc('id')
                            ->values()
                            ->take(15);
                    @endphp


                
                        <div class="owl-carousel owl-carousel-setenta my-slider2">
                        
                        @foreach ($recentVideos as $video)
                        <a href="{{ route('facevideo')}}/{{ $video->collection_id }}/{{ str_replace(' ', '-', $video->title) }}/{{ $video->id }}"
                            style="text-decoration: none">
                            <div class="slider-card-top">
                                <div class="d-flex justify-content-center align-items-center mb-4">
                                    <img src="{{ $video->cover }}"
                                        alt="{{ $video->title }}" 
                                        class="top-slider-img" style="border-radius: 15px">
                                </div>
                            </div>
                        </a>
                        @endforeach

                        </div>
                   
  </div>


  <!-- propaganda -->
  <div class="container propaganda">
    <div class="my-slider5">
      <a><img src="https://dentalpress.com.br/portal/wp-content/uploads/2024/01/dvi.png"></a>
      <a><img src="https://dentalpress.com.br/portal/wp-content/uploads/2025/02/angelPortal.jpeg"></a>
      <a><img src="https://dentalpress.com.br/portal/wp-content/uploads/2024/11/banner-doctor-sa.jpg"></a>
    </div>
  </div>


  <!-- Go Talks -->

  <div class="container-fluid" style="background-color:#f5f5f5; padding-block: 60px; margin-top: 50px; height:"
    id="SessionGotalks">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img class="img-fluid" style="width: 50%; filter:invert(0.8)"
            src="{{ asset('imagens/Facelift/selo-go-talks-branco.png') }}" alt="" id="LogoGotalks">
          <h2 style="color:#4f4f4f; font-family: raleway; font-size: 20px;  text-align: left; margin-bottom: 5px;">
            {{__("messages.GOTALKSDia")}}</h2>
          <p style="color: #555555ff; font-size: 15px;">{{__("messages.GOTALKSRevista")}}</p>
          <h1 class="revistaImagemArtigoh1"
            style="font-family: 'Montserrat'; text-decoration:none !important; color:#4f4f4f; font-size:25px; font-weight:900;">
            {{__("messages.GOTALKSTitulo")}}</h1>
          <p class="revistaImagemArtigop" style="color:#4f4f4f;">
            {{__("messages.GOTALKSParagrafo")}}
          </p>
          <p class="revistaImagemArtigop1" style="color:#4f4f4f;">{{__("messages.GOTALKSAutores")}}</p>
          <div class="justify-content-center align-items-center" style="gap: 10px;">
            <button type="button" class="btn btn-primary openModalBtn"
              data-audio-url="https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n5/gotalks/Expans%C3%A3o_r%C3%A1pida_da_maxila_e_seu_impacto_na_apneia_do_sono_em_crian%C3%A7as_de_5_a_8_anos_um_estudo_retrospectivo.mp3"
              data-bs-toggle="modal" data-bs-target="#gotalk"
              style="background-color: transparent; border: 1px solid #4f4f4f; padding: 10px 30px; border-radius: 18px; display: flex; align-items: center; gap: 10px;">
              <i class="fa-solid fa-play letra" style="color:#4f4f4f; font-size: 23px;"></i>
              <span
                style="color:#4f4f4f; font-size: 23px; text-transform: none !important;">{{__("messages.GOTALKSBotao")}}</span>
            </button>
            <!--<button type="button" class="btn btn-primary openModalBtn botaobandeiras" 
                      data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/Pt-Entrevista_com_Ravindra_Nanda.mp3" 
                      data-bs-toggle="modal" 
                      data-bs-target="#gotalk" 
                      style="background-color: transparent; border: 1px solid #4f4f4f; padding: 10px 30px; border-radius: 18px; display: flex; align-items: center;">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Flag_of_Brazil.svg" alt="BR">
                      <i class="fa-solid fa-play letra" style="color:#4f4f4f; font-size: 23px;"></i>
                      <span style="color:#4f4f4f; font-size: 15px; text-transform: none;">Clique e Ouça</span>
                      </button>
                      <button type="button" class="btn btn-primary openModalBtn botaobandeiras" 
                      data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/En-Interview_with_Ravindra_Nanda.mp3" 
                      data-bs-toggle="modal" 
                      data-bs-target="#gotalk" 
                      style="background-color: transparent; border: 1px solid #4f4f4f; padding: 10px 30px; border-radius: 18px; display: flex; align-items: center;">
                      <img src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg" alt="EN">
                      <i class="fa-solid fa-play letra" style="color:#4f4f4f; font-size: 23px;"></i>
                      <span style="color:#4f4f4f; font-size: 15px; text-transform: none;">Click and Listen</span>
                      </button>
                      <button type="button" class="btn btn-primary openModalBtn botaobandeiras" 
                      data-audio-url="https://artigos.dentalgo.com.br/revistas/Clinical/2023/v22n1/audios/Es-Entrevista_con_Ravindra_Nanda.mp3" 
                      data-bs-toggle="modal" 
                      data-bs-target="#gotalk" 
                      style="background-color: transparent; border: 1px solid #4f4f4f; padding: 10px 30px; border-radius: 18px; display: flex; align-items: center;">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Flag_of_Spain.svg" alt="ES">
                      <i class="fa-solid fa-play letra" style="color:#4f4f4f; font-size: 23px;"></i>
                      <span style="color:#4f4f4f; font-size: 15px; text-transform: none;">Haz clic y Escucha</span>
                      </button>-->
          </div>
        </div>
        <div class="col-md-6 revistaImagemArtigo d-none d-md-block"
          style="padding-right: auto !important; padding-left: 190px !important;">
          <img class="img-fluid" style="height: 400px; margin-right: auto; margin-left: auto;"
            src="{{ asset('imagens/Facelift/exp.png') }}" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <a href="#" style="text-decoration: none;">
        <h2 class="h4 mb-4 titulogeral">Go Talks<span
            style="font-size: 14px; font-family: poppins; margin-left: 10px;">Veja mais</span></h2>
      </a>
    </div>

    <div class="my-slider3">
      <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(72deg);"></a>
      <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(144deg);"></a>
      <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(216deg);"></a>
      <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(288deg);"></a>
      <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(360deg);"></a>
    </div>
  </div> -->


  <!-- GoBooks - Livros -->
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <a href="{{ route('facelivros') }}" style="text-decoration: none;">
        <h2 class="h4 mb-4 mt-5 titulogeral">GoBooks<span
            style="font-size: 14px; font-family: poppins; margin-left: 10px;">Veja mais</span></h2>
      </a>
    </div>

    <div class="my-slider7">
      @if(isset($livros) && isset($livros['livrosG']) && isset($livros['livrosG']->rows))
        @php
          $todosLivrosG = $livros['livrosG']->rows;
          // Filtra apenas livros com cortesia = 1
          $livrosCortesia = array_filter($todosLivrosG, function ($livro) {
            return isset($livro->subscriberCourtesy) && $livro->subscriberCourtesy == 1 && $livro->id != '1109';
          });
          // Limita a 8 livros
          $livrosCortesia = array_slice($livrosCortesia, 0, 8);
        @endphp

        @foreach ($livrosCortesia as $livro)
          <a href="{{ route('facelivro') }}/{{ $livro->id }}/{{ str_replace(' ', '-', $livro->title) }}"
            style="text-decoration: none;">
            <div class="slider-card-book">
              <div class="d-flex justify-content-center align-items-center mb-2">
                <img src="{{ $livro->cover }}" alt="{{ $livro->title }}" class="top-slider-img arredonda-imagem"
                  style="border-radius: 15px; width: 100%; height: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
              </div>
              <h3 class="godocstitulo" style="margin-top: 8px; font-size: 14px; line-height: 1.3;">
                {{ Str::limit($livro->title, 50) }}</h3>
            </div>
          </a>
        @endforeach
      @else
        <!-- Fallback caso não haja livros disponíveis -->
        <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(0deg);"></a>
        <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(72deg);"></a>
        <a><img src="{{ asset('facelift2/img/Screenshot_142.png') }}" style="filter: hue-rotate(144deg);"></a>
      @endif
    </div>
  </div>

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