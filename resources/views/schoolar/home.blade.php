@extends('schoolar.master')

@section('title', 'Minhas Apostilas')

@section('content')
    <!-- Banner Section -->
    <section id="banner-section" class="container-fluid p-0">
      <div id="carouselBanner" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          @if(isset($schoolar->turmas[0]->banners) && count($schoolar->turmas[0]->banners) > 0)
            @foreach($schoolar->turmas[0]->banners as $index => $banner)
              <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                @if($banner->url)
                  <a href="{{ $banner->url }}" target="_blank" style="text-decoration: none; color: inherit;">
                @endif
                <div class="banner" style="background-image: url('http://127.0.0.1:8081{{ $banner->imagem }}');">
                  <div class="overlay"></div>
                  <div class="container">
                    <div class="row justify-content-start align-items-center" style="height: 300px;">
                      <div class="col-md-6">
                        <div class="banner-content">
                          @if($banner->titulo)
                            <h2 style="color: white; font-weight: bold; margin-bottom: 10px;">{{ $banner->titulo }}</h2>
                          @endif
                          @if($banner->descricao)
                            <p style="color: white; font-size: 16px; line-height: 1.4;">{{ $banner->descricao }}</p>
                          @endif
                          <div class="line"></div>
                          @if($banner->url)
                            <div class="mt-3">
                              <span class="btn btn-primary btn-sm">Saiba Mais</span>
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @if($banner->url)
                  </a>
                @endif
              </div>
            @endforeach
          @else
            <!-- Banner padrão quando não há banners da instituição -->
            <div class="carousel-item active">
              <div class="banner" style="background-image: url('{{ asset('schoolar_files/banner.png') }}');">
                <div class="overlay"></div>
                <div class="container">
                  <div class="row justify-content-start align-items-center" style="height: 300px;">
                    <div class="col-md-6">
                      <div class="banner-content">
                        <p>Há 35 anos inspirando</p>
                        <p>DENTISTAS PELO MUNDO</p>
                        <div class="line"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        <!-- Controles do Carousel - só aparecem se há múltiplos banners -->
        @if(isset($schoolar->turmas[0]->banners) && count($schoolar->turmas[0]->banners) > 1)
          <a class="carousel-control-prev" href="#carouselBanner" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
          </a>

          <a class="carousel-control-next" href="#carouselBanner" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
          </a>
        @endif
      </div>
    </section>
    
    <!--Materiais Didaticos-->
    <section class="container-fluid matdid">
      <div class="container">
        <p class="titlematdid">Materiais Didáticos</p>
        <div class="line2"></div>
        
        @if(isset($apostilasPorTurma) && count($apostilasPorTurma) > 0)
          @foreach($apostilasPorTurma as $turmaData)
            @if(count($turmaData['apostilas']) > 0)
              {{-- Título da Turma --}}
              <div class="turma-section" style="margin-bottom: 30px;">
                <h3 class="turma-title" style="color: #2c5aa0; font-family: 'Open Sans', sans-serif; font-weight: bold; font-size: 24px; margin-bottom: 15px; border-bottom: 2px solid #2c5aa0; padding-bottom: 10px;">
                  {{ $turmaData['nome'] }}
                  @if($turmaData['especialidade'])
                    <span style="font-size: 16px; color: #666; font-weight: normal;"> - {{ $turmaData['especialidade'] }}</span>
                  @endif
                </h3>
                
                {{-- Apostilas da Turma --}}
                <div class="row">
                  @foreach($turmaData['apostilas'] as $apostila)
                    <div class="col-md-4 parent">
                      <p class="cardtext" style="font-size: 40px;"></p>
                      @php
                        // Usar a capa real da API
                        $urlCapa = isset($apostila['capa']) ? 'https://scholar.dentalgo.com.br/storage/' . $apostila['capa'] : 'https://scholar.dentalgo.com.br/storage/default-cover.jpg';
                        
                        // Usar rota interna para apostila
                        $urlAPOSTILA = '/apostila/' . $apostila['id'];
                      @endphp
                      <a href="{{ $urlAPOSTILA }}" title="{{ $apostila['nome'] }}">
                         <img style="margin-bottom: 20px;" 
                              src="{{ $urlCapa }}"
                              alt="Capa de {{ $apostila['nome'] }}"
                              class="img-fluid">
                       </a>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
        @else
          {{-- Fallback para o código antigo caso não existam apostilas organizadas --}}
          <div class="row">
            @if(isset($schoolar->aluno->apostilas) && is_array($schoolar->aluno->apostilas))
              @php
                // Ordenar apostilas pela ordem definida na API
                $apostilasOrdenadas = collect($schoolar->aluno->apostilas)->sortBy('ordem');
              @endphp
              @foreach($apostilasOrdenadas as $apostila)
                <div class="col-md-4 parent">
                  <p class="cardtext" style="font-size: 40px;"></p>
                  @php
                    // Usar a capa real da API
                    $urlCapa = isset($apostila->capa) ? 'https://scholar.dentalgo.com.br/storage/' . $apostila->capa : 'https://scholar.dentalgo.com.br/storage/default-cover.jpg';
                    
                    // Usar rota interna para apostila
                    $urlAPOSTILA = '/apostila/' . $apostila->id;
                  @endphp
                  <a href="{{ $urlAPOSTILA }}" title="{{ $apostila->nome }}">
                     <img style="margin-bottom: 20px;" 
                          src="{{ $urlCapa }}"
                          alt="Capa de {{ $apostila->nome }}"
                          class="img-fluid">
                   </a>
                </div>
              @endforeach
            @else
              @foreach($schoolar->turmas as $turma)
                @foreach($turma->apostilas as $vinculo)
                  @php
                    $apostila = $vinculo->apostila;
                  @endphp
                  <div class="col-md-4 parent">
                    <p class="cardtext" style="font-size: 40px;"></p>
                    @php
                        $c = $vinculo->apostila->capa;
                        $urlCapa = 'https://scholar.dentalgo.com.br/storage/'.$c;
                    @endphp
                    @php
                      $idAPOSTILA = $vinculo->apostila->id;
                      $urlAPOSTILA = '/apostila/' .$idAPOSTILA;
                    @endphp
                    <a href=" {{ $urlAPOSTILA }} "><img style="margin-bottom: 20px;" src="{{ $urlCapa }}"
                    alt="Capa de {{ $apostila->nome }}"
                    class="img-fluid"></a>
                  </div>
                @endforeach
              @endforeach
            @endif
          </div>
        @endif
      </div>
    </section>

    <!--revistas-->

    <section class="container-fluid secrevistas">
      <div class="container">
      <p class="titlerevistas">Revistas</p>
      </div>

      <div class="container-fluid">
        <div class="owl-carousel owl-carousel-revistasschoolar">
            @if(isset($ultimasRevistas) && count($ultimasRevistas) > 0)
                @php
                    // Filtra as revistas que não possuem id == 80 (seguindo padrão do DentalGo)
                    $magazinesFiltradas = array_values(array_filter($colecoes[0]->collections->magazines, function($magazine) {
                        return $magazine->id != 80;
                    }));

                    // Define o número máximo de itens a exibir
                    $maxItems = min(count($ultimasRevistas), count($magazinesFiltradas));
                @endphp

                @for ($i = 0; $i < $maxItems; $i++)
                    @php
                        $revista = $magazinesFiltradas[$i];
                        $ultima  = $ultimasRevistas[$i];
                    @endphp
                    <div class="item">
                        <a href="{{ route('revista') }}/{{ $ultima->id }}/{{ str_replace(' ', '-', $ultima->title) }}/{{ $revista->id }}" style="text-decoration: none;">
                            <img src="{{ $revista->lastProductCover }}" alt="{{ $ultima->title }}" class="img-fluid" style="border-radius: 10px;">
                        </a>
                    </div>
                @endfor
            @else
                {{-- Fallback para revistas fixas caso não haja dados dinâmicos --}}
                <div class="item">
                    <a href="https://dentalgo.com.br/revista/1089/Clinical-2025-v24n01/5?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/zIvf1hVQxtstRA4cYhxIQEutDNI=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2025/3/21/474c79c1-779f-4bd4-80ac-3886c91f2958.png" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1083/Journal-2025-v30n1/6?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/mATRgMJhoYAd5cJQaHEln6dFatk=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2025/2/28/1f2ad865-1a43-4050-81a8-39aabfb74e57.PNG" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1086/Orofacial-Harmony-2024-v2n2/67?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/t76x6ggGJI3bDjqGXL_09flgrJM=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2025/3/20/1dfb2097-a9c7-4cc5-ad2e-228a9852b6d0.jpg" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1072/JCDAM-v03n2/79?language=en" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/c_oBLRFq57yDnFbb4jyVSprdl9A=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2024/12/18/678b04c3-bc6a-4fb0-bb56-b36a3ee7c2c8.jpg" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1071/Est%C3%A9tica-%7C-JCDR-2024-v21n3/4?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/Vpbix3_rXOs2bBXdJY9s8O4wfYE=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2024/12/18/5dbfe9c4-cdaa-4bfb-a46c-426a16042fba.png" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1070/JBCOMS-2024-v10n4/1?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/C2oRghHhsCxzjLq3NFTPHrRGIOM=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2025/1/17/429d4abe-da0a-47fe-8d65-b12e970f47f0.png" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1064/Endodontics-2024-v14n3/2?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/0-TUjU2TKLPFoUTx__YVxiFwFhM=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2024/11/27/5b53f619-9bf3-42b7-bbda-3e9e49119829.png" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
                <div class="item">
                    <a href="https://www.dentalgo.com.br/revista/1073/Periodontology-2024-v34n4/50?language=pt" style="text-decoration: none;">
                        <img src="https://thumbor.dentalgo.com.br/uCAzO2TWI5bo4kU95fUStvXLhiI=/fit-in/origx450/https://cloud.dentalgo.com.br/storage/2025/1/6/87513016-c3d7-4b13-a319-3e80771645fb.png" alt="" class="img-fluid" style="border-radius: 10px;">
                    </a>
                </div>
            @endif

        </div>
      </div>


    </section>

    <!--blog-->
    <section class="container-fluid secblog">
      <div class="container">
      <p class="titleblog">Blog<div class="line3"></div></p>
      </div>
      <div class="container">
        <div class="row">
          @if(isset($schoolar->turmas) && count($schoolar->turmas) > 0 && isset($schoolar->turmas[0]->blog_posts))
            @foreach($schoolar->turmas[0]->blog_posts as $index => $post)
              @if($index < 3) {{-- Limita a 3 posts --}}
                <div class="col-lg-4">
                  <div class="card cardblog" style="width: 100%;background-color:black; border-color:#959595;">
                    @if($post->capa)
                                <img class="card-img-top imgblog img-fluid" src="http://127.0.0.1:8081/storage/{{ str_replace('public/', '', $post->capa) }}" alt="{{ $post->titulo }}">
                            @else
                                <img class="card-img-top imgblog img-fluid" src="schoolar_files/blog-default.png" alt="Imagem padrão">
                            @endif
                    <div class="card-body cardbody">
                      <h5 class="card-title titlecardblog">{{ $post->titulo }}</h5>
                      <p class="card-text textcardblog">{{ $post->resumo ?? limita_caracteres($post->texto, 200) }}</p>
                      <a href="{{ route('school.blog', $post->id) }}" class="btn btn-primary btnblog">Saiba mais</a>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          @else
            {{-- Fallback caso não haja posts do blog --}}
            <div class="col-lg-12">
              <div class="card cardblog" style="width: 100%;background-color:black; border-color:#959595;">
                <div class="card-body cardbody">
                  <h5 class="card-title titlecardblog">Nenhum post encontrado</h5>
                  <p class="card-text textcardblog">Não há posts de blog disponíveis no momento.</p>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>    
    </section>


  



@endsection