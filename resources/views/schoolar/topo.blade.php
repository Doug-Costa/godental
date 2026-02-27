<header class="header-custom edesktop" style="background-color: #000; z-index:1030;" id="header" >
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-5 " >
      <a class="navbar-brand" href="#">

        
                        @if(isset($schoolar->turmas[0]->instituicao->logo) && !empty($schoolar->turmas[0]->instituicao->logo))
                            <img src="https://scholar.dentalgo.com.br/{{ $schoolar->turmas[0]->instituicao->logo }}" alt="{{ $schoolar->turmas[0]->instituicao->nome ?? 'Logo da Instituição' }}">
        @else
          <img src="{{ asset('imagens/Logo-dentalgo-branca.png') }}" alt="DentalGo" style="height: 40px;">
        @endif
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link active" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/colecoes') }}">Revistas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/videos') }}">Vídeos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/livros') }}">Livros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/school') }}">Materiais Didáticos</a>
          </li>
          <li class="nav-item">
            <div class="search-icon text-white" id="searchToggle" aria-label="Abrir busca">
              <i class="bi bi-search"></i>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="search-container w-100" style="margin-top: 60px;" id="searchContainer">
        <div class="container">
          <form class="d-flex search-form" onsubmit="event.preventDefault(); alert('Busca realizada!')">
            <input type="text" id="searchInput" class="form-control search-input rounded-start" placeholder="Digite sua busca...">
            <button class="btn btn-primary search-btn" type="submit">Buscar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>


<!--MOBILE-->

<header class="header-custom emobile" style="background-color: #000;" id="headerMOBILE" >
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid px-5 " >
      <a class="navbar-brand" href="#">
        @if(isset($schoolar->turmas[0]->instituicao->logo) && !empty($schoolar->turmas[0]->instituicao->logo))
                            <img src="https://scholar.dentalgo.com.br/{{ $schoolar->turmas[0]->instituicao->logo }}" alt="{{ $schoolar->turmas[0]->instituicao->nome ?? 'Logo da Instituição' }}">
        @else
          <img src="{{ asset('imagens/Logo-dentalgo-branca.png') }}" alt="DentalGo" style="height: 40px;">
        @endif
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link active" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/colecoes') }}">Revistas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/videos') }}">Vídeos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/livros') }}">Livros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/school') }}">Materiais Didáticos</a>
          </li>
          <li class="nav-item">
            <div class="search-icon text-white" id="searchToggleMOBILE" aria-label="Abrir busca">
              <i class="bi bi-search"></i>
            </div>
          </li>
                <div class="search-container"id="searchContainerMOBILE" style="z-index: 9999;">
                  <div class="container">
                    <form class="d-flex search-form" onsubmit="event.preventDefault(); alert('Busca realizada!')">
                      <input type="text" id="searchInputMOBILE" class="form-control search-input rounded-start" placeholder="Digite sua busca...">
                      <button class="btn btn-primary search-btn" type="submit">Buscar</button>
                    </form>
                  </div>
                </div>
        </ul>
      </div>
    </div>
  </nav>
</header>
