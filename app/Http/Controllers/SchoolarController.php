<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Session;


class SchoolarController extends Controller
{
    public function loginSchoolar()
    {
        return view('loginschoolar');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Fazer requisição para a API de autenticação
        $response = Http::post('https://scholar.dentalgo.com.br/api/autenticar', [
            'email' => $request->email,
            'senha' => $request->password,
        ]);

        $authData = $response->object();

        // Se falhou
        if (!$response->successful() || !isset($authData->token)) {
            echo 'erro aqui';
            return back()->withErrors('Erro ao autenticar no Schoolar.')->withInput();
        }

        // Armazena token e tempo de expiração
        session()->put('tokenschoolar', $authData->token);
        session()->put('token_expires_at', now()->addSeconds($authData->expires_in));

        // Requisição com cURL para buscar dados do aluno
        $ch = curl_init('https://scholar.dentalgo.com.br/api/aluno/dados');
        $authorization = "Authorization: Bearer " . $authData->token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            $authorization
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $resultado = curl_exec($ch);
        curl_close($ch);

        $conteudo = json_decode($resultado);

        // Verificação de resposta
        if (!isset($conteudo->status) || $conteudo->status !== 'ok') {
            echo 'erro aqui';
            session()->flush();
            return back()->withErrors('Erro ao obter dados do aluno no Schoolar.');
        }


        // Armazena os dados completos da API
        session()->put('usuario', $conteudo);
        session()->put('tipoUsuario', 'schoolar');

        // Configurar permissões para acesso aos conteúdos DentalGo
        // Alunos Schoolar têm acesso completo aos artigos e vídeos
        session()->put('usuarioPlano', (object)[
            'id' => 'schoolar_plan',
            'nome' => 'Plano Schoolar',
            'ativo' => true,
            'tipo' => 'completo'
        ]);

        // Array com todos os IDs das coleções para acesso completo
        $colecaoPermissao = [
            1,   // JBCOMS
            2,   // DP Endodontics
            4,   // Clinical Dentistry
            5,   // Clinical Orthodontics
            6,   // DPJO
            7,   // Vídeos
            50,  // Brazilian Periodontology
            67,  // Orofacial Harmony
            79   // JCDAM
        ];
        
        session()->put('usuarioPermissao', $colecaoPermissao);

        // Redireciona para a pagina do schoolar
        return redirect()->route('school');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('home')->with('success', 'Logout realizado com sucesso.');
    }

}