<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class ColecoesController extends Controller
{
    public function colecoes()
    {

        if (session()->get('lang_code')) {
            if (session()->get('lang_code') == 'pt') {
                $locale = 'pt';
            } elseif (session()->get('lang_code') == 'en') {
                $locale = 'en';
            } elseif (session()->get('lang_code') == 'es') {
                $locale = 'es';
            }
        } else {
            $locale = '';
        }
        $colecoes = 'colecoes' . $locale;

        $token = Cache::get('tokenGlobal');


        $ch = curl_init('https://api.dentalgo.com.br/subscription?page=1&locale=');
        $authorization = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch);
        curl_close($ch);

        $conteudo = json_decode($resultado);

        if (!$conteudo || !isset($conteudo->collections) || !isset($conteudo->collections->magazines)) {
            Log::error("Erro ao obter coleções da API: " . ($resultado ?: 'Resposta vazia'));
            return array(null, '');
        }

        foreach ($conteudo->collections->magazines as $key => $value) {

            if (!empty($value->cover)) {
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG, 450);
                $thumbor->fit(Fit::FIT_IN);
                $thumbor->imageUrl($value->cover);
                $thumb = $thumbor->get();
                $conteudo->collections->magazines[$key]->cover = $thumb;
            } else {
                unset($thumb);
            }

            if (!empty($value->lastProductCover)) {
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG, 450);
                $thumbor->fit(Fit::FIT_IN);
                $thumbor->imageUrl($value->lastProductCover);
                $thumb = $thumbor->get();
                $conteudo->collections->magazines[$key]->lastProductCover = $thumb;
            } else {
                unset($thumb);
            }
        }


        Cache::put($colecoes, $conteudo, 864000);
        if (isset($conteudo->code)) {
            if ($conteudo->code == 'unauthorized') {
                session()->flush();
                return 'deslogou';
            } else {
                session()->flush();
                return 'deslogou';
            }
        } else {

            return array($conteudo, '');

        }
    }

}

