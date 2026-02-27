<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class ParceiroController extends Controller
{
    public function canal($id)
    {
        $canal = 'canal'.$id;
        $token = Cache::get('tokenGlobal');
        if (Cache::has($canal)) {
            return Cache::get($canal);
        }else{
            //Busca Conteudo Canal
            $ch = curl_init('https://api.dentalgo.com.br/catalog/collections/'.$id.'/divulgation');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);

            if(!empty($conteudo->cover)){
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG, 450);
                $thumbor->fit(Fit::FIT_IN);
                $thumbor->imageUrl($conteudo->cover);
                $thumb = $thumbor->get();

                $conteudo->cover = $thumb;
            }

            $canalTitulo = $conteudo->title;
            $canalCapa = $conteudo->cover;
            $canalDescricao = $conteudo->brief;
            $materias = array();
            $videos = array();
            // SEPARA O QUE É MATERIA E O QUE É VIDEO
            foreach ($conteudo->products as $product) {
                if ($product->internalCode === 'materia') {
                    if(!empty($product->cover)){
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($product->cover);
                        $thumb = $thumbor->get();
                        $product->cover = $thumb;
                    }else{
                        unset($thumb);
                    }
                    foreach ($product->productItems as $productItem) {
                        if(!empty($productItem->cover)){
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($productItem->cover);
                            $thumb = $thumbor->get();
                            $productItem->cover = $thumb;
                        }else{
                            unset($thumb);
                        }  
                    }
                    $materias[] = $product;
                }elseif($product->internalCode === 'video'){
                    if(!empty($product->cover)){
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($product->cover);
                        $thumb = $thumbor->get();
                        $product->cover = $thumb;
                    }else{
                        unset($thumb);
                    }
                    foreach ($product->productItems as $productItem) {
                        if(!empty($productItem->cover)){
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($productItem->cover);
                            $thumb = $thumbor->get();
                            $productItem->cover = $thumb;
                        }else{
                            unset($thumb);
                        }  
                    }
                    $videos[] = $product;
                }
            }

            $conteudo_final = array($conteudo, $canalTitulo, $canalCapa, $canalDescricao, $materias, $videos);
            Cache::put($canal, $conteudo_final, 864000);
            return $conteudo_final;
        }

    }
}