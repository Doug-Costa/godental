<a class="visually-hidden-focusable skiplink" href="#conteudo">Pular para o conteúdo</a>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<aside class="sidebar" id="sidebar" aria-label="Menu lateral">

  <header>
    <div class="d-flex align-items-center gap-2 brandmark">
      <a href="{{ route('facehome') }}" style="display: flex; align-items: center;">
        <img src="{{ asset('facelift2/img/logo_main.png') }}" alt="DentalGo Logo"
          style="display: block; width: 150px !important; height: 50px !important; max-width: none !important; object-fit: contain; margin-top: -5px; margin-bottom: -5px;">
      </a>
    </div>
    <button class="btn btn-sm btn-light" id="btnCloseSidebar" aria-label="Fechar menu lateral"><i
        class="bi bi-x-lg"></i></button>
  </header>
  <nav class="mt-1 border-bottom">
    <form class="d-lg-none mt-2 search-top" role="search" method="GET" action="#" aria-label="Busca global">
      <div class="input-group">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
        <input name="q" class="form-control border-start-0" type="search" placeholder="Pesquisar..."
          aria-label="Buscar">
      </div>
    </form>

    <div class="mt-2 d-flex flex-column gap-1">
      <a href="{{ route('facehome') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('facehome') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('facehome') ? 'color: #d21d5b;' : '' }}">
        <i class="bi bi-house me-2"></i> Home
      </a>
      <a href="{{ route('gointelligence.index') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('gointelligence.*') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('gointelligence.*') ? 'color: #d21d5b;' : '' }}">
        <i class="fa-solid fa-robot me-2" style="font-size: 0.9em;"></i> Go Intelligence
      </a>
      <a href="{{ route('facecolecoes') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('facecolecoes', 'facecolecao') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('facecolecoes', 'facecolecao') ? 'color: #d21d5b;' : '' }}">
        <i class="bi bi-journal-richtext me-2"></i> Revistas
      </a>
      <a href="{{ route('facevideos') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('facevideos') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('facevideos') ? 'color: #d21d5b;' : '' }}">
        <i class="bi bi-play-circle me-2"></i> Vídeos
      </a>
      <a href="{{ route('facelivros') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('facelivros') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('facelivros') ? 'color: #d21d5b;' : '' }}">
        <i class="bi bi-book me-2"></i> Livros
      </a>
      <a href="{{ route('facecanais') }}"
        class="btn btn-light text-start border-0 fw-semibold {{ request()->routeIs('facecanais') ? 'bg-white shadow-sm' : '' }}"
        style="{{ request()->routeIs('facecanais') ? 'color: #d21d5b;' : '' }}">
        <i class="bi bi-briefcase me-2"></i> Canais
      </a>

      <div class="crm-group">
        <div class="d-flex align-items-center">
          <a href="{{ route('consultas.hub') }}"
            class="btn btn-light text-start border-0 fw-semibold flex-grow-1 {{ request()->routeIs('consultas.hub') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('consultas.hub') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-hospital me-2"></i> Go Clinic
          </a>
          <button class="btn btn-light border-0 px-2" data-bs-toggle="collapse" href="#collapseCRM" role="button"
            aria-expanded="{{ request()->routeIs('consultas.*', 'patients.*', 'agenda.*', 'kanban.*', 'dashboard.*', 'admin.*') && !request()->routeIs('consultas.hub') ? 'true' : 'false' }}"
            aria-controls="collapseCRM">
            <i class="bi bi-chevron-down small"></i>
          </button>
        </div>
        <div
          class="collapse {{ request()->routeIs('consultas.*', 'patients.*', 'agenda.*', 'kanban.*', 'dashboard.*', 'admin.*') && !request()->routeIs('consultas.hub') ? 'show' : '' }} ps-3"
          id="collapseCRM">
          <a href="{{ route('consultas.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 mt-1 {{ request()->routeIs('consultas.index') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('consultas.index') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-grid-1x2 me-2"></i> Consultas
          </a>
          <a href="{{ route('agenda.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('agenda.index') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('agenda.index') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-calendar3 me-2"></i> Agenda
          </a>
          <a href="{{ route('patients.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('patients.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('patients.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-people-fill me-2"></i> Pacientes
          </a>
          <a href="{{ route('kanban.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('kanban.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('kanban.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-kanban me-2"></i> Kanban
          </a>
          <a href="{{ route('dashboard.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('dashboard.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('dashboard.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-graph-up-arrow me-2"></i> Dashboard
          </a>
          <a href="{{ route('admin.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('admin.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('admin.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-gear-fill me-2"></i> Administração
          </a>
          <a href="{{ route('financial.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('financial.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('financial.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-cash-coin me-2"></i> Financeiro
          </a>
          <a href="{{ route('marketing.index') }}"
            class="btn btn-light text-start border-0 fw-semibold w-100 {{ request()->routeIs('marketing.*') ? 'bg-white shadow-sm text-accent' : '' }}"
            style="{{ request()->routeIs('marketing.*') ? 'color: #d21d5b;' : '' }}">
            <i class="bi bi-megaphone me-2"></i> Marketing / Vendas
          </a>
        </div>
      </div>
      <a href="#" class="btn btn-light text-start border-0 fw-semibold" style="display:none;">
        <i class="bi bi-star me-2"></i> Clube de vantagem
      </a>
      <a href="#" class="btn btn-light text-start border-0 fw-semibold" style="display:none;">
        <i class="bi bi-info-circle me-2"></i> Sobre
      </a>
      <a href="https://wa.me/554430339812" class="btn btn-light text-start border-0 fw-semibold" style="display:yes;">
        <i class="bi bi-info-circle me-2"></i> Fale conosco
      </a>
    </div>
  </nav>
  <div class="mt-3 pt-1 border-top">
    <div class="muted mb-2 ps-3 fw-bold text-secondary" style="font-size: 0.8rem;">ACESSO</div>
    @if(null == session()->get('token'))
      <div class="d-grid gap-2 px-2">
        <a class="btn btn-light border" data-bs-toggle="modal"
          data-bs-target="#modalLogin">{{__("messages.TopoMenuAcess")}} <i class="bi bi-box-arrow-in-right ms-2"></i></a>
        <a class="btn btn-dark text-white border-0" style="background-color: #d21d5b; border-color: #d21d5b;"
          href="https://www.dentalgo.com.br/checkoutnovo">{{__("messages.TopoMenuAssine")}} <i
            class="bi bi-star-fill ms-2"></i></a>
      </div>
    @else
      <?php  $usuario = session()->get("usuario"); ?>
      <div class="px-3 mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-person-circle fs-4 text-secondary"></i>
        <span class="fw-semibold">
          @if(session()->get('tipoUsuario') == 'schoolar')
            {{ is_array($usuario) ? $usuario['aluno']['nome'] : $usuario->aluno->nome }}
          @else
            {{ $usuario->fullName }}
          @endif
        </span>
      </div>
      <nav class="mt-1">
        <?php  if (in_array(session()->get('usuarioPermissao'), ['naotem', 'naotemVencido', 'naotemSemPlano'])): ?>
        <a href="#" data-bs-toggle="modal" data-bs-target="#ModalGift"><i class="bi bi-gift"></i>
          {{__("messages.TopoMenuGift")}}</a>
        <?php  endif; ?>
        <?php  if (session()->get('tipoUsuario') == 'pessoal'): ?>
        <a href="{{ route('minhaconta') }}"><i class="bi bi-person-gear"></i> {{__("messages.TopoMenuMinhaConta")}}</a>
        <?php  endif; ?>
        <a href="{{ route('logout') }}" class="text-danger"><i class="bi bi-box-arrow-left"></i>
          {{__("messages.TopoMenuSair")}}</a>
      </nav>
    @endif
  </div>
