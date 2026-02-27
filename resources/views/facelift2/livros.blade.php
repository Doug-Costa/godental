<?php
$todosLivrosG = $livros['livrosG']->rows;
$todosLivros = $livros['livros']->books->rows;
$minhaBiblioteca = $livrosComprados;

?>

<?php
$tipoTopo = 'topoPreto';
?>

@extends('facelift2.master')

@section('content')

<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    @if($minhaBiblioteca != null)
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12">
            <h1 class="titulogeral">{{__("messages.LivrosBladeBiblioteca")}}</h1>
        </div>
    </div>

    <div class="row">
        @foreach ($minhaBiblioteca as $key => $revista)
            <article class="col-6 col-md-3 col-lg-2">
                <a href="@if($revista['tipo'] == 'comprado'){{ route('faceprodutocomprado') }}@elseif($revista['tipo'] == 'plano'){{ route('facelivro') }}@endif/{{ $revista['id'] }}/{{ str_replace(' ', '-', $revista['title']) }}" alt="{{ $revista['title'] }} - {{ $revista['brief'] }}" class="titulolivros">
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
            <h3 class="titulogeral">{{__("messages.LivrosBladeCourtesy")}}</h3>
        </div>
    </div>

    <div class="row">
        @foreach ($todosLivrosG as $key => $revista)
            @if($revista->subscriberCourtesy == 1)
                @if($revista->id == '1109')
                    <article class="col-6 col-md-3 col-lg-2 d-none">
                        <a href="{{ route('facelivro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="titulolivros">
                            <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <h1 class="colecaoRound">
                                {{ $revista->title }}
                            </h1>
                            <p style="display: none !important;">{{ $revista->brief }}</p>
                        </a>
                    </article>
                @else
                    <article class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('facelivro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="titulolivros">
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
            <h3 class="titulogeral">{{__("messages.LivrosBladeComprar")}}</h3>
        </div>
    </div>

    <div class="row">
        @foreach ($todosLivros as $key => $revista)
            @if($revista->subscriberCourtesy == null)
                @if($revista->id == '1109')
                    <article class="col-6 col-md-3 col-lg-2 d-none">
                        <a href="{{ route('facelivro') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}" alt="{{ $revista->title }} - {{ $revista->brief }}" class="titulolivros">
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
                        <a href="https://novo.dentalpresscursos.com.br/livro_maxilares/" target="_blank" class="titulolivros">
                    @else
                        <a href="https://www.dentalpressbooks.com/{{$revista->id}}" target="_blank" class="titulolivros">
                    @endif



                    @if($revista->id == '1081')
                        <a href="https://www.dentalpressbooks.com/books/insights-em-ortodontia/" target="_blank" class="titulolivros">
                    @elseif($revista->id == '1121')
                        <a href="https://www.dentalpressbooks.com/books/ortodoncia-objetiva/" target="_blank"
                        class="titulolivros">
                    @elseif($revista->id == '1131')
                        <a href="https://www.dentalpressbooks.com/books/the-six-elements-orthodontic-philosophy-goals-diagnosis-classification-and-treatment-e-book/" target="_blank"
                        class="titulolivros">
                    @elseif($revista->id == '1132')
                        <a href="https://www.dentalpressbooks.com/books/digital-mini-implantes-extra-alveolares-em-aparelhos-fixos-e-alinhadores/" target="_blank"
                        class="titulolivros">
                    @else
                        <a href="https://www.dentalpressbooks.com/{{$revista->id}}" target="_blank" class="titulolivros">
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