<?php
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

@extends('schoolar.master')

</style>
@section('content')
<div class="container-fluid revistaTopo produtoTopo5  retirarbordamobile" > 

@php
    // 1) Lista de IDs permitidos (sua string original)
    $idsCsv    = '78,84,85,86,88,89,90,91,93,94,95,96,97,98,99,100,101,102,103,104,105';
    $idsPermit = array_map('intval', explode(',', $idsCsv));

    // 2) Captura o ID da URL — ajuste o segment() se necessário
    $urlId     = (int) request()->segment(2);
@endphp

{{-- Se o ID da URL não estiver nem na lista, já encerra com erro --}}
@if (! in_array($urlId, $idsPermit, true))
    <h2 style="color:#fff;">Apostila não encontrada.</h2>
@else
    {{-- Caso esteja permitido, percorre normalmente as turmas e apostilas --}}
    @foreach($schoolar->turmas as $turma)
      @foreach($turma->apostilas as $vinculo)
        @php
          $apostila = $vinculo->apostila;
          $capitulo = $vinculo->capitulos
        @endphp

        @php
          // pega o valor nao cuzido (cu) (string ou array)
          $cu = is_array($capitulo)
            ? ($capitulo['idioma'] ?? '')
            : ($capitulo->idioma   ?? '');

          // garante que $idiomas seja um array
          $idiomas = is_array($cu)
            ? $cu
            : explode(',', $cu);
        @endphp

        {{-- Só renderiza se for exatamente a apostila da URL --}}
        @if ($apostila->id === $urlId)
          <div class="row titulo-clinical">
            <div class="col-5"></div>
            <div class="col-4 outroteste">
              <div class="borda-titulo">
                <a href="https://dentalgo.com.br/school" class="link-titulo">
                  <h1 class="revistatitulo-decoration testando123">{{ $apostila->nome }}</h1>
                </a>
              </div>
            </div>
          </div>
          
          <div class="container capamobile">
            <div class="row">
              <div class="col-12 col-lg-3 col-md-10 col-sm-6 center ">
                @php
                  $c      = $apostila->capa;
                  $urlCapa = 'https://scholar.dentalgo.com.br/storage/'.$c;
                @endphp
                <img src="{{ $urlCapa }}" alt="{{ $apostila->nome }}" class="revistaCapaAbsolute">
              </div>
            </div>
          </div>
