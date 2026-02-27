<?php 
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Beeyev\Thumbor\Thumbor;
    use Beeyev\Thumbor\Manipulations\Resize;
    use Beeyev\Thumbor\Manipulations\Fit;
    use Session;

class ProdutofiltroController extends Controller
{
    public function produto($tipo)
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

        $tipo = $tipo;
        $produtoCache = 'produtofiltro'.$tipo.''.$locale;

        if (Cache::has($produtoCache)) {
            return Cache::get($produtoCache);
        }else{

            $token = Cache::get('tokenGlobal');

            $ch = curl_init('https://api.dentalgo.com.br/catalog/products?orderBy%5Bproduct.id%5D=desc&q%5BproductType%5D='.$tipo);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $server_output = curl_exec($ch); 
            curl_close($ch); 
            $conteudo_produto = json_decode($server_output);

            foreach ($conteudo_produto->rows as $key => $produto) {
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

            Cache::put($produtoCache, $conteudo_produto, 864000);

            return $conteudo_produto;
        }
    }
}
 