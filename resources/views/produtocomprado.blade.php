<?php
$tipoTopo = 'topoPreto';

/*$permicao = $revista[0]->collections[0]->id;
if(session()->get('usuarioPermissao') == 'naotem'){
    $modalConteudo = 'espacoParaAssinantes';
}elseif(session()->get('usuarioPermissao') == 'naotemVencido'){
    $modalConteudo = 'renoveOplano';
}elseif(session()->get('usuarioPermissao') == 'naotemSemPlano'){
    $modalConteudo = 'vamosAssinar';
}elseif(is_array(session()->get('usuarioPermissao'))){
    if (in_array($permicao, session()->get('usuarioPermissao'))){
        $modalConteudo = 'permitido';
    }else{
        $modalConteudo = 'espacoParaAssinantes';
    }
}else{
    $modalConteudo = 'espacoParaAssinantes';
}*/

$modalConteudo = 'permitido';

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
                    Capitulos
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbar2Label">CAPITULOS</h5><hr>
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
                  @foreach ($revista[1]->productItems as $capitulo)
                    <span id="Cap{{ $capitulo->id }}" style="color: #444444; text-decoration: none; font-weight: bold; cursor: pointer;">
                        {{ $capitulo->title }}
                    </span>
                    <br><hr>
                  @endforeach
                </div>
                <div class="col-md-12 col-lg-9" style="height: 100vh;">
                  <div id="adobe-dc-view"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.ProdutoCompradoBladeFechar")}}</button>
          </div>
        </div>
      </div>
    </div>
@endif

<div class="container">
    <div class="row" style="padding: 40px 0;">
        <div class="col-sm-12">
            <label class="revistaQntArtigos" style="font-size: 40px; font-weight: 900; color: #c9c8c6;">{{ count($revista[0]->productItems) }} ARTIGOS</label>
        </div>
    </div>
    <div class="row">
    @foreach ($revista[1]->productItems as $key => $capitulo2)
        

        @foreach ($revista[0]->productItems as $key2 => $capitulo)
        @if($capitulo2->id == $capitulo->id)
            @break
        @endif
        @endforeach
        
        <?php
        $semImagem = 1;
        ?>     


        @if($semImagem == 0)
            <article class="row boxbordasComprar" data-bs-toggle="modal" data-bs-target="@if(null !== session()->get('token')) #leiaCapitulo{{$capitulo->id}} @else #leiaNaIntegra @endif">
            <div class="col-md-6 revistaImagemArtigo d-block d-md-none" style="background: url( {{ $capitulo->cover }}) no-repeat center center !important;">
              </div>
              <div class="col-md-6">
              <h1 class="revistaImagemArtigoh1" style="font-family: 'Montserrat';">{{ $capitulo->title }}</h1>
                        <p class="revistaImagemArtigop" style="font-family: 'Open Sans';">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                        <p class="revistaImagemArtigop1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($revista[1]->productItems[$key]->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                      
                        @if($modalConteudo == 'permitido')
                            <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                        @endif
                            {{__("messages.RevistaBladeLerArtigo")}}
                        </button>

                        @if(isset($capitulo->data->html))
                            <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                        @endif
                        
                      
                      
                                          
                  
    
              </div>
              <div class="col-md-6 revistaImagemArtigo d-none d-md-block" style="background: url( {{ $capitulo->cover }}) no-repeat center center !important;">
              </div>
            </article>
        @else
          <article class="row shadowbox-article">
                <div class="col-sm-12">
                    <h1 class="shadowbox-articleh1" style="font-family: 'Montserrat';">{{ $capitulo->title }}</h1>
                    <p class="shadowbox-articlep" style="font-family: 'Open Sans';">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                    <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($revista[1]->productItems[$key]->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                    @if($modalConteudo == 'permitido')
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">
                    @else
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">
                    @endif
                    {{__("messages.RevistaBladeLerArtigo")}}
                      </button>

                    @if(isset($capitulo->data->html))
                        <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                    @endif

                  </div>
            </article>
      @endif

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
                        <div id="adobe-dc-view{{$capitulo->id}}" class="col-md-12">
                        </div>
                    </div>
                    <script type="text/javascript">
                        document.addEventListener("adobe_dc_view_sdk.ready", function () {
                            document.getElementById("artigoCap{{ $capitulo->id }}").addEventListener("click", function () {
                                showPDF{{ $capitulo->id }}("{{ $capitulo->content }}");
                            })
                        });
                        function showPDF{{ $capitulo->id }}(url) {
                            adobeDCView = null;
                            fetch(url)
                              .then((res) => res.blob())
                              .then((blob) => {
                              adobeDCView = new AdobeDC.View({
                                clientId: "509e95046c654d969e54d6c182aceba0",
                                //clientId: "2aed258cc30e450db5bc65309da1ad25",
                                locale: "pt-BR",
                                divId: "adobe-dc-view{{$capitulo->id}}"
                              });
                              adobeDCView.previewFile(
                                {
                                    content:   {location: {url: "{{ $capitulo->content }}"}},
                                    metaData: {fileName: "{{ $capitulo->title }}.pdf"}
                                },
                                {
                                  embedMode: "FULL_WINDOW",
                                  defaultViewMode: "FIT_WIDTH",
                                  enablePDFAnalytics: true,
                                  @if($revista[0]->productType == 'magazine')
                                    showDownloadPDF: true,
                                    showPrintPDF: true,
                                    showLeftHandPanel: true,
                                    showAnnotationTools: true,
                                    focusOnRendering: true
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
                    </script>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.ProdutoCompradoBladeFechar")}}</button>
                  </div>
                </div>
              </div>
            </div>

            @if(isset($capitulo->data->html))
                <div class="modal fade" id="leiaCapituloHtml{{$capitulo->id}}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
                  <div class="modal-dialog" style="--bs-modal-width: 98%;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="leiaCapituloHtml{{$capitulo->id}}">{{ $capitulo->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row" style="height: 100vh;">
                            <iframe src="{{$capitulo->data->html}}"></iframe>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.ProdutoCompradoBladeFechar")}}</button>
                      </div>
                    </div>
                  </div>
                </div>
            @endif
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
          @if($revista[0]->productType == 'magazine')
            showDownloadPDF: true,
            showPrintPDF: true,
            showLeftHandPanel: true,
            showAnnotationTools: true,
            focusOnRendering: true
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
</script>

@endsection



@section('api')
@endsection