<?php
$paginaTitulo = $colecao[0]->title.' - DentalGo';
$padinaDescricao = '';

$tipoTopo = 'topoAzul';
?>
@extends('layouts.master')

@section('content')



<?php
//$colecaoOrdenada = $colecao->orderBy('products->publishDate', 'desc');
// INFORMAÇÃO DAS COLECOES
$todasColecoes = $colecoes;
// INFORMAÇÃO DA ESPECIFICA COLECAO
$recebidoC = $colecao;
$colecoes = collect($colecao[1])->sortBy('count')->reverse()->toArray();

$linguagem = request('language');
if($linguagem == null){
  $linguagem = 'pt';
}




?>




<div class="container-fluid produtoTopo">
    <div class="container containerColecao position-relative">
        <div style="text-align: right;">
            @foreach ($ultimaRevista[0]->productItems as $ultimaRevistas)
                @if($colecao[0]->id == '79')
                    <script>
                        window.location.href = 'https://www.dentalgo.com.br/';
                    </script>
                @endif
                @if($colecao[0]->id == '5')
                    @if(isset($ultimaRevistas->data->corpo))
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-4" style="text-align: left !important; justify-content: left !important;">
                                    <p class="publicacao-colecao" style="font-family: 'Raleway'; color: #fff; width: 100px; text-align:justify; margin-bottom:20px;">{{__("messages.PUBLICACAOOficial")}}</p>
                                    <a class="img-fluid " href="https://abor.org.br/" target="_blank"><img class="img-fluid no-margin" style="width: 20% !important; margin-bottom: 20px; text-align: left !important; justify-content: left !important;" src="{{ asset('imagens/Facelift/SELOS/seloaboradaptdado.fw.png') }}" alt=""></a>
                                    <a class="img-fluid " href="https://www.alado.org/" target="_blank"><img class="img-fluid no-margin" style="width: 20% !important; text-align: left !important; justify-content: left !important;" src="{{ asset('imagens/Facelift/SELOS/seloaladoadaptdado.fw.png') }}" alt=""></a>
                                </div>
                                <div class="col-4" style="justify-content: center;">
                                    <div class="container" style="justify-content: center !important; text-align: center; display: flex; margin-top: 50px;">
                                        <img src="{{ $recebidoC[0]->cover }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                                    <a href="https://clinicalorthodontics.net/instrucoesaosautores" target=_blank>
                                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @break
                    @endif 
                @elseif($colecao[0]->id == '6')
                    @if(isset($ultimaRevistas->data->corpo))
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://dpjo.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif
                @elseif($colecao[0]->id == '67')
                    @if(isset($ultimaRevistas->data->corpo ))
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://orofacialharmony.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif 
                @elseif($colecao[0]->id == '4')
                    @if(isset($ultimaRevistas->data->corpo)) 
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://clinicaldentistry.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif 
                @elseif($colecao[0]->id == '1')
                    @if(isset($ultimaRevistas->data->corpo)) 
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://jbcoms.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif 
                @elseif($colecao[0]->id == '2')
                    @if(isset($ultimaRevistas->data->corpo)) 
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://dpendodontics.com/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif 
                @elseif($colecao[0]->id == '50')
                    @if(isset($ultimaRevistas->data->corpo)) 
                        <button id="artigoCap{{ $ultimaRevistas->id }}" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$ultimaRevistas->id}}" type="button" class="btn btn-primary corpoEditorial{{$ultimaRevistas->language}}" style="margin-right:10px; margin-top:22px;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                        <a href="https://www.brazilianperiodontology.com/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary paraAutoresColecao" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                        </a>
                        @break
                    @endif
                @endif                   
            @endforeach
        </div>
        <!-- Modal -->
        @foreach ($ultimaRevista[0]->productItems as $ultimaRevistas)
            @if(isset($ultimaRevistas->data->corpo) == 'editorial')
                <div class="modal fade" id="leiaCapitulo{{ $ultimaRevistas->id }}" tabindex="-1" aria-labelledby="leiaCapituloLabel{{ $ultimaRevistas->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="leiaCapitulo{{$ultimaRevistas->id}}">{{ $ultimaRevistas->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row" style="height: 100vh;">
                                    <div id="adobe-dc-view{{$ultimaRevistas->id}}" class="col-md-12">
                                    </div>

                                </div>
                                <script type="text/javascript">
                                    document.addEventListener("adobe_dc_view_sdk.ready", function () {
                                        document.getElementById("artigoCap{{ $ultimaRevistas->id }}").addEventListener("click", function () {
                                            showPDF{{ $ultimaRevistas->id }}("{{ $ultimaRevistas->content }}");
                                        })
                                    });
                                    function showPDF{{ $ultimaRevistas->id }}(url) {
                                        adobeDCView = null;
                                        fetch(url)
                                        .then((res) => res.blob())
                                        .then((blob) => {
                                        adobeDCView = new AdobeDC.View({
                                            clientId: "509e95046c654d969e54d6c182aceba0",
                                            //clientId: "509e95046c654d969e54d6c182aceba0",
                                            locale: "pt-BR",
                                            divId: "adobe-dc-view{{$ultimaRevistas->id}}"
                                        });
                                        adobeDCView.previewFile(
                                            {
                                                content:   {location: {url: "{{ $ultimaRevistas->content }}"}},
                                                metaData: {fileName: "{{ $ultimaRevistas->title }}.pdf"}
                                            },
                                            {
                                            embedMode: "FULL_WINDOW",
                                            defaultViewMode: "FIT_WIDTH",
                                            enablePDFAnalytics: true,
                                            showDownloadPDF: true,
                                            showPrintPDF: true,
                                            showLeftHandPanel: true,
                                            showAnnotationTools: true,
                                            focusOnRendering: true
                                            }
                                        );
                                        });
                                    }
                                </script>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if($colecao[0]->id == '5')
            <img style="display: none;" src="{{ $recebidoC[0]->cover }}">
        @else
            <img src="{{ $recebidoC[0]->cover }}">
        @endif
        @if($colecao[0]->id == '5')
        <div class="col-md-12 col-sm-12 d-flex justify-content-center linhaAopiadoresRevista">
            <a href="https://www.id-logical.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/id-logicalbranca.fw.png') }}" class="img-fluid expand-icon icones-colecao"/></a>
            <a href="https://www.easy3d.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/easy-3d-branco.fw.png') }}" class="img-fluid expand-icon icones-colecao"/></a>
            <a href="https://www.morelli.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logo_transparentebrancamorelli.fw.png') }}" class="img-fluid expand-icon icones-colecao"/></a>
            <a href="https://www.dolphinimaging.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/dolphin-logo-branca.fw.png') }}" class="img-fluid expand-icon icones-colecao" style="margin-left: 20px;"/></a>
            <a href="https://www.orthometric.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" class="img-fluid expand-icon icones-colecao" style=" width: 200px; margin-left: 20px;"/></a>
        </div> 
        @elseif($colecao[0]->id == '4')
            <div class="col-md-12 col-sm-12 d-flex justify-content-center linhaAopiadoresRevista">
            <a href="https://www.dentsplysirona.com/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/corp-logo-branca-dentsply-sirona-logo.fw.png') }}" class="img-fluid expand-icon icones-colecao"/></a>
            <a href="https://fgmdentalgroup.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/LOGO_FGMbranca.fw.png') }}" class="img-fluid expand-icon icones-colecao"/></a>
            <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid expand-icon icones-colecao" style="width: 100px;"/></a>
            </div>
        @elseif($colecao[0]->id == '2')
            <div class="col-md-12 col-sm-12 d-inline linhaAopiadoresRevista">
            <a href="https://www.biologix.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/biologix.fw.png') }}" class="img-fluid expand-icon"/></a>
            </div>
        @elseif($colecao[0]->id == '1')
            <div class="col-md-12 col-sm-12 d-inline linhaAopiadoresRevista">
            <a href="https://www.traumec.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logo-traumec.png') }}" class="img-fluid expand-icon" /></a>
            </div>
        @elseif($colecao[0]->id == '50')
            <div class="col-md-12 col-sm-12 justify-content-center d-flex linhaAopiadoresRevista">
            <a href="http://curaprox.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Curaprox-logo-branca.jpg') }}" class="img-fluid icones-colecao expand-icon" /></a>
            <a href="https://www.colgate.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Colgate-Logo-branca.fw.png') }}" class="img-fluid icones-colecao expand-icon" ></a>
            <a href="https://www.gumbrand.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/GUM-Logo-branca.fw.png') }}" class="img-fluid icones-colecao expand-icon" /></a>
            <a href="https://www.bionnovation.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/bionnovation.fw.png') }}" class="img-fluid icones-colecao expand-icon" /></a>
            <a href="https://www.oralb.com.br/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/oral-b.fw.png') }}" class="img-fluid icones-colecao expand-icon" /></a>
            <a href="https://plenum.bio/" target="_blank"><img src="{{ asset('imagens/siteRevista/plenum.fw.png') }}" class="img-fluid icones-colecao expand-icon" style="width: 120px; "/></a>
            <a href="https://www.geistlich.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Geistlich.fw.png') }}" class="img-fluid icones-colecao expand-icon" /></a>
            <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid icones-colecao expand-icon" /></a>
            </div>
        @elseif($colecao[0]->id == '6')
            <div class="col-md-12 col-sm-12 d-inline linhaAopiadoresRevista">    
            <a href="https://www.orthometric.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" class="img-fluid expand-icon"/> </a>
            </div> 
        @else
        <div class="col-md-12 col-sm-12 d-inline linhaAopiadoresRevista"></div>
        @endif
    </div>
