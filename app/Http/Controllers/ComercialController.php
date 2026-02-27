<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Session;

class ComercialController extends Controller
{
    public function autores()
    {
        $token = Cache::get('tokenGlobal');

        $busca = 'Flavia%20Artese';
        $ch = curl_init('https://api.dentalgo.com.br/subscription/search/complete?take=30&q%5Bquery%5D='.$busca);
        //$ch = curl_init('https://api.dentalgo.com.br/catalog/authors/4');
        //$ch = curl_init('https://api.dentalgo.com.br/admin/banners');
        //$ch = curl_init('https://api.dentalgo.com.br/catalog/favorites/product-items');
        //$ch = curl_init('https://api.dentalgo.com.br/subscription?page=1');
        //$ch = curl_init('https://api.dentalgo.com.br/admin/authors/4');
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $conteudo_pesquisa = json_decode($server_output);

        for ($i = 2; $i <= $conteudo_pesquisa->pages; $i++){
            $ch = curl_init('https://api.dentalgo.com.br/subscription/search/complete?page='.$i.'&take=30&q%5Bquery%5D='.$busca);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $server_output = curl_exec($ch); 
            curl_close($ch); 
            $conteudo_pagina = json_decode($server_output);
            if($i > 2){
                $conteudo_pesquisa_final = array_merge($conteudo_pesquisa_final, $conteudo_pagina->rows);
            }else{
                $conteudo_pesquisa_final = array_merge($conteudo_pesquisa->rows, $conteudo_pagina->rows);
            }
        }

        $produtos_pesquisa = array();
        $ii = 0;
        foreach ($conteudo_pesquisa_final as $key => $value) {
            $qntAutors = count($value->authors);
            if($qntAutors > 1){
                foreach ($value->authors as $valor) {
                    if($valor->id == 4){
                        $temAutor = 1;
                    }
                }
            }elseif($qntAutors == 1){
                if($value->authors[0]->id == 4){
                    $temAutor = 1;
                }
            }else{
                $temAutor = 0;
                continue;
            }
            if($temAutor == 1){
                $ii++;

                if(!empty($value->cover)){
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG);
                    $thumbor->imageUrl($value->cover);
                    $thumb = $thumbor->get();
                }
                if(!empty($value->product->cover)){
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG);
                    $thumbor->imageUrl($value->product->cover);
                    $thumb_produto = $thumbor->get();
                }
                

                
                $produtos_pesquisa[$value->productType][$key]['id_artigo'] = $value->id;
                $produtos_pesquisa[$value->productType][$key]['id_produto'] = $value->product->id;
                $produtos_pesquisa[$value->productType][$key]['title'] = $value->title;
                $produtos_pesquisa[$value->productType][$key]['title_produto'] = $value->product->title;
                $produtos_pesquisa[$value->productType][$key]['cover'] = $value->cover;
                $produtos_pesquisa[$value->productType][$key]['cover_produto'] = $value->product->cover;
                if(isset($thumb)){
                    $produtos_pesquisa[$value->productType][$key]['cover_thumb'] = $thumbor->get();
                }
                if(isset($thumb_produto)){
                    $produtos_pesquisa[$value->productType][$key]['cover_produto_thumb'] = $thumb_produto;
                }
                $produtos_pesquisa[$value->productType][$key]['brief_produto'] = $value->product->brief;
                $produtos_pesquisa[$value->productType][$key]['brief'] = $value->brief;
            }else{
                continue;
            }
        }


        print_r($produtos_pesquisa['magazine']);

        
    }

    public function autor($id)
    {
        $id_autor = $id;
        $token = Cache::get('tokenGlobal');

        $ch = curl_init('https://api.dentalgo.com.br/catalog/authors/'.$id_autor);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $conteudo_autor = json_decode($server_output);

        $autorNome = str_replace(" ","%20",$conteudo_autor->name);


        $ch = curl_init('https://api.dentalgo.com.br/subscription/search/complete?take=30&q%5Bquery%5D='.$autorNome);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $conteudo_pesquisa = json_decode($server_output);

        for ($i = 2; $i <= $conteudo_pesquisa->pages; $i++){
            $ch = curl_init('https://api.dentalgo.com.br/subscription/search/complete?page='.$i.'&take=30&q%5Bquery%5D='.$autorNome);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $server_output = curl_exec($ch); 
            curl_close($ch); 
            $conteudo_pagina = json_decode($server_output);
            if($i > 2){
                $conteudo_pesquisa_final = array_merge($conteudo_pesquisa_final, $conteudo_pagina->rows);
            }else{
                $conteudo_pesquisa_final = array_merge($conteudo_pesquisa->rows, $conteudo_pagina->rows);
            }
        }

        $produtos_pesquisa = array();
        $ii = 0;
        /*print_r($conteudo_pesquisa_final);
        die();*/

        foreach ($conteudo_pesquisa_final as $key => $value) {
            $qntAutors = count($value->authors);
            if($qntAutors > 1){
                foreach ($value->authors as $valor) {
                    if($valor->id == $conteudo_autor->id){
                        $temAutor = 1;
                    }else{
                        $temAutor = 0;
                    }
                }
            }elseif($qntAutors == 1){
                if($value->authors[0]->id == $conteudo_autor->id){
                    $temAutor = 1;
                }
            }else{
                $temAutor = 0;
                continue;
            }
            if(isset($temAutor)){
                if($temAutor == 1){
                    $ii++;

                    if(!empty($value->cover)){
                        $thumb = '';
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG);
                        $thumbor->imageUrl($value->cover);
                        $thumb = $thumbor->get();
                    }else{
                        unset($thumb);
                    }
                    if(!empty($value->product->cover)){
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG);
                        $thumbor->imageUrl($value->product->cover);
                        $thumb_produto = $thumbor->get();
                    }else{
                        unset($thumb_produto);
                    }

                    $produtos_pesquisa[$value->productType][$key]['id_artigo'] = $value->id;
                    $produtos_pesquisa[$value->productType][$key]['id_produto'] = $value->product->id;
                    $produtos_pesquisa[$value->productType][$key]['title'] = $value->title;
                    $produtos_pesquisa[$value->productType][$key]['title_produto'] = $value->product->title;
                    $produtos_pesquisa[$value->productType][$key]['cover'] = $value->cover;
                    if(isset($thumb)){
                        $produtos_pesquisa[$value->productType][$key]['cover_thumb'] = $thumb;
                    }
                    $produtos_pesquisa[$value->productType][$key]['cover_produto'] = $value->product->cover;
                    if(isset($thumb_produto)){
                        $produtos_pesquisa[$value->productType][$key]['cover_produto_thumb'] = $thumb_produto;
                    }
                    $produtos_pesquisa[$value->productType][$key]['brief_produto'] = $value->product->brief;
                    $produtos_pesquisa[$value->productType][$key]['brief'] = $value->brief;
                }else{
                    continue;
                }
            }else{
                print_r($qntAutors);
                die();
            }
        }

        print_r($produtos_pesquisa);
    }


    /*public function autor($id)
    {
        $id_autor = $id;
        $token = Cache::get('tokenGlobal');

        $ch = curl_init('https://api.dentalgo.com.br/catalog/authors/'.$id_autor);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $conteudo_autor = json_decode($server_output);

        $ch = curl_init('https://api.dentalgo.com.br/catalog/products?q%5Bauthors%5D%5B0%5D='.$id_autor);
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $conteudo = json_decode($server_output);


        for ($i = 2; $i <= $conteudo->pages; $i++){
            echo $i.'<br>';
            $ch = curl_init('https://api.dentalgo.com.br/catalog/products?page='.$i.'&q%5Bauthors%5D%5B0%5D='.$id_autor);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $server_output = curl_exec($ch); 
            curl_close($ch); 
            $conteudo_pagina = json_decode($server_output);
            if($i > 2){
                $conteudo_final = array_merge($conteudo_final, $conteudo_pagina->rows);
            }else{
                $conteudo_final = array_merge($conteudo->rows, $conteudo_pagina->rows);
            }
        }

        echo '<br><br><hr><br><br>';

        print_r($conteudo_autor);

        echo '<br><br><hr><br><br>';

        print_r($conteudo);

        echo '<br><br><hr><br><br>';

        print_r($conteudo_pagina);

        echo '<br><br><hr><br><br>';

        $produtos = array();
        foreach ($conteudo_final as $key => $value) {
            $produtos[$key]['id'] = $value->id;
            $produtos[$key]['title'] = $value->title;
            $produtos[$key]['cover'] = $value->cover;
            $produtos[$key]['brief'] = $value->brief;
        }


        $autorNome = str_replace(" ","%20",$conteudo_autor->name);

        print_r($produtos);
    }*/
}
