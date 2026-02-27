<?php

namespace App\Http\Controllers;

use App\GiftCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use League\Csv\Writer;
use Carbon\Carbon;
use Session;
use Http;

class GiftController extends Controller
{

    //A função generate é utilizada para gerar um grande número de códigos de cartão presente. Ela faz isso através de um loop que chama a função create repetidas vezes (neste caso, 10000 vezes). A função create gera e salva um codigo único no banco de dados.
    public function generate() {
      for ($i = 0; $i < 10000; $i++) {
           $this->create();
      }
    }


    //Essa função é responsável por gerar um novo código para cartão presente. Ela começa gerando um código aleatório de 12 dígitos, com hífen nos quarto, oitavo e doze caracteres, depois checa se o código gerado é único, caso não seja, ela gera outro código, e assim sucessivamente até gerar um código único ou atingir o limite de 10000 tentativas. Quando um código único é gerado, ele é salvo no banco de dados como um novo cartão presente ativo.
    public function create()
    {
        // Inicializando uma variável contadora
        $count = 0;

        // Gerando um código aleatório com 12 dígitos
        $code = 't01-';
        $characters = '0123456789';

        for ($i = 0; $i < 12; $i++) {
            if ($i == 3 || $i == 7 || $i == 11) {
                // adicionando hífen no quarto, oitavo e doze caracter
                $code .= '-';
            } else {
                // adicionando números aleatórios
                $code .= rand(0,9);
            }
        }
        // removendo o ultimo caracter
        $code = substr($code, 0, -1);

        // Verificando se o código é único
        $giftCard = GiftCard::where('code', $code)->first();

        while ($giftCard) {
            // Gerando um novo código
            $code = 't01-';
            for ($i = 0; $i < 12; $i++) {
                if ($i == 3 || $i == 7 || $i == 11) {
                    $code .= '-';
                } else {
                    $code .= rand(0,9);
                }
            }
            $code = substr($code, 0, -1);

            // Verificando o novo código
            $giftCard = GiftCard::where('code', $code)->first();

            // incrementando o contador
            $count++;

            // Parando de gerar códigos caso o limite seja atingido
            if ($count >= 10000) {
                break;
            }
        }

        //se o contador é menor que 10000
        if ($count < 10000) {
            // criando o cartão presente
            $giftCard = GiftCard::create([
                'code' => $code,
                 'type' => 't01',
                'active' => true
            ]);
        }
    }

    //O código abaixo é responsável por buscar os cartões presentes do tipo especificado e que ainda não foram impressos. Em seguida, ele atualiza os cartões impressos para serem marcados como impressos, para que eles não possam ser impressos novamente. Finalmente, ele exporta os cartões presentes selecionados para um arquivo CSV. Essa função é geralmente usada quando o usuário deseja baixar os cartões presentes em massa e o usuário especifica o tipo e a quantidade dos cartões presentes na requisição.
    public function getAndExportCsv(Request $request)
    {
        // Obtém o tipo de cartão presente desejado e a quantidade de cartões desejada a partir da requisição
        $type = $request->input('type');
        $quantity = $request->input('quantity');

         // Busca os cartões presentes do tipo especificado que ainda não foram impressos, e os limita a quantidade especificada
        $giftCards = GiftCard::where('type', $type)->where('foi_impressa', 0)->limit($quantity)->get();

        // Atualiza os cartões impressos
        GiftCard::whereIn('id', $giftCards->pluck('id'))->update(['foi_impressa' => 1]);

        // Exporta os códigos para um arquivo CSV
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Adiciona uma coluna "code" ao cabeçalho do arquivo CSV
        $csv->insertOne(['code']);

        // Adiciona cada código dos cartões presentes selecionados ao arquivo CSV
        foreach($giftCards as $giftCard) {
            $csv->insertOne([$giftCard->code]);
        }
        //Adiciona headers HTTP para indicar que o arquivo é do tipo CSV e define o nome do arquivo como 'gift_cards.csv' para forçar o download do arquivo
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="gift_cards.csv"');
        $csv->output();
    }

    /*public function validagift(Request $request)
    {
        // Validação do pedido
        $request->validate([
        'code' => 'required|string|size:16',
        ]);
        // Busca pelo cartão presente
        $giftCard = GiftCard::where('code', $request->code)->first();

        if ($giftCard) {
            if ($giftCard->active) {
                // Cartão presente é válido
                // ... aplica o cartão presente na assinatura
                // Marca o cartão presente como utilizado
                $giftCard->active = false;
                $usuario = $request->input('usuario');
                $giftCard->id_usuario = $usuario;
                $giftCard->save();
                return redirect('/subscription')->with('success', 'Gift card aplicado com sucesso!');
            } else {
                // Cartão presente inativo
                return redirect('/subscription')->with('error', 'Este gift card já foi usado!');
            }
        } else {
            // Cartão presente não encontrado
            return redirect('/subscription')->with('error', 'Este gift card não foi encontrado!');
        }
    }*/

