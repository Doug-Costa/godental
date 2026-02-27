<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class LivroController extends Controller
{
    public function livros()
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
        $livros = 'livros'.$locale;
        $token = Cache::get('tokenGlobal');

        if (Cache::has($livros)) {
            return Cache::get($livros);
        }else{

            $ch = curl_init('https://api.dentalgo.com.br/catalog/books/courtesies');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudoG = json_decode($resultado);

            sleep(1);

            foreach ($conteudoG->rows as $key => $produto) {
                if(!empty($produto->cover)){
                    $thumb = '';
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($produto->cover);
                    $thumb = $thumbor->get();
                    $produto->cover = $thumb;
                }
            }


            $ch = curl_init('https://api.dentalgo.com.br/catalog/home?language=');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);
            

            sleep(1);

            
            foreach ($conteudo as $key => $colecoes) {

                if($key != 'banners'){
                    foreach ($colecoes->rows as $key => $produto) {
                        if(!empty($produto->cover)){
                            $thumb = '';
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($produto->cover);
                            $thumb = $thumbor->get();
                            $produto->cover = $thumb;
                        }

                        foreach ($produto->authors as $key => $autor) {
                            if(!empty($autor->photoURL)){
                                $thumb = '';
                                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                                $thumbor->resize(Resize::ORIG, 450);
                                $thumbor->fit(Fit::FIT_IN);
                                $thumbor->imageUrl($autor->photoURL);
                                $thumb = $thumbor->get();
                                $autor->photoURL = $thumb;
                            }
                        }
                    }
                }
            }


            $retorno = array();
            $retorno['livrosG'] = $conteudoG;
            $retorno['livros'] = $conteudo;


            Cache::put($livros, $retorno, 864000);
            return $retorno;
            if(isset($conteudo->code)){
                if($conteudo->code == 'unauthorized'){
                    session()->flush();
                    return 'deslogou';
                }else{
                    session()->flush();
                    return 'deslogou';
                }
            }
        }

    }

    public function livrosComprados()
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
        $livros = 'livrosComprado'.$locale;
        $token = session()->get('token');


        if (Cache::has($livros)) {
            return Cache::get($livros);
        }else{

            $ch = curl_init('https://api.dentalgo.com.br/subscription/collections?page=1&q%5BproductType%5D=book');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudoPlano = json_decode($resultado);
            

            $produtoComprados = array();
            if(isset($conteudoPlano->code)){

            }else{
            
                foreach ($conteudoPlano->rows as $key => $produto) {
                    if(!empty($produto->cover)){
                        $thumb = '';
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($produto->cover);
                        $thumb = $thumbor->get();
                        $produto->cover = $thumb;
                    }
                }

                

                foreach ($conteudoPlano->rows as $keyC => $colecao) {

                    foreach ($colecao->products as $key => $produto) {
                        $loop = $keyC+$key;
                        $exists = false;
                        foreach ($produtoComprados as $p) {
                            if ($p['id'] == $produto->id) {
                                $exists = true;
                                break;
                            }
                        }
                        if (!$exists) {
                            $produtoComprados[$loop]['id'] = $produto->id;
                            $produtoComprados[$loop]['createdAt'] = $produto->createdAt;
                            $produtoComprados[$loop]['updatedAt'] = $produto->updatedAt;
                            $produtoComprados[$loop]['title'] = $produto->title;
                            $produtoComprados[$loop]['cover'] = $produto->cover;
                            $produtoComprados[$loop]['brief'] = $produto->brief;
                            $produtoComprados[$loop]['publishDate'] = $produto->publishDate;
                            $produtoComprados[$loop]['price'] = $produto->price;
                            $produtoComprados[$loop]['customerCourtesy'] = $produto->customerCourtesy;
                            $produtoComprados[$loop]['internalCode'] = $produto->internalCode;
                            $produtoComprados[$loop]['subscriberCourtesy'] = $produto->subscriberCourtesy;
                            $produtoComprados[$loop]['monetizationForFiliations'] = $produto->monetizationForFiliations;
                            $produtoComprados[$loop]['category'] = $produto->category;
                            $produtoComprados[$loop]['length'] = $produto->length;
                            $produtoComprados[$loop]['itemsQuantityPerLanguage'] = $produto->itemsQuantityPerLanguage;
                            $produtoComprados[$loop]['status'] = $produto->status;
                            $produtoComprados[$loop]['digitalProduct'] = $produto->digitalProduct;
                            $produtoComprados[$loop]['availableLanguages'] = $produto->availableLanguages;
                            $produtoComprados[$loop]['availableFileFormats'] = $produto->availableFileFormats;
                            $produtoComprados[$loop]['productType'] = $produto->productType;
                            $produtoComprados[$loop]['collections'] = $produto->collections;
                            $produtoComprados[$loop]['tipo'] = 'plano';
                        }
                    }
                }
            }

            // CONSULTA OS PRODUTOS COMPRADOS
            $ch = curl_init('https://api.dentalgo.com.br/catalog/libraries?page=1');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);

            
            if (!empty($conteudo->rows)) {

                if(isset($conteudo->rows)){
                    foreach ($conteudo->rows as $key => $produto) {
                        if(!empty($produto->cover)){
                            $thumb = '';
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($produto->cover);
                            $thumb = $thumbor->get();
                            $produto->cover = $thumb;
                        }
                    }
                }

                foreach ($conteudo->rows as $keyPC => $produto) {
                    if(isset($loop)){
                        $loop2 = $keyPC+$loop;
                    }else{
                        $loop2 = $keyPC;
                    }
                    $exists = false;
                    foreach ($produtoComprados as $p) {
                        if ($p['id'] == $produto->id) {
                            $exists = true;
                            break;
                        }
                    }
                    if (!$exists) {
                        $produtoComprados[$loop2]['id'] = $produto->id;
                        $produtoComprados[$loop2]['createdAt'] = $produto->createdAt;
                        $produtoComprados[$loop2]['updatedAt'] = $produto->updatedAt;
                        $produtoComprados[$loop2]['title'] = $produto->title;
                        $produtoComprados[$loop2]['cover'] = $produto->cover;
                        $produtoComprados[$loop2]['brief'] = $produto->brief;
                        $produtoComprados[$loop2]['publishDate'] = $produto->publishDate;
                        $produtoComprados[$loop2]['price'] = $produto->price;
                        $produtoComprados[$loop2]['customerCourtesy'] = $produto->customerCourtesy;
                        $produtoComprados[$loop2]['internalCode'] = $produto->internalCode;
                        $produtoComprados[$loop2]['subscriberCourtesy'] = $produto->subscriberCourtesy;
                        $produtoComprados[$loop2]['monetizationForFiliations'] = $produto->monetizationForFiliations;
                        $produtoComprados[$loop2]['category'] = $produto->category;
                        $produtoComprados[$loop2]['length'] = $produto->length;
                        $produtoComprados[$loop2]['itemsQuantityPerLanguage'] = $produto->itemsQuantityPerLanguage;
                        $produtoComprados[$loop2]['status'] = $produto->status;
                        $produtoComprados[$loop2]['digitalProduct'] = $produto->digitalProduct;
                        $produtoComprados[$loop2]['availableLanguages'] = $produto->availableLanguages;
                        $produtoComprados[$loop2]['availableFileFormats'] = $produto->availableFileFormats;
                        $produtoComprados[$loop2]['productType'] = $produto->productType;
                        $produtoComprados[$loop2]['collections'] = '';
                        $produtoComprados[$loop2]['tipo'] = 'comprado';
                    }
                }

            }


            return $produtoComprados;
            if(isset($conteudo->code)){
                if($conteudo->code == 'unauthorized'){
                    session()->flush();
                    return 'deslogou';
                }else{
                    session()->flush();
                    return 'deslogou';
                }
            }

        }

    }

}
