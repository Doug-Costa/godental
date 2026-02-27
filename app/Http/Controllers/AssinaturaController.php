<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class AssinaturaController extends Controller
{
	public function assinar(){
    if(session()->has('token')){

    		$token = session()->get('token');

        $plan = Request()->input('plan');
        $panUrl = Request()->segment(2);
        if($plan == null){
          if($panUrl == null){
            $plan = 262;
          }else{
            $plan = $panUrl;
          }
        }else{
          $plan = $plan;
        }


        if(null !== session()->get('plano')){
          $plan = session()->get('plano');
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
        


  		// CONSULTA SOBRE O PLANO
  		$ch = curl_init('https://api.dentalgo.com.br/catalog/plans/'.$plan);
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoPlano = curl_exec($ch); 
      curl_close($ch); 
      $retornoPlano = json_decode($infoPlano);

      // CONSULTA Mais SOBRE O PLANO
      $ch = curl_init('https://api.dentalgo.com.br/catalog/plans/'.$plan.'/collections?page=1');
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $infoPlanoMais = curl_exec($ch); 
      curl_close($ch); 
      $retornoPlanoMais = json_decode($infoPlanoMais);

		
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


      $conteudoFinal = array("retornoPlano" => $retornoPlano, "retornoPlanoMais" => $retornoPlanoMais, "retornoIugu" => $retornoIugu, "retornoCotacao" => $retornoCotacao);


      return $conteudoFinal;

  	}else{
      return redirect()->route('home')->withErrors('crieSeuCadastro')->withInput();
  	}
  }

  public function assinarPlano(){



    $cardHash = Request()->input('token');
    $paymentGatewayType = 'iugu';
    $plan = Request()->segment(2);


    if($cardHash !== null){
      if($paymentGatewayType !== null){
        if($plan !== null){
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

      $infoAssinatura = array(
            "cardHash" => "$cardHash",
            "paymentGatewayType" => "$paymentGatewayType",
            "plan" => array("id" => "$plan")
          );

      $infoAssinaturaJ = json_encode($infoAssinatura);

      $token = session()->get('token');

      $url = 'https://api.dentalgo.com.br/catalog/subscriptions';
      $ch = curl_init($url); 
      $authorization = "Authorization: Bearer ".session()->get('token');
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $infoAssinaturaJ);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
      $result = curl_exec($ch);
      curl_close($ch);

      $retorno = json_decode($result);

      // Consulta se o usuário está autorizado
      /*$response = Http::withToken(Session::get('token'))
          ->post('https://api.dentalgo.com.br/catalog/subscriptions');

      $retorno = $response->json();*/

      /*if (isset($retorno['code']) && $retorno['code'] === 'unauthorized') {
          Session::flush();
          return redirect()->back();
      }*/



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
        }
      }else{
        //if($retorno->expiresIn == null){
          if(isset($retorno->status)){

            /*$url = 'https://api.dentalgo.com.br/subscription';
            $ch = curl_init($url); 
            $authorization = "Authorization: Bearer ".session()->get('token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            $result = curl_exec($ch);
            curl_close($ch);

            $retornoVerifica = json_decode($result);*/
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session()->get('token'),
            ])->get('https://api.dentalgo.com.br/subscription');
            /*dd([
                'Status Code' => $response->status(),
                'Headers' => $response->headers(),
                'Body' => $response->body(),
                'JSON' => $response->json(),
            ]);*/
            if ($response->successful()) {
                $retornoVerifica = $response->object();
                // Continue com a lógica existente
            } else {
                $statusCode = $response->status();
                $errorBody = $response->body();
                \Log::error("Erro ao verificar a assinatura: HTTP $statusCode - $errorBody");
                // Opcionalmente, você pode usar dd() para depurar
                // dd($statusCode, $errorBody);
                return back()->withErrors('Erro ao verificar a assinatura.')->withInput();
            }
            if(isset($retornoVerifica->code)){
              if($retornoVerifica->code == 'subscriptionExpired'){
                return back()->withErrors('erroCartaoValido')->withInput();
              }else{
                $idPlano = $retorno->plan->id;
                $ch = curl_init('https://api.dentalgo.com.br/catalog/plans/'.$idPlano.'/collections?page=1');
                $authorization = "Authorization: Bearer ".session()->get('token');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $info_plano = curl_exec($ch); 
                curl_close($ch); 
                $retorno_plano = json_decode($info_plano);

                $colecaoPermissao = array(); 
                foreach ($retorno_plano->rows as $key => $colecao) {
                    $colecaoPermissao[$key] = $colecao->id;
                }

                $usuarioPlano = session()->put('usuarioPlano', $retorno_plano);
                $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);

                return back()->withErrors('sucessoCartao')->withInput();
              }
            }else{

              $idPlano = $retorno->plan->id;
              $ch = curl_init('https://api.dentalgo.com.br/catalog/plans/'.$idPlano.'/collections?page=1');
              $authorization = "Authorization: Bearer ".session()->get('token');
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
              $info_plano = curl_exec($ch); 
              curl_close($ch); 
              $retorno_plano = json_decode($info_plano);

              $colecaoPermissao = array(); 
              foreach ($retorno_plano->rows as $key => $colecao) {
                  $colecaoPermissao[$key] = $colecao->id;
              }

              $usuarioPlano = session()->put('usuarioPlano', $retorno_plano);
              $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);

              return back()->withErrors('sucessoCartao')->withInput();
            }
          }
        /*}else{
          return back()->withErrors('erroCartaoValido')->withInput();
        }*/
      }

    }
  }
}
?>