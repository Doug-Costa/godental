<?php 
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Beeyev\Thumbor\Thumbor;
    use Beeyev\Thumbor\Manipulations\Resize;
    use Beeyev\Thumbor\Manipulations\Fit;
    use Session;

class BuscaController extends Controller
{
   
    public function busca()
    {
        $token = Cache::get('tokenGlobal');

        $buscaGet = Request()->input('busca');
        $buscaSemEspaco = str_replace("/","%2",$buscaGet);
        $buscaSemEspaco = str_replace(" ","%20",$buscaSemEspaco);
        $buscaSemEspaco = str_replace(":","%3A",$buscaSemEspaco);
        if (isset($_GET['busca'])) {
            $url = 'https://api.dentalgo.com.br/subscription/search/complete?take=1000&';

            $params = array(
                'search' => isset($buscaSemEspaco) ? $buscaSemEspaco : '',
                'q' => array()
            );

            // Verifique se os campos do filtro de busca estão definidos e adicione-os aos parâmetros
            $params['q']['query'] = $buscaSemEspaco;
            if (isset($_GET['q']['productTypes'])) {
                $params['q']['productTypes'] = $_GET['q']['productTypes'];
            }
            if (isset($_GET['q']['collectionIds'])) {
                $params['q']['collectionIds'] = $_GET['q']['collectionIds'];
            }
            if (isset($_GET['publishOrder'])) {
                $params['q']['publishOrder'] = $_GET['publishOrder'];
            }
            if (isset($_GET['q']['languages'])) {
                $params['q']['languages'] = $_GET['q']['languages'];
            }
            $url .= http_build_query($params);
            $ch = curl_init($url);
            $authorization = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $server_output = curl_exec($ch); 
            curl_close($ch); 
            $conteudo_pesquisa = json_decode($server_output);


            $produtos_pesquisa = array();
            $ii = 0;
            $conteudo_pesquisa_final = $conteudo_pesquisa->rows;
            $contadorFelipino = $conteudo_pesquisa->counts;

            for ($i = 2; $i <= $conteudo_pesquisa->pages; $i++){
                
                $url = 'https://api.dentalgo.com.br/subscription/search/complete?page='.$i.'&take=1000&';
                $params = array(
                    'search' => isset($buscaSemEspaco) ? $buscaSemEspaco : '',
                    'q' => array()
                );

                // Verifique se os campos do filtro de busca estão definidos e adicione-os aos parâmetros
                $params['q']['query'] = $buscaSemEspaco;
                if (isset($_GET['q']['productTypes'])) {
                    $params['q']['productTypes'] = $_GET['q']['productTypes'];
                }
                if (isset($_GET['q']['collectionIds'])) {
                    $params['q']['collectionIds'] = $_GET['q']['collectionIds'];
                }
                if (isset($_GET['publishOrder'])) {
                    $params['q']['publishOrder'] = $_GET['publishOrder'];
                }
                if (isset($_GET['q']['languages'])) {
                    $params['q']['languages'] = $_GET['q']['languages'];
                }

                $url .= http_build_query($params);
                $ch = curl_init($url);
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
                    $conteudo_pesquisa_final = array_merge($conteudo_pesquisa_final, $conteudo_pagina->rows);
                }
            }


            $produtos_pesquisa['book'] = array();
            $produtos_pesquisa['video'] = array();
            $produtos_pesquisa['magazine'] = array();
            foreach ($conteudo_pesquisa_final as $key => $value) {
                $qntAutors = count($value->authors);
                $temAutor = 1;
                if(isset($temAutor)){
                    if($temAutor == 1){
                        $ii++;

                        if(!empty($value->cover)){
                            $thumb = '';
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($value->cover);
                            $thumb = $thumbor->get();
                            $cover = $thumb;
                        }else{
                            unset($thumb);
                            $cover = $value->cover;
                        }
                        if(!empty($value->product->cover)){
                            $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                            $thumbor->resize(Resize::ORIG, 450);
                            $thumbor->fit(Fit::FIT_IN);
                            $thumbor->imageUrl($value->product->cover);
                            $thumb_produto = $thumbor->get();
                            $cover_produto = $thumb_produto;
                        }else{
                            unset($thumb_produto);
                            $cover_produto = $value->product->cover;
                        }

                        $produtos_pesquisa[$value->productType][$key]['id_artigo'] = $value->id;
                        $produtos_pesquisa[$value->productType][$key]['id_produto'] = $value->product->id;
                        $produtos_pesquisa[$value->productType][$key]['title'] = $value->title;
                        $produtos_pesquisa[$value->productType][$key]['title_produto'] = $value->product->title;
                        $produtos_pesquisa[$value->productType][$key]['cover'] = $cover;
                        $produtos_pesquisa[$value->productType][$key]['cover_produto'] = $cover_produto;
                        $produtos_pesquisa[$value->productType][$key]['brief_produto'] = $value->product->brief;
                        $produtos_pesquisa[$value->productType][$key]['brief'] = $value->brief;
                        $produtos_pesquisa[$value->productType][$key]['authors'] = $value->authors;

                    }else{
                        continue;
                    }
                }else{
                    continue;
                }
            }

            $conteudo_final = array($produtos_pesquisa, $conteudo_pesquisa_final, $contadorFelipino);

            return $conteudo_final;
        }
       
    }

    public function colecoes()
    {

        $token = Cache::get('tokenGlobal');

        $ch = curl_init('https://api.dentalgo.com.br/subscription/search/collections');
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $server_output = curl_exec($ch); 
        curl_close($ch); 
        $colecoes = json_decode($server_output);

        foreach ($colecoes as $key => $value) {
            if(!empty($value->cover)){
                $thumb = '';
                $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                $thumbor->resize(Resize::ORIG, 450);
                $thumbor->fit(Fit::FIT_IN);
                $thumbor->imageUrl($value->cover);
                $thumb = $thumbor->get();
                $value->cover = $thumb;
            }else{
                unset($thumb);
            }
        }

        return $colecoes;
    }
}
 