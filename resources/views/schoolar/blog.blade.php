@extends('schoolar.master')

@section('title', $post->titulo)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header do Blog -->
            <div class="blog-header text-center py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
                <div class="container">
                    <h1 class="text-white mb-3">{{ $post->titulo }}</h1>
                    <div class="blog-meta text-light">
                        @if($post->categoria)
                            <span class="badge badge-primary me-2">{{ $post->categoria->nome }}</span>
                        @endif
                        <span class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Conteúdo do Blog -->
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Imagem de Capa -->
                        @if($post->capa)
                            <div class="blog-image mb-4">
                                <img src="http://127.0.0.1:8081/storage/{{ str_replace('public/', '', $post->capa) }}" 
                                     alt="{{ $post->titulo }}" 
                                     class="img-fluid rounded shadow">
                            </div>
                        @endif

                        <!-- Resumo -->
                        @if($post->resumo)
                            <div class="blog-summary mb-4">
                                <div class="alert alert-light border-left-primary">
                                    <h5 class="text-primary mb-2">Resumo</h5>
                                    <p class="mb-0">{{ $post->resumo }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Conteúdo Principal -->
                        <div class="blog-content">
                            <div class="content-body">
                                {!! $post->texto !!}
                            </div>
                        </div>

                        <!-- Botão Voltar -->
                        <div class="text-center mt-5">
                            <a href="{{ url('/school') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Voltar para Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.blog-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.blog-content p {
    margin-bottom: 1.5rem;
}

.blog-image img {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
}

.blog-meta .badge {
    font-size: 0.9rem;
}

.content-body {
    text-align: justify;
    background-color: #ffffff;
}
</style>
@endsection