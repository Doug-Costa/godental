<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;


class LoginBooksController extends Controller
{
    public function login()
    {
        $email = Request()->input('email');
        $password = Request()->input('password');


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.dentalgo.com.br/sessions/sign-in");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        curl_close($ch);

        $retorno = json_decode($server_output);


        if (isset($retorno->token)) {

            $token = session()->put('token', $retorno->token);

            $ch = curl_init('https://api.dentalgo.com.br/account/current-user');
            $authorization = "Authorization: Bearer " . session()->get('token');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $infoUser = curl_exec($ch);
            curl_close($ch);

            $retorno = json_decode($infoUser);
            $usuario = session()->put('usuario', $retorno);

            if (isset($retorno->subscription->planId)) {

                if ($retorno->subscription->status == 'canceled') {
                    $usuarioPlano = session()->put('usuarioPlano', 'venceu');
                    $usuarioPermissao = session()->put('usuarioPermissao', 'naotemVencido');
                    return back()->withErrors('logadoVencido')->withInput();
                } else {

                    $idPlano = $retorno->subscription->planId;

                    $ch = curl_init('https://api.dentalgo.com.br/catalog/plans/' . $idPlano . '/collections?page=1');
                    $authorization = "Authorization: Bearer " . session()->get('token');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
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
                    return redirect('/minhacontabooks');

                    /*if (in_array("40", $colecaoPermissao)){
                        echo 'tem';
                    }else{
                        echo 'nao tem';
                    }*/

                }

            } else {
                $usuarioPlano = session()->put('usuarioPlano', 'semplano');
                $usuarioPermissao = session()->put('usuarioPermissao', 'naotemSemPlano');
                return back()->withErrors('logadoSem')->withInput();
            }



        } else {
            if (isset($retorno->code)) {
                if ($retorno->code == 'userNotFound') {

                    return back()->withErrors('errousuario')->withInput();

                } elseif ($retorno->code == 'wrongPassword') {

                    return back()->withErrors('errosenha')->withInput();

                } else {
                    return $retorno;
                }
            } else {
                return $retorno;
            }
        }

    }

    public function logout()
    {
        $ch = curl_init('https://api.dentalgo.com.br/sessions/sign-out');
        $authorization = "Authorization: Bearer " . session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch);
        curl_close($ch);
        session()->flush();
        return redirect()->back();
    }
}
?>