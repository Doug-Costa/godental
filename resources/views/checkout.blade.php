<?php
$tipoTopo = 'topoPreto';
$assinar = 0;

$artigosUrl = request('q.productItemsIds');
if($artigosUrl != null){
    $queryParams = array();
    foreach ($artigosUrl as $index => $id) {
        $queryParams["q[productItemsIds][$index]"] = $id;
    }
    $queryParamsString = http_build_query($queryParams);
    //$urlCheckout = Request()->segment(2).'?'.$queryParamsString;
    $urlCheckout = Request()->segment(2);
}else{
    $urlCheckout = Request()->segment(2);
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
    @foreach ($errors->all() as $error)

        @if($error == 'crieSeuCadastro')
            <div class="container" style="margin-top: 75px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__("messages.SignBladeExclusiva")}}</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'sucessoCartao')
            <div class="container" style="margin-top: 125px; margin-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6" style="text-align: center; -webkit-box-shadow: 1px 1px 5px 0px rgb(0 0 0 / 75%); -moz-box-shadow: 1px 1px 5px 0px rgba(0,0,0,0.75); box-shadow: 1px 1px 5px 0px rgb(0 0 0 / 75%); border-radius: 15px; padding: 30px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 75px; color: green; margin-bottom:30px;"></i>
                        <h1>{{__("messages.SignCladeSucess")}} <br/>{{__("messages.SignBladeBom")}}</h1>
                    </div>
                    <div class="col-sm-3"></div>
                </div>
            </div>
        @elseif($error == 'erroCPF')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__("messages.SignBladeCpfErro")}}</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'erroCartao')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__("messages.SignBladeCardError")}}</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'erroCartaoValido')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Pendente no Gatway de pagamento por favor aguarde enquanto valida seu pagamento. Obrigado por sua compreensão <br> tente logar novamente mais tarde</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'erroJaTemPlano')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__("messages.SignBladeAlreadyExists")}} <br> {{__("messages.SignBladeGiftValid")}} <br> {{__("messages.SignBladeWhenExpire")}}</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'erroGiftUsado')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__("messages.SignBladeAlreadyInUse")}}</h1>
                    </div>
                </div>
            </div>
        @elseif($error == 'erroGiftInvalido')
            <div class="container" style="margin-top: 100px;">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>{{__(messages.SignBladeInvalid)}}<a href="{{ route('assinatura') }}"  type="button" class="btn btn-danger">{{__("messages.SignBladeTry")}}</a></h1>
                    </div>
                </div>
            </div>
        @else

        

        @endif
    @endforeach

    @if($errors->all() == null)
        @if(session()->has('token'))
        <div class="container" style="margin-top: 65px; margin-bottom: 80px;">
            <div class="row">
                @if(isset($checkout['retornoProduto']->product))
                    @if($checkout['retornoItensProduto'] == null)
                        <div class="col-sm-6">
                            <div class="col-sm-12" style="background: #000000; padding: 15px 0;">
                                <h3 style="text-align:center; color:#FFFFFF;">{{__("messages.SignBladeInfos")}}</h3>
                            </div>
                            <div class="col-sm-12">
                                <img src="{{$checkout['retornoProduto']->product->cover}}" class="img-fluid" style="max-height: 150px; margin: 25px auto; display: block;" />
                                <h1 style="text-align: center; padding: 15px 0;">{{$checkout['retornoProduto']->product->title}}</h1>
                                <h2 style="border-top: 2px solid gray; padding-top: 15px; text-align: center; color: #1d96aa; font-size: 75px; margin: 0;"><label style="font-size: 30px;"> {{__("messages.SignBladeReaul")}}</label> {{number_format(($checkout['retornoProduto']->product->price /100), 2, ',', ' ') }}</h2>
                            </div>
                        </div>
                    @endif
                @endif
                @if(isset($checkout['retornoItensProduto']->productItems))
                    @if($checkout['retornoItensProduto']->productItems != null)
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12" style="background: #000000; padding: 15px 0; margin-bottom: 25px;">
                                    <h3 style="text-align:center; color:#FFFFFF;">{{__("messages.SignBladeInfos")}}</h3>
                                </div>
                                    @php
                                        $preco = 0;
                                    @endphp
                                    @foreach ($checkout['retornoItensProduto']->productItems as $key => $artigo)
                                        @php
                                            $preco += $artigo->price
                                        @endphp
                                        <div class="col-2" style="margin-bottom:15px;">
                                            <img src="{{$artigo->cover}}" class="img-fluid">
                                        </div>
                                        <div class="col-9" style="margin-bottom:15px;">
                                            <h3 style="font-size:14px;">{{$artigo->title}}</h3>
                                        </div>
                                    @endforeach
                                    <div class="col-12">
                                        <h2 style="border-top: 2px solid gray; padding-top: 15px; text-align: center; color: #1d96aa; font-size: 75px; margin: 0;"><label style="font-size: 30px;"> {{__("messages.SignBladeReaul")}}</label> {{number_format(($preco /100), 2, ',', ' ') }}</h2>
                                    </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="col-sm-6">
                    <div class="col-sm-12" style="background: #000000; padding: 15px 0; margin-bottom: 15px;">
                        <h3 style="text-align: center; color:#FFFFFF;">{{__("messages.SignBladeAddPay")}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            
                        </div>
                    </div>
                    <div>
                        <div class="card-wrapper"></div>

                        <div class="form-container active">
                            <form id="payment-form" action="{{ route('checkoutpay') }}/{{$urlCheckout}}" method="GET">
                                <div class="row" style="margin-bottom: 15px; margin-top: 30px;">
                                    <div class="col-sm-12">
                                        <label for="nome" class="form-label">{{__("messages.SignBladeCardNum")}}</label>
                                        <input type="text" class="form-control credit_card_number" name="number" autocomplete="off" data-iugu="number" placeholder="Número do Cartão" aria-describedby="Número do Cartão" required>
                                    </div>
                                </div> 
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-sm-12">
                                        <label for="nome" class="form-label">{{__("messages.SignBladeName")}}</label>
                                        <input type="text" class="form-control credit_card_name" name="name" data-iugu="full_name" placeholder="Titular do Cartão" aria-describedby="Titular do Cartão" required>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-sm-6">
                                        <label for="nome" class="form-label">{{__("messages.SignBladeExpireDate")}}</label>
                                        <input type="text" class="form-control credit_card_expiration" name="expiry" autocomplete="off" data-iugu="expiration" placeholder="MM/AA" aria-describedby="MM/AA" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="nome" class="form-label">{{__("messages.SignBladeCvv")}}</label>
                                        <input type="text" class="form-control credit_card_cvv" name="cvc" autocomplete="off" data-iugu="verification_value" placeholder="CVV" aria-describedby="CVV" required>
                                    </div>
                                </div>
                                <div class="row" style="display: none;">
                                    <div class="col-sm-12">
                                        <label for="nome" class="form-label">{{__("messages.SignBladeCvv2")}}</label>
                                        <input type="text" name="token" id="token" value="" readonly="true" size="64" style="text-align:center" />
                                    </div>
                                </div>
                                @if($artigosUrl != null)
                                    <div style="display: none;">
                                        @foreach ($artigosUrl as $index => $idCap)
                                            <input type="checkbox" name="q[productItemsIds][]" value="{{$idCap}}" id="item{{$index}}" checked style="display:none;">
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-danger" style="width: 100%; color: #FFFFFF; --bs-btn-color: #fff;
    --bs-btn-bg: #1d96bd;
    --bs-btn-border-color: #1d96bd;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #1d96bd;
    --bs-btn-hover-border-color: #073746;
    --bs-btn-focus-shadow-rgb: 225,83,97;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #0c323e;
    --bs-btn-active-border-color: #0a3f50;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #1d96bd;
    --bs-btn-disabled-border-color: #1d96bd;">{{__("messages.SignBladeConfirmPay")}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                
                        

                        
                        
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
        <script src="https://www.jqueryscript.net/demo/Interactive-Credit-Card-Form-In-jQuery/jquery.card.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>
        <script type="text/javascript">
            const giftcardButton = document.querySelector("[name='submit-giftcard']");
            const giftcardForm = document.querySelector("#form-giftcard");

            giftcardButton.addEventListener("click", function(event) {
              event.preventDefault();
              // Validate giftcard form 
              giftcardForm.submit();
            });
        </script>
        <script type="text/javascript" src="https://js.iugu.com/v2"></script>
        <script>
          $('#payment-form').card({
                // a selector or DOM element for the container
                // where you want the card to appear
                container: '.card-wrapper', // *required*

                // all of the other options from above
            });
        </script>
        <script type="text/javascript">
            Iugu.setAccountID("0F1DB94596ED4E4388BFF71A7A1C79AC");
            jQuery(function($) {
              $('#payment-form').submit(function(evt) {
                  var form = $(this);
                  var tokenResponseHandler = function(data) {
                      
                      if (data.errors) {
                          alert("Erro salvando cartão: " + JSON.stringify(data.errors));
                      } else {
                          $("#token").val( data.id );
                          form.get(0).submit();
                      }
                      
                      // Seu código para continuar a submissão
                      // Ex: form.submit();
                  }
                  Iugu.createPaymentToken(this, tokenResponseHandler);
                  return false;
              });
            });
        </script>
    @endif

                

    @else
    <div class="container" style="margin-top: 75px;">
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <i class="fa-solid fa-person-circle-exclamation" style="font-size: 120px;"></i>
                    <h1>{{__("messages.SignBladePagExclusivCompra")}}</h1>
                </div>
            </div>
        </div>
    @endif

@endsection