<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class ConsultaUserIdController extends Controller
{
    public function userID($id)
    {
        //Pega o barear do Super User
        $token = Cache::get('tokenGlobal');

        //Id do usuario que ira consultar
        $UserId = $id;

        //Consulta na rota admin o usuario desejado utilizando o token do super user;
        $ch = curl_init('https://api.dentalgo.com.br/admin/people/'.$UserId);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultadoUser = curl_exec($ch); 
        curl_close($ch); 
        $conteudoUser = json_decode($resultadoUser);
        return $conteudoUser;
    }

    public function recsenhaaply(){
        //Barear Token do super user
        $token = Cache::get('tokenGlobal');

        //Busca usuario pelo id informado pelo formulario de recuperar a senha
        $UserId64 = request()->input('cod');
        $UserId = base64_decode($UserId64);
        $UserById = app('App\Http\Controllers\ConsultaUserIdController')->userID($UserId);

        //Dados informados pelo usuario
        $email = request()->input('email');
        $password = request()->input('password');
        $passwordconfirm = request()->input('passwordconfirm');

        if($UserById->email == $email){

            if($password == $passwordconfirm){


                //SE TODOS OS DADOS DO USUARIO BATER TANTO EMAIL INFORMADO QUANTO AS DUAS SENHAS SEREM IGUAIS SUBMETE AO SISTEMA A NOVA SENHA
                // Dados para o payload

                $payload = array(
                    "id" => $UserById->id,
                    "createdAt" => $UserById->createdAt,
                    "updatedAt" => $UserById->updatedAt,
                    "fullName" => $UserById->fullName,
                    "scope" => $UserById->scope,
                    "photoURL" => $UserById->photoURL,
                    "email" => $UserById->email,
                    "phoneNumber" => $UserById->phoneNumber,
                    "documentNumber" => $UserById->documentNumber,
                    "admin" => false,
                    "password" => $password
                );
                $ch = curl_init('https://api.dentalgo.com.br/admin/people/'.$UserId);
                $authorization = "Authorization: Bearer ".$token;
                // Configurar a solicitação para o método PUT
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

                // Configurar o cabeçalho e o payload JSON
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

                // Configurar opções adicionais se necessário
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

                // Executar a solicitação
                $resultadoUser = curl_exec($ch);

                // Verificar se ocorreram erros
                if (curl_errno($ch)) {
                    echo 'Erro ao realizar a solicitação cURL: ' . curl_error($ch);
                }

                // Fechar a sessão cURL
                curl_close($ch);

                // Decodificar a resposta JSON
                $conteudoUser = json_decode($resultadoUser);

                return redirect("/")->withErrors('senhaRedefinida')->withInput();
            }else{
                //ERRO DE SENHAS DIFERENTES
                return view("recuperarsenha", ["usuario"=>$UserById, "localizado"=>3]);
            }
        }else{
            //ERRO DE EMAIL INCOMPATIVEL COM O CODIGO ID E EMAIL DIGITADO
            return view("recuperarsenha", ["usuario"=>$UserById, "localizado"=>2]);
        }
        print_r($UserById);
        die();
    }
}