</aside>

<div class="topbar py-2">
  <div class="container-fluid">
    <div class="d-flex align-items-center gap-3">
      <button class="hamburger" id="btnSidebar" aria-label="Abrir menu lateral" aria-expanded="false"
        aria-controls="sidebar" aria-selected="true">
        <span class="bar"></span>
      </button>
      <div class="d-flex align-items-center gap-2 brandmark">
        <a href="{{ route('facehome') }}" style="display: flex; align-items: center;" aria-label="DentalGo - Início">
          <img class="logodentalgotopo" src="{{ asset('facelift2/img/logo_main.png') }}"
            style="display: block; width: 190px !important; height: 65px !important; max-width: none !important; object-fit: contain; margin-top: -12px; margin-bottom: -12px; margin-left: 10px;">
        </a>
      </div>

      <!-- Busca Desktop (>= 992px) -->
      <form class="d-none d-lg-flex search-top divpesquisarform" role="search" method="GET"
        action="{{ route('busca-elastic25') }}" enctype="multipart/form-data" aria-label="Busca global"
        style="min-width: 420px;">
        @csrf
        <div class="input-group divpesquisar">
          <input name="q" class="form-control border-end-0" type="search" placeholder="Pesquisar..."
            aria-label="Buscar">
          <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        </div>
      </form>

      <!-- Botão de Busca Mobile Expansível (< 992px) -->
      <button class="btn btn-light d-lg-none mobile-search-toggle" id="mobileSearchToggle" aria-label="Buscar"
        type="button">
        <i class="bi bi-search"></i>
      </button>

      <!-- Campo de Busca Mobile Expansível -->
      <form class="mobile-search-form d-lg-none" id="mobileSearchForm" role="search" method="GET"
        action="{{ route('busca-elastic25') }}" enctype="multipart/form-data" aria-label="Busca mobile">
        @csrf
        <div class="input-group">
          <input name="q" class="form-control" type="search" placeholder="Pesquisar..." aria-label="Buscar"
            id="mobileSearchInput">
          <button class="btn btn-light" type="button" id="closeMobileSearch" aria-label="Fechar busca">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </form>
      <!-- <div class="d-none d-lg-flex align-items-center gap-2">
          <a href="#" class="btn btn-outline-secondary btn-sm">Entrar</a>
          <a href="#" class="btn btn-accent btn-sm">Assinar</a>
        </div> -->
      <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 text-secondary" href="#"
            id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-globe"></i>
            <span class="d-none d-md-inline">
              {{session()->has('lang_code') ? (session()->get('lang_code') == 'pt' ? 'PT-BR' : '') : ''}}
              {{session()->has('lang_code') ? (session()->get('lang_code') == 'en' ? 'EN' : '') : ''}}
              {{session()->has('lang_code') ? (session()->get('lang_code') == 'es' ? 'ES' : '') : ''}}
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarDropdownLang">
            <li><a onclick="changeLanguage('pt')"
                class="dropdown-item {{session()->has('lang_code') ? (session()->get('lang_code') == 'pt' ? 'active fw-bold' : '') : ''}}">PT-BR</a>
            </li>
            <li><a onclick="changeLanguage('en')"
                class="dropdown-item {{session()->has('lang_code') ? (session()->get('lang_code') == 'en' ? 'active fw-bold' : '') : ''}}">English</a>
            </li>
            <li><a onclick="changeLanguage('es')"
                class="dropdown-item {{session()->has('lang_code') ? (session()->get('lang_code') == 'es' ? 'active fw-bold' : '') : ''}}">Español</a>
            </li>
          </ul>
        </li>

        @if(null == session()->get('token'))
          <li class="nav-item">
            <a class="nav-link btn btn-sm btn-light px-3 fw-semibold text-dark" data-bs-toggle="modal"
              data-bs-target="#modalLogin">
              <i class="bi bi-box-arrow-in-right d-sm-none"></i>
              <span class="d-none d-sm-inline">{{__("messages.TopoMenuAcess")}}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-sm px-3 fw-semibold text-white"
              style="background-color: #d21d5b; border-color: #d21d5b;" href="https://www.dentalgo.com.br/checkoutnovo">
              <i class="bi bi-star-fill d-sm-none"></i>
              <span class="d-none d-sm-inline">{{__("messages.TopoMenuAssine")}}</span>
            </a>
          </li>
        @endif

        @if(null !== session()->get('token'))
          <?php  $usuario = session()->get("usuario"); ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark" href="#" id="navbarDropdownUser"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-5"></i>
              <span class="d-none d-md-inline fw-semibold">
                @if(session()->get('tipoUsuario') == 'schoolar')
                  {{ is_array($usuario) ? $usuario['aluno']['nome'] : $usuario->aluno->nome }}
                @else
                  {{ $usuario->fullName }}
                @endif
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarDropdownUser">
              <?php  if (in_array(session()->get('usuarioPermissao'), ['naotem', 'naotemVencido', 'naotemSemPlano'])): ?>
              <li><a class="dropdown-item" data-bs-toggle="modal"
                  data-bs-target="#ModalGift">{{__("messages.TopoMenuGift")}}</a></li>
              <?php  endif; ?>
              <?php  if (session()->get('tipoUsuario') == 'pessoal'): ?>
              <li><a class="dropdown-item" href="{{ route('minhaconta') }}">{{__("messages.TopoMenuMinhaConta")}}</a></li>
              <?php  endif; ?>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">{{__("messages.TopoMenuSair")}}</a>
              </li>
            </ul>
          </li>
        @endif
      </ul>

    </div>
    <!-- <form class="d-lg-none mt-2 search-top" role="search" method="GET" action="#" aria-label="Busca global">
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
          <input name="q" class="form-control border-start-0" type="search" placeholder="Buscar artigos, temas, autores…" aria-label="Buscar">
        </div>
      </form> -->
  </div>
