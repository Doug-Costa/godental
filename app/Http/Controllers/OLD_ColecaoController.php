<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OLDColecaoController extends Controller
{
    public function colecao($id)
    {
        if (session()->get('lang_code')) {
            if (session()->get('lang_code') == 'pt') {
                $locale = 'pt';
            } elseif (session()->get('lang_code') == 'en') {
                $locale = 'en';
            } elseif (session()->get('lang_code') == 'es') {
                $locale = 'es';
            } elseif (session()->get('lang_code') == 'en') {
                $locale = ' ';
            }
        } else {
            $locale = '';
        }

        $colecao = 'colecao' . $id;



        if (Cache::has($colecao)) {
            echo 'batima';
            print_r(Cache::get($colecao));
            die();
        } else {
            $ch = curl_init('https://api.dentalgo.com.br/subscription/collections/' . $id . '/products?page=1&locale=' . $locale);
            $authorization = "Authorization: Bearer " . session()->get('token');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch);
            curl_close($ch);

            $conteudo = json_decode($resultado);
            print_r($conteudo);
            //die();
            if (isset($conteudo->code)) {
                if ($conteudo->code == 'unauthorized') {
                    session()->flush();
                    return 'deslogou';
                } else {
                    session()->flush();
                    return 'deslogou';
                }
            } else {
                Cache::put($colecao, $conteudo, 50);
                die();
                return $conteudo;
            }
        }
    }
}