</div>
<div class="container-fluid" style="background-color: #fff;">
        <div class="container" style="background-color: #fff;">
          <div class="row espacamentointerno-revista">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-12">
                      <ul class="nav nav-tabs centerTab"  style="margin-top: 50px;"id="myTab" role="tablist">
                        <li class="nav-item centerTab" role="presentation">
                            @if($apostila->idioma == 'pt')
                              <button class="nav-link buscaLink @if($apostila->idioma == 'pt') active @endif" id="portugues-tab" data-bs-toggle="tab" data-bs-target="#portugues" type="button" role="tab" aria-controls="portugues" aria-selected="true">{{__("messages.IdiomaBladePt")}}</button>
                            @else
                              <button class="nav-link buscaLink disabled button-off" id="portugues-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladePt")}}</button>
                            @endif
                        </li>
                        <li class="nav-item centerTab" role="presentation">
                            @if($apostila->idioma == 'es')
                                <button class="nav-link buscaLink @if($apostila->idioma == 'es') active @endif" id="espanhol-tab" data-bs-toggle="tab" data-bs-target="#espanhol" type="button" role="tab" aria-controls="espanhol" aria-selected="false">{{__("messages.IdiomaBladeEs")}}</button>
                            @else
                                <button class="nav-link buscaLink disabled button-off" id="espanhol-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladeEs")}}</button>
                            @endif
                        </li>
                        <li class="nav-item centerTab" role="presentation">
                            @if($apostila->idioma =='en')
                                <button class="nav-link buscaLink @if($apostila->idioma == 'en') active @endif" id="ingles-tab" data-bs-toggle="tab" data-bs-target="#ingles" type="button" role="tab" aria-controls="ingles" aria-selected="false">{{__("messages.IdiomaBladeEn")}}</button>
                            @else
                                <button class="nav-link buscaLink disabled button-off" id="ingles-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladeEn")}}</button>
                            @endif
                        </li>
                    </ul>
                      <div class="tab-content" id="myTabContent">
                          <!-- TAB PORTUGUES -->
                          <div class="tab-pane fade @if($apostila->idioma == 'pt') show active @endif" id="portugues" role="tabpanel" aria-labelledby="portugues-tab">
                              <!-- Conteúdo da aba em português -->
                              @if($apostila->idioma == 'pt')
                                @foreach($vinculo->capitulos as $capitulo)
                                  <article class="row boxbordasComprar">
                                    <div class="col-md-8">
                                      <h1 class="revistaImagemArtigoh1">
                                        {{ $capitulo->nome }}
                                      </h1>
                                      <p class="revistaImagemArtigop">
                                        {{ limita_caracteres(strip_tags($capitulo->descricao_capitulo), 300, false) }}
                                      </p>
                                      @php
                                        $c      = $capitulo->arquivo_pdf;
                                        $urlPDF = 'https://scholar.dentalgo.com.br/storage/'.$c;
                                      @endphp
                                    <button
                                      type="button"
                                      id="artigoCap{{ $capitulo->id }}"
                                      class="btn btn-primary"
                                      data-bs-toggle="modal"
                                      data-bs-target="#leiaCapitulo{{ $capitulo->id }}">
                                      {{ __("messages.RevistaBladeLerArtigo") }}
                                    </button>
                                    </div>
                                  </article>
                                   {{-- Modal para cada capítulo --}}
                                    <div class="modal fade" id="leiaCapitulo{{ $capitulo->id }}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
                                      <div class="modal-dialog" style="--bs-modal-width: 98%;">
                                        <div class="modal-content" style="background-color: #fff;">
                                          <div class="modal-header" style="background-color: #fff;">
                                            <h5 class="modal-title">{{ $capitulo->nome }}</h5>
                                            <button
                                              type="button"
                                              class="btn-close"
                                              data-bs-dismiss="modal"
                                              aria-label="Fechar"></button>
                                          </div>
                                          <div class="modal-body">
                                            {{-- use iframe ou embed com a URL absoluta --}}
                                            <iframe
                                              src="{{ $urlPDF }}"
                                              frameborder="0"
                                              width="100%"
                                              height="700px">
                                            </iframe>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @endforeach
                              @endif
                          </div>
                          <!-- TAB Espanhol -->
                          <div class="tab-pane fade @if($apostila->idioma == 'es') show active @endif" id="espanhol" role="tabpanel" aria-labelledby="espanhol-tab">
                              <!-- Conteúdo da aba em espanhol -->
                                  @if($apostila->idioma == 'es')
                                    @foreach($vinculo->capitulos as $capitulo)
                                      <article class="row boxbordasComprar">
                                        <div class="col-md-6">
                                          <h1 class="revistaImagemArtigoh1">
                                            {{ $capitulo->nome }}
                                          </h1>
                                          <p class="revistaImagemArtigop">
                                            {{ limita_caracteres(strip_tags($capitulo->descricao_capitulo), 300, false) }}
                                          </p>
                                          <button
                                            type="button"
                                            id="artigoCap{{ $capitulo->id }}"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#leiaCapitulo{{ $capitulo->id }}">
                                            {{ __("messages.RevistaBladeLerArtigo") }}
                                          </button>
                                        </div>
                                      </article>
                                      @endforeach
                                  @endif
                          </div>
                          <!-- TAB INGLÊS -->
                          <div class="tab-pane fade @if($apostila->idioma == 'en') show active @endif" id="ingles" role="tabpanel" aria-labelledby="ingles-tab">
                              <!-- Conteúdo da aba em inglês -->
                                  @if($apostila->idioma == 'en')
                                    @foreach($vinculo->capitulos as $capitulo)
                                      <article class="row boxbordasComprar">
                                        <div class="col-md-6">
                                          <h1 class="revistaImagemArtigoh1">
                                            {{ $capitulo->nome }}
                                          </h1>
                                          <p class="revistaImagemArtigop">
                                            {{ limita_caracteres(strip_tags($capitulo->descricao_capitulo), 300, false) }}
                                          </p>
                                          <button
                                            type="button"
                                            id="artigoCap{{ $capitulo->id }}"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#leiaCapitulo{{ $capitulo->id }}">
                                            {{ __("messages.RevistaBladeLerArtigo") }}
                                          </button>
                                        </div>
                                      </article>
                                    @endforeach
                                  @endif
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
</div>
        @endif
      @endforeach
    @endforeach
