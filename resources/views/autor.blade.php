<?php
$tipoTopo = 'topoVerde';

$tipoBanner = 'bannerAutor';



?>
@extends('layouts.master')

@section('content')


    <div class="container-fluid produtoTopo">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $autor[0]->photoURL }}" alt="{{ $autor[0]->name}}" class="revistaCapa">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>{{ $autor[0]->name }}</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 autorContagem">
                            <p>{{__("messages.AuthorBladeConteudo")}}</p>
                            <ul>
                                <li>{{ count($autor[1]['magazine']) }} {{__("messages.AuthorBladeArtigos")}}</li>
                                <li>{{ count($autor[1]['video']) }} {{__("messages.AuthorBladeVideos")}}</li>
                                <li>{{ count($autor[1]['book']) }} {{__("messages.AuthorBladeLivros")}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                {{ $autor[0]->resumes[0]->resume}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs centerTab" id="myTab" role="tablist">
              <li class="nav-item centerTab" role="presentation">
                <button class="nav-link active" id="artigos-tab" data-bs-toggle="tab" data-bs-target="#artigos" type="button" role="tab" aria-controls="artigos" aria-selected="true">Artigos</button>
              </li>
              <li class="nav-item centerTab" role="presentation">
                <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false">Vídeos</button>
              </li>
              <li class="nav-item centerTab" role="presentation">
                <button class="nav-link" id="livros-tab" data-bs-toggle="tab" data-bs-target="#livros" type="button" role="tab" aria-controls="livros" aria-selected="false">Livros</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- TAB ARTIGOS -->
                <div class="tab-pane fade show active" id="artigos" role="tabpanel" aria-labelledby="artigos-tab">
                    @foreach ($autor[1]['magazine'] as $key => $artigo)
                        <article class="col-12 autorListaArtigo">
                            <div class="row">
                                <div class="col-sm-4">
                                    @if(!$artigo['cover'])
                                        <img src="{{ $artigo['cover_produto'] }}" alt="{{ $artigo['title_produto'] }}" class="img-fluid">
                                    @else
                                        <img src="{{ $artigo['cover'] }}" alt="{{ $artigo['title'] }}" class="img-fluid">
                                    @endif
                                </div>
                                <div class="col-sm-8">
                                    <h1>{{ $artigo['title'] }}</h1>
                                    <h2>{{ $artigo['title_produto'] }}</h2>
                                    @if(!$artigo['brief'])
                                        <p>{{ $artigo['brief_produto'] }}</p>
                                    @else
                                        <p>{{ $artigo['brief'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <!-- TAB VIDEOS -->
                <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                    @foreach ($autor[1]['video'] as $key => $video)
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
                                        <p>{{ $video['brief_produto'] }}</p>
                                    @else
                                        <p>{{ $video['brief'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <!-- TAB LIVROS -->
                <div class="tab-pane fade" id="livros" role="tabpanel" aria-labelledby="livros-tab">
                    @foreach ($autor[1]['book'] as $key => $book)
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
                                        <p>{{ $book['brief_produto'] }}</p>
                                    @else
                                        <p>{{ $book['brief'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>





@endsection


@section('api')
<?php
print_r($autor);
?>
@endsection