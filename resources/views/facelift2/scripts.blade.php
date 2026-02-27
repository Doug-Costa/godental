<script>
  // Sidebar open/close
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebarBackdrop');
  const btnOpen = document.getElementById('btnSidebar');
  const btnClose = document.getElementById('btnCloseSidebar');
  function setSidebar(open) {
    document.documentElement.classList.toggle('sidebar-open', open);
    backdrop.hidden = !open; // Mostra backdrop quando aberto
    btnOpen.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (open) { sidebar.focus?.(); }
  }
  btnOpen.addEventListener('click', () => setSidebar(!document.documentElement.classList.contains('sidebar-open')));
  btnClose.addEventListener('click', () => setSidebar(false));
  backdrop.addEventListener('click', () => setSidebar(false)); // Fecha ao clicar no backdrop

  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') setSidebar(false) });

  // ===========================
  // BUSCA MOBILE EXPANSÍVEL
  // ===========================
  const mobileSearchToggle = document.getElementById('mobileSearchToggle');
  const mobileSearchForm = document.getElementById('mobileSearchForm');
  const closeMobileSearch = document.getElementById('closeMobileSearch');
  const mobileSearchInput = document.getElementById('mobileSearchInput');

  if (mobileSearchToggle && mobileSearchForm) {
    // Abrir busca mobile
    mobileSearchToggle.addEventListener('click', () => {
      mobileSearchForm.classList.add('active');
      // Focar no input após animação
      setTimeout(() => mobileSearchInput?.focus(), 300);
    });

    // Fechar busca mobile
    if (closeMobileSearch) {
      closeMobileSearch.addEventListener('click', () => {
        mobileSearchForm.classList.remove('active');
      });
    }

    // Fechar com ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && mobileSearchForm.classList.contains('active')) {
        mobileSearchForm.classList.remove('active');
      }
    });
  }

  // ===========================
  // TOUCH GESTURES (SWIPE)
  // ===========================
  let touchStartX = 0;
  let touchEndX = 0;
  let touchStartY = 0;
  let touchEndY = 0;
  const minSwipeDistance = 50; // pixels mínimos para detectar swipe

  document.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
  }, { passive: true });

  document.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    touchEndY = e.changedTouches[0].screenY;
    handleSwipe();
  }, { passive: true });

  function handleSwipe() {
    const swipeDistanceX = touchEndX - touchStartX;
    const swipeDistanceY = Math.abs(touchEndY - touchStartY);

    // Só detecta swipe horizontal se movimento vertical for pequeno
    if (swipeDistanceY < 100) {
      // Swipe da esquerda para direita (abrir sidebar)
      if (swipeDistanceX > minSwipeDistance && touchStartX < 50) {
        setSidebar(true);
      }
      // Swipe da direita para esquerda (fechar sidebar)
      else if (swipeDistanceX < -minSwipeDistance && document.documentElement.classList.contains('sidebar-open')) {
        setSidebar(false);
      }
    }
  }

  // Carrosséis horizontais (Novidades/Docs/Talks)
  function setupScrollCarousel(items) {
    const buttons = items.parentElement.querySelectorAll('.nav-arrows [data-scroll]');
    const calc = () => { const f = items.querySelector(':scope > *'); const w = f ? f.getBoundingClientRect().width : 320; return w + 16; };
    buttons.forEach(btn => { btn.addEventListener('click', () => { const dir = parseInt(btn.getAttribute('data-dir'), 10) || 1; items.scrollBy({ left: dir * calc(), behavior: 'smooth' }); }); });
  }
  document.querySelectorAll('.scroll-carousel .items').forEach(items => setupScrollCarousel(items));
  document.querySelectorAll('.scroll-carousel .items').forEach(items => {
    let isDown = false, startX = 0, scrollStart = 0;
    items.addEventListener('pointerdown', (e) => { isDown = true; items.setPointerCapture(e.pointerId); startX = e.clientX; scrollStart = items.scrollLeft; });
    window.addEventListener('pointerup', () => { isDown = false; });
    window.addEventListener('pointercancel', () => { isDown = false; });
    items.addEventListener('pointermove', (e) => { if (!isDown) return; items.scrollLeft = scrollStart - (e.clientX - startX); });
  });


  //botaooutline
  const botoes = document.querySelectorAll('.meu-botao');
  botoes.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();            // evita submit se estiver em <form>
      botoes.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
    });
  });

  //carrosseis
  document.addEventListener('DOMContentLoaded', () => {
    // cada carrossel descrito em um objeto
    const sliders = [
      {
        name: 'novrevista',
        selector: '.my-slider',
        options: {
          items: 5,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 3 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 4 },
            1350: { items: 5 },
            1920: { items: 6 },
          }
        }
      },
      {
        name: 'dentalgoacademy',
        selector: '.my-slider1',
        options: {
          items: 5,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 4 },
            1350: { items: 5 },
            1920: { items: 6 },
          }
        }
      },
      {
        name: 'godocs',
        selector: '.my-slider2',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 4 },
            1350: { items: 5 },
            1920: { items: 6 },
          }
        }
      },
      {
        name: 'gotalks',
        selector: '.my-slider3',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 2 },
            768: { items: 3 },
            1200: { items: 4 }
          }
        }
      },
      {
        name: 'blocos',
        selector: '.my-slider4',
        options: {
          items: 5,
          gutter: 15,
          edgePadding: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'propaganda',
        selector: '.my-slider5',
        options: {
          items: 1,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          navPosition: 'bottom',

        }
      },
      {
        name: 'congressosprop',
        selector: '.my-slider6',
        options: {
          items: 1,
          autoplay: false,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false
        }
      },
      {
        name: 'drops',
        selector: '.my-slider7',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'navespecialidades',
        selector: '.my-slider8',
        options: {
          items: 4,
          gutter: 20,
          edgePadding: 0,
          autoplay: false,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          loop: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 3 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'GoCast',
        selector: '.my-slider9',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'congressodgoorto',
        selector: '.my-slider10',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'entrevistashistoricas',
        selector: '.my-slider11',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'entrevistas',
        selector: '.my-slider12',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },

      {
        name: 'dicasmecorto',
        selector: '.my-slider13',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 }
          }
        }
      },
      {
        name: 'solucoesortokleber',
        selector: '.my-slider14',
        options: {
          items: 4,
          gutter: 12,
          autoplay: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          controls: false,
          nav: false,
          responsive: {
            0: { items: 2 },
            576: { items: 3 },
            768: { items: 4 },
            1200: { items: 5 },
          }
        }
      },
      {
        name: 'slidercanais',
        selector: '.my-slider15',
        options: {
          items: 4,
          gutter: 50,
          container: '.carrossellogocanais',
          autoplay: true,
          center: true,
          mouseDrag: true,
          autoplayButtonOutput: false,
          slideBy: 1,
          controls: false,
          edgePadding: 100,
          autoplayTimeout: 3500, // intervalo entre animações (ms)
          speed: 5000,           // duração da transição (ms)
          nav: false,
          loop: true,
          rewind: false,
          responsive: {
            0: { items: 2, edgePadding: 0 },
            576: { items: 2, edgePadding: 100 },
            768: { items: 2, edgePadding: 150 },
            992: { items: 2, edgePadding: 150 },
            1200: { items: 3, edgePadding: 150 },
            1300: { items: 3, edgePadding: 200 },
            1500: { items: 3, edgePadding: 250 },
            1700: { items: 3, edgePadding: 300 },
            1920: { items: 3, edgePadding: 200 },
          }
        }
      },
      {
        name: 'sliderlogocolecao',
        selector: '.my-slider16',
        options: {
          items: 6,
          gutter: 0,
          autoplay: true,
          mouseDrag: true,
          loop: true,
          autoplayButtonOutput: false,
          speed: 4000,
          autoplayTimeout: 3000,
          slideBy: 1,
          controls: false,
          edgePadding: 0,
          rewind: false,
          center: false,
          nav: false,

          responsive: {
            0: { items: 2, gutter: 0 },    /* Mobile: 2 items (Big & Visible) */
            576: { items: 3, gutter: 0 },
            992: { items: 5, gutter: 0 },
            1200: { items: 4, gutter: 0 },
          }
        }
      }



    ];






    // inicializa apenas os que existem na página
    sliders.forEach(slider => {
      const el = document.querySelector(slider.selector);
      if (el) {
        tns({
          container: el,
          slideBy: 1,        // padrão pra todos
          ...slider.options  // espalha as opções específicas
        });
        console.log(`Carrossel iniciado: ${slider.name}`);
      }
    });
  });

  // inicializa o menu hamburg automaticamente
  window.addEventListener("DOMContentLoaded", () => {
    if (window.innerWidth > 991) {
      document.getElementById("btnSidebar").click();
    }
  });

  // filtroacademy

  const cardacademyContainer = document.getElementById('lista');
  const botaodiv = document.querySelectorAll('.botaodiv button, .limparfiltros');
  const limpar = document.querySelector('.limparfiltros');

  if (cardacademyContainer) {
    const conteudoacademy = Array.from(cardacademyContainer.children);
    const DUR = 400;

    botaodiv.forEach(btn => {
      btn.addEventListener('click', () => {
        const ativo = btn.classList.toggle('ativo');
        botaodiv.forEach(b => b !== btn && b.classList.remove('ativo'));
        filtrar(ativo ? btn.dataset.filter : 'tudo');
        if (limpar) {
            limpar.style.display = document.querySelector('.botaodiv button.ativo') ? 'flex' : 'none';
        }
      });
    });

    if (limpar) {
      limpar.addEventListener('click', () => {
        botaodiv.forEach(b => b.classList.remove('ativo'));
        filtrar('tudo');
        limpar.style.display = 'none';
      });
    }

    function filtrar(tag) {
      cardacademyContainer.classList.add('fade-out');
      setTimeout(() => {
        conteudoacademy.forEach(cardacademy => {
          if (tag === 'tudo' || cardacademy.dataset.tag === tag) {
            cardacademy.style.display = 'block';
          } else {
            cardacademy.style.display = 'none';
          }
        });
        void cardacademyContainer.offsetWidth;
        cardacademyContainer.classList.remove('fade-out');
        cardacademyContainer.classList.add('fade-in');
        setTimeout(() => {
          cardacademyContainer.classList.remove('fade-in');
        }, DUR);
      }, DUR);
    }
  }
</script>