    public function validagift(Request $request)
    {

        // Validate the request
        /*$request->validate([
            'code' => 'required|string|size:16',
        ]);*/


        // Get the gift card
        $giftCard = GiftCard::where('code', $request->code)->first();
        
        if ($giftCard) {
            if ($giftCard->active) {
                // Inicializing data to send to api
                $data = new \stdClass();
                $data->startAt = Carbon::now()->format('Y-m-d\TH:i:s.u\Z');
                if (str_starts_with($giftCard->code, "G01")) {
                    //Gift card is 1 month
                    $data->expiresIn = Carbon::now()->addMonths(1)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 234;
                } else if (str_starts_with($giftCard->code, "G03")) {
                    //Gift card is 3 months
                    $data->expiresIn = Carbon::now()->addMonths(3)->format('Y-m-d\TH:i:s.u\Z');
                    $data->planId = 243;
                } else if (str_starts_with($giftCard->code, "G06")) {
                    //Gift card is 6 months
                    $data->expiresIn = Carbon::now()->addMonths(6)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 235;
                } else if (str_starts_with($giftCard->code, "G12")) {
                    //Gift card is 12 months
                    $data->expiresIn = Carbon::now()->addMonths(12)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 236;
                } else if (str_starts_with($giftCard->code, "G24")) {
                    //Gift card is 24 months
                    $data->expiresIn = Carbon::now()->addMonths(24)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 237;
                } else if (str_starts_with($giftCard->code, "D07")) {
                    //Gift card is 7 days
                    $data->expiresIn = Carbon::now()->addDays(7)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 238;
                }else if (str_starts_with($giftCard->code, "t01")) {
                    //Gift card is 7 days
                    $data->expiresIn = Carbon::now()->addDays(7)->format('Y-m-d\TH:i:s.u\Z');
                    $data->status = "active";
                    $data->planId = 238;
                }
                $data->canceledAt = null;
                $data->overdue = false;
                $data->personId = session()->get('usuario')->id;
                $data->paymentMethod = "credit_card";
                $json = json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
                
                $email = 'api@dentalpress.com.br';
                $password = 'MaquinaDeConverterC4fe3mC0digo@godental';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://api.dentalgo.com.br/sessions/sign-in");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,
                            "email=$email&password=$password");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec ($ch);
                curl_close ($ch);
                $token = json_decode($server_output);
                $token = $token->token;


                /*$response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])->post('https://api.dentalgo.com.br/admin/subscriptions', $json);*/

                $ch = curl_init('https://api.dentalgo.com.br/admin/subscriptions');
                $authorization = "Authorization: Bearer ".$token;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $resultado = curl_exec($ch); 
                curl_close($ch); 
                $resultadoFinal = json_decode($resultado);
                if(isset($resultadoFinal->status)){
                    if($resultadoFinal->status == 'active'){
                        $idPlano = $resultadoFinal->plan->id;
                        $ch = curl_init('https://api.dentalgo.com.br/catalog/plans/'.$idPlano.'/collections?page=1');
                        $authorization = "Authorization: Bearer ".session()->get('token');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        $info_plano = curl_exec($ch); 
                        curl_close($ch); 
                        $retorno_plano = json_decode($info_plano);

                        $colecaoPermissao = array();
                        foreach ($retorno_plano->rows as $key => $colecao) {
                            $colecaoPermissao[$key] = $colecao->id;
                        }

                        $usuarioPlano = session()->put('usuarioPlano', $retorno_plano);
                        $usuarioPermissao = session()->put('usuarioPermissao', $colecaoPermissao);

                        // Cartão presente é válido
                        // ... aplica o cartão presente na assinatura
                        // Marca o cartão presente como utilizado
                        $giftCard->active = false;
                        $usuario = session()->get('usuario')->id;
                        $giftCard->id_usuario = $usuario;
                        $giftCard->save();

                        return redirect()->route('assinatura')->withErrors('sucessoCartao')->withInput();

                    }
                }else{
                    if(isset($resultadoFinal->code)){
                        return redirect()->route('assinatura')->withErrors('erroJaTemPlano')->withInput();
                    }else{
                        return redirect()->route('assinatura')->withErrors('erroCartao')->withInput();
                    }
                }
                if(isset($resultadoFinal->code)){
                    return redirect()->route('assinatura')->withErrors('erroJaTemPlano')->withInput();
                }

            }else{
                return redirect()->route('assinatura')->withErrors('erroGiftUsado')->withInput();
                // Cartão presente inativo
               // return redirect('/subscription')->with('error', 'Este gift card já foi usado!');
            }
        }else{
            return redirect()->route('assinatura')->withErrors('erroGiftInvalido')->withInput();
            // Cartão presente não encontrado
           // return redirect('/subscription')->with('error', 'Este gift card não foi encontrado!');
        }
    }
}
