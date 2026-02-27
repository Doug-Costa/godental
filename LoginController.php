<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Session;
use App\Mail\ExemploEmail;


class LoginController extends Controller
{
    public function login($params = [])
    {
        if($params == null){
            $email = Request()->input('email');
            $password = Request()->input('password');
            $tipoUsuario = 'pessoal';
        }else{
            $email = $params['usuario'];
            $password = $params['senha'];
            $tipoUsuario = 'institucional';
        }


        $response = Http::asForm()->post('https://api.dentalgo.com.br/sessions/sign-in', [
            'email' => $email,
            'password' => $password,
        ]);

        $retorno = $response->object();
        

        if(isset($retorno->token)){

            $token = session()->put('token', $retorno->token);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . session()->get('token'),
            ])->get('https://api.dentalgo.com.br/account/current-user');

            if ($response->successful()) {
                $retorno = $response->object();
            } else {
                // Tratamento de erros
                $statusCode = $response->status();
                $errorBody = $response->body();
                // Você pode registrar o erro ou retornar uma mensagem personalizada
                return back()->withErrors('Erro ao obter informações do usuário.')->withInput();
            }

            $retorno->tipoUsuario = $tipoUsuario;
            $usuario = session()->put('usuario', $retorno);


            if(isset($retorno->subscription->planId)){

                if($retorno->subscription->status == 'canceled'){
                    $usuarioPlano = session()->put('usuarioPlano', 'venceu');
                    $usuarioPermissao = session()->put('usuarioPermissao', 'naotemVencido');
                    return back()->withErrors('logadoVencido')->withInput();
                }else{

                    $idPlano = $retorno->subscription->planId;

                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . session()->get('token'),
                    ])->get('https://api.dentalgo.com.br/catalog/plans/'.$idPlano.'/collections', [
                        'page' => 1,
                    ]);

                    if ($response->successful()) {
                        $retorno_plano = $response->object();
                    } else {
                        // Tratamento de erros
                        $statusCode = $response->status();
                        $errorBody = $response->body();
                        // Você pode registrar o erro ou retornar uma mensagem personalizada
                        return back()->withErrors('Erro ao obter as coleções do plano.')->withInput();
                    }

                    $colecaoPermissao = array();
                    foreach ($retorno_plano->rows as $key => $colecao) {
                        $colecaoPermissao[$key] = $colecao->id;
                    }

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

                    $usuarioPlanoId = session()->put('usuarioPlanoID',$idPlano);
                    if(isset($retornoVerifica->code)){
                      if($retornoVerifica->code == 'subscriptionExpired'){
                        $usuarioPlano = session()->put('usuarioPlano', 'venceu');
                        $usuarioPermissao = session()->put('usuarioPermissao', 'naotemVencido');
                        return back()->withErrors('logadoVencido')->withInput();
                      }elseif($retornoVerifica->code == 'routeNotFound'){
                        $usuarioPlano = session()->put('usuarioPlano', $retorno_plano);
                        $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);
                        return back()->withErrors('logado')->withInput();
                      }
                    }else{

                        $usuarioPlano = session()->put('usuarioPlano', $retorno_plano);
                        $usuarioPlanoId = session()->put('usuarioPlanoID',$idPlano);
                        $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);
                        return back()->withErrors('logado')->withInput();

                        /*if (in_array("40", $colecaoPermissao)){
                            echo 'tem';
                        }else{
                            echo 'nao tem';
                        }*/
                    }

                }

            }else{
                $usuarioPlano = session()->put('usuarioPlano', 'semplano');
                $usuarioPermissao = session()->put('usuarioPermissao', 'naotemSemPlano');
                return back()->withErrors('logadoSem')->withInput();
            }



        }else{

            if(isset($retorno->code)){
                if($retorno->code == 'userNotFound'){

                    return back()->withErrors('errousuario')->withInput();

                }elseif($retorno->code == 'wrongPassword'){

                    return back()->withErrors('errosenha')->withInput();
                    
                }elseif($retorno->code == 'requestNewPassword'){

                    return back()->withErrors('errosenhaNova')->withInput();
                    
                }else{
                    return $retorno;
                }
            }else{
                return $retorno;
            }
        }

    }

    

    public function loginAuto($barear)
    {
        if(empty($barear)){
            $email = Request()->input('email');
            $password = Request()->input('password');


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://api.dentalgo.com.br/sessions/sign-in");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec ($ch);
            curl_close ($ch);

            $retorno = json_decode($server_output);

            if(isset($retorno->token)){
                $token = session()->put('token', $retorno->token);
            }
        }else{
            session()->flush();
            $token = $barear;
            $token = session()->put('token', $token);
        }

        if(!empty(session()->get('token'))){
            
            $ch = curl_init('https://api.dentalgo.com.br/account/current-user');
            $authorization = "Authorization: Bearer ".session()->get('token');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $infoUser = curl_exec($ch); 
            curl_close($ch); 

            $retorno = json_decode($infoUser);
            $tipoUsuario = 'pessoal';
            $retorno->tipoUsuario = $tipoUsuario;
            $usuario = session()->put('usuario', $retorno);

            if(isset($retorno->subscription->planId)){

                if($retorno->subscription->status == 'canceled'){
                    $usuarioPlano = session()->put('usuarioPlano', 'venceu');
                    $usuarioPermissao = session()->put('usuarioPermissao', 'naotemVencido');
                    return back()->withErrors('logadoVencido')->withInput();
                }else{

                    $idPlano = $retorno->subscription->planId;

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
                    $usuarioPlanoId = session()->put('usuarioPlanoID',$idPlano);
                    $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);
                    return back()->withErrors('logado')->withInput();

                    /*if (in_array("40", $colecaoPermissao)){
                        echo 'tem';
                    }else{
                        echo 'nao tem';
                    }*/

                }

            }else{
                $usuarioPlano = session()->put('usuarioPlano', 'semplano');
                $usuarioPermissao = session()->put('usuarioPermissao', 'naotemSemPlano');
                return back()->withErrors('logadoSem')->withInput();
            }



        }else{
            if(isset($retorno->code)){
                if($retorno->code == 'userNotFound'){

                    return back()->withErrors('errousuario')->withInput();

                }elseif($retorno->code == 'wrongPassword'){

                    return back()->withErrors('errosenha')->withInput();
                    
                }elseif($retorno->code == 'requestNewPassword'){

                    return back()->withErrors('errosenhaNova')->withInput();
                    
                }else{
                    return $retorno;
                }
            }else{
                return $retorno;
            }
        }

    }



    public function authenticate(Request $request)
    {
        // 1. Valida se o email e senha foram enviados
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Faz a requisição para a API externa da DentalGO
        $response = Http::asForm()->post('https://api.dentalgo.com.br/sessions/sign-in', [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // 3. Analisa a resposta da API
        if ($response->successful() && isset($response->object()->token)) {
            // SUCESSO!
            $retornoApi = $response->object();

            // Guarda o token e os dados do usuário na sessão
            session()->put('token', $retornoApi->token);
            session()->put('usuario', $retornoApi);

            // Responde ao JavaScript com sucesso
            return response()->json(['success' => true, 'message' => 'Login realizado!']);
        } else {
            // FALHA!
            $errorMessage = 'Credenciais inválidas.'; // Mensagem padrão
            if(isset($response->object()->code)) {
                $errorCode = $response->object()->code;
                if($errorCode == 'userNotFound') $errorMessage = 'Usuário não encontrado.';
                if($errorCode == 'wrongPassword') $errorMessage = 'Senha incorreta.';
            }
            // Responde ao JavaScript com o erro
            return response()->json(['success' => false, 'message' => $errorMessage], 422);
        }
    }

    

    public function logout()
    {
        $ch = curl_init('https://api.dentalgo.com.br/sessions/sign-out');
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch); 
        curl_close($ch); 
        session()->flush();
        return redirect()->back();
    }

    public function recsenha()
    {

        $email = Request()->input('email');

        // URL base da API
        $apiUrl = 'https://api.dentalgo.com.br/admin/people';

        // Parâmetros da requisição
        $params = [
            'q[email]' => $email,
            'q[admin]' => 0,
        ];

        // Constrói a URL final
        $url = $apiUrl . '?' . http_build_query($params);

        $token = Cache::get('tokenGlobal');

        $ch = curl_init($url);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch); 
        curl_close($ch); 

        $conteudo = json_decode($resultado);

        
        $localizado = 0;
        foreach ($conteudo->rows as $key => $valores) {
            if($valores->email == $email){
                $destinatario = $email;
                $assunto = 'E-mail de recuperação de senha DentalGo';
                $nomeUsuario = $valores->fullName;

                $linkRecuperacao = 'https://dentalgo.com.br/recuperarsenha?cod='.base64_encode($valores->id);

                // Envie o e-mail usando a Mailable personalizada
                Mail::to($destinatario)->send(new ExemploEmail($assunto, $nomeUsuario, $linkRecuperacao));
                $localizado = 1;
                return back()->withErrors('recSenhaSucess')->withInput();

            }
        }
        if($localizado == 0){
            return back()->withErrors('recSenhaErro')->withInput();
        }
        die();

        /*if($retorno == null){
            return back()->withErrors('recSenhaSucess')->withInput();
        }elseif(isset($retorno->code)){
            if($retorno->code == 'userNotFound'){
                return back()->withErrors('recSenhaErro')->withInput();
            }else{
                return back()->withErrors('recSenhaSucess')->withInput();
            }
        }else{
            return back()->withErrors('recSenhaSucess')->withInput();
        }*/

    }
}
?>