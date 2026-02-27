@extends('facelift2.master')

@section('content')
<style>
    body{
        background-color: #212529;
    }
    .bannergotalks {
    background-image: url('/facelift2/img/bannergotalks2.png');
    position: relative;
    background-size: cover;
    background-position: bottom;
    background-repeat: no-repeat;
    background-color: #212529; /* ambienta com o resto do site */
    width: 100%;
    min-height: 680px; /* ajuste conforme o layout */
    filter: hue-rotate(70deg);
   
}
.logo-gotalks {
    
    width: 450px;   /* controla o tamanho */
    max-width: 100%;
    margin-top: 100px;
}
.logo-gotalks {
    filter: drop-shadow(0 8px 20px rgba(0,0,0,.4));
}


.subtit{
    color: white;
    font-family: poppins;
    font-size: 30px;
    margin-left: 60px;
    text-shadow: 0 3px 10px rgba(0, 0, 0, 0.8);
    
}
.titulo{
    color: #d8d8d8;
    font-family: poppins;
    font-size: 22.5px;
    font-weight: 500;
}
.blocosgotalks{
    width: 100%;
    height: auto;
    border-radius: 15px;
    
}

.gotalks-info-card {
  max-width: 360px;
  padding: 24px 26px;
  border-radius: 18px;

  background: rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);

  border: 1px solid rgba(202, 29, 83, 0.35);
  box-shadow:
    0 20px 40px rgba(0, 0, 0, 0.55),
    inset 0 0 0 1px rgba(255,255,255,0.03);

  color: #fff;
}

.gotalks-info-card ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.gotalks-info-card li {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 14px;
}

.gotalks-info-card li:last-child {
  margin-bottom: 0;
}

.gotalks-info-card .icon {
  font-size: 22px;
  line-height: 1;
  filter: drop-shadow(0 0 6px rgba(202, 29, 84, 0.36));
}

.gotalks-info-card .text {
  font-size: 15px;
  line-height: 1.4;
  color: #eaeaea;
}

.gotalks-info-card strong {
  color: #fff;
  font-weight: 700;
}
.gotalks-info-card {
  justify-self: end;
  
}
@media (max-width: 768px) {
    .logo-gotalks {
        width: 400px;
        margin-top: 30px;
    
    }
    .subtit{
        margin-left: 0;
        text-align: center;
    }
     .bannergotalks {
    
        min-height: 500px !important;
     }
     .gotalks-info-card {
        justify-self: center;
     }
}
.gotalks-card {
  padding: 0;
  margin-bottom: 30px;
}

.gotalks-thumb {
  position: relative;
  overflow: hidden;
  border-radius: 12px; /* opcional */
}

.blocosgotalks {
  width: 100%;
  display: block;
  transition: transform 0.4s ease;
}

/* Overlay escuro */
.gotalks-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.35s ease;
}

/* Ícone play */
.gotalks-overlay i {
  font-size: 40px;
  color: #fff;
  background: rgba(202, 29, 83, 0.9);
  width: 70px;
  height: 70px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 30px rgba(202, 29, 83, 0.6);
  transform: scale(0.85);
  transition: transform 0.35s ease;
}

/* HOVER */
.gotalks-card:hover .gotalks-overlay {
  opacity: 1;
}

.gotalks-card:hover .gotalks-overlay i {
  transform: scale(1);
}

.gotalks-card:hover .blocosgotalks {
  transform: scale(1.05);
}

</style>
<div class="corpogotalks" style="margin-top: 25px; margin-bottom:50px;">
    <div class="container-fluid bannergotalks">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                 <img src="/facelift2/img/gotalkslogo.png" alt="GOtalks" class="logo-gotalks">
                 <p class="subtit">Atualizações e debates sobre temas odontológicos</p>
                </div>
                <div class="col-12 col-lg-6" style="align-self: end;">
                    <div class="gotalks-info-card">
                        <ul>
                            <li>
                            <span class="icon"><i class="fa-solid fa-microphone"></i></span>
                            <span class="text"><strong>+50 episódios</strong></span>
                            </li>
                            <li>
                            <span class="icon"><i class="fa-solid fa-book"></i></span>
                            <span class="text">Baseado em <strong>artigos científicos</strong></span>
                            </li>
                            <li>
                            <span class="icon"><i class="fa-solid fa-comment"></i></span>
                            <span class="text"><strong>Ciência em formato de conversa</strong></span>
                            </li>
                        </ul>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 50px;">
        <p class="titulo">Últimos Epsódios</p>
        <div class="row">
            <div class="col-6 col-lg-3">
                <button type="button" class="btn openModalBtn gotalks-card"
              data-audio-url="https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n5/gotalks/Expans%C3%A3o_r%C3%A1pida_da_maxila_e_seu_impacto_na_apneia_do_sono_em_crian%C3%A7as_de_5_a_8_anos_um_estudo_retrospectivo.mp3"
              data-bs-toggle="modal" data-bs-target="#gotalk" style="padding: 0 !important;">
                <div class="gotalks-thumb">
                  <img class="blocosgotalks" src="/facelift2/img/gt1.png" alt="">
                  <div class="gotalks-overlay">
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
                </button>
            </div>
            <div class="col-6 col-lg-3">
                <button type="button" class="btn openModalBtn gotalks-card"
              data-audio-url="https://artigos.dentalgo.com.br/revistas/Periodontology/2025-1/v35n2/audios/Morbidade_da_%C3%A1rea_doadora_rela.mp3"
              data-bs-toggle="modal" data-bs-target="#gotalk" style="padding: 0 !important;">
                <div class="gotalks-thumb">
                  <img class="blocosgotalks" src="/facelift2/img/gt2.png" alt="">
                  <div class="gotalks-overlay">
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
                </button>
            </div>
            <div class="col-6 col-lg-3">
                <button type="button" class="btn openModalBtn gotalks-card"
              data-audio-url="https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n3/audio/Caracteriza%C3%A7%C3%A3o_fenot%C3%ADpica_da_m%C3%A1_oclus%C3%A3o_de_Classe.mp3"
              data-bs-toggle="modal" data-bs-target="#gotalk" style="padding: 0 !important;">
                <div class="gotalks-thumb">
                  <img class="blocosgotalks" src="/facelift2/img/gt3.png" alt="">
                  <div class="gotalks-overlay">
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
                </button>
            </div>
            <div class="col-6 col-lg-3">
                <button type="button" class="btn openModalBtn gotalks-card"
              data-audio-url="https://artigos.dentalgo.com.br/revistas/DPJO/2025/v30n3/audio/Avalia%C3%A7%C3%A3o_de_longo_prazo_%2810_anos%29_dos_resultados_do_aparelho_funcional_Herbst_nas_dimens%C3%B5es_da_faringe_e_na_posi%C3%A7%C3%A3o_do_osso_hioide.mp3"
              data-bs-toggle="modal" data-bs-target="#gotalk" style="padding: 0 !important;">
                <div class="gotalks-thumb">
                  <img class="blocosgotalks" src="/facelift2/img/gt4.png" alt="">
                  <div class="gotalks-overlay">
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
                </button>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 50px;">
        <p class="titulo">Ouça no Spotify</p>
        <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/1R0SQA5Z68OGGIpcYXiV0s?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
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