<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class ColecaoController extends Controller
{
    public function colecao($id)
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
        
        $colecao = 'colecao'.$id.''.$locale;
        $token = Cache::get('tokenGlobal');

        
        if (Cache::has($colecao.'c')) {
            return array(Cache::get($colecao.'c'), Cache::get($colecao.'r'));
        }else{
            $ch = curl_init('https://api.dentalgo.com.br/subscription/collections/'.$id);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout de 10 segundos
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Timeout de conexão de 5 segundos
            $resultadoColecao = curl_exec($ch); 
            
            // Verificar se houve erro na requisição
            if ($resultadoColecao === false) {
                $error = curl_error($ch);
                curl_close($ch);
                \Log::error('Erro na API DentalGo Collections: ' . $error);
                return response()->json(['error' => 'Erro ao buscar coleção'], 500);
            }
            
            curl_close($ch); 
            $conteudoColecao = json_decode($resultadoColecao);
            
            // Verificar se a resposta é válida
            if (!$conteudoColecao || !isset($conteudoColecao->products)) {
                \Log::error('Resposta inválida da API DentalGo Collections: ' . $resultadoColecao);
                return response()->json(['error' => 'Resposta inválida da API'], 500);
            }


            sleep(1);


            foreach ($conteudoColecao->products as $key => $value) {

                if(!empty($value->cover)){
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($value->cover);
                    $thumb = $thumbor->get();
                    $conteudoColecao->products[$key]->cover = $thumb;
                }else{
                    unset($thumb);
                }

            }



            $ch = curl_init('https://api.dentalgo.com.br/subscription/collections/'.$id.'/products?page=1&locale=');
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultado = curl_exec($ch); 
            curl_close($ch); 

            $conteudo = json_decode($resultado);
            sleep(1);

            foreach ($conteudo as $key2 => $value2) {

                foreach ($value2 as $key => $value) {

                    if(!empty($conteudo->$key2[$key]->cover)){
                        $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                        $thumbor->resize(Resize::ORIG, 450);
                        $thumbor->fit(Fit::FIT_IN);
                        $thumbor->imageUrl($conteudo->$key2[$key]->cover);
                        $thumb = $thumbor->get();
                        $conteudo->$key2[$key]->cover = $thumb;
                    }else{
                        unset($thumb);
                    }
                }

            }
            
            if(isset($conteudo->code)){
                if($conteudo->code == 'unauthorized'){
                    session()->flush();
                    return 'deslogou';
                }else{
                    session()->flush();
                    return 'deslogou';
                }
            }else{

                Cache::put($colecao.'c', $conteudoColecao, 864000);
                Cache::put($colecao.'r', $conteudo, 864000);




                return array($conteudoColecao, $conteudo);
            }
        }
    }
}
