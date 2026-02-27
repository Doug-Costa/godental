<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Session;

class VideosController extends Controller
{
    public function videos()
    {

        if(session()->get('lang_code')){
            if(session()->get('lang_code')=='pt'){
                $locale = 'pt';
            }elseif(session()->get('lang_code')=='en'){
                $locale = 'en';
            }elseif(session()->get('lang_code')=='es'){
                $locale = 'es';
            }
        }else{
            $locale = '';
        }
        $canais = 'canais'.$locale;
        $token = Cache::get('tokenGlobal');

        if (Cache::has($canais)) {
            return Cache::get($canais);
        }else{
            $ch = curl_init('https://api.dentalgo.com.br/subscription/videos');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);
            sleep(1);
            foreach ($conteudo as $key2 => $value2) {


                if(!empty($conteudo[$key2]->cover)){
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG);
                    $thumbor->imageUrl($conteudo[$key2]->cover);
                    $thumb = $thumbor->get();
                    $conteudo[$key2]->cover = $thumb;
                }else{
                    unset($thumb);
                }

                foreach ($value2->productItems as $key => $value) {

                    if(!empty($conteudo[$key2]->productItems[$key]->cover)){
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG);
                        $thumbor->imageUrl($conteudo[$key2]->productItems[$key]->cover);
                        $thumb = $thumbor->get();
                        $conteudo[$key2]->productItems[$key]->cover = $thumb;
                    }else{
                        unset($thumb);
                    }

                }

            }

            Cache::put($canais, $conteudo, 86400);
            if(isset($conteudo->code)){
                if($conteudo->code == 'unauthorized'){
                    session()->flush();
                    return 'deslogou';
                }else{
                    session()->flush();
                    return 'deslogou';
                }
            }else{
                return $conteudo;
            }
        }
    }

    public function video($id)
    {
        if(session()->get('lang_code')){
            if(session()->get('lang_code')=='pt'){
                $locale = 'pt';
            }elseif(session()->get('lang_code')=='pt'){
                $locale = 'en';
            }elseif(session()->get('lang_code')=='en'){
                $locale = 'es';
            }elseif(session()->get('lang_code')=='es'){
                $locale = ' ';
            }
        }else{
            $locale = '';
        }
        $canal = 'canal'.$id.''.$locale;
        $token = Cache::get('tokenGlobal');
        
        if (Cache::has($canal)) {
            return Cache::get($canal);
        }else{
            $ch = curl_init('https://api.dentalgo.com.br/subscription/products/'.$id);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);

            sleep(1);
            foreach ($conteudo->productItems as $key => $value){
                $ord[] = strtotime($value->createdAt);
            }
            array_multisort($ord, SORT_DESC, $conteudo->productItems);



            if(!empty($conteudo->cover)){
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG);
                $thumbor->imageUrl($conteudo->cover);
                $thumb = $thumbor->get();
                $conteudo->cover = $thumb;
            }else{
                unset($thumb);
            }

            foreach ($conteudo->productItems as $key => $value) {
                if(!empty($conteudo->productItems[$key]->cover)){
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG);
                    $thumbor->imageUrl($conteudo->productItems[$key]->cover);
                    $thumb = $thumbor->get();
                    $conteudo->productItems[$key]->cover = $thumb;
                }else{
                    unset($thumb);
                }
            }

            Cache::put($canal, $conteudo, 86400);
            if(isset($conteudo->code)){
                if($conteudo->code == 'unauthorized'){
                    session()->flush();
                    return 'deslogou';
                }else{
                    session()->flush();
                    return 'deslogou';
                }
            }else{
                return $conteudo;
            }
        }
    }
}
