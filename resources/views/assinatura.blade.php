<?php
$tipoTopo = 'topoPreto';
$assinar = 0;

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
                        <h1>{{__("messages.SignBladeSucess")}} <br/>{{__("messages.SignBladeBom")}}</h1>
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

        <?php
            $assinar = 1;
        ?>
        

        @endif
    @endforeach

    @if($errors->all() == null)
        @if(isset(session()->get('usuario')->subscription))
            @if(session()->get('usuario')->subscription->status == 'canceled')
                <?php
                    $podeAsssinar = 'sim';
                ?>
            @else
            <div class="container" style="margin-top: 75px;">
                <div class="row">
                    <div class="col-sm-12" style="text-align: center;">
                        <i class="fa-solid fa-circle-check" style="font-size: 50px;"></i>
                        <h1>{{__("messages.SignBladeAlreadySign")}}</h1>
                    </div>
                </div>
            </div>
            @endif
        @else
            <?php
                $podeAsssinar = 'sim';
            ?>
        @endif
        @if($podeAsssinar = 'sim')
            @if(session()->has('token'))
                <div class="container" style="margin-top: 100px;">
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center; border-bottom: 2px solid gray; padding: 15px 0 ;">
                            <h3>{{__("messages.SignBladeClick")}} <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ModalGift">{{__("messages.SignBladeGiftCard")}}</button></h3>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-12" style="background: #dddddd; padding: 15px 0;">
                                <h3 style="text-align:center;">{{__("messages.SignBladeInfos")}}</h3>
                            </div>
                            <div class="col-sm-12">
                                <h1 style="text-align: center; border-bottom: 2px solid gray; padding: 15px 0;">{{ $assinatura['retornoPlano']->title }}</h1>
                                @foreach ($assinatura['retornoPlanoMais']->rows as $beneficio)
                                    <p style="padding: 0 15px;"><i class="fa-solid fa-check"></i> {{$beneficio->title}}</p>
                                @endforeach
                                <h2 style="border-top: 2px solid gray; padding-top: 15px; text-align: center; color: red; font-size: 75px; margin: 0;"><label style="font-size: 30px;"> {{__("messages.SignBladeReaul")}}</label>{{ number_format(($assinatura['retornoPlano']->price /100), 2, ',', ' ') }}</h2>
                                <p style="text-align: center;">{{__("messages.SignBladePerMonth")}}</p>
                            </div>
                            <?php
                                //print_r($assinatura);
                            ?>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-12" style="background: #dddddd; padding: 15px 0; margin-bottom: 15px;">
                                <h3 style="text-align: center;">{{__("messages.SignBladeAddPay")}}</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    
                                </div>
                            </div>
                            <div>
                                <div class="card-wrapper"></div>

                                <div class="form-container active">
                                    <form id="payment-form" action="{{ route('assinarplano') }}/{{ $assinatura['retornoPlano']->id }}" method="GET">
                                        <div class="row" style="margin-bottom: 15px; margin-top: 30px;">
                                            <div class="col-sm-12">
                                                <label for="nome" class="form-label">{{__("messages.SignBladeCardNum")}}</label>
                                                <input type="text" class="form-control credit_card_number" name="number" autocomplete="off" data-iugu="number" placeholder="{{__("messages.SignBladeCardNum")}}" aria-describedby="Número do Cartão" required>
                                            </div>
                                        </div> 
                                        <div class="row" style="margin-bottom: 15px;">
                                            <div class="col-sm-12">
                                                <label for="nome" class="form-label">{{__("messages.SignBladeName")}}</label>
                                                <input type="text" class="form-control credit_card_name" name="name" data-iugu="full_name" placeholder="{{__("messages.SignBladeName")}}" aria-describedby="Titular do Cartão" required>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 15px;">
                                            <div class="col-sm-6">
                                                <label for="nome" class="form-label">{{__("messages.SignBladeExpireDate")}}</label>
                                                <input type="text" class="form-control credit_card_expiration" name="expiry" autocomplete="on" data-iugu="expiration" placeholder="MM/AA" aria-describedby="MM/AA" required>
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
                                        <div class="row" style="margin-bottom: 15px;">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-danger" style="width: 100%;">{{__("messages.SignBladeConfirmPay")}}</button>
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

            @else
                <div class="container" style="margin-top: 75px;">
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;">
                            <i class="fa-solid fa-person-circle-exclamation" style="font-size: 120px;"></i>
                            <h1>{{__("messages.SignBladePagExclusiv")}}</h1>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endif

@endsection