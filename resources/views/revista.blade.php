<?php
$paginaTitulo = $revista[0]->title.' - DentalGO' ;
$padinaDescricao = '';
$tipoTopo = 'topoAzul';


$permicao = $revista[1]->collections;
$modalConteudo = 'espacoParaAssinantes';
if($revista[0]->customerCourtesy == 1){
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

$linguagem = request('language');
if($linguagem == null){
  $linguagem = 'pt';
}

$produtosIds = array('857', '886', '850', '826','895','963','998','1044', '1056', '1050', '1044', '1067', '1080', '1089', '1095', '1107', '1134', '1138');

?>
@extends('layouts.master')

@section('content')
<div class="container-fluid revistaTopo produtoTopo5  retirarbordamobile"> 


    @if($idColecao == '5')
      <div class="row titulo-clinical">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          @if($idColecao == '5')
            <div style="display:flex">
              <p class="publicacao " style="font-family: 'Raleway'; color: #fff; width: 100px; text-align:left; margin-right: 20px; margin-left: 0px; margin-bottom:0px;">{{__("messages.PUBLICACAOOficial")}}</p>
              <a style="justify-content: right !important; text-align: right;" href="https://abor.org.br/"  target="_blank"><img class="img-fluid" style="width: 60%; text-align: right; justify-self: right !important;" src="{{ asset('imagens/Facelift/SELOS/seloaboradaptdado.fw.png') }}" alt=""></img></a>
              <a style="text-align: center;" href="https://www.alado.org/"  target="_blank"><img class="img-fluid" style="width: 60%;" src="{{ asset('imagens/Facelift/SELOS/seloaladoadaptdado.fw.png') }}" alt=""></img></a>
            </div>
          @endif
          </div>
        </div>
      </div>
    @elseif($idColecao == '6')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '67')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '79')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '80')
    <div class="row titulo-clinical" style="margin-bottom: -256px;">
      <div class="col-5 naoedesktop"></div>
      <div class="col-4 outroteste naoedesktop etablet abaixotablet">
        <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
      </div>
      <div class="col-3">
        <div class="row outroteste naoedesktop abaixopadding">
        </div>
      </div>
    </div>
    @elseif($idColecao == '4')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '1')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '2')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @elseif($idColecao == '50')
      <div class="row titulo-clinical" style="margin-bottom: -256px;">
        <div class="col-5 naoedesktop"></div>
        <div class="col-4 outroteste naoedesktop etablet abaixotablet">
          <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
        </div>
        <div class="col-3">
          <div class="row outroteste naoedesktop abaixopadding">
          </div>
        </div>
      </div>
    @endif
    <div class="row titulo-clinical emobile retirarbordamobile">
      <div class="col-12 emobile">
        <div class="borda-titulo"><a href="#" class="link-titulo"><h1 class="revistatitulo-decoration testando123">{{ $revista[0]->title }}</h1></a></div>
      </div>
    </div>

    <div class="container capamobile">
      <div class="row">
          <div class="col-12 col-lg-3 col-md-10 col-sm-6 center capamobile naoedesktop">
              @if($idColecao == '5')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute">
                @if(in_array($revista[0]->id, $produtosIds))
                  <div class="d-flex" >
                    <a class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" href="https://abor.org.br/" target="_blank"><img class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" src="{{ asset('imagens/Facelift/logo_abor.png') }}"    style=" @if($linguagem == 'es') display:none; @endif"> </a>
                    <a class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" href="https://www.alado.org/" target="_blank"><img class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"   ></a>
                  </div>
                @else
                  <div class="d-flex">
                    <a class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" href="" target=""><img class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" src="{{ asset('imagens/Facelift/SELOS/logo_aborvazio.fw.png') }}"> </a>
                    <a class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" href="" target=""><img class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" src="{{ asset('imagens/Facelift/SELOS/logo-aladovazio.fw.png') }}"   ></a>
                  </div>
                @endif

              @endif
              @if($idColecao == '6')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '67')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '79')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '80')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '4')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '1')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '2')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @elseif($idColecao == '50')
                <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute" style="margin-bottom:0px !important;">
              @endif
          </div>
          <div class="emobile">
            <img src="{{ $revista[0]->cover }}" alt="{{ $revista[0]->title}}" class="revistaCapaAbsolute">
            @if($idColecao == '5')
              @if(in_array($revista[0]->id, $produtosIds))
                <div class="d-flex" >
                  <a class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" href="https://abor.org.br/" target="_blank"><img class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" src="{{ asset('imagens/Facelift/logo_abor.png') }}"    style=" @if($linguagem == 'es') display:none; @endif"> </a>
                  <a class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" href="https://www.alado.org/" target="_blank"><img class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" src="{{ asset('imagens/Facelift/logo-aladosemfundo.png') }}"   ></a>
                </div>
              @else
                <div class="d-flex" >
                  <a class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" href="" target=""><img class="img-fluid logo-abor-revista mostrar-imagem imagem-portugues imagem-ingles" src="{{ asset('imagens/Facelift/SELOS/logo_aborvazio.fw.png') }}"    style=" @if($linguagem == 'es') display:none; @endif"> </a>
                  <a class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" href="" target=""><img class="img-fluid logo-alado-revista mostrar-imagem imagem-portugues imagem-ingles imagem-espanhol" src="{{ asset('imagens/Facelift/SELOS/logo-aladovazio.fw.png') }}"   ></a>
                </div>
              @endif

            @endif
          </div>
          <div class="col-12 col-lg-9">
            <div class="row">
               <div class="col-12 emobile">
                 @if($idColecao == '5')
                    <div class="row"> 
                        <p class="publicacao " style="font-family: 'Raleway'; color: #fff; width: 100px; text-align:center; margin-right: auto !important; margin-left: auto !important; margin-bottom:0px;">{{__("messages.PUBLICACAOOficial")}}</p>
                        <img class="img-fluid" style="width: 140%; margin-right: auto !important; margin-left: auto !important;" src="{{ asset('imagens/Facelift/SELOS/selo-abor.png') }}" alt="">
                        <img class="img-fluid" style="width: 140%; margin-right: auto !important; margin-left: auto !important;" src="{{ asset('imagens/Facelift/SELOS/selo-alado.png') }}" alt="">
                    </div>
                 @endif
               </div>
               <div class="container-fluid naoedesktop">
                 <div class="row">
                   <div class="col-6">
                   </div>
                   <div class="col-6">
                     
                   </div>
                 </div>
               </div>
            </div>
            <div class="container-fluid">
              
              <div class="row">
                <div style="text-align: left;">
                    @if($idColecao == '5')
                      <a href="https://clinicalorthodontics.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '6')
                      <a href="https://dpjo.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '67')
                      <a href="https://orofacialharmony.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '79')
                      <a href="https://jcdam.net/instructionstoauthors" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '4')
                      <a href="https://clinicaldentistry.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '1')
                      <a href="https://jbcoms.net/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '2')
                      <a href="https://dpendodontics.com/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @elseif($idColecao == '50')
                      <a href="https://www.brazilianperiodontology.com/instrucoesaosautores" target=_blank>
                        <button type="button" class="btn btn-primary botaoParaAutores" style="margin-top: -400px; margin-left: 150px;">{{__("messages.BOTAOParaautores")}}</button>
                      </a>
                    @endif
                  </div>

                <div class="container fundoRevista" style=" margin-top: 90px; justify-content: center; justify-self: center !important;">
                  <div class="col-sm-12 revistaApoiadores" >
                      <div class="row align-items-bottom">
                        <div class="text-center">
                          @if($idColecao == '5')
                            <a href="https://clinicalorthodontics.net/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '6')
                            <a href="https://dpjo.net/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '67')
                            <a href="https://orofacialharmony.net/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '79')
                            <a href="https://jcdam.net/instructionstoauthors" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '4')
                            <a href="https://clinicaldentistry.net/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '1')
                            <a href="https://jbcoms.net/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '2')
                            <a href="https://dpendodontics.com/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @elseif($idColecao == '50')
                            <a href="https://www.brazilianperiodontology.com/instrucoesaosautores" target=_blank>
                              <button type="button" class="btn btn-primary botao-mobile-autor" style="margin-top: 25px;">{{__("messages.BOTAOParaautores")}}</button>
                            </a>
                          @endif
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

