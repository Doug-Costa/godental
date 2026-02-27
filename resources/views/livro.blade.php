<?php
$paginaTitulo = $revista[0]->title.' - DentalGo';
$padinaDescricao = '';
$tipoTopo = 'topoAzul';

$permicao = $revista[1]->collections;

// Verifica se é um livro cortesia - se for, permite acesso independente das permissões
if(isset($revista[1]->subscriberCourtesy) && $revista[1]->subscriberCourtesy == true){
    $modalConteudo = 'permitido';
}elseif(session()->get('usuarioPermissao') == 'naotem'){
    $modalConteudo = 'espacoParaAssinantes';
}elseif(session()->get('usuarioPermissao') == 'naotemVencido'){
    $dataVencimento = date(session()->get('usuario')->subscription->isValidUntil);
    $dataVencimento = explode('UTC', $dataVencimento);

    $dataAtual = date("Y-m-d");
    if($dataVencimento[0] >= $dataAtual){
        $modalConteudo = 'permitido';
    }else{
        $modalConteudo = 'renoveOplano';
    }
}elseif(session()->get('usuarioPermissao') == 'naotemSemPlano'){
    $modalConteudo = 'vamosAssinar';
}elseif(is_array(session()->get('usuarioPermissao'))){
    $modalConteudo = 'espacoParaAssinantes';
    foreach ($permicao as $key => $value) {
        if(in_array($value->id, session()->get('usuarioPermissao'))){
            $modalConteudo = 'permitido';
        }
    }
}else{
    $modalConteudo = 'espacoParaAssinantes';
}

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

?>
@extends('layouts.master')

@section('content')
<div class="container-fluid revistaTopo produtoTopo{{$idColecao}}">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapa">
            </div>
            <div class="col-md-8">
                
            </div>
        </div>
    </div>
</div>
<div class="container-fluid revistaApoiadoresFundo">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-sm-12 revistaApoiadores">
                        <div class="row">
                            <!--<div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/apoio_institucional.png" alt="{{ $revista[0]->title}}">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/biologix.png" alt="{{ $revista[0]->title}}">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/fgm.png" alt="{{ $revista[0]->title}}">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/sulzer.png" alt="{{ $revista[0]->title}}">
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid revistaTituloFundo">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-8">
                <div class="row revistaTitulo">
                    <h1>{{ $revista[0]->title }}</h1>
                    <br>
                    <!--@if($modalConteudo == 'permitido')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaNaIntegra">
                    @else
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                    @endif
                      {{__("messages.LivroBladeIntegra")}}
                    </button>-->
                </div>
            </div>
        </div>
    </div>
</div> 

@if($modalConteudo == 'permitido')
    <!-- Modal Leia na integra -->
    <div class="modal fade" id="leiaNaIntegra" tabindex="-1" aria-labelledby="leiaNaIntegraLabel" aria-hidden="true">
      <div class="modal-dialog" style="--bs-modal-width: 98%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="leiaNaIntegraLabel">{{ $revista[0]->title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">

            <nav class="navbar navbar-expand-lg p-3 d-lg-none " aria-label="Offcanvas navbar large">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
                    {{__("messages.LivroBladeCapitulos")}}
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbar2Label">{{__("messages.LivroBladeCaps")}}</h5><hr>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                @foreach ($revista[0]->productItems as $capitulo)
                                  <li id="CapM{{ $capitulo->id }}" style="color: #444444; text-decoration: none; font-weight: bold; cursor: pointer;">
                                      {{ $capitulo->title }}
                                    <br><hr>
                                  </li>
                                @endforeach
                            </ul>         
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid" style="height: 100vh;">
              <div class="row" style="height: 100vh;">
                <div class="col-md-3 d-none d-lg-block" style="height: 100vh; overflow-y: auto;">
                  @foreach ($revista[0]->productItems as $capitulo)
                    <span id="Cap{{ $capitulo->id }}" style="color: #444444; text-decoration: none; font-weight: bold; cursor: pointer;">
                        {{ $capitulo->title }}
                    </span>
                    <br><hr>
                  @endforeach
                </div>
                <div class="col-md-12 col-lg-9" style="height: 100vh;">
                    <div class="loadingLivro2" style="padding-top: 150px;">
                        <div class="book col-12">
                            <div class="inner">
                                <div class="left"></div>
                                <div class="middle"></div>
                                <div class="right"></div>
                            </div>
                            <ul>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        <h3 style="text-align: center; margin-top: 25px;">Carregando</h3>
                    </div>
                    <div id="adobe-dc-view"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.LivroBladeFechar")}}</button>
          </div>
        </div>
      </div>
    </div>