</div>

   

<!--<div class="container-fluid revistaApoiadoresFundoCol">
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
                                <img src="{{ route('home') }}/imagens/biologix(1).png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/fgm.png">
                            </div>
                            <div class="col-md-3">
                                <img src="{{ route('home') }}/imagens/sulzer(1).png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="container">


    @foreach ($colecoes as $keyAno => $colecaof)
        <div class="row">
            <div class="col-sm-12">
                <h3 class="sombraAno">{{ $keyAno }}</h3>
            </div>

            @foreach ($colecaof as $key => $revista)
                <article class="col-6 col-md-3 col-lg-2">
                    @if(in_array('pt', $revista->availableLanguages ))
                        <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=pt" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                    @elseif(in_array('es', $revista->availableLanguages))
                        <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=es" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                    @elseif(in_array('en', $revista->availableLanguages))
                        <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=en" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                    @endif
                        <h1 class="colecaoRound">
                            {{ $revista->title }}
                        </h1>
                        @if($keyAno >= '2023' && ($colecao[0]->id == '5'))
                        <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                            <div class="d-flex" >
                                <img src="{{ asset('imagens/Facelift/logo_abor.png') }}"  class="img-fluid logo-abor-revista-colecao mostrar-imagem imagem-portugues imagem-ingles"  style=" @if($linguagem == 'es') display:none; @endif">
                                <img src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"  class="img-fluid logo-alado-revista-colecao mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" >
                            </div>
                        @elseif($colecao[0]->id)
                        <img class="img-fluid sombrita arredonda-imagem" src="{{ $revista->cover }}" alt="{{ $revista->title }} - {{ $revista->brief }}" width="100%" height="auto">
                        @endif
                        
                        

                    </a>
                        @foreach($revista->availableLanguages as $linguagensDisponiveis)
                            @if($linguagensDisponiveis == 'pt')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=pt" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/pt.png') }}" >
                                </a>    
                            @elseif($linguagensDisponiveis == 'es')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=es" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/esp.png') }}">
                                </a>    
                            @elseif($linguagensDisponiveis == 'en')
                                <a href="{{ route('revista') }}/{{ $revista->id }}/{{ str_replace(' ', '-', $revista->title) }}/{{Request()->segment(2)}}?language=en" alt="{{ $revista->title }} - {{ $revista->brief }}" class="tiraUnderline">
                                    <img src="{{ asset('imagens/bandeiras/ing.png') }}">
                                </a>
                            @endif
                        @endforeach
                       
                        <p style="display: none !important;">{{ $revista->brief }}</p>
                    
                </article>
            @endforeach

            @if($keyAno == '2024')
                @if($colecao[0]->id == '5')
                <!-- Revista Clínica de Ortodontia Dental Press -->
                    @php
                    $empresasComercial = [
                            [
                                'nome' => 'Easy3d',
                                'link' => 'https://www.easy3d.com.br/',
                                'imagem' => 'bannersComercial/Easy-3d-DPJO-e-clinica.png'
                            ],
                            [
                                'nome' => 'Id-Logical',
                                'link' => 'https://www.id-logical.com/',
                                'imagem' => 'bannersComercial/IDLOGICAL1.fw.png'
                            ],
                            [
                                'nome' => 'ClickAligner',
                                'link' => 'https://wa.me/5551982586525?text=Oi,%20vim%20do%20site%20da%20DentalPress,%20quero%20saber%20mais%20sobre%20a%20assinatura%20de%20alinhadores',
                                'imagem' => 'bannersComercial/bannerClickAligner.png'    
                            ],
                            [
                                'nome' => 'ORTHOMETRIC',
                                'link' => 'https://www.orthometric.com.br/',
                                'imagem' => 'bannersComercial/diminuidocapelozza.fw.png'
                            ],
                    ];


                

                    $institutions = [
                        
                    ];
                    shuffle($empresasComercial);
                    shuffle($institutions);
                    $arrayFinal = array();

                    while (count($empresasComercial)>0 || count($institutions)>0) {
                        if (count($empresasComercial)>0) {
                            $randomEmpresa = array_shift($empresasComercial);
                            $arrayFinal[] = [
                                'nome' => $randomEmpresa['nome'],
                                'link' => $randomEmpresa['link'],
                                'imagem' => $randomEmpresa['imagem'],
                                'tipo' => 'empresa'
                            ];
                        }
                        if (count($institutions)>0) {
                            $randomInstituicao = array_shift($institutions);
                            $arrayFinal[] = [
                                'nome' => $randomInstituicao['nome'],
                                'link' => $randomInstituicao['link'],
                                'imagem' => $randomInstituicao['imagem'],
                                'tipo' => 'instituicao'
                            ];
                        }
                    }
                    @endphp

                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="sombraAno2">{{__("messages.PUBLICIDADE")}}</h3>
                        </div>  

                    <div class="col-sm-12">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                 <a href="{{ $empresa['link'] }}" target="_blank">
                                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
                                    <div class="carousel-caption conteudoBanner">
                                    </div>
                                 </a>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div> 
                    </div>
                @elseif($colecao[0]->id == '6')
                <!-- Revista Clínica de Ortodontia Dental Press -->
                    @php
                    $empresasComercial = [
                        [
                            'nome' => 'Easy3d',
                            'link' => 'https://www.easy3d.com.br/',
                            'imagem' => 'bannersComercial/Easy-3d-DPJO-e-clinica.png'
                        ],
                        [
                            'nome' => 'Id-Logical',
                            'link' => 'https://www.id-logical.com/',
                            'imagem' => 'bannersComercial/IDLOGICAL1.fw.png'
                        ],
                        [
                            'nome' => 'ClickAligner',
                            'link' => 'https://wa.me/5551982586525?text=Oi,%20vim%20do%20site%20da%20DentalPress,%20quero%20saber%20mais%20sobre%20a%20assinatura%20de%20alinhadores',
                            'imagem' => 'bannersComercial/bannerClickAligner.png'    
                        ],
                        [
                            'nome' => 'ORTHOMETRIC',
                            'link' => 'https://www.orthometric.com.br/',
                            'imagem' => 'bannersComercial/diminuidocapelozza.fw.png'
                        ],
                    ];

                    $institutions = [
                        
                    ];
                    shuffle($empresasComercial);
                    shuffle($institutions);
                    $arrayFinal = array();

                    while (count($empresasComercial)>0 || count($institutions)>0) {
                        if (count($empresasComercial)>0) {
                            $randomEmpresa = array_shift($empresasComercial);
                            $arrayFinal[] = [
                                'nome' => $randomEmpresa['nome'],
                                'link' => $randomEmpresa['link'],
                                'imagem' => $randomEmpresa['imagem'],
                                'tipo' => 'empresa'
                            ];
                        }
                        if (count($institutions)>0) {
                            $randomInstituicao = array_shift($institutions);
                            $arrayFinal[] = [
                                'nome' => $randomInstituicao['nome'],
                                'link' => $randomInstituicao['link'],
                                'imagem' => $randomInstituicao['imagem'],
                                'tipo' => 'instituicao'
                            ];
                        }
                    }
                    @endphp
                    <div class="col-sm-12">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner">
                            @foreach ($arrayFinal as $keyBanner => $empresa)
                                <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                 <a href="{{ $empresa['link'] }}" target="_blank">
                                    <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
                                    <div class="carousel-caption conteudoBanner">
                                    </div>
                                 </a>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div> 
                    </div>
                    @elseif($colecao[0]->id == '4')
                    <!-- Revista Estética -->
                        @php
                        $empresasComercial = [
                            [
                                'nome' => 'CVdentus',
                                'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press?utm_source=direct&utm_medium=link&utm_campaign=dental-press',
                                'imagem' => 'bannersComercial/BANNERDENTALPRESS1920X500.jpg'
                            ],
                            [
                                'nome' => 'ultradent',
                                'link' => 'https://www.ultradent.com.br/',
                                'imagem' => 'bannersComercial/ULTRADENTBANNER.jpg'
                            ]
                        ];

                        $institutions = [
                            
                        ];
                        shuffle($empresasComercial);
                        shuffle($institutions);
                        $arrayFinal = array();

                        while (count($empresasComercial)>0 || count($institutions)>0) {
                            if (count($empresasComercial)>0) {
                                $randomEmpresa = array_shift($empresasComercial);
                                $arrayFinal[] = [
                                    'nome' => $randomEmpresa['nome'],
                                    'link' => $randomEmpresa['link'],
                                    'imagem' => $randomEmpresa['imagem'],
                                    'tipo' => 'empresa'
                                ];
                            }
                            if (count($institutions)>0) {
                                $randomInstituicao = array_shift($institutions);
                                $arrayFinal[] = [
                                    'nome' => $randomInstituicao['nome'],
                                    'link' => $randomInstituicao['link'],
                                    'imagem' => $randomInstituicao['imagem'],
                                    'tipo' => 'instituicao'
                                ];
                            }
                        }
                        @endphp
                        <div class="col-sm-12">
                        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($arrayFinal as $keyBanner => $empresa)
                                    <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                                @endforeach
                            </div>

                            <div class="carousel-inner">
                                @foreach ($arrayFinal as $keyBanner => $empresa)
                                    <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                    <a href="{{ $empresa['link'] }}" target="_blank">
                                        <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
                                        <div class="carousel-caption conteudoBanner">
                                        </div>
                                    </a>
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div> 
                        </div>
                        @elseif($colecao[0]->id == '50')
                        <!-- Revista BJP -->
                            @php
                            $empresasComercial = [
                                [
                                    'nome' => 'CVdentus',
                                    'link' => 'https://conteudo.cvdentus.com.br/parceria-dental-press?utm_source=direct&utm_medium=link&utm_campaign=dental-press',
                                    'imagem' => 'bannersComercial/BANNERDENTALPRESS1920X500.jpg'
                                ]
                            ];

                            $institutions = [
                                
                            ];
                            shuffle($empresasComercial);
                            shuffle($institutions);
                            $arrayFinal = array();

                            while (count($empresasComercial)>0 || count($institutions)>0) {
                                if (count($empresasComercial)>0) {
                                    $randomEmpresa = array_shift($empresasComercial);
                                    $arrayFinal[] = [
                                        'nome' => $randomEmpresa['nome'],
                                        'link' => $randomEmpresa['link'],
                                        'imagem' => $randomEmpresa['imagem'],
                                        'tipo' => 'empresa'
                                    ];
                                }
                                if (count($institutions)>0) {
                                    $randomInstituicao = array_shift($institutions);
                                    $arrayFinal[] = [
                                        'nome' => $randomInstituicao['nome'],
                                        'link' => $randomInstituicao['link'],
                                        'imagem' => $randomInstituicao['imagem'],
                                        'tipo' => 'instituicao'
                                    ];
                                }
                            }
                            @endphp

                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="sombraAno">{{__("messages.PUBLICIDADE")}}</h3>
                                </div>  

                            <div class="col-sm-12">
                            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach ($arrayFinal as $keyBanner => $empresa)
                                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="{{ $keyBanner }}" @if($keyBanner == 0) class="active" @endif aria-current="true" aria-label="Slide {{ $keyBanner }}"></button>
                                    @endforeach
                                </div>

                                <div class="carousel-inner">
                                    @foreach ($arrayFinal as $keyBanner => $empresa)
                                        <div class="carousel-item @if($keyBanner == 0) active @endif" data-bs-interval="8000">
                                        <a href="{{ $empresa['link'] }}" target="_blank">
                                            <img src="{{ asset('imagens') }}/{{ $empresa['imagem'] }}" class="d-block w-100" alt="{{ $empresa['nome'] }}">
                                            <div class="carousel-caption conteudoBanner">
                                            </div>
                                        </a>
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div> 
                            </div>
                @endif
            @endif
            
        </div>
    @endforeach
</div>

<script src="https://documentservices.adobe.com/view-sdk/viewer.js"></script>
    <script type="text/javascript">
    var adobeDCView = null;
      document.addEventListener("adobe_dc_view_sdk.ready", function () {
        showPDF("{{ $ultimaRevista[0]->productItems[0]->content }}");
        @foreach ($ultimaRevista[0]->productItems as $capitulo)
          document.getElementById("Cap{{ $capitulo->id }}").addEventListener("click", function () {
            showPDF("{{ $capitulo->content }}");
          })
        @endforeach
        @foreach ($ultimaRevista[0]->productItems as $capitulo)
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
                showDownloadPDF: true,
                showPrintPDF: true,
                showLeftHandPanel: true,
                showAnnotationTools: true,
                focusOnRendering: true
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
@endsection