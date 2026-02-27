<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class minhacontaController extends Controller
{
    public function meusprodutos()
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


        $token = session()->get('token');


        // CONSULTA OS PRODUTOS COMPRADOS
        $ch = curl_init('https://api.dentalgo.com.br/catalog/libraries?page=1');
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultado = curl_exec($ch); 
        curl_close($ch); 

        $conteudo = json_decode($resultado);

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


        // CONSULTA OS ARTIGOS FAVORITADOS
        $ch = curl_init('https://api.dentalgo.com.br/catalog/favorites/product-items');
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultadoFav = curl_exec($ch); 
        curl_close($ch); 

        $conteudoFav = json_decode($resultadoFav);

        if(isset($conteudoFav->rows)){
            foreach ($conteudoFav->rows as $key => $produto) {
                if(!empty($produto->productItem->cover)){
                    $thumb = '';
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($produto->productItem->cover);
                    $thumb = $thumbor->get();
                    $produto->productItem->cover = $thumb;
                }
                if(!empty($produto->productItem->product->cover)){
                    $thumb = '';
                    $thumbor = new Thumbor('https://thumbor.dentalgo.com.br/', '8e965d636dc76246b');
                    $thumbor->resize(Resize::ORIG, 450);
                    $thumbor->fit(Fit::FIT_IN);
                    $thumbor->imageUrl($produto->productItem->product->cover);
                    $thumb = $thumbor->get();
                    $produto->productItem->product->cover = $thumb;
                }
            }
        }

        // CONSULTA O Endereço
        $ch = curl_init('https://api.dentalgo.com.br/account/address');
        $authorization = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultadoEnd = curl_exec($ch); 
        curl_close($ch); 
        $conteudoEnd = json_decode($resultadoEnd);




        $retorno = array();
        $retorno['minhabiblioteca'] = $conteudo;
        $retorno['meusFav'] = $conteudoFav;
        $retorno['endereco'] = $conteudoEnd;


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

    public function attcadastro()
    {

        $nome = Request()->input('nome');
        $email = Request()->input('email');
        $cpf = Request()->input('cpf');
        $ddi = Request()->input('ddi');
        $telefone = Request()->input('telefone');

        $token = session()->get('token');

        $infoCliente = array(
            "fullName" => "$nome",
            "email" => "$email",
            "photoURL" => "",
            "phoneNumber" => "$ddi $telefone",
            "documentNumber" => "$cpf"
          );
         

        $infoClienteJ = json_encode($infoCliente);

        $token = session()->get('token');

        $url = 'https://api.dentalgo.com.br/account/current-user';
        $ch = curl_init($url); 
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $infoClienteJ);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        $result = curl_exec($ch);
        curl_close($ch);

        $retorno = json_decode($result);

        $ch = curl_init('https://api.dentalgo.com.br/account/current-user');
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $infoUser = curl_exec($ch); 
        curl_close($ch); 

        $retornoU = json_decode($infoUser);
        $usuario = session()->put('usuario', $retornoU);



        return redirect()->back();

    }

    public function attendereco()
    {

        $cep = Request()->input('cep');
        $cidade = Request()->input('cidade');
        $uf = Request()->input('uf');
        $endereco = Request()->input('endereco');
        $numero = Request()->input('numero');
        $bairro = Request()->input('bairro');
        $complemento = Request()->input('complemento');

        $token = session()->get('token');

        $infoEndereco = array(
           "zipCode" => "$cep", 
           "city" => "$cidade", 
           "state" => [
                 "code" => "$uf" 
              ], 
           "street" => "$endereco", 
           "number" => "$numero", 
           "neighborhood" => "$bairro", 
           "complement" => "$complemento" 
        ); 
         

        $infoEnderecoJ = json_encode($infoEndereco);

        $token = session()->get('token');

        $url = 'https://api.dentalgo.com.br/catalog/address';
        $ch = curl_init($url); 
        $authorization = "Authorization: Bearer ".session()->get('token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $infoEnderecoJ);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        $result = curl_exec($ch);
        curl_close($ch);

        $retorno = json_decode($result);


        return redirect()->back();

    }

}