<div style="background-color: #000; text-align: center; justify-content: center; padding-top: 40px; padding-bottom: 20px;" class="container-fluid">
  @if($idColecao == '5')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex text-center linhaAopiadoresRevista naoedesktop">
    <p class="apoioinstitucional" style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="https://www.id-logical.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/id-logicalbranca.fw.png') }}" class="img-fluid revistapoio1"/></a>
    <a href="https://www.easy3d.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/easy-3d-branco.fw.png') }}" class="img-fluid revistaEasy3D"/></a>
    <a href="https://www.morelli.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logo_transparentebrancamorelli.fw.png') }}" class="img-fluid revistasulzer1"/></a>
    <a href="https://www.dolphinimaging.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/dolphin-logo-branca.fw.png') }}" class="img-fluid revistaDolphin" style="margin-left: 20px;"/></a>
    <a href="https://www.orthometric.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" class="img-fluid" style=" width: 200px; margin-left: 20px; margin-top: 12px;"/></a>
  </div> 
  <div style="justify-content: center;" class="col-md-12 com-sm-12 d-inline text-center linhaAopiadoresRevista emobile">
    <div class="container">
      <div class="row">
        <div class="col-12" style="justify-content:center !important;">
          <p class="apoioinstitucional" style="font-family: raleway; color:#fff; text-align: center; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
        </div>
      </div>
    </div>
        <a href="https://www.id-logical.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/id-logicalbranca.fw.png') }}" class="img-fluid revistapoio1"/></a>
        <a href="https://www.easy3d.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/easy-3d-branco.fw.png') }}" class="img-fluid revistaEasy3D"/></a>
        <a href="https://www.morelli.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logo_transparentebrancamorelli.fw.png') }}" class="img-fluid revistasulzer1"/></a>
        <a href="https://www.dolphinimaging.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/dolphin-logo-branca.fw.png') }}" class="img-fluid revistaDolphin" style="margin-left: 20px;"/></a>
    <a href="https://www.orthometric.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" class="img-fluid" style=" width: 200px; margin-left: 20px; margin-top: 12px;"/></a>
  </div>
  @elseif($idColecao == '4')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex text-center linhaAopiadoresRevista naoedesktop">
    <p class="apoioinstitucional" style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="https://www.dentsplysirona.com/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/corp-logo-branca-dentsply-sirona-logo.fw.png') }}" class="img-fluid revistapoio1"/></a>
    <a href="https://fgmdentalgroup.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/LOGO_FGMbranca.fw.png') }}" style="margin-left: 20px;" class="img-fluid revistaEasy3D"/></a>
    <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid revistaEasy3D" style="width: 100px; margin-left: 20px;"/></a>
  </div> 
  <div style="justify-content: center;" class="col-md-12 com-sm-12 d-inline text-center linhaAopiadoresRevista emobile">
    <div class="container">
      <div class="row">
        <div class="col-12" style="justify-content:center !important;">
          <p class="apoioinstitucional" style="font-family: raleway; color:#fff; text-align: center; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
        </div>
      </div>
    </div>
    <a href="https://www.dentsplysirona.com/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/corp-logo-branca-dentsply-sirona-logo.fw.png') }}" class="img-fluid revistapoio1"/></a>
    <a href="https://fgmdentalgroup.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/LOGO_FGMbranca.fw.png') }}" class="img-fluid revistaEasy3D"/></a>
    <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid revistaEasy3D" style="width: 100px;"/></a>
  </div>
  @elseif($idColecao == '2')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex linhaAopiadoresRevista">  
    <p style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold; margin-right: 40px;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="https://www.biologix.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/biologix.fw.png') }}" class="img-fluid revistapoio1"/></a>
  </div>
  @elseif($idColecao == '1')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex linhaAopiadoresRevista">  
    <!--p style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold; margin-right: 40px;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="https://www.traumec.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logo-traumec.png') }}" class="img-fluid" style="width: 200px;"/></a-->
  </div>
  @elseif($idColecao == '50')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex text-center linhaAopiadoresRevista naoedesktop">
    <p class="apoioinstitucional" style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="http://curaprox.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Curaprox-logo-branca.jpg') }}" class="img-fluid" style="width: 120px;"/></a>
    <a href="https://www.colgate.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Colgate-Logo-branca.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.gumbrand.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/GUM-Logo-branca.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.bionnovation.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/bionnovation.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.oralb.com.br/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/oral-b.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://plenum.bio/" target="_blank"><img src="{{ asset('imagens/siteRevista/plenum.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.geistlich.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Geistlich.fw.png') }}" class="img-fluid" style="width: 120px; margin-left: 20px;"/></a>
    <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid revistaEasy3D" style="width: 100px; margin-left: 20px;"/></a>
  </div> 
  <div style="justify-content: center;" class="col-md-12 com-sm-12 d-inline text-center linhaAopiadoresRevista emobile">
    <div class="container">
      <div class="row">
        <div class="col-12" style="justify-content:center !important;">
          <p class="apoioinstitucional" style="font-family: raleway; color:#fff; text-align: center; font-weight: bold;">{{__("messages.APOIOInstitucional")}}</p>
        </div>
      </div>
    </div>
    <a href="http://curaprox.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Curaprox-logo-branca.jpg') }}" class="img-fluid" style="width: 120px;"/></a>
    <a href="https://www.colgate.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Colgate-Logo-branca.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.gumbrand.com/" target="_blank"><img src="{{ asset('imagens/siteRevista/GUM-Logo-branca.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.bionnovation.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/bionnovation.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.oralb.com.br/pt-br" target="_blank"><img src="{{ asset('imagens/siteRevista/oral-b.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://plenum.bio/" target="_blank"><img src="{{ asset('imagens/siteRevista/plenum.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://www.geistlich.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/Geistlich.fw.png') }}" class="img-fluid" style="width: 120px; "/></a>
    <a href="https://cvdentus.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/cvdentusbranca.png') }}" class="img-fluid revistaEasy3D" style="width: 100px;"/></a>
  </div>
  @elseif($idColecao == '6')
  <div style="justify-content: center;" class="col-md-12 col-sm-12 d-flex linhaAopiadoresRevista">  
    <p style="font-family: raleway; color:#fff; width: 8%; text-align: justify; font-weight: bold; margin-right: 40px;">{{__("messages.APOIOInstitucional")}}</p>
    <a href="https://www.orthometric.com.br/" target="_blank"><img src="{{ asset('imagens/siteRevista/logobrancaorthometric.fw (1).png') }}" class="img-fluid" style=" width: 200px;"/></a>
  </div> 
  @else
  <div class="col-md-12 col-sm-12 d-inline linhaAopiadoresRevista"></div>
  @endif
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
                            <h5 class="offcanvas-title" id="offcanvasNavbar2Label">{{__("messages.RevistaBladeCap")}}</h5><hr>
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
                    <div id="adobe-dc-view"></div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
          </div>
        </div>
      </div>
    </div>
