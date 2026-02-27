<script>
// Fix para abas da página de resultados da busca (Bootstrap 5)
// Garante a troca de conteúdo ao clicar em Vídeos/Livros
(function() {
  document.addEventListener('DOMContentLoaded', function() {
    var tabContainer = document.getElementById('resultTabs');
    if (!tabContainer || !(window.bootstrap && bootstrap.Tab)) return;

    tabContainer.addEventListener('click', function(e) {
      var btn = e.target.closest('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]');
      if (!btn) return;
      var tab = new bootstrap.Tab(btn);
      tab.show();
    });
  });
})();
</script>
<script>
// Scroll infinito para busca.resultado (abas Artigos/Vídeos/Livros)
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    var containerTabs = document.getElementById('resultTabs');
    var contentTabs = document.getElementById('resultTabsContent');
    if(!containerTabs || !contentTabs) return;

    var isLoading = false;
    var currentPageByTab = { articles: 1, videos: 1, books: 1 };

    // Glassmorphism loader (overlay) for infinite scroll
    (function ensureInfiniteGlassLoaderCSS(){
      if(document.getElementById('infinite-glass-css')) return;
      var css = "\n        .infinite-glass-loader{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);z-index:2147483000;display:flex;align-items:center;justify-content:center;width:clamp(260px,50vw,520px);height:88px;pointer-events:none;opacity:1;transition:opacity .25s ease, transform .25s ease;}\n        .infinite-glass-loader.is-hidden{opacity:0;transform:translateX(-50%) translateY(6px) scale(.98);} \n        .infinite-glass-loader .igl-blob{position:absolute;width:240px;height:240px;border-radius:50%;filter:blur(24px);opacity:.35;}\n        .infinite-glass-loader .igl-blob.igl-blob-1{background:radial-gradient( circle at 30% 30%, rgba(86,217,254,.9), rgba(149,114,252,.55) 60%, rgba(86,217,254,0) 70% );animation:igl-float-1 6s ease-in-out infinite;}\n        .infinite-glass-loader .igl-blob.igl-blob-2{background:radial-gradient( circle at 70% 70%, rgba(255,94,244,.85), rgba(86,217,254,.5) 55%, rgba(255,94,244,0) 75% );animation:igl-float-2 7.5s ease-in-out infinite;}\n        .infinite-glass-loader .igl-card{position:relative;display:flex;gap:16px;align-items:center;backdrop-filter:blur(14px) saturate(140%);-webkit-backdrop-filter:blur(14px) saturate(140%);background:rgba(20,20,30,0.45);border:1px solid rgba(255,255,255,0.18);border-radius:16px;padding:16px 18px;width:100%;box-shadow:0 10px 30px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.06);overflow:hidden;}\n        .infinite-glass-loader .igl-card::after{content:\"\";position:absolute;inset:-1px;pointer-events:none;background:linear-gradient(120deg, rgba(255,255,255,.08) 20%, rgba(255,255,255,.18) 40%, rgba(255,255,255,0) 60%);transform:translateX(-100%);animation:igl-glint 2.4s ease-in-out infinite;}\n        .infinite-glass-loader .igl-ring{width:40px;height:40px;border-radius:50%;background:conic-gradient(from 0turn, #56d9fe, #9572fc, #ff5ef4, #56d9fe);mask:radial-gradient(farthest-side, transparent calc(100% - 5px), #000 0);-webkit-mask:radial-gradient(farthest-side, transparent calc(100% - 5px), #000 0);animation:igl-spin 1s linear infinite;filter:drop-shadow(0 2px 8px rgba(149,114,252,.5));}\n        .infinite-glass-loader .igl-text{color:#e9f0ff;font-size:14px;letter-spacing:.2px;text-shadow:0 1px 1px rgba(0,0,0,.25);} \n        @keyframes igl-spin{to{transform:rotate(1turn);}}\n        @keyframes igl-float-1{0%{transform:translate(-40px,0) scale(1);}50%{transform:translate(40px,6px) scale(1.05);}100%{transform:translate(-40px,0) scale(1);}}\n        @keyframes igl-float-2{0%{transform:translate(30px,6px) scale(1);}50%{transform:translate(-30px,-6px) scale(1.06);}100%{transform:translate(30px,6px) scale(1);}}\n        @keyframes igl-glint{0%{transform:translateX(-120%);}60%{transform:translateX(110%);}100%{transform:translateX(110%);}}\n        @media (max-width: 576px){.infinite-glass-loader{width:92vw;height:80px;bottom:16px;}}\n        @media (prefers-reduced-motion: reduce){.infinite-glass-loader .igl-ring{animation-duration:1.8s}.infinite-glass-loader .igl-blob,.infinite-glass-loader .igl-card::after{animation:none}}\n      ";
      var style = document.createElement('style');
      style.id = 'infinite-glass-css';
      style.textContent = css;
      document.head.appendChild(style);
    })();

    // FX avançados: brilho animado, partículas, glitches e animação de saída (glass shatter)
    (function ensureInfiniteGlassFXCSS(){
      if(document.getElementById('infinite-glass-css-fx')) return;
      var css2 = `
        /* Portal futurista: borda com glow dinâmico e estética glass */\n        .infinite-glass-loader .igl-card{background:rgba(18,20,28,0.42); border:1px solid rgba(255,255,255,0.18);}\n        .infinite-glass-loader .igl-card::before{content:\"\";position:absolute;inset:-1.5px;border-radius:inherit;pointer-events:none;background:conic-gradient(from 0turn at 50% 50%, rgba(86,217,254,0), rgba(86,217,254,.75), rgba(149,114,252,.8), rgba(255,94,244,.75), rgba(86,217,254,0));filter:blur(10px);animation:igl-orbit 3.2s linear infinite;opacity:.9;}\n        @keyframes igl-orbit{to{transform:rotate(1turn);}}\n\n        /* Círculo líquido (vidro fluido) dentro do anel */\n        .infinite-glass-loader .igl-ring{position:relative;width:46px;height:46px;border-radius:50%;background:conic-gradient(from 0turn, #56d9fe, #9572fc, #ff5ef4, #56d9fe);mask:radial-gradient(farthest-side, transparent calc(100% - 6px), #000 0);-webkit-mask:radial-gradient(farthest-side, transparent calc(100% - 6px), #000 0);filter:drop-shadow(0 2px 10px rgba(149,114,252,.5));}
        .infinite-glass-loader .igl-liquid{position:absolute;inset:4px;border-radius:50%;background:radial-gradient(120% 100% at 30% 30%, rgba(255,255,255,.6) 0, rgba(255,255,255,.12) 40%, rgba(255,255,255,0) 62%), conic-gradient(from 0turn, rgba(86,217,254,.85), rgba(149,114,252,.9), rgba(255,94,244,.85), rgba(86,217,254,.85));mask:radial-gradient(farthest-side, #0000 54%, #000 56%);-webkit-mask:radial-gradient(farthest-side, #0000 54%, #000 56%);animation:igl-liquid-spin 1.6s cubic-bezier(.22,.61,.36,1) infinite;mix-blend-mode:screen;}
        @keyframes igl-liquid-spin{0%{transform:rotate(0) scale(1);}50%{transform:rotate(180deg) scale(1.02);}100%{transform:rotate(360deg) scale(1);}}\n\n        /* Fragmentos/glitches geométricos (Assassin's Creed vibe) */\n        .infinite-glass-loader .igl-frag{position:absolute;width:22px;height:12px;border-radius:2px;background:linear-gradient(90deg, rgba(149,114,252,.65), rgba(255,94,244,.3));opacity:.55;filter:blur(.3px);mix-blend-mode:screen;animation:igl-frag-glitch 1.8s steps(2,end) infinite;}
        .infinite-glass-loader .igl-frag.f1{top:10px;right:18px;transform:skewX(-12deg);} 
        .infinite-glass-loader .igl-frag.f2{bottom:12px;left:22px;animation-duration:2.2s;transform:skewX(10deg);} 
        .infinite-glass-loader .igl-frag.f3{top:50%;left:calc(50% + 24px);width:16px;height:8px;animation-duration:1.6s;} 
        @keyframes igl-frag-glitch{0%{transform:translateX(-2px) skewX(-6deg);}50%{transform:translateX(2px) skewX(4deg);}100%{transform:translateX(-2px) skewX(-6deg);}}\n\n        /* Partículas luminosas atravessando a faixa */\n        .infinite-glass-loader .igl-particle{position:absolute;width:6px;height:6px;border-radius:50%;background:radial-gradient(circle,#ffffff, rgba(255,255,255,.25) 60%, rgba(255,255,255,0) 70%);box-shadow:0 0 8px rgba(149,114,252,.8), 0 0 14px rgba(86,217,254,.55);left:-10%;opacity:0;filter:blur(.2px);animation:igl-dash 3s cubic-bezier(.22,.61,.36,1) infinite;}
        @keyframes igl-dash{0%{transform:translateX(0) translateY(0) scale(.85);opacity:0;}10%{opacity:1;}80%{opacity:.95;}100%{transform:translateX(120%) translateY(var(--y,0px)) scale(1.05);opacity:0;}}\n\n        /* Animação de saída (distorção digital / vidro quebrando) */\n        .infinite-glass-loader.is-hiding .igl-card{animation:igl-outro 420ms cubic-bezier(.22,.61,.36,1) forwards;}
        @keyframes igl-outro{0%{filter:none;clip-path:inset(0% round 16px);transform:translateY(0) scale(1);opacity:1;}35%{filter:blur(1px) saturate(140%);transform:translateY(2px) scale(1.02) skewX(-1deg);}60%{clip-path:polygon(0 0,100% 0,100% 35%,0 50%);transform:translateY(-2px) scale(.995);}100%{clip-path:polygon(0 0,100% 0,100% 0,0 0);opacity:0;transform:translateY(6px) scale(.96);filter:blur(2px) saturate(60%);}}\n\n        @media (prefers-reduced-motion: reduce){.infinite-glass-loader .igl-liquid{animation-duration:2.4s}.infinite-glass-loader .igl-frag{animation:none}.infinite-glass-loader.is-hiding .igl-card{animation-duration:0ms}}
      `;
      var st = document.createElement('style');
      st.id = 'infinite-glass-css-fx';
      st.textContent = css2;
      document.head.appendChild(st);
    })();

    var iglLoader = (function createInfiniteGlassLoader(){
      var n = document.createElement('div');
      n.className = 'infinite-glass-loader is-hidden';
      n.setAttribute('role', 'status');
      n.setAttribute('aria-live', 'polite');
      n.innerHTML = "\n        <div class=\"igl-blob igl-blob-1\"></div>\n        <div class=\"igl-blob igl-blob-2\"></div>\n        <div class=\"igl-card\">\n          <div class=\"igl-ring\" aria-hidden=\"true\"><div class=\"igl-liquid\"></div></div>\n          <div class=\"igl-text\"><strong>Carregando</strong> mais conteúdos...</div>\n          <div class=\"igl-frag f1\"></div>\n          <div class=\"igl-frag f2\"></div>\n          <div class=\"igl-frag f3\"></div>\n          <div class=\"igl-particle\" style=\"--y:-6px; animation-delay:.2s\"></div>\n          <div class=\"igl-particle\" style=\"--y:4px; animation-delay:.9s\"></div>\n          <div class=\"igl-particle\" style=\"--y:-2px; animation-delay:1.4s\"></div>\n          <div class=\"igl-particle\" style=\"--y:6px; animation-delay:2s\"></div>\n        </div>\n      ";
      document.body.appendChild(n);
      return n;
    })();

    var loaderVisibleAt = 0;
    var loaderMinShowMs = 450; // evita flicker
    function showLoader(){ loaderVisibleAt = Date.now(); iglLoader.classList.remove('is-hidden'); iglLoader.classList.remove('is-hiding'); }
    function hideLoader(){ var elapsed = Date.now() - loaderVisibleAt; var wait = Math.max(0, loaderMinShowMs - elapsed); setTimeout(function(){ iglLoader.classList.add('is-hiding'); setTimeout(function(){ iglLoader.classList.add('is-hidden'); iglLoader.classList.remove('is-hiding'); }, 450); }, wait); }

    function activeTabId(){
      var activeBtn = containerTabs.querySelector('.nav-link.active');
      if(!activeBtn) return 'articles';
      var target = activeBtn.getAttribute('data-bs-target') || '';
      if(target === '#videos') return 'videos';
      if(target === '#books') return 'books';
      return 'articles';
    }

    function paneByTab(tab){
      if(tab === 'videos') return document.getElementById('videos');
      if(tab === 'books') return document.getElementById('books');
      return document.getElementById('articles');
    }

    function totalForTab(tab){
      var btn = document.getElementById(tab + '-tab');
      var total = btn ? parseInt(btn.getAttribute('data-total') || '0', 10) : 0;
      return isNaN(total) ? 0 : total;
    }

    function pageSize(){
      var sizeAttr = contentTabs.getAttribute('data-size');
      var s = parseInt(sizeAttr || '10', 10);
      return isNaN(s) ? 10 : s;
    }

    function buildAjaxUrl(tab, page){
      var base = window.location.pathname.indexOf('busca-elastic-filtrada') !== -1 ? '/busca-elastic-filtrada' : '/busca-elastic';
      var params = new URLSearchParams(window.location.search);
      params.set('page', page);
      params.set('size', pageSize());
      params.set('tab', tab);
      return base + '?' + params.toString();
    }

    function hasMore(tab){
      var total = totalForTab(tab);
      var loaded = paneByTab(tab).querySelectorAll('.card.mb-3').length;
      return loaded < total; // enquanto não carregou tudo
    }

    function loadNextPage(){
      if(isLoading) return;
      var tab = activeTabId();
      if(!hasMore(tab)) return;

      isLoading = true;
      showLoader();
      var nextPage = (currentPageByTab[tab] || 1) + 1;
      var url = buildAjaxUrl(tab, nextPage);

      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, credentials: 'same-origin' })
        .then(async function(r){
          try{
            var ct = (r.headers && r.headers.get) ? (r.headers.get('content-type') || '') : '';
            if(ct.indexOf('application/json') !== -1){
              return r.json();
            }
            var text = await r.text();
            try { return JSON.parse(text); } catch(parseErr){
              return { error: 'non-json', status: r.status, text: text };
            }
          }catch(e){
            return { error: 'response-parse-failed', detail: String(e) };
          }
        })
        .then(function(data){
          if(data && data.html){
            paneByTab(tab).insertAdjacentHTML('beforeend', data.html);
            currentPageByTab[tab] = nextPage;
          } else if(data && data.error){
            console.warn('Infinite scroll: non-JSON or error payload', data);
          }
          if(data && data.hasMore === false){
            var loaded = paneByTab(tab).querySelectorAll('.card.mb-3').length;
            var btn = document.getElementById(tab + '-tab');
            if(btn){ btn.setAttribute('data-total', String(loaded)); }
          }
        })
        .catch(function(err){ console.error('Infinite scroll error', err); })
        .finally(function(){ isLoading = false; hideLoader(); });
    }

    // Observa troca de abas (pode ajustar sentinela se necessário)
    containerTabs.addEventListener('shown.bs.tab', function(){
      hideLoader();
      // noop por enquanto
    });

    // Interseção com sentinela no fim do conteúdo
    var sentinel = document.createElement('div');
    sentinel.className = 'infinite-sentinel';
    contentTabs.appendChild(sentinel);

    if('IntersectionObserver' in window){
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
          if(entry.isIntersecting){ loadNextPage(); }
        });
      }, { rootMargin: '400px' });
      io.observe(sentinel);
    } else {
      // fallback por scroll
      window.addEventListener('scroll', function(){
        if((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 600)){
          loadNextPage();
        }
      });
    }
  });
})();
</script>