@endif

      
<!-- Modal do artigo -->
<div class="modal fade" id="{{$apostila->id}}" tabindex="-1" aria-labelledby="{{$apostila->id}}" aria-hidden="true">
  <div class="modal-dialog" style="--bs-modal-width: 98%;">
    <div class="modal-content" style="background-color: #fff;">
      <div class="modal-header" style="background-color: #fff;">
        <h5 class="modal-title" id="{{$apostila->id}}">{{ $apostila->nome }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="row" style="height: 100vh;">
            <div id="adobe-dc-view{{$apostila->id}}" class="col-md-12">
            </div>
        </div>
        <script type="text/javascript">
            document.addEventListener("adobe_dc_view_sdk.ready", function () {
                document.getElementById("artigoCap{{ $apostila->id }}").addEventListener("click", function () {
                    showPDF{{ $apostila->id }}("{{ $apostila->descricao }}");
                })
            });
            function showPDF{{ $apostila->id }}(url) {
                adobeDCView = null;
                fetch(url)
                  .then((res) => res.blob())
                  .then((blob) => {
                  adobeDCView = new AdobeDC.View({
                    clientId: "509e95046c654d969e54d6c182aceba0",
                    //clientId: "509e95046c654d969e54d6c182aceba0",
                    locale: "pt-BR",
                    divId: "adobe-dc-view{{$apostila->id}}"
                  });
                  adobeDCView.previewFile(
                    {
                        content:   {location: {url: "{{ $apostila->descricao }}"}},
                        metaData: {fileName: "{{ $apostila->nome }}.pdf"}
                    },
                    {
                      embedMode: "FULL_WINDOW",
                      defaultViewMode: "FIT_WIDTH",
                      enablePDFAnalytics: true,
                      @if (session()->get('usuarioPlanoID') == 274)
                        showDownloadPDF: false,
                        showPrintPDF: false,
                        showLeftHandPanel: false,
                        showAnnotationTools: false,
                        focusOnRendering: false
                      @else
                        showDownloadPDF: true,
                        showPrintPDF: true,
                        showLeftHandPanel: true,
                        showAnnotationTools: true,
                        focusOnRendering: true
                      @endif
                    }
                  );
                });
            }
        </scri>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
      </div>
    </div>
  </div>
</div>

<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
<script type="text/javascript">
var adobeDCView = null;
  document.addEventListener("adobe_dc_view_sdk.ready", function () {
    showPDF("{{ $apostila->descricao }}");
    @foreach($schoolar->turmas as $turma)
      @foreach($turma->apostilas as $apostilas)
        @php
          $apostila = $apostilas->apostila;
        @endphp
      document.getElementById("Cap{{ $apostila->id }}").addEventListener("click", function () {
        showPDF("{{ $apostila->descricao }}");
      })
    @endforeach
  @endforeach
    @foreach($schoolar->turmas as $turma)
      @foreach($turma->apostilas as $apostilas)
        @php
          $apostila = $apostilas->apostila;
        @endphp
      document.getElementById("CapM{{ $apostila->id }}").addEventListener("click", function () {
        showPDF("{{ $apostila->descricao }}");
      })
      @endforeach
    @endforeach
  });

  function showPDF(url) {
    adobeDCView = null;
    fetch(url)
      .then((res) => res.blob())
      .then((blob) => {
      adobeDCView = new AdobeDC.View({
        clientId: "509e95046c654d969e54d6c182aceba0",
        //clientId: "509e95046c654d969e54d6c182aceba0",
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
          @if (session()->get('usuarioPlanoID') == 274)
            showDownloadPDF: false,
            showPrintPDF: false,
            showLeftHandPanel: false,
            showAnnotationTools: false,
            focusOnRendering: false
          @else
            showDownloadPDF: true,
            showPrintPDF: true,
            showLeftHandPanel: true,
            showAnnotationTools: true,
            focusOnRendering: true
          @endif
        }
      );
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

  let total = 0; // Inicializa a variável total como zero

</script>

<script>
   

// Adicionar evento de clique para cada aba
document.getElementById('portugues-tab').addEventListener('click', function() {
    trocarImagem('imagem-portugues');
    document.querySelectorAll('.corpoEditorialpt').forEach(function(elemento) {
        elemento.style.display = 'block';
    });
});

document.getElementById('ingles-tab').addEventListener('click', function() {
    trocarImagem('imagem-ingles');
    document.querySelectorAll('.corpoEditorialen').forEach(function(elemento) {
        elemento.style.display = 'block';
    });
});

document.getElementById('espanhol-tab').addEventListener('click', function() {
    trocarImagem('imagem-espanhol');
    document.querySelectorAll('.corpoEditoriales').forEach(function(elemento) {
        elemento.style.display = 'block';
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;            // ex: "#leiaCapituloHtml15540" ou "#gotalk15540"
    if (!hash) return;

    const modalEl = document.querySelector(hash);
    if (modalEl) {
      new bootstrap.Modal(modalEl).show();
    }
  });


    </script>

@endsection
