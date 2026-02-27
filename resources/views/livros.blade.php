<?php
$todosLivrosG = $livros['livrosG']->rows;
$todosLivros = $livros['livros']->books->rows;
$minhaBiblioteca = $livrosComprados;

?>

<?php
$tipoTopo = 'topoPreto';
?>

@extends('layouts.master')

@section('content')

<!-- <div class="container-fluid produtoTopo produtoTopo livros-banner mobile-display-none">
    <div class="container containerColecao">
        <div class="row">
            <h1 style="display: flex; color: #fff; font-size: 75px; align-items: center;">{{__("messages.LivrosBladeLivros")}}</h1>
        </div>
    </div>
</div>



<div class="container-fluid revistaApoiadoresFundoCol3 mobile-display-none" style="background: #e5e5e5; filter: drop-shadow(0px 2px 2px #9999); margin-bottom: 10px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 revistaApoiadoresCol3"> 
                        <div class="row">
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/Livros.png" style="width: 100%;">
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/Vídeos.png" style="width: 100%;">
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/quandoeondequiser.png" style="width: 100%;">
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/Novosconteúdos.png" style="width: 100%;">
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/especialistas.png" style="width: 100%;">
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="{{ route('home') }}/imagens/iconVantagens/Descontos.png" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!--
<div class="container-fluid revistaApoiadoresFundoCol">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12 revistaApoiadoresCol">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/apoio_institucional.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/biologix.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/fgm.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/sulzer.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<div class="container" style="margin-top: 100px; margin-bottom: 50px;">
    @if($minhaBiblioteca != null)
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12">
            <h1>{{__("messages.LivrosBladeBiblioteca")}}</h1>
        </div>
    </div>

    <div class="row">
        @foreach ($minhaBiblioteca as $key => $revista)
            <article class="col-6 col-md-3 col-lg-2">
                <a href="@if($revista['tipo'] == 'comprado'){{ route('produtocomprado') }}@elseif($revista['tipo'] == 'plano'){{ route('livro') }}@endif/{{ $revista['id'] }}/{{ str_replace(' ', '-', $revista['title']) }}" alt="{{ $revista['title'] }} - {{ $revista['brief'] }}" class="tiraUnderline">
                    <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista['cover'] }}" alt="{{ $revista['title'] }} - {{ $revista['brief'] }}" width="100%" height="auto">
                    <h1 class="colecaoRound">
                        {{ $revista['title'] }}
                    </h1>
                    <p style="display: none !important;">{{ $revista['brief'] }}</p>
                </a>
            </article>
        @endforeach
    </div>
    @endif

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12">
            <h3>{{__("messages.LivrosBladeCourtesy")}}</h3>
        </div>
    </div>

    <div class="row">
        @foreach ($todosLivrosG as $key => $revista)
            @if($revista->subscriberCourtesy == 1)
                @if($revista->id == '1109')
                    <article class="col-6 col-md-3 col-lg-2 d-none">
                        <a href="{{ route('livro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                            <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <h1 class="colecaoRound">
                                {{ $revista->title }}
                            </h1>
                            <p style="display: none !important;">{{ $revista->brief }}</p>
                        </a>
                    </article>
                @else
                    <article class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('livro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                            <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <h1 class="colecaoRound">
                                {{ $revista->title }}
                            </h1>
                            <p style="display: none !important;">{{ $revista->brief }}</p>
                        </a>
                    </article>
                @endif
            @endif
        @endforeach
    </div>

    <div class="row" style="margin-block: 30px;">
        <div class="col-sm-12">
            <h3>{{__("messages.LivrosBladeComprar")}}</h3>
        </div>
    </div>

    <div class="row">
        @foreach ($todosLivros as $key => $revista)
            @if($revista->subscriberCourtesy == null)
                @if($revista->id == '1109')
                    <article class="col-6 col-md-3 col-lg-2 d-none">
                        <a href="{{ route('livro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                            <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <h1 class="colecaoRound">
                                {{ $revista->title }}
                            </h1>
                            <p style="display: none !important;">{{ $revista->brief }}</p>
                        </a>
                    </article>
                @else

                <article class="col-6 col-md-3 col-lg-2">
                    @if($revista->id == '870')
                        <a href="https://novo.dentalpresscursos.com.br/livro_maxilares/" target="_blank" class="tiraUnderline">
                    @else
                        <a href="https://www.dentalpressbooks.com/{{$revista->id}}" target="_blank" class="tiraUnderline">
                    @endif



                    @if($revista->id == '1081')
                        <a href="https://www.dentalpressbooks.com/books/insights-em-ortodontia/" target="_blank" class="tiraUnderline">
                    @elseif($revista->id == '1121')
                        <a href="https://www.dentalpressbooks.com/books/ortodoncia-objetiva/" target="_blank"
                        class="tiraUnderline">
                    @elseif($revista->id == '1131')
                        <a href="https://www.dentalpressbooks.com/books/the-six-elements-orthodontic-philosophy-goals-diagnosis-classification-and-treatment-e-book/" target="_blank"
                        class="tiraUnderline">
                    @elseif($revista->id == '1132')
                        <a href="https://www.dentalpressbooks.com/books/digital-mini-implantes-extra-alveolares-em-aparelhos-fixos-e-alinhadores/" target="_blank"
                        class="tiraUnderline">
                    @else
                        <a href="https://www.dentalpressbooks.com/{{$revista->id}}" target="_blank" class="tiraUnderline">
                    @endif
                        <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                        <h1 class="colecaoRound">
                            {{ $revista->title }}
                        </h1>
                        <p style="display: none !important;">{{ $revista->brief }}</p>
                    </a>
                </article>
                @endif
            @endif
        @endforeach
    </div>

</div>

@endsection