<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Beeyev\Thumbor\Thumbor;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Fit;
use Session;

class PromoSuryaController extends Controller
{
    public function userID()
    {
        $nome = Request()->input('nome');
        $cpf = Request()->input('cpf');
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        $ddi = Request()->input('ddi');
        $telefone = Request()->input('telefone');
        $email = Request()->input('email');
        $password = Request()->input('password');
        $passwordConfirm = Request()->input('passwordConfirm');
        $origem = Request()->input('origem');

        $telefoneFinal = $ddi.' '.$telefone;
        if ($password !== $passwordConfirm) {
            return back()->withErrors('errosenha')->withInput();
        }

        $tokenAdm = Cache::get('tokenGlobal');

        $ch = curl_init('https://api.dentalgo.com.br/admin/people?q%5Bemail%5D=' . $email . '&q%5Badmin%5D=0');
        $authorization = "Authorization: Bearer " . $tokenAdm;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $resultadoBuscaEmail = curl_exec($ch);
        curl_close($ch);
        $conteudoBuscaEmail = json_decode($resultadoBuscaEmail);

        $usuarioExistente = false;
        foreach ($conteudoBuscaEmail->rows as $key => $value) {
            if ($value->email == $email) {
                $usuarioExistente = true;
                $usuarioID = $value->id;
                $usuarioNome = $value->fullName;
                $usuarioEmail = $value->email;
                $usuarioTelefone = $value->phoneNumber;
                $usuarioCpf = $value->documentNumber;
            }
        }
        if ($usuarioExistente == true) {

            // Verificação de planos do usuário
            $ch = curl_init('https://api.dentalgo.com.br/admin/subscriptions?q%5BpersonId%5D=' . $usuarioID . '&take=5&page=1');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $resultadoBuscaPlano = curl_exec($ch);
            curl_close($ch);
            $conteudoBuscaPlano = json_decode($resultadoBuscaPlano);

            $podeLiberarSeteDias = true;
            foreach ($conteudoBuscaPlano->rows as $plano) {
                $dataExpiracao = new \DateTime($plano->expiresIn);
                $dataAtual = new \DateTime();
                $intervalo = $dataAtual->diff($dataExpiracao);
                if ($plano->status == 'active' || $intervalo->y < 1) {
                    $podeLiberarSeteDias = false;
                    break;
                }
            }

            if ($podeLiberarSeteDias) {
                // Liberação do plano de 7 dias grátis
                $startAt = (new \DateTime())->format('Y-m-d\TH:i:s\Z');
                $expiresIn = (new \DateTime('+90 days'))->format('Y-m-d\TH:i:s\Z');

                $ch = curl_init('https://api.dentalgo.com.br/admin/subscriptions');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'startAt' => $startAt,
                    'expiresIn' => $expiresIn,
                    'status' => 'active',
                    'planId' => 297,
                    'canceledAt' => null,
                    'overdue' => false,
                    'personId' => $usuarioID,
                    'paymentMethod' => 'credit_card'
                ]));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $resultadoLiberacao = curl_exec($ch);
                curl_close($ch);

                // Verificar se a liberação foi bem-sucedida
                $retornoLiberacao = json_decode($resultadoLiberacao);
                if (isset($retornoLiberacao->id)) {
                    // Plano liberado com sucesso
                    return redirect()->route('assine')->withErrors(['status' => 'Parabéns Plano de 3 meses liberado com sucesso!']);

                } else {
                    // Falha na liberação do plano
                    //return back()->withErrors('erroLiberaçaoPlano')->withInput();
                    return redirect()->route('assine')->withErrors(['erroLiberaçaoPlano' => 'Tivemos um problema para realizar a liberação porfavor tente novamente mais tarde']);
                }
            } else {
                return redirect()->route('assine')->withErrors(['planoAtivoOuRecente' => 'Você já possui um plano ativo ou com menos de 1 ano de vencido.']);
            }

        } else {
            // Criação do usuário e liberação do plano
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.dentalgo.com.br/sessions/sign-up");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "documentNumber=$cpf&email=$email&fullName=$nome&password=$password&phoneNumber=$telefoneFinal");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            curl_close($ch);

            $retorno = json_decode($server_output);

            if (isset($retorno->id)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.dentalgo.com.br/sessions/sign-in");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);

                $retornoLogin = json_decode($server_output);

                if (isset($retornoLogin->token)) {
                    $token = session()->put('token', $retornoLogin->token);
                    $ch = curl_init('https://api.dentalgo.com.br/account/current-user');
                    $authorization = "Authorization: Bearer " . session()->get('token');
                    $authorizationAdm = "Authorization: Bearer " . $tokenAdm;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $infoUser = curl_exec($ch);
                    curl_close($ch);

                    $retornoLogin = json_decode($infoUser);
                    $tipoUsuario = 'pessoal';
                    $retornoLogin->tipoUsuario = $tipoUsuario;
                    /*$usuario = session()->put('usuario', $retornoLogin);
                    $usuarioPlano = session()->put('usuarioPlano', 'semplano');
                    $usuarioPermissao = session()->put('usuarioPermissao', 'naotem');*/

                    // Liberação do plano de 7 dias grátis
                    $startAt = (new \DateTime())->format('Y-m-d\TH:i:s\Z');
                    $expiresIn = (new \DateTime('+90 days'))->format('Y-m-d\TH:i:s\Z');

                    $ch = curl_init('https://api.dentalgo.com.br/admin/subscriptions');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                        'startAt' => $startAt,
                        'expiresIn' => $expiresIn,
                        'status' => 'active',
                        'planId' => 297,
                        'canceledAt' => null,
                        'overdue' => false,
                        'personId' => $retornoLogin->id,
                        'paymentMethod' => 'credit_card'
                    ]));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorizationAdm));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $resultadoLiberacao = curl_exec($ch);
                    curl_close($ch);

                    // Verificar se a liberação foi bem-sucedida
                    $retornoLiberacao = json_decode($resultadoLiberacao);
                    if (isset($retornoLiberacao->id)) {
                        // Plano liberado com sucesso
                        if ($origem == 'hub') {
                            return back()->withErrors('logado')->withInput();
                        } else {
                            //return redirect('/assinatura')->with('status', 'Plano de 7 dias liberado com sucesso!');
                            return redirect()->route('assine')->withErrors(['status' => 'Parabéns Plano de 3 meses liberado com sucesso!']);
                        }
                    } else {
                        // Falha na liberação do plano
                        return redirect()->route('assine')->withErrors(['erroLiberaçaoPlano' => 'Tivemos um problema para realizar a liberação porfavor tente novamente mais tarde']);

                    }

                } else {
                    if (isset($retornoLogin->code)) {
                        if ($retornoLogin->code == 'userNotFound') {
                            return back()->withErrors('errousuario')->withInput();
                        } elseif ($retornoLogin->code == 'wrongPassword') {
                            return back()->withErrors('errosenha')->withInput();
                        } else {
                            return $retornoLogin;
                        }
                    } else {
                        return $retornoLogin;
                    }
                }
            } else {
                return back()->withErrors('erroCadastro')->withInput();
                return redirect()->route('assine')->withErrors(['erroCadastro' => 'Tivemos um erro ao criar seu usuario. Porfavor tente novamente mais tarde ou entre em contato conosco. Obrigado!']);
            }
        }

    }
}