@endif

<div class="modal fade" id="gotalk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="iframe-container">
                <iframe id="audioPlayerIframe" src="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('gotalk');
        const iframe = document.getElementById('audioPlayerIframe');
        const buttons = document.querySelectorAll('.openModalBtn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const audioUrl = this.getAttribute('data-audio-url'); // Obtém a URL do áudio do botão
                const playerUrl = `https://dentalgo.com.br/audioplayer?url=` + audioUrl;
                
                console.log("Carregando Iframe com URL:", playerUrl); // Log para depuração
                iframe.src = playerUrl;
            });
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            iframe.src = ""; // Limpa o iframe ao fechar o modal
            console.log("Iframe removido.");
        });
    });
</script>
 <style>
    .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .modal-backdrop {
        backdrop-filter: blur(10px);
        background: rgba(100, 0, 0, 0.5); /* Tom avermelhado */
    }

    .iframe-container {
        width: 100%;
        height: 500px; /* Defina a altura conforme necessário */
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
</style>


<div class="container">
    <div class="row espacamentointerno-revista">
      @if($idColecao == '5')
        <div class="col-sm-3">
          
        </div>
        
        <div class="col-sm-9 ps-5 text-center botaoColetanea">
          <a href="{{ route('colecao') }}/{{ Request()->segment(4) }}" style="text-decoration: none;">
            <button type="button" class="btn btn-primary btn-lg">{{__("messages.BOTAOVerAcervo")}}</button>
          </a>
          @foreach ($revista[0]->productItems as $key => $capitulo)
              @if(isset($capitulo->data))
                @if(isset($capitulo->data->corpo))
                  @if($capitulo->data->corpo == 'editorial')
                    @if($capitulo->language == $linguagem)
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary btn-lg corpoEditorial{{$capitulo->language}} botaoCorpo" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}" style="display:block;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                      @else
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary btn-lg corpoEditorial{{$capitulo->language}} botaoCorpo" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}" style="display:none;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                    @endif
                  @endif
                @endif
              @endif
          @endforeach
        </div>
      @else
        <div class="col-sm-3">
          
        </div>
          
        <div class="col-sm-9 ps-5 text-center botaoColetaneaMenosClinical">
          <a href="{{ route('colecao') }}/{{ Request()->segment(4) }}" style="text-decoration: none;">
            <button type="button" class="btn btn-primary btn-lg">{{__("messages.BOTAOVerAcervo")}}</button>
          </a>
          @foreach ($revista[0]->productItems as $key => $capitulo)
            @if(isset($capitulo->data))
              @if(isset($capitulo->data->corpo))
                @if($capitulo->data->corpo == 'editorial')
                    @if($capitulo->language == $linguagem)
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary btn-lg corpoEditorial{{$capitulo->language}} botaoCorpo" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}" style="display:block;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                    @else
                      <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary btn-lg corpoEditorial{{$capitulo->language}} botaoCorpo" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}" style="display:none;">{{__("messages.BOTAOCorpoEditorial")}}</button>
                    @endif
                @endif
              @endif
            @endif
          @endforeach
        </div>
      @endif
    </div>
    <div class="row">

      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-12">
              <ul class="nav nav-tabs centerTab" id="myTab" role="tablist">
                <li class="nav-item centerTab" role="presentation">
                    @if(in_array('pt', $revista[0]->availableLanguages))
                      <button class="nav-link buscaLink @if($linguagem == 'pt') active @endif" id="portugues-tab" data-bs-toggle="tab" data-bs-target="#portugues" type="button" role="tab" aria-controls="portugues" aria-selected="true">{{__("messages.IdiomaBladePt")}}</button>
                    @else
                      <button class="nav-link buscaLink disabled button-off" id="portugues-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladePt")}}</button>
                    @endif
                </li>
                <li class="nav-item centerTab" role="presentation">
                    @if(in_array('es', $revista[0]->availableLanguages))
                        <button class="nav-link buscaLink @if($linguagem == 'es') active @endif" id="espanhol-tab" data-bs-toggle="tab" data-bs-target="#espanhol" type="button" role="tab" aria-controls="espanhol" aria-selected="false">{{__("messages.IdiomaBladeEs")}}</button>
                    @else
                        <button class="nav-link buscaLink disabled button-off" id="espanhol-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladeEs")}}</button>
                    @endif
                </li>
                <li class="nav-item centerTab" role="presentation">
                    @if(in_array('en', $revista[0]->availableLanguages))
                        <button class="nav-link buscaLink @if($linguagem == 'en') active @endif" id="ingles-tab" data-bs-toggle="tab" data-bs-target="#ingles" type="button" role="tab" aria-controls="ingles" aria-selected="false">{{__("messages.IdiomaBladeEn")}}</button>
                    @else
                        <button class="nav-link buscaLink disabled button-off" id="ingles-tab" type="button" role="tab" aria-disabled="true">{{__("messages.IdiomaBladeEn")}}</button>
                    @endif
                </li>
            </ul>
              <div class="tab-content" id="myTabContent">
                  <!-- TAB PORTUGUES -->
                  <div class="tab-pane fade @if($linguagem == 'pt') show active @endif" id="portugues" role="tabpanel" aria-labelledby="portugues-tab">
                      <!-- Conteúdo da aba em português -->
                      @foreach ($revista[0]->productItems as $key => $capitulo)
                        @if(isset($capitulo->data))
                          @if(isset($capitulo->data->corpo))
                            @if($capitulo->data->corpo == 'editorial')
                              @continue
                            @endif
                          @endif
                        @endif

                          @if($capitulo->language == 'pt')
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
                                      @if($modalConteudo == 'permitido')
                                        <!--<a href="#"><i class="fa-regular fa-heart fa-2xl iconeArtigo"></i></a>
                                        <a href="#"><i class="fa-solid fa-square-plus fa-2xl iconeArtigo"></i></a> 
                                        <a href="#"><i class="fa-solid fa-download fa-2xl iconeArtigo"></i></a> -->
                                        <a href="{{ route('artigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}" style="text-decoration: none; color:#000;"><h1 class="revistaImagemArtigoh1" style="font-family: 'Montserrat'; text-decoration:none !important; " >{{ $capitulo->title }}</h1></a>
                                        <!--<a href="{{ route('compraartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}" class="btn btn-primary compras">COMPRAR ARTIGO</a>-->
                                        <!--<button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary leiamaisbotao" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">-->                                  
                                        @else
                                        <!--<a href="#"><i class="fa-regular fa-heart fa-2xl iconeArtigo expand-icon1"></i></a>
                                        <a href="#"><i class="fa-solid fa-square-plus fa-2xl iconeArtigo expand-icon1"></i></a>
                                        <a href="#"><i class="fa-solid fa-download fa-2xl iconeArtigo expand-icon1"></i></a>  -->
                                        <a href="{{ route('artigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}" style="text-decoration: none; color:#000;"><h1 class="revistaImagemArtigoh1" style="font-family: 'Montserrat'; text-decoration:none !important; " >{{ $capitulo->title }}</h1></a>
                                        <!--<<a href="{{ route('compraartigo') }}/{{ $revista[0]->id }}/{{ str_replace(' ', '-', $revista[0]->title) }}/{{ $capitulo->id }}/{{ str_replace(' ', '-', $capitulo->title) }}" class="btn btn-primary compras">COMPRAR ARTIGO</a>-->
                                        <!--<button type="button" class="btn btn-primary leiamaisbotao" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">-->
                                      @endif
                                      <p class="revistaImagemArtigop">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                                      <p class="revistaImagemArtigop1">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>

                                      <p class="revistaImagemArtigop2">{{__("messages.RevistaBladeKeywords")}}: @foreach ($itensCapitulo->keywords as $key => $keywords){{ $keywords->keyword }}. @endforeach</p>
                                      @if($modalConteudo == 'permitido')
                                          <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                        @if(session()->get('usuarioPlanoID') != 274)
                                          <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">  
                                            Download
                                          </a>
                                        @endif
                                        @else
                                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}"> {{__("messages.RevistaBladeLerArtigo")}}</button>
                                       @endif  
                                       @if(isset($capitulo->data->html))
                                          @if($modalConteudo == 'permitido')
                                            <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                          @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                          @endif
                                        @endif

                                      @if(isset($capitulo->data->gotalk))
                                        @if(isset($capitulo->data->liberado))
                                          @if($capitulo->data->liberado == 'true')
                                            <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                          @else
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                            @else
                                              <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                              <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                            @endif
                                          @endif
                                        @else
                                          @if($modalConteudo == 'permitido')
                                            <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                          @else
                                              <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                              <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                          @endif
                                        @endif
                                      @endif              
                      
                                    </div>
                                    <div class="col-md-6 revistaImagemArtigo d-none d-md-block" style="background: url( {{ $capitulo->cover }}) no-repeat center center !important;">
                                    </div>
                                  </article>
                              
                              @else
                                  <article class="row shadowbox-article">
                                      <div class="col-sm-12">
                                          <h1 class="shadowbox-articleh1" style="font-family: 'Montserrat';">{{ $capitulo->title }}</h1>
                                          <p class="shadowbox-articlep " style="font-family: 'Open Sans';">{{ limita_caracteres(strip_tags( strip_tags($capitulo->brief) ), 300, false) }}</p>
                                          <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                          @if(($modalConteudo == 'permitido') OR  ($capitulo->customerCourtesy == 1))  
                                            <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                            <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">
                                              Download
                                            </a>
                                          @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                          @endif
                                          @if(isset($capitulo->data->html))
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                            @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                            @endif
                                          @endif

                                          @if(isset($capitulo->data->gotalk))
                                            @if(isset($capitulo->data->liberado))
                                              @if($capitulo->data->liberado == 'true')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                              @else
                                                @if($modalConteudo == 'permitido')
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                                @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                                @endif
                                              @endif
                                            @else
                                              @if($modalConteudo == 'permitido')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                              @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                              @endif
                                            @endif
                                          @endif      
                                      </div>
                                  </article>
                              @endif
                          @endif
                      @endforeach
                  </div>

                  <!-- TAB Espanhol -->
                  <div class="tab-pane fade @if($linguagem == 'es') show active @endif" id="espanhol" role="tabpanel" aria-labelledby="espanhol-tab">
                      <!-- Conteúdo da aba em espanhol -->
                      @foreach ($revista[0]->productItems as $key => $capitulo)
                        @if(isset($capitulo->data))
                          @if(isset($capitulo->data->corpo))
                            @if($capitulo->data->corpo == 'editorial')
                              @continue
                            @endif
                          @endif
                        @endif
                          @if($capitulo->language == 'es')
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
                                         
                                          @if(($modalConteudo == 'permitido') OR  ($capitulo->customerCourtesy == 1))   
                              
                                              <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                              <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">
                                                Download
                                              </a>

                                          @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">{{__("messages.RevistaBladeLerArtigo")}}</button>

                                          @endif  
                                          @if(isset($capitulo->data->html))
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                            @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                            @endif
                                          @endif

                                          @if(isset($capitulo->data->gotalk))
                                            @if(isset($capitulo->data->liberado))
                                              @if($capitulo->data->liberado == 'true')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                              @else
                                                @if($modalConteudo == 'permitido')
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                                @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                                @endif
                                              @endif
                                            @else
                                              @if($modalConteudo == 'permitido')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                              @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                              @endif
                                            @endif
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
                                          <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>
                                          <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaAutores")}}: @foreach ($itensCapitulo->keywords as $key => $keywords){{ $keywords->keyword }}, @endforeach</p>
                                          @if(($modalConteudo == 'permitido') OR  ($capitulo->customerCourtesy == 1)) 
                                            <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                            <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">
                                              Download
                                            </a>

                                          @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                             
                                          <!-- @endif -->
                                          @if(isset($capitulo->data->html))
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                            @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                            @endif
                                          @endif

                                          @if(isset($capitulo->data->gotalk))
                                            @if(isset($capitulo->data->liberado))
                                              @if($capitulo->data->liberado == 'true')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                              @else
                                                @if($modalConteudo == 'permitido')
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                                @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                                @endif
                                              @endif
                                            @else
                                              @if($modalConteudo == 'permitido')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                              @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                              @endif
                                            @endif
                                          @endif    
                                      </div>
                                  </article>
                              @endif
                          @endif
                      @endforeach
                  </div>

                  <!-- TAB INGLÊS -->
                  <div class="tab-pane fade @if($linguagem == 'en') show active @endif" id="ingles" role="tabpanel" aria-labelledby="ingles-tab">
                      <!-- Conteúdo da aba em inglês -->
                      @foreach ($revista[0]->productItems as $key => $capitulo)

                        
                        @if(isset($capitulo->data))
                          @if(isset($capitulo->data->corpo))
                            @if($capitulo->data->corpo == 'editorial')
                              @continue
                            @endif
                          @endif
                        @endif
                          @if($capitulo->language == 'en')
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
                                         
                                          @if(($modalConteudo == 'permitido') OR ($capitulo->customerCourtesy == 1)) 
                                            <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                            <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">
                                              Download
                                            </a>

                                          @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                              
                                          @endif
                                          @if(isset($capitulo->data->html))
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                            @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                            @endif
                                          @endif

                                          @if(isset($capitulo->data->gotalk))
                                            @if(isset($capitulo->data->liberado))
                                              @if($capitulo->data->liberado == 'true')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                              @else
                                                @if($modalConteudo == 'permitido')
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                                @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                                @endif
                                              @endif
                                            @else
                                              @if($modalConteudo == 'permitido')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                              @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                              @endif
                                            @endif
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
                                          <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaBladeAutores")}}: @foreach ($itensCapitulo->authors as $key => $autor){{ $autor->name }}, @endforeach</p>

                                          <p class="shadowbox-articlep1" style="font-family: 'Open Sans';">{{__("messages.RevistaAutores")}}: @foreach ($itensCapitulo->keywords as $key => $keywords){{ $keywords->keyword }}, @endforeach</p>
                                          @if($modalConteudo == 'permitido' OR ($capitulo->customerCourtesy == 1))
                                            <button type="button" id="artigoCap{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapitulo{{$capitulo->id}}">{{__("messages.RevistaBladeLerArtigo")}}</button>
                                            <a href="{{ $capitulo->content }}" target="_blank" class="botao-download btn btn-primary">
                                              Download
                                            </a>

                                          @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">{{__("messages.RevistaBladeLerArtigo")}}</button>

                                          @endif
                                          @if(isset($capitulo->data->html))
                                            @if($modalConteudo == 'permitido')
                                              <button type="button" id="artigoCapHtml{{ $capitulo->id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leiaCapituloHtml{{$capitulo->id}}">Ler em HTML</button>
                                            @else
                                              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">Ler em HTML</button>
                                            @endif
                                          @endif

                                          @if(isset($capitulo->data->gotalk))
                                            @if(isset($capitulo->data->liberado))
                                              @if($capitulo->data->liberado == 'true')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk" style="background-color: limegreen; border-color: limegreen;">GoTalks</button>
                                              @else
                                                @if($modalConteudo == 'permitido')
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                                @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                                @endif
                                              @endif
                                            @else
                                              @if($modalConteudo == 'permitido')
                                                <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#gotalk">GoTalks</button>
                                              @else
                                                  <!-- <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}" style="background-color:dimgrey; border-color: dimgrey;">GoTalk &nbsp;&nbsp;<i class="fa-solid fa-lock"></i></button> cinza bloqueado -->
                                                  <button type="button" class="btn btn-primary openModalBtn" data-audio-url="{{$capitulo->data->gotalk}}" data-bs-toggle="modal" data-bs-target="#{{ $modalConteudo }}">GoTalks</button>
                                              @endif
                                            @endif
                                          @endif     
                                      </div>
                                  </article>
                              @endif
                          @endif
                      @endforeach
                  </div>
              </div>
          </div>
      </div>
    </div>

      
    @foreach ($revista[0]->productItems as $key => $capitulo)
        

    @if($modalConteudo == 'permitido' || isset($capitulo->data->corpo) == 'editorial' || ($capitulo->customerCourtesy == 1))
            <!-- Modal do artigo -->
            <div class="modal fade" id="leiaCapitulo{{$capitulo->id}}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
              <div class="modal-dialog" style="--bs-modal-width: 98%;">
                <div class="modal-content" style="background-color: #fff;">
                  <div class="modal-header" style="background-color: #fff;">
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
                                //clientId: "509e95046c654d969e54d6c182aceba0",
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
                    </script>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("messages.RevistaBladeFechar")}}</button>
                  </div>
                </div>
              </div>
            </div>

              @if(isset($capitulo->data->html))
                  <div class="modal fade" id="leiaCapituloHtml{{$capitulo->id}}" tabindex="-1" aria-labelledby="leiaCapitulo{{$capitulo->id}}" aria-hidden="true">
                    <div class="modal-dialog" style="--bs-modal-width: 98%;">
                      <div class="modal-content" style="background-color: #fff;">
                        <div class="modal-header" style="background-color: #fff;">
                          <h5 class="modal-title" id="leiaCapituloHtml{{$capitulo->id}}">{{ $capitulo->title }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                        <p>For a Better Experience</p>
                        <p style="position: relative;">Click the button below, to change the language ↓</p>
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

  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        const price = parseFloat(this.getAttribute('data-price'));
        if (this.checked) {
          total += price;
        } else {
          total -= price;
        }
        updateTotal();
        setTimeout(atualizarCarrinho, 0); // Chama a função para atualizar o carrinho usando setTimeout
      });
    });
  });

  function updateTotal() {
    const formattedTotal = 'R$ ' + (total / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    document.getElementById('total').textContent = formattedTotal;
  }

  function atualizarCarrinho() {
    const carrinhoProdutos = document.getElementById('carrinhoProdutos');
    if (!carrinhoProdutos) return; // Verifica se o elemento carrinhoProdutos existe
    let algumSelecionado = false;

    carrinhoProdutos.innerHTML = ''; // Limpa o carrinho antes de atualizar

    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
      if (checkbox.checked) {
        algumSelecionado = true;
        const produtoContainer = checkbox.closest('.produto');
        if (!produtoContainer) return; // Verifica se o contêiner do produto existe

        const imagemProduto = produtoContainer.querySelector('img');
        const tituloProduto = produtoContainer.querySelector('.article-content-options');

        if (!imagemProduto || !tituloProduto) return; // Verifica se os elementos existem

        const imagemProdutoClone = imagemProduto.cloneNode(true);
        const tituloProdutoClone = tituloProduto.cloneNode(true);

        const produto = document.createElement('div');
        produto.className = 'produtoSelecionado';
        produto.appendChild(imagemProdutoClone);
        produto.appendChild(tituloProdutoClone);

        carrinhoProdutos.appendChild(produto);
      }
    });
    if (!algumSelecionado) {
      carrinhoVazio.style.display = 'block';
    } else {
      carrinhoVazio.style.display = 'none';
    }
  }