@endif

<div class="container">
    <div class="row" style="padding: 40px 0;">
        <div class="col-sm-12">
            <label class="revistaQntArtigos" style="font-size: 40px; font-weight: 900; color: #c9c8c6;">{{ count($revista[0]->productItems) }} {{__("messages.LivroBladeCaps")}}</label>
        </div>
    </div>
    <div class="row">
    @foreach ($revista[0]->productItems as $key => $capitulo)
    <?php
      if($capitulo->cover != null){
          $semImagem = 0;
      }else{
          $semImagem = 1;
      }
      $idArtigo = $capitulo->id; // ID do produto atual no loop foreach
  
      // Procurar o item correspondente no segundo array pelo ID
      $itensCapitulo = null;
      foreach ($revista[2] as $objeto) {
          if ($objeto->id == $idArtigo) {
              $itensCapitulo = $objeto;
              break;
          }
      }
      ?>
      @if($semImagem == 0)
          <article class="row boxbordasComprar">
              <div class="col-md-6 revistaImagemArtigo d-block d-md-none" style="background: url( {{ $capitulo->cover }}) no-repeat center center !important;">
              </div>
              <div class="col-md-6">
                  <h1 class="revistaImagemArtigoh1" style="font-family: 'Montserrat';">{{ $capitulo->title }}</h1>
                  <p class="revistaImagemArtigop" style="font-family: 'Open Sans';">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                  <p class="revistaImagemArtigop1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>

                  <p class="revistaImagemArtigop2" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeKeywords")}}: @foreach ($itensCapitulo->keywords as $key => $keywords){{ $keywords->keyword }}, @endforeach</p>
                  
                  @if($modalConteudo == 'permitido')
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">
                  @else
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                  @endif
                  {{__("messages.RevistaBladeLerArtigo")}}
                    </button>
              </div>
              <div class="col-md-6 revistaImagemArtigo d-none d-md-block" style="background: url( {{ $capitulo->cover }}) no-repeat center center !important;">
              </div>
          </article>
      
      @else
          <article class="row shadowbox-article">
              <div class="col-sm-12">
                  <h1 class="shadowbox-articleh1" style="font-family: 'Montserrat';">{{ $capitulo->title }}</h1>
                  <p class="shadowbox-articlep" style="font-family: 'Open Sans';">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                  <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                  @if($modalConteudo == 'permitido')
                    <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">
                  @else
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                  @endif
                  {{__("messages.RevistaBladeLerArtigo")}}
                    </button>
                </div>
          </article>
      @endif

        <style type="text/css">
            .book {
              --color: #873434;
              --duration: 6.8s;
              width: 32px;
              height: 12px;
              position: relative;
              zoom: 1.5;
              margin: auto;
            }
            .book .inner {
              width: 32px;
              height: 12px;
              position: relative;
              transform-origin: 2px 2px;
              transform: rotateZ(-90deg);
              animation: book var(--duration) ease infinite;
            }
            .book .inner .left,
            .book .inner .right {
              width: 60px;
              height: 4px;
              top: 0;
              border-radius: 2px;
              background: var(--color);
              position: absolute;
            }
            .book .inner .left:before,
            .book .inner .right:before {
              content: "";
              width: 48px;
              height: 4px;
              border-radius: 2px;
              background: inherit;
              position: absolute;
              top: -10px;
              left: 6px;
            }
            .book .inner .left {
              right: 28px;
              transform-origin: 58px 2px;
              transform: rotateZ(90deg);
              animation: left var(--duration) ease infinite;
            }
            .book .inner .right {
              left: 28px;
              transform-origin: 2px 2px;
              transform: rotateZ(-90deg);
              animation: right var(--duration) ease infinite;
            }
            .book .inner .middle {
              width: 32px;
              height: 12px;
              border: 4px solid var(--color);
              border-top: 0;
              border-radius: 0 0 9px 9px;
              transform: translateY(2px);
            }
            .book ul {
              margin: 0;
              padding: 0;
              list-style: none;
              position: absolute;
              left: 50%;
              top: 0;
            }
            .book ul li {
              height: 4px;
              border-radius: 2px;
              transform-origin: 100% 2px;
              width: 48px;
              right: 0;
              top: -10px;
              position: absolute;
              background: #742b2b;
              transform: rotateZ(0deg) translateX(-18px);
              animation-duration: var(--duration);
              animation-timing-function: ease;
              animation-iteration-count: infinite;
            }
            .book ul li:nth-child(0) {
              animation-name: page-0;
            }
            .book ul li:nth-child(1) {
              animation-name: page-1;
            }
            .book ul li:nth-child(2) {
              animation-name: page-2;
            }
            .book ul li:nth-child(3) {
              animation-name: page-3;
            }
            .book ul li:nth-child(4) {
              animation-name: page-4;
            }
            .book ul li:nth-child(5) {
              animation-name: page-5;
            }
            .book ul li:nth-child(6) {
              animation-name: page-6;
            }
            .book ul li:nth-child(7) {
              animation-name: page-7;
            }
            .book ul li:nth-child(8) {
              animation-name: page-8;
            }
            .book ul li:nth-child(9) {
              animation-name: page-9;
            }
            .book ul li:nth-child(10) {
              animation-name: page-10;
            }
            .book ul li:nth-child(11) {
              animation-name: page-11;
            }
            .book ul li:nth-child(12) {
              animation-name: page-12;
            }
            .book ul li:nth-child(13) {
              animation-name: page-13;
            }
            .book ul li:nth-child(14) {
              animation-name: page-14;
            }
            .book ul li:nth-child(15) {
              animation-name: page-15;
            }
            .book ul li:nth-child(16) {
              animation-name: page-16;
            }
            .book ul li:nth-child(17) {
              animation-name: page-17;
            }
            .book ul li:nth-child(18) {
              animation-name: page-18;
            }

            @keyframes page-0 {
              4% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              13%, 54% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              63% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-1 {
              5.86% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              14.74%, 55.86% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              64.74% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-2 {
              7.72% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              16.48%, 57.72% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              66.48% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-3 {
              9.58% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              18.22%, 59.58% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              68.22% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-4 {
              11.44% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              19.96%, 61.44% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              69.96% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-5 {
              13.3% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              21.7%, 63.3% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              71.7% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-6 {
              15.16% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              23.44%, 65.16% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              73.44% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-7 {
              17.02% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              25.18%, 67.02% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              75.18% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-8 {
              18.88% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              26.92%, 68.88% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              76.92% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-9 {
              20.74% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              28.66%, 70.74% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              78.66% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-10 {
              22.6% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              30.4%, 72.6% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              80.4% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-11 {
              24.46% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              32.14%, 74.46% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              82.14% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-12 {
              26.32% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              33.88%, 76.32% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              83.88% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-13 {
              28.18% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              35.62%, 78.18% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              85.62% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-14 {
              30.04% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              37.36%, 80.04% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              87.36% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-15 {
              31.9% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              39.1%, 81.9% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              89.1% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-16 {
              33.76% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              40.84%, 83.76% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              90.84% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-17 {
              35.62% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              42.58%, 85.62% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              92.58% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes page-18 {
              37.48% {
                transform: rotateZ(0deg) translateX(-18px);
              }
              44.32%, 87.48% {
                transform: rotateZ(180deg) translateX(-18px);
              }
              94.32% {
                transform: rotateZ(0deg) translateX(-18px);
              }
            }
            @keyframes left {
              4% {
                transform: rotateZ(90deg);
              }
              10%, 40% {
                transform: rotateZ(0deg);
              }
              46%, 54% {
                transform: rotateZ(90deg);
              }
              60%, 90% {
                transform: rotateZ(0deg);
              }
              96% {
                transform: rotateZ(90deg);
              }
            }
            @keyframes right {
              4% {
                transform: rotateZ(-90deg);
              }
              10%, 40% {
                transform: rotateZ(0deg);
              }
              46%, 54% {
                transform: rotateZ(-90deg);
              }
              60%, 90% {
                transform: rotateZ(0deg);
              }
              96% {
                transform: rotateZ(-90deg);
              }
            }
            @keyframes book {
              4% {
                transform: rotateZ(-90deg);
              }
              10%, 40% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
              }
              40.01%, 59.99% {
                transform-origin: 30px 2px;
              }
              46%, 54% {
                transform: rotateZ(90deg);
              }
              60%, 90% {
                transform: rotateZ(0deg);
                transform-origin: 2px 2px;
              }
              96% {
                transform: rotateZ(-90deg);
              }
            }
        </style>

        @if($modalConteudo == 'permitido')
            <!-- Modal do artigo -->
            <div class="modal fade" id="leiaCapitulo{{$capitulo->id}}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
              <div class="modal-dialog" style="--bs-modal-width: 98%;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="leiaCapitulo{{$capitulo->id}}">{{ $capitulo->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row" style="height: 100vh;">
                        <div class="loadingLivro{{ $capitulo->id}}" style="padding-top: 150px;">
                            <div class="book col-12">
                                <div class="inner">
                                    <div class="left"></div>
                                    <div class="middle"></div>
                                    <div class="right"></div>
                                </div>
                                <ul>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                            <h3 style="text-align: center; margin-top: 25px;">Carregando</h3>
                        </div>
                        <div id="adobe-dc-view{{$capitulo->id}}" class="col-md-12">
                        </div>
                    </div>
                    <script type="text/javascript">
                        document.addEventListener("adobe_dc_view_sdk.ready", function () {
                            document.getElementById("artigoCap{{ $capitulo->id }}").addEventListener("click", function () {
                                showPDF{{ $capitulo->id }}("{{ $capitulo->content }}");
                            });
                        });

                        function showPDF{{ $capitulo->id }}(url) {

                            adobeDCView = new AdobeDC.View({
                                clientId: "509e95046c654d969e54d6c182aceba0",
                                locale: "pt-BR",
                                divId: "adobe-dc-view{{$capitulo->id}}"
                            });

                            adobeDCView.previewFile(
                                {
                                    content: { location: { url: url } },
                                    metaData: { fileName: "{{ $capitulo->title }}.pdf" }
                                },
                                {
                                    embedMode: "FULL_WINDOW",
                                    defaultViewMode: "FIT_WIDTH",
                                    enablePDFAnalytics: true,
                                    showDownloadPDF: false,
                                    showPrintPDF: false,
                                    showLeftHandPanel: true,
                                    showAnnotationTools: false,
                                    focusOnRendering: true
                                }
                            );

                            // Oculta o loading assim que a requisição do SDK for completada
                            document.querySelector('.loadingLivro{{ $capitulo->id}}').style.display = 'none';
                        }
                    </script>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.LivroBladeFechar")}}</button>
                  </div>
                </div>
              </div>
            </div>
        @endif


    @endforeach
</div>
</div>


<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
<script type="text/javascript">
var adobeDCView = null;
  document.addEventListener("adobe_dc_view_sdk.ready", function () {
    showPDF("{{ $revista[0]->productItems[0]->content }}");
    @foreach ($revista[0]->productItems as $capitulo)
      document.getElementById("Cap{{ $capitulo->id }}").addEventListener("click", function () {
        showPDF("{{ $capitulo->content }}");
      })
    @endforeach
    @foreach ($revista[0]->productItems as $capitulo)
      document.getElementById("CapM{{ $capitulo->id }}").addEventListener("click", function () {
        showPDF("{{ $capitulo->content }}");
      })
    @endforeach
  });

  function showPDF(url) {
    adobeDCView = null;
    fetch(url)
      .then((res) => res.blob())
      .then((blob) => {
      adobeDCView = new AdobeDC.View({
        clientId: "509e95046c654d969e54d6c182aceba0",
        //clientId: "2aed258cc30e450db5bc65309da1ad25",
        locale: "pt-BR",
        divId: "adobe-dc-view"
      });
      adobeDCView.previewFile(
        {
          content: { promise: Promise.resolve(blob.arrayBuffer()) },
          metaData: { fileName: url.split("/").slice(-1)[0] }
        },
        {
          embedMode: "FULL_WINDOW",
          defaultViewMode: "FIT_WIDTH",
          enablePDFAnalytics: true,
          showDownloadPDF: false,
          showPrintPDF: false,
          showLeftHandPanel: true,
          showAnnotationTools: false,
          focusOnRendering: true
        }
      );
      // Oculta o loading assim que a requisição do SDK for completada
        document.querySelector('.loadingLivro2').style.display = 'none';

    });
  }

  // Add arrayBuffer if necessary i.e. Safari
  (function () {
    if (Blob.arrayBuffer != "function") {
      Blob.prototype.arrayBuffer = myArrayBuffer;
    }

    function myArrayBuffer() {
      return new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = () => {
          resolve(fileReader.result);
        };
        fileReader.readAsArrayBuffer(this);
      });
    }
  })();
</script>

@endsection
