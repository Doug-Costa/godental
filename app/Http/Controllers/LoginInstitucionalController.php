<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;


class LoginInstitucionalController extends Controller
{
    public function login()
    {
        $fact = Request()->input('fact');
        $userId = Request()->input('userId');
        $tokenUserFact = Request()->input('token');
        $handShakeUrl = Request()->input('handShakeUrl');
        $loginUrl = Request()->input('loginUrl');

        if($fact != null or $fact != ''){
            if($fact == 'unilavras'){
                $parsedUrl = parse_url($handShakeUrl);
                $host = $parsedUrl['host'];
                if (str_ends_with($host, '.unilavras.edu.br') || $host === 'unilavras.edu.br') {

                    $ch = curl_init();
                    $authorization = "Authorization: Bearer ".$tokenUserFact;
                    $headers = array('Content-Type: application/json', $authorization);
                    $json_data = json_encode($userId);

                    curl_setopt($ch, CURLOPT_URL, $handShakeUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $response = curl_exec($ch);


                    
                    if ($response === false){
                        return back()->withErrors('erroApi')->withInput();
                    }else{
                        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                        if ($http_status == 200){
                            $retorno = json_decode($response);
                            if (isset($retorno->hasPermission) && $retorno->hasPermission === true){
                                $loginController = new LoginController();
                                $usuario = env('INSTITUTIONAL_LOGIN_USER');
                                $senha = env('INSTITUTIONAL_LOGIN_PASSWORD');
                                
                                if (!$usuario || !$senha) {
                                    Log::error('Credenciais institucionais não configuradas no .env');
                                    return redirect($loginUrl)->withErrors('config_error');
                                }
                                
                                $loginController->login(['usuario' => $usuario, 'senha' => $senha]);
                                return redirect('/')->withErrors('logado')->withInput();
                            } else {
                                return redirect($loginUrl);
                            }
                        } else {
                            $retorno = json_decode($response);
                            if (isset($retorno->error)){
                                if($retorno->error == 'Not found'){
                                    return redirect($loginUrl);
                                } else {
                                    return redirect($loginUrl);
                                }
                            } else {
                                return redirect($loginUrl);
                            }
                        }
                    }

                    curl_close($ch);

                }else{
                    return back()->withErrors('apidesconhecida')->withInput();
                }
            }else{
                return back()->withErrors('instituicaoDesconhecida')->withInput();
            }
        }else{
            return back()->withErrors('instituicaoDesconhecida')->withInput();
        }

        /*
        $instituicao = Request()->input('instituicao');
        $ra = Request()->input('ra');

        if($ra != null or $ra != ''){

            if($instituicao == 'unilavras'){

                $ch = curl_init();

                $url = "https://integradorportal.unilavras.edu.br/api/v1/dentalgo-user";
                $data = array('usercode' => $ra);

                $authorization = "Authorization: Bearer F7mbfWZ1nVk0gRidvZ0bogRO3JL9D8niQJQAnNop";
                $headers = array('Content-Type: multipart/form-data', $authorization);

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);

                if ($response === false){
                    return back()->withErrors('erroApi')->withInput();
                }else{
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($http_status != 200){
                        $retorno = json_decode($response);
                        if(isset($retorno->error)){
                            if($retorno->error == 'Not found'){
                                return back()->withErrors('raInvalido')->withInput();
                            }else{
                                return back()->withErrors('erroApi')->withInput();
                            }
                        }
                    }else{
                        $retorno = json_decode($response);
                        if(isset($retorno->data)){
                            if($retorno->data == 'confirmed'){
                                $loginController = new LoginController();
                                $usuario = env('INSTITUTIONAL_LOGIN_USER');
                                $senha = env('INSTITUTIONAL_LOGIN_PASSWORD');
                                
                                if (!$usuario || !$senha) {
                                    Log::error('Credenciais institucionais não configuradas no .env');
                                    return back()->withErrors('config_error');
                                }
                                
                                $loginController->login(['usuario' => $usuario, 'senha' => $senha]);
                                return back()->withErrors('logado')->withInput();
                                
                            }else{
                                return back()->withErrors('raInvalido')->withInput();
                            }
                        }
                    }
                }

                curl_close($ch);
            }else{
                return back()->withErrors('instituicaoDesconhecida')->withInput();
            }
        }else{
            return back()->withErrors('raVazio')->withInput();
        }*/

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


    }

    public function logout()
    {
        session()->flush();
        return redirect()->back();
    }

}
?>