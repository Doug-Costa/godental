<?php
$paginaTitulo = 'Busca: '.Request()->input('busca').' - DentalGo';
$padinaDescricao = '';
$tipoTopo = 'topoPreto';

$tipoBanner = 'bannerAutor';


function limita_caracteres($texto, $limite, $quebra = true){
   $tamanho = strlen($texto);
   if($tamanho <= $limite){ //Verifica se o tamanho do texto é menor ou igual ao limite
      $novo_texto = $texto;
   }else{ // Se o tamanho do texto for maior que o limite
      if($quebra == true){ // Verifica a opção de quebrar o texto
         $novo_texto = trim(substr($texto, 0, $limite))."...";
      }else{ // Se não, corta $texto na última palavra antes do limite
         $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
         $novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; // Corta o $texto até a posição localizada
      }
   }
   return $novo_texto; // Retorna o valor formatado
}

$buscaFelipina = $busca[1];
$contadorFelipino = $busca[2];
$busca = $busca[0];

?>
@extends('layouts.master')

@section('content')
    

    <div class="container" style="margin-top: 75px; padding: 25px;">
        <div class="row">
            <div class="col-sm-3">
                <form action="{{ route('busca') }}" method="GET" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-group mb-4" style="display:;">
                        <label for="busca">Search:</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" style="width: 70%;" id="busca" name="busca" placeholder="Buscar" value="{{ Request()->input('busca') }}">
                                <button type="submit" id="search-submit" class="search-button">
                                        <p class="botao-pesquisardgo">Pesquisar</p>
                                </button>
                        </div>
                    </div>
                <button class="btn btn-primary d-md-none w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filtroMobile" aria-expanded="false" aria-controls="filtroMobile" style="margin-bottom:15px;">Filtros <span class="fas fa-filter"></span></button>
                <div class="collapse d-md-block" id="filtroMobile">
                    <form action="{{ route('busca') }}" method="GET" enctype="multipart/form-data" >
                        @csrf
                        <button type="submit" class="btn btn-primary w-100" style="margin-bottom: 15px;">Filtrar</button>
                        <div class="form-group">
                          <label for="publishOrder" style="font-weight: bold; margin-bottom: 10px;">Ordem:</label>
                            <div>
                                <label>
                                    <input type="radio" name="publishOrder" value="" checked> Mais relevantes primeiro
                                </label>
                                <label>
                                    <input type="radio" name="publishOrder" value="desc"> Mais recentes primeiro
                                </label>
                                <label>
                                    <input type="radio" name="publishOrder" value="asc"> Mais antigos primeiro
                                </label>
                            </div>
                            <hr>
                        </div>
                        <div class="form-group">
                          <label for="productTypes" style="font-weight: bold; margin-bottom: 10px;">Buscar Por:</label><br>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="magazine" name="q[productTypes][]" value="magazine" <?php if($contadorFelipino->productTypes->magazine > 0){echo 'checked';}?>>
                            <label class="form-check-label" for="magazine">Revistas {{$contadorFelipino->productTypes->magazine}}</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="book" name="q[productTypes][]" value="book" <?php if($contadorFelipino->productTypes->book > 0){echo 'checked';}?>>
                            <label class="form-check-label" for="book">Capitulos de livros {{$contadorFelipino->productTypes->book}}</label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="video" name="q[productTypes][]" value="video" <?php if($contadorFelipino->productTypes->video > 0){echo 'checked';}?>>
                            <label class="form-check-label" for="video">Videos {{$contadorFelipino->productTypes->video}}</label>
                          </div>
                          <hr>
                        </div>
                        <div class="form-group">
                            <label for="collectionIds" style="font-weight: bold; margin-bottom: 10px;">Resultado por coletâneas:</label><br>
                            @foreach ($buscaColecoes as $colecao)
                            <?php
                            $quantidade = $contadorFelipino->collections->{$colecao->id};
                            ?>
                                <div class="form-check" style="padding-bottom: 5px; border-bottom:1px dashed #b3b3b3; ">
                                    <input class="form-check-input" type="checkbox" id="colecao{{$colecao->id}}" name="q[collectionIds][]" value="{{$colecao->id}}" <?php if($quantidade > 0){echo 'checked';}?>>
                                    <label class="form-check-label" for="colecao{{$colecao->id}}"> {{$colecao->title}} {{$quantidade}}</label>
                                </div>
                            @endforeach
                            <hr>
                        </div>
                        <!-- Language -->
                        <div class="mb-3">
                            <label for="languages" style="font-weight: bold; margin-bottom: 10px;">Idiomas:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="languageEn" name="q[languages][]" value="en" checked>
                                <label for="languageEn" class="form-check-label">Inglês</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="languageEs" name="q[languages][]" value="es" checked>
                                <label for="languageEs" class="form-check-label">Espanhol</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="languagePt" name="q[languages][]" value="pt" checked>
                                <label for="languagePt" class="form-check-label">Portugues</label>
                            </div>
                            <hr>
                        </div>
                        <!-- Submit button -->
                        
                    </form>
                </form>
                </div>

            </div>
            <div class="col-sm-9">
                <ul class="nav nav-tabs centerTab" id="myTab" role="tablist">
                  <li class="nav-item centerTab" role="presentation">
                    <button class="nav-link buscaLink active" id="artigos-tab" data-bs-toggle="tab" data-bs-target="#artigos" type="button" role="tab" aria-controls="artigos" aria-selected="true"><span>{{ count($busca['magazine']) }}</span> {{__("messages.SearchBladeArtigos")}}</button>
                  </li>
                  <li class="nav-item centerTab" role="presentation">
                    <button class="nav-link buscaLink" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false"><span>{{ count($busca['video']) }}</span>{{__("messages.SearchBladeVideos")}}</button>
                  </li>
                  <li class="nav-item centerTab" role="presentation">
                    <button class="nav-link buscaLink" id="livros-tab" data-bs-toggle="tab" data-bs-target="#livros" type="button" role="tab" aria-controls="livros" aria-selected="false"><span>{{ count($busca['book']) }}</span> {{__("messages.SearchBladeLivros")}}</button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- TAB ARTIGOS -->
                    <div class="tab-pane fade show active" id="artigos" role="tabpanel" aria-labelledby="artigos-tab">
                        @foreach ($busca['magazine'] as $key => $artigo)
                            <article class="col-12 autorListaArtigo">
                                <div class="row" style="margin-top: 25px;">
                                    <div class="col-sm-4">
                                        @if(!$artigo['cover'])
                                            <img src="{{ $artigo['cover_produto'] }}" alt="{{ $artigo['title_produto'] }}" class="img-fluid">
                                        @else
                                            <img src="{{ $artigo['cover'] }}" alt="{{ $artigo['title'] }}" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="col-sm-8">
                                        <h1 style="font-size: 1.5rem; text-align: justify; margin-bottom: 10px;">{{ $artigo['title'] }}</h1>
                                        <a href="{{ route('revista') }}/{{ $artigo['id_produto'] }}">
                                            <h2 style="font-size: 1rem; font-style: italic;">{{ $artigo['title_produto'] }}</h2>
                                        </a>
                                        @if(!$artigo['brief'])
                                            <p style="text-align: justify;">{{ limita_caracteres(strip_tags($artigo['brief_produto']), 300, false) }}</p>
                                        @else
                                            <p style="text-align: justify;">{{ limita_caracteres(strip_tags($artigo['brief']), 300, false) }}</p>
                                        @endif
                                        <p>Autores: @foreach ($artigo['authors'] as $key => $autor)<a href="{{ route('busca') }}?busca={{ $autor->name }}">{{ $autor->name }}</a>,  @endforeach</p>
                                        <a type="button" class="btn btn-primary" href="{{ route('artigo') }}/{{ $artigo['id_produto'] }}/{{ str_replace(' ', '-', $artigo['title_produto']) }}/{{ $artigo['id_artigo'] }}/{{ str_replace(' ', '-', $artigo['title']) }}">{{__("messages.SearchBladeRead")}}</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- TAB VIDEOS -->
                    <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                        @foreach ($busca['video'] as $key => $video)
                            <article class="col-12 autorListaArtigo">
                                <div class="row">
                                    <div class="col-sm-4">
                                        @if(!$video['cover'])
                                            <img src="{{ $video['cover_produto'] }}" alt="{{ $video['title_produto'] }}" class="img-fluid">
                                        @else
                                            <img src="{{ $video['cover'] }}" alt="{{ $video['title'] }}" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="col-sm-8">
                                        <h1>{{ $video['title'] }}</h1>
                                        <h2>{{ $video['title_produto'] }}</h2>
                                        @if(!$video['brief'])
                                            <p>{{ limita_caracteres(strip_tags($video['brief_produto']), 300, false) }}</p>
                                        @else
                                            <p>{{ limita_caracteres(strip_tags($video['brief']), 300, false) }}</p>
                                        @endif
                                        <p>Autores: @foreach ($video['authors'] as $key => $autor)<a href="{{ route('busca') }}?busca={{ $autor->name }}">{{ $autor->name }}</a>,  @endforeach</p>
                                        <a type="button" class="btn btn-primary" href="{{ route('video') }}/{{ $video['id_produto'] }}/{{ str_replace(' ', '-', $video['title_produto']) }}/{{ $video['id_artigo'] }}">{{__("messages.SearchBladeWacth")}}</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <!-- TAB LIVROS -->
                    <div class="tab-pane fade" id="livros" role="tabpanel" aria-labelledby="livros-tab">
                        @foreach ($busca['book'] as $key => $book)
                            <article class="col-12 autorListaArtigo">
                                <div class="row">
                                    <div class="col-sm-4">
                                        @if(!$book['cover'])
                                            <img src="{{ $book['cover_produto'] }}" alt="{{ $book['title_produto'] }}" class="img-fluid">
                                        @else
                                            <img src="{{ $book['cover'] }}" alt="{{ $book['title'] }}" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="col-sm-8">
                                        <h1>{{ $book['title'] }}</h1>
                                        <h2>{{ $book['title_produto'] }}</h2>
                                        @if(!$book['brief'])
                                            <p>{{ limita_caracteres(strip_tags($book['brief_produto']), 300, false) }}</p>
                                        @else
                                            <p>{{ limita_caracteres(strip_tags($book['brief']), 300, false) }}</p>
                                        @endif
                                        <p>Autores: @foreach ($book['authors'] as $key => $autor) <a href="{{ route('busca') }}?busca={{ $autor->name }}">{{ $autor->name }}</a>,  @endforeach</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        .buscaLink {
            color: #666;
        }
        .buscaLink:hover {
            color: #000 !important;
        }
    </style>





@endsection