</script>

<script>
     // Função para trocar a imagem ao clicar na aba
function trocarImagem(classeDaImagem) {
    // Esconder todas as imagens com a classe "mostrar-imagem"
    var imagens = document.querySelectorAll('.mostrar-imagem');
    imagens.forEach(function(imagem) {
        imagem.style.display = 'none';
    });

    // Mostrar a imagem desejada
    var imagensDesejadas = document.querySelectorAll('.' + classeDaImagem);
    imagensDesejadas.forEach(function(imagemDesejada) {
        imagemDesejada.style.display = 'block';
    });

    // Esconder todos os elementos com a classe "corpoEditoriales", "corpoEditorialpt" e "corpoEditorialen"
    var elementosCorpoEditoriales = document.querySelectorAll('.corpoEditoriales');
    elementosCorpoEditoriales.forEach(function(elemento) {
        elemento.style.display = 'none';
    });

    var elementosCorpoEditorialpt = document.querySelectorAll('.corpoEditorialpt');
    elementosCorpoEditorialpt.forEach(function(elemento) {
        elemento.style.display = 'none';
    });

    var elementosCorpoEditorialen = document.querySelectorAll('.corpoEditorialen');
    elementosCorpoEditorialen.forEach(function(elemento) {
        elemento.style.display = 'none';
    });
}

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
