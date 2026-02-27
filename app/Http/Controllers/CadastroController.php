<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;


class CadastroController extends Controller
{
    public function cadastro()
    {
        $nome = Request()->input('nome');
        $cpf = Request()->input('cpf');
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $ddi = Request()->input('ddi');
        $telefone = Request()->input('telefone');
        $email = Request()->input('email');
        $password = Request()->input('password');
        $passwordConfirm = Request()->input('passwordConfirm');
        $origem = Request()->input('origem');

        $telefoneFinal = $ddi.' '.$telefone;
        if($password !== $passwordConfirm){
            return back()->withErrors('errosenha')->withInput();
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.dentalgo.com.br/sessions/sign-up");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "documentNumber=$cpf&email=$email&fullName=$nome&password=$password&phoneNumber=$telefoneFinal");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
        curl_close ($ch);

        $retorno = json_decode($server_output);

        if(isset($retorno->id)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.dentalgo.com.br/sessions/sign-in");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec ($ch);
            curl_close ($ch);

            $retornoLogin = json_decode($server_output);

            if(isset($retornoLogin->token)){

                $token = session()->put('token', $retornoLogin->token);
                $ch = curl_init('https://api.dentalgo.com.br/account/current-user');
                $authorization = "Authorization: Bearer ".session()->get('token');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $infoUser = curl_exec($ch); 
                curl_close($ch); 

                $retornoLogin = json_decode($infoUser);
                $tipoUsuario = 'pessoal';
                $retornoLogin->tipoUsuario = $tipoUsuario;
                $usuario = session()->put('usuario', $retornoLogin);
                $usuarioPlano = session()->put('usuarioPlano', 'semplano');
                $usuarioPermissao = session()->put('usuarioPermissao', 'naotem');
                
                
                if($origem == 'hub'){
                    //return back()->withErrors('logado')->withInput();
                    if (request()->has('id_produto')){
                        return redirect('/checkout/'.Request()->input('id_produto'));
                    }else{
                        return redirect('/assinatura');
                    }
                }else{
                    return redirect('/assinatura');
                }
                
                //return back()->withErrors('cadastroSucesso')->withInput();

            }else{
                if(isset($retornoLogin->code)){
                    if($retornoLogin->code == 'userNotFound'){
                        return back()->withErrors('errousuario')->withInput();
                    }elseif($retornoLogin->code == 'wrongPassword'){
                        return back()->withErrors('errosenha')->withInput();
                    }else{
                        return $retornoLogin;
                    }
                }else{
                    return $retornoLogin;
                }
            }
        }else{
            return back()->withErrors('erroCadastro')->withInput();
        }

    }

     public function storeCheckout(Request $request)
    {
        // 1. Validação dos dados (sem alterações)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cpf' => 'required_if:ddi,55|nullable|string|max:14',
            'ddi' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Montagem do payload (sem alterações)
        $fullPhoneNumber = preg_replace('/\D/', '', $request->ddi . $request->phone);
        $payload = [
            'email' => $request->email,
            'fullName' => $request->name,
            'password' => $request->password,
            'phoneNumber' => $fullPhoneNumber
        ];
        if ($request->filled('cpf')) {
            $payload['documentNumber'] = preg_replace('/\D/', '', $request->cpf);
        }
        
        // 3. Primeira chamada à API: Tenta criar o usuário
        $registerResponse = Http::asForm()->post('https://api.dentalgo.com.br/sessions/sign-up', $payload);

        if (!$registerResponse->successful()) {
            return response()->json(['message' => 'Este e-mail ou CPF já possui um cadastro.'], 409);
        }

        // 4. Segunda chamada à API: Tenta fazer o login automático
        $loginResponse = Http::asForm()->post('https://api.dentalgo.com.br/sessions/sign-in', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$loginResponse->successful() || !isset($loginResponse->object()->token)) {
            return response()->json(['message' => 'Cadastro realizado, mas o login automático falhou.'], 400);
        }

        // 5. SUCESSO! TEMOS O TOKEN. AGORA CONSTRUÍMOS O OBJETO DE USUÁRIO.
        $token = $loginResponse->object()->token;
        
        // Pega o objeto básico retornado pelo login
        $usuario = $loginResponse->object();

        // Adiciona as informações que já temos do formulário para completá-lo
        $usuario->fullName = $request->name;
        $usuario->email = $request->email;
        $usuario->tipoUsuario = 'pessoal'; // Adiciona o tipo de usuário padrão

        // 6. Salva a sessão completa
        session()->put('token', $token);
        session()->put('usuario', $usuario);
        session()->save();
        
        // Retorna sucesso para o JavaScript, que irá recarregar a página
        return response()->json(['success' => true]);
    }

}
?>