</div>
@if($errors->any() || (session()->get('plano') == 277 && request()->input('plano') == 277))
  <div class="container mt-2"
    style="margin-top: 100px !important; position: fixed; z-index: 9999; max-width: unset; display: flex; justify-content: center;">
    @foreach ($errors->all() as $error)
      @if($error == 'logado')
        <div class="alert alert-success alert-dismissable alert-fade" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertSucess")}}
        </div>
      @elseif($error == 'senhaRedefinida')
        <div class="alert alert-success alert-dismissable alert-fade" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertRecSenhaSucess")}}
        </div>
      @elseif($error == 'logadoVencido')
        <div class="alert alert-warning" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertVencido")}} <a href="https://www.dentalgo.com.br/checkoutnovo" type="button"
            class="btn btn-danger">{{__("messages.AlertVencidoRenovar")}}</a>
        </div>
      @elseif($error == 'logadoSem')
        <div class="alert alert-info" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertNoPlan")}} <a href="https://www.dentalgo.com.br/checkoutnovo" type="button"
            class="btn btn-danger">{{__("messages.AlertNoPlanAssinar")}}</a>
        </div>
      @elseif($error == 'errousuario')
        <div class="alert alert-danger alert-fade" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertUser")}}
        </div>
      @elseif($error == 'errosenha')
        <div class="alert alert-danger" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertSenha")}}
        </div>
      @elseif($error == 'errosenhaNova')
        <div class="alert alert-danger" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertSenhaNova")}}
        </div>
      @elseif($error == 'erroCadastro')
        <div class="alert alert-danger" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertErroCadastro")}}<a href="#" type="button"
            class="btn btn-danger">{{__("messages.AlertErrorContato")}}</a>
        </div>
      @elseif($error == 'cadastroSucesso')
        <div class="alert alert-info" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertCadastroSucess")}} <a href="{{ route('assinatura') }}" type="button"
            class="btn btn-danger">{{__("messages.AlertCadastroAssinar")}}</a>
        </div>
      @elseif($error == 'crieSeuCadastro')
        <div class="alert alert-info" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertExclusive")}}<a href="https://www.dentalgo.com.br/checkoutnovo" type="button"
            class="btn btn-danger">{{__("messages.AlertCrieCadastroAssine")}}</a>
        </div>
      @elseif($error == 'recSenhaSucess')
        <div class="alert alert-info alert-fade" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertRecSenhas")}}
        </div>
      @elseif($error == 'recSenhaErro')
        <div class="alert alert-danger alert-fade" role="alert"
          style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
          {{__("messages.AlertUserNaoLocalizado")}}
        </div>
      @endif
    @endforeach

    <!-- script para sumir com a mensagem após 4 segundos -->
    <script>     setTimeout(function () { var fadeAlerts = document.querySelectorAll('.alert-fade'); fadeAlerts.forEach(function (alert) { alert.style.transition = "opacity 0.5s"; alert.style.opacity = 0; setTimeout(function () { alert.style.display = "none"; }, 500); }); }, 4000); // 4 segundos
    </script>

    @if(session()->get('plano') == 277 && request()->input('plano') == 277)
      <div class="alert alert-success alert-dismissable" role="alert"
        style="text-align: center; font-weight: bold; box-shadow: 0 0 5px 1px; min-width: 70%;">
        Parabéns você recebeu 20% de desconto da Alado de R$98 por R$78 <a href="{{ route('cadastrar') }}" type="button"
          class="btn btn-danger">{{__("messages.AlertCadastroAssinar")}}</a>
      </div>
    @endif
  </div>
@endif
<div class="page">

  <div class="container">
    <div class="row divbotao d-none d-sm-flex">
      <div class="col"><a href="{{ route('facehome') }}"
          class="btn btn-light mod-button nav-btn {{ request()->routeIs('facehome') ? 'active' : '' }}">Principal</a>
      </div>
      <div class="col"><a href="{{ route('facevideos') }}"
          class="btn btn-light mod-button nav-btn {{ request()->routeIs('facevideos') ? 'active' : '' }}">Vídeos</a>
      </div>
      <div class="col"><a href="{{ route('facecolecoes') }}"
          class="btn btn-light mod-button nav-btn {{ request()->routeIs('facecolecoes') ? 'active' : '' }}">Revistas</a>
      </div>
      <div class="col"><a href="{{ route('facelivros') }}"
          class="btn btn-light mod-button nav-btn {{ request()->routeIs('facelivros') ? 'active' : '' }}">Livros</a>
      </div>
      <div class="col"><a href="{{ route('facecanais') }}"
          class="btn btn-light mod-button nav-btn {{ request()->routeIs('facecanais') ? 'active' : '' }}">Canais</a>
      </div>
    </div>

  </div>