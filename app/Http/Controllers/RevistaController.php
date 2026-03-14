<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class RevistaController extends Controller
{
    public function revista($id)
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

        $revista = 'revista' . $id . '' . $locale;
        $token = Cache::get('tokenGlobal');

        if (Cache::has($revista)) {
            return Cache::get($revista);
        } else {

            // TRATA ARRAY 0 SOBRE AS REVISTAS
            $ch = curl_init('https://api.dentalgo.com.br/subscription/products/' . $id);
            $authorization = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch);
            curl_close($ch);

            $conteudo = json_decode($resultado);

            if (!$conteudo || isset($conteudo->code)) {
                \Log::error('Erro ou resposta inválida da API DentalGo Products: ' . $resultado);
                return [null, null, null];
            }

            sleep(1);

            if (!empty($conteudo->cover)) {
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG, 450);
                $thumbor->fit(Fit::FIT_IN);
                $thumbor->imageUrl($conteudo->cover);
                $thumb = $thumbor->get();

                $conteudo->cover = $thumb;
            }


            foreach ($conteudo->productItems as $key => $value) {

                if (!empty($value->cover)) {
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($value->cover);
                    $thumb = $thumbor->get();
                    $conteudo->productItems[$key]->cover = $thumb;
                } else {
                    unset($thumb);
                }

            }



            //TRATA ARRAY 1 SOBRE AS REVISTAS

            $ch = curl_init('https://api.dentalgo.com.br/catalog/products/' . $id);
            $authorization = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch);
            curl_close($ch);

            $conteudo_catalogo = json_decode($resultado);

            sleep(1);

            //TRATA ARRAY 2 SOBRE ITENS DAS REVISTAS

            $ch = curl_init('https://api.dentalgo.com.br/admin/products/' . $id . '/items');
            $authorization = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch);
            curl_close($ch);

            $conteudo_itens = json_decode($resultado);

            sleep(1);

            // JUNTA OS CONTEUDOS CRIANDO UM ARRAY
            $conteudo_final = array($conteudo, $conteudo_catalogo, $conteudo_itens);



            if (isset($conteudo->code)) {
                if ($conteudo->code == 'unauthorized') {
                    session()->flush();
                    return 'deslogou';
                } else {
                    session()->flush();
                    return 'deslogou';
                }
            } else {
                Cache::put($revista, $conteudo_final, 864000);
                return $conteudo_final;
            }
        }
    }

    public function produtocomprado($id)
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

        $token = session()->get('token');

        // TRATA ARRAY 0 SOBRE AS REVISTAS
        $ch = curl_init('https://api.dentalgo.com.br/catalog/libraries/' . $id);
        $authorization = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch);
        curl_close($ch);

        $conteudo = json_decode($resultado);

        if (!is_object($conteudo)) {
            session()->flush();
            return 'deslogou';
        }


        if (!empty($conteudo->cover)) {
            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
            $thumbor->resize(Resize::ORIG, 450);
            $thumbor->fit(Fit::FIT_IN);
            $thumbor->imageUrl($conteudo->cover);
            $thumb = $thumbor->get();

            $conteudo->cover = $thumb;
        }

        if (isset($conteudo->productItems)) {
            foreach ($conteudo->productItems as $key => $value) {

                if (!empty($value->cover)) {
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($value->cover);
                    $thumb = $thumbor->get();
                    $conteudo->productItems[$key]->cover = $thumb;
                } else {
                    unset($thumb);
                }

            }
        }



        //TRATA ARRAY 1 SOBRE AS REVISTAS

        $ch = curl_init('https://api.dentalgo.com.br/catalog/products/' . $id);
        $authorization = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch);
        curl_close($ch);

        $conteudo_catalogo = json_decode($resultado);

        //TRATA ARRAY 2 SOBRE ITENS DAS REVISTAS

        $ch = curl_init('https://api.dentalgo.com.br/admin/products/' . $id . '/items');
        $authorization = "Authorization: Bearer " . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch);
        curl_close($ch);

        $conteudo_itens = json_decode($resultado);

        if (isset($conteudo_catalogo->code) && ($conteudo_catalogo->code == 'unauthorized' || $conteudo_catalogo->code == 'forbidden')) {
            $conteudo_catalogo = null;
        }

        if (isset($conteudo_itens->code) && ($conteudo_itens->code == 'unauthorized' || $conteudo_itens->code == 'forbidden')) {
            $conteudo_itens = null;
        }

        // JUNTA OS CONTEUDOS CRIANDO UM ARRAY
        $conteudo_final = array($conteudo, $conteudo_catalogo, $conteudo_itens);

        if (isset($conteudo->code)) {
            if ($conteudo->code == 'unauthorized') {
                session()->flush();
                return 'deslogou';
            } else {
                session()->flush();
                return 'deslogou';
            }
        } else {
            return $conteudo_final;
        }
    }
}
