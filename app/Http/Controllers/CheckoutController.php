<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class CheckoutController extends Controller
{
	public function checkout(){
    if(session()->has('token')){

        $token = session()->get('token');

        $produto = Request()->segment(2);
        $artigos = request('q.productItemsIds');
        if($produto == null){
          return redirect()->route('home')->withErrors('informeProduto')->withInput();
        }else{
          if($artigos == null){
            $artigos = 'all';
          }else{
            $artigos = $artigos;
          }
        }





      // Consulta se o usuario está logado
     /*$url = 'https://api.dentalgo.com.br/catalog/subscriptions';
      $ch = curl_init($url); 
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      $result = curl_exec($ch);
      curl_close($ch);
      $retorno = json_decode($result);

      if(isset($retorno->code)){
        
        if($retorno->code == 'unauthorized'){
          return 'deslogou';
          die();
        }
      }*/
      // Consulta se o usuário está autorizado
      $response = Http::withToken(Session::get('token'))
          ->post('https://api.dentalgo.com.br/catalog/subscriptions');

      $retorno = $response->json();

      if (isset($retorno['code']) && $retorno['code'] === 'unauthorized') {
          Session::flush();
          return redirect()->back();
      }
      
      //VERIFICA OS PARAMETROS DO SISTEMA E DESCONTO PARA ASSINANTES
      $ch = curl_init('https://api.dentalgo.com.br/catalog/system-parameters');
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoSystemParameters = curl_exec($ch); 
      curl_close($ch);
      $systemParameters = json_decode($infoSystemParameters);

      //Verifica se o usuario ja tem um cadastro na Iugu e cartão salvo!
      $ch = curl_init('https://api.dentalgo.com.br/catalog/payment-profiles/current');
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoPaymentProfile = curl_exec($ch); 
      curl_close($ch);
      $paymentProfile = json_decode($infoPaymentProfile);

      $retornoProduto = null;
      $retornoItensProduto = null;
      if($artigos == 'all'){
        // CONSULTA SOBRE O Produto
        $ch = curl_init('https://api.dentalgo.com.br/catalog/purchases/preview?q%5BproductId%5D='.$produto);
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $infoProduto = curl_exec($ch); 
        curl_close($ch); 
        $retornoProduto = json_decode($infoProduto);
      }else{
        // CONSULTA SOBRE O Produto
        $ch = curl_init('https://api.dentalgo.com.br/catalog/purchases/preview?q%5BproductId%5D='.$produto);
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $infoProduto = curl_exec($ch); 
        curl_close($ch); 
        $retornoProduto = json_decode($infoProduto);

        //CONSULTA OS IDS DE ITENS DOS PRODUTOS COMO EXEMPLO ARTIGOS OU CAPITULOS
        $queryParams = array();
        foreach ($artigos as $index => $id) {
            $queryParams["q[productItemsIds][$index]"] = $id;
        }
        $url = 'https://api.dentalgo.com.br/catalog/purchases/preview?' . http_build_query($queryParams);
        $ch = curl_init($url);
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $infoItensProduto = curl_exec($ch); 
        curl_close($ch); 
        $retornoItensProduto = json_decode($infoItensProduto);
      }

    
      // CONSULTA SOBRE A IUGU
      $ch = curl_init('https://api.dentalgo.com.br/catalog/system-parameters/payment-gateway');
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoIugu = curl_exec($ch); 
      curl_close($ch); 
      $retornoIugu = json_decode($infoIugu);


      // CONSULTA SOBRE A COTAÇÃO 
      $ch = curl_init('https://api.dentalgo.com.br/catalog/monetary-quotes');
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoCotacao = curl_exec($ch); 
      curl_close($ch); 
      $retornoCotacao = json_decode($infoCotacao);


      $conteudoFinal = array("systemParameters" => $systemParameters, "paymentProfile" => $paymentProfile, "retornoProduto" => $retornoProduto, "retornoItensProduto" => $retornoItensProduto, "retornoIugu" => $retornoIugu, "retornoCotacao" => $retornoCotacao);


      return $conteudoFinal;

    }else{
      return redirect()->route('home')->withErrors('crieSeuCadastro')->withInput();
    }
  }

  public function checkoutpaypay(){



    $cardHash = Request()->input('token');
    $paymentGatewayType = 'iugu';
    $idproduct = Request()->segment(2);
    $artigos = request('q.productItemsIds');

    if($cardHash !== null){
      if($paymentGatewayType !== null){
        if($idproduct !== null){
          $erro = 0;
        }else{
          $erro = 1;
        }
      }else{
        $erro = 1;
      }
    }else{
      $erro = 1;
    }

    if($erro == 1){
      return back()->withErrors('erroCartao')->withInput();
    }else{

      if($idproduct == null){
        return redirect()->route('home')->withErrors('informeProduto')->withInput();
      }else{
        if($artigos == null){
          $infoAssinatura = array(
            "cardHash" => "$cardHash",
            "paymentGatewayType" => "$paymentGatewayType",
            "couponCode" => ''
          );
          $url = 'https://api.dentalgo.com.br/catalog/purchases/products/'.$idproduct;
        }else{
          $artigos = array_map('intval', $artigos);
          $infoAssinatura = array(
            "cardHash" => "$cardHash",
            "paymentGatewayType" => "$paymentGatewayType",
            "couponCode" => '',
            "productItemsIds" => $artigos
          );
          $url = 'https://api.dentalgo.com.br/catalog/purchases/product-items';
        }
      }



      $infoAssinaturaJ = json_encode($infoAssinatura);

      $token = session()->get('token');

      
      $ch = curl_init($url); 
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $infoAssinaturaJ);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      $result = curl_exec($ch);
      curl_close($ch);

      $retorno = json_decode($result);

      if(isset($retorno->code)){
        if($retorno->code == "unknown"){
          if(isset($retorno->additionalProperties->errors->cpf_cnpj)){
            return back()->withErrors('erroCPF')->withInput();
          }else{
            return back()->withErrors('erroCartao')->withInput();
          }
        }elseif($retorno->code == "unauthorized"){
            return 'deslogou';
            die();
        }elseif($retorno->code == "purchasePaymentError"){
          return back()->withErrors('erroCartao')->withInput();
        }
      }else{
        app('App\Http\Controllers\LoginController')->loginAuto(session()->get('token'));
        return back()->withErrors('sucessoCartao')->withInput();
      }

    }
  }
}
?>