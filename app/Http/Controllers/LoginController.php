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
        \Log::info('MÉTODO LOGIN EXECUTADO - Email: ' . Request()->input('email') . ' - Timestamp: ' . now());
        
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

                    // Fallback: Tentar autenticação via API Schoolar
                    \Log::info('FALLBACK SCHOOLAR - Tentando autenticação via API Schoolar para: ' . $email . ' - Timestamp: ' . now());
                    
                    try {
                        $schoolarResponse = Http::post('http://127.0.0.1:8081/api/autenticar', [
                            'email' => $email,
                            'senha' => $password
                        ]);

                        $schoolarRetorno = $schoolarResponse->object();

                        if (!$schoolarResponse->successful() || !isset($schoolarRetorno->token)) {
                            throw new \Exception('Falha na autenticação Schoolar');
                        }
                        
                        if(isset($schoolarRetorno->token)){
                            \Log::info('FALLBACK SCHOOLAR - Token obtido com sucesso para: ' . $email);
                            
                            // Armazenar token Schoolar na sessão
                            session()->put('tokenschoolar', $schoolarRetorno->token);
                            session()->put('token', $schoolarRetorno->token); // Para compatibilidade com templates
                            session()->put('token_expires_at', now()->addSeconds($schoolarRetorno->expires_in));
                            session()->put('tipoUsuario', 'schoolar');
                            
                            // Obter dados do usuário Schoolar
                            try {
                                $userResponse = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $schoolarRetorno->token,
                                    'Accept' => 'application/json'
                                ])->get('http://127.0.0.1:8081/api/aluno/dados');
                                
                                if($userResponse->successful()) {
                                    $userData = $userResponse->json();
                                } else {
                                    throw new \Exception('Erro ao obter dados do usuário: ' . $userResponse->status());
                                }
                                
                                if($userData && isset($userData['status']) && $userData['status'] === 'ok'){
                                    \Log::info('FALLBACK SCHOOLAR - Dados do usuário obtidos com sucesso para: ' . $email);
                                    
                                    // Armazenar dados do usuário na sessão
                                    session()->put('usuario', $userData);
                                    
                                    // Configurar permissões para acesso aos conteúdos DentalGo
                                    session()->put('usuarioPlano', (object)[
                                        'id' => 'schoolar_plan',
                                        'nome' => 'Plano Schoolar',
                                        'ativo' => true,
                                        'tipo' => 'completo'
                                    ]);

                                    // Array com todos os IDs das coleções para acesso completo
                                    $colecaoPermissao = [1, 2, 4, 5, 6, 7, 50, 67, 79];
                                    session()->put('usuarioPermissao', $colecaoPermissao);
                                    
                                    return back()->withErrors('logado')->withInput();
                                } else {
                                    \Log::error('FALLBACK SCHOOLAR - Falha ao obter dados do usuário para: ' . $email);
                                }
                                
                            } catch (\Exception $e) {
                                \Log::error('FALLBACK SCHOOLAR - Erro ao obter dados do usuário: ' . $e->getMessage());
                            }
                        } else {
                            \Log::info('FALLBACK SCHOOLAR - Falha na autenticação para: ' . $email);
                        }
                        
                    } catch (\Exception $e) {
                        \Log::error('FALLBACK SCHOOLAR - Erro na requisição: ' . $e->getMessage());
                    }

                    // Se chegou até aqui, o fallback Schoolar também falhou
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

            try {
                $response = \App\Services\SecureHttpService::post('https://api.dentalgo.com.br/sessions/sign-in', [
                    'email' => $email,
                    'password' => $password
                ], [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]);

                if($response['success']) {
                    $retorno = json_decode($response['response']);
                    if(isset($retorno->token)){
                        $token = session()->put('token', $retorno->token);
                    }
                } else {
                    throw new \Exception($response['error']);
                }
            } catch (\Exception $e) {
                \Log::error('Erro na autenticação API: ' . $e->getMessage());
                return redirect()->back()->withErrors(['auth.failed']);
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
        \Log::info('=== MÉTODO AUTHENTICATE INICIADO ===', [
            'email' => $request->input('email'),
            'timestamp' => now()
        ]);
        
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

        // 3. Analisa a resposta da API DentalGo
        if ($response->successful() && isset($response->object()->token)) {
            // SUCESSO no DentalGo!
            $retornoApi = $response->object();

            // Guarda o token e os dados do usuário na sessão
            session()->put('token', $retornoApi->token);
            session()->put('usuario', $retornoApi);

            // Responde ao JavaScript com sucesso
            return response()->json(['success' => true, 'message' => 'Login realizado!']);
        } else {
            // FALHA no DentalGo - Tenta fallback para API Schoolar
            \Log::info('=== INICIANDO FALLBACK SCHOOLAR ===', [
                'email' => $validated['email'],
                'dentalgo_response_status' => $response->status(),
                'dentalgo_response_body' => $response->body()
            ]);
            
            try {
                $schoolarResponse = Http::post('http://127.0.0.1:8081/api/autenticar', [
                    'email' => $validated['email'],
                    'senha' => $validated['password'],
                ]);

                \Log::info('Resposta da API Schoolar', [
                    'status' => $schoolarResponse->status(),
                    'successful' => $schoolarResponse->successful(),
                    'body' => $schoolarResponse->body()
                ]);

                $schoolarData = $schoolarResponse->object();

                // Verifica se o login no Schoolar foi bem-sucedido
                if ($schoolarResponse->successful() && isset($schoolarData->token)) {
                    // SUCESSO no Schoolar!
                    
                    // Armazena token e tempo de expiração
                    session()->put('tokenschoolar', $schoolarData->token);
                    session()->put('token_expires_at', now()->addSeconds($schoolarData->expires_in));

                    // Busca dados do aluno via API Schoolar
                    $ch = curl_init('http://127.0.0.1:8081/api/aluno/dados');
                    $authorization = "Authorization: Bearer " . $schoolarData->token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        $authorization
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $resultado = curl_exec($ch);
                    curl_close($ch);

                    $conteudo = json_decode($resultado);

                    // Verificação de resposta
                    if (isset($conteudo->status) && $conteudo->status === 'ok') {
                        // Armazena os dados completos da API Schoolar
                        session()->put('usuario', $conteudo);
                        session()->put('tipoUsuario', 'schoolar');

                        // Configurar permissões para acesso aos conteúdos DentalGo
                        session()->put('usuarioPlano', (object)[
                            'id' => 'schoolar_plan',
                            'nome' => 'Plano Schoolar',
                            'ativo' => true,
                            'tipo' => 'completo'
                        ]);

                        // Array com todos os IDs das coleções para acesso completo
                        $colecaoPermissao = [1, 2, 4, 5, 6, 7, 50, 67, 79];
                        session()->put('usuarioPermissao', $colecaoPermissao);

                        // Responde ao JavaScript com sucesso
                        return response()->json(['success' => true, 'message' => 'Login realizado via Schoolar!']);
                    } else {
                        \Log::warning('Falha na verificação dos dados do usuário Schoolar', [
                            'conteudo' => $conteudo
                        ]);
                    }
                } else {
                    \Log::warning('Falha no login Schoolar', [
                        'status' => $schoolarResponse->status(),
                        'response' => $schoolarResponse->body(),
                        'has_token' => isset($schoolarData->token)
                    ]);
                }
            } catch (\Exception $e) {
                // Log do erro do fallback
                \Log::error('Erro no fallback Schoolar: ' . $e->getMessage());
            }

            \Log::info('=== FALLBACK SCHOOLAR FINALIZADO - AMBAS APIS FALHARAM ===');

            // FALHA em ambas as APIs
            $errorMessage = 'Usuario informado não localizado'; // Mensagem padrão
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