<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Session;


if (session()->has('token')) {

} else {
    if (Cache::has('tokenGlobal')) {
        session()->put('usuario', 'API');
    } else {
        $email = 'yuzofuzii2@gmail.com';
        $password = 'emchuvadepikatuusaabundadeguardachuva';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.dentalgo.com.br/sessions/sign-in");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&password=$password");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        if ($server_output === false) {
            echo 'Erro do cURL: ' . curl_error($ch); // Mostra a descrição do erro
            echo 'Código de erro: ' . curl_errno($ch); // Mostra o código numérico
        }
        curl_close($ch);
        $token = json_decode($server_output);
        $token = $token->token;
        Cache::put('tokenGlobal', $token, 500);
        $usuarioPlano = session()->put('usuarioPlano', 'semplano');
        $usuarioPermissao = session()->put('usuarioPermissao', 'naotem');
    }
}

class PagesController extends Controller
{


    function changeLang($langcode)
    {
        App::setLocale($langcode);
        session()->put("lang_code", $langcode);
        return redirect()->back();
    }


    //FACELIFT2.0
    public function faceindex()
    {

        $idsColecoes = [5, 6, 67, 4, 1, 2, 50];
        $ultimasRevistas = [];

        foreach ($idsColecoes as $id) {
            $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);

            $ultimaRevista = end($colecao[0]->products);

            if ($ultimaRevista) {
                $ultimasRevistas[] = $ultimaRevista;
            }
        }

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';

        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas[0]->id);
        $videos = app('App\Http\Controllers\VideosController')->videos();
        $livros = app('App\Http\Controllers\LivroController')->livros();
        //DESCONTO PROFESSOR

        if (request()->input('plano') != null) {
            $plano = request()->input('plano');
            session()->put('plano', $plano);
        }
        //SCHOOLAR
        $colecaoSchoolar = null;
        if (session()->get("usuario") != 'API') {
            if (isset(session()->get("usuario")->subscription)) {
                if (isset(session()->get("usuario")->subscription->plan->id)) {
                    if (session()->get("usuario")->subscription->plan->id == '256') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('77');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '255') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('71');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '272') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('85');
                    }
                }
            }
        }
        if (null !== session()->get('token')) {
            $livrosComprados = app('App\Http\Controllers\LivroController')->livrosComprados();
        } else {
            $livrosComprados = null;
        }
        return view("facelift2/home", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista, "videos" => $videos, "livros" => $livros, "livrosComprados" => $livrosComprados, "colecaoSchoolar" => $colecaoSchoolar]);
    }

    public function facevideos()
    {
        $videos = app('App\Http\Controllers\VideosController')->videos();
        if ($videos == 'deslogou') {
            return redirect('/');
        } else {
            return view("facelift2/videos", ["videos" => $videos]);
        }
    }
    public function facecolecoes()
    {

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';
        $ultimasRevistas = app('App\Http\Controllers\ProdutofiltroController')->produto($tipo);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas->rows[0]->id);
        if ($colecoes == 'deslogou') {
            return redirect('/');
        } else {
            return view("facelift2/colecoes", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista]);
        }
    }

    // FACELIFT METHODS FOR LEGACY ROUTES (Single Item & Search)

    public function facelivro()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $id = Request()->segment(2 + $offset); // was 3 or 2
        $idColecao = Request()->segment(4 + $offset);

        $revista = app('App\Http\Controllers\RevistaController')->revista($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();

        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('facelift2/livro', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function faceprodutocomprado()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $id = Request()->segment(2 + $offset); // was 2
        $idColecao = Request()->segment(4 + $offset); // was 4

        $revista = app('App\Http\Controllers\RevistaController')->produtocomprado($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();

        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('facelift2/produtocomprado', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function facebusca()
    {
        // Handle legacy /busca/TERM support
        $term = Request()->segment(2); // /busca/TERM
        if ($term && !Request()->has('q') && !Request()->has('busca')) {
            Request()->merge(['q' => $term]);
        }

        return app('App\Http\Controllers\BuscaElasticController')->buscar25(Request());
    }

    public function facelivros()
    {
        // if(Request()->segment(2)){
        //     $barear = Request()->segment(2);
        //     app('App\Http\Controllers\LoginController')->loginAuto($barear);
        // }   
        $livros = app('App\Http\Controllers\LivroController')->livros();
        if (null !== session()->get('token')) {
            $livrosComprados = app('App\Http\Controllers\LivroController')->livrosComprados();
        } else {
            $livrosComprados = null;
        }
        if ($livros == 'deslogou') {
            return redirect('/');
        } else {
            return view("facelift2/livros", ["livros" => $livros, "livrosComprados" => $livrosComprados]);
        }
    }



    public function facecanais()
    {
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();

        if ($colecoes == 'deslogou') {
            return redirect('/');
        }

        return view('facelift2/canais', ['colecoes' => $colecoes]);
    }


    public function facecolecao()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $idColecao = Request()->segment(4 + $offset); // was 5
        $id = Request()->segment(2 + $offset); // was 3
        $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);
        $pegaUltimaRevista = end($colecao[0]->products);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($pegaUltimaRevista->id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($colecao == 'deslogou') {
            return redirect('/');
        } else {
            return view('facelift2/colecao', ["colecao" => $colecao, "colecoes" => $colecoes, "idColecao" => $idColecao, "ultimaRevista" => $ultimaRevista]);
        }
    }

    public function facerevista()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $id = Request()->segment(2 + $offset); // was 3
        $idColecao = Request()->segment(4 + $offset); // was 5
        $revista = app('App\Http\Controllers\RevistaController')->revista($id);

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('facelift2/revista', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function faceartigo()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $id = Request()->segment(2 + $offset); // was 3
        $idColecao = Request()->segment(4 + $offset); // was 5
        $revista = app('App\Http\Controllers\RevistaController')->revista($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('facelift2/artigo', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }


    public function facevideo()
    {
        $offset = (Request()->segment(1) == 'facelift25') ? 1 : 0;
        $id = Request()->segment(2 + $offset); // was 3
        $videos = app('App\Http\Controllers\VideosController')->videos();
        $video = app('App\Http\Controllers\VideosController')->video($id);
        if ($video == 'deslogou') {
            return redirect('/');
        } else {
            return view("facelift2/video", ["videos" => $videos, "video" => $video]);
        }
    }



    public function faceloadingvideo()
    {
        return view('loadingvideo');
    }





    //DENTALGOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    public function facevideoplay()
    {
        return view('facelift2/videoplay');
    }


    //chama blade do canais
    public function clubeDeVantagens()
    {
        return view('clube-de-vantagens');
    }
    //gotalks
    public function gotalks()
    {
        return view('facelift2.gotalks');
    }

    public function index()
    {

        $idsColecoes = [5, 6, 67, 4, 1, 2, 50];
        $ultimasRevistas = [];

        foreach ($idsColecoes as $id) {
            $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);

            $ultimaRevista = end($colecao[0]->products);

            if ($ultimaRevista) {
                $ultimasRevistas[] = $ultimaRevista;
            }
        }

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';

        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas[0]->id);
        $videos = app('App\Http\Controllers\VideosController')->videos();
        $livros = app('App\Http\Controllers\LivroController')->livros();
        //DESCONTO PROFESSOR

        if (request()->input('plano') != null) {
            $plano = request()->input('plano');
            session()->put('plano', $plano);
        }
        //SCHOOLAR
        $colecaoSchoolar = null;
        if (session()->get("usuario") != 'API') {
            if (isset(session()->get("usuario")->subscription)) {
                if (isset(session()->get("usuario")->subscription->plan->id)) {
                    if (session()->get("usuario")->subscription->plan->id == '256') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('77');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '255') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('71');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '272') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('85');
                    }
                }
            }
        }
        if (null !== session()->get('token')) {
            $livrosComprados = app('App\Http\Controllers\LivroController')->livrosComprados();
        } else {
            $livrosComprados = null;
        }
        return view("home", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista, "videos" => $videos, "livros" => $livros, "livrosComprados" => $livrosComprados, "colecaoSchoolar" => $colecaoSchoolar]);
    }

    public function indexMobile()
    {
        $idsColecoes = [5, 6, 67, 4, 1, 2, 50];
        $ultimasRevistas = [];

        foreach ($idsColecoes as $id) {
            $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);

            $ultimaRevista = end($colecao[0]->products);

            if ($ultimaRevista) {
                $ultimasRevistas[] = $ultimaRevista;
            }
        }
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';

        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas[0]->id);
        $videos = app('App\Http\Controllers\VideosController')->videos();
        $livros = app('App\Http\Controllers\LivroController')->livros();
        //SCHOOLAR
        $colecaoSchoolar = null;
        if (session()->get("usuario") != 'API') {
            if (isset(session()->get("usuario")->subscription)) {
                if (isset(session()->get("usuario")->subscription->plan->id)) {
                    if (session()->get("usuario")->subscription->plan->id == '256') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('77');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '255') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('71');
                    }
                    if (session()->get("usuario")->subscription->plan->id == '272') {
                        $colecaoSchoolar = app('App\Http\Controllers\ColecaoController')->colecao('85');
                    }
                }
            }
        }
        if (null !== session()->get('token')) {
            $livrosComprados = app('App\Http\Controllers\LivroController')->livrosComprados();
        } else {
            $livrosComprados = null;
        }
        return view("mobile/home", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista, "videos" => $videos, "livros" => $livros, "livrosComprados" => $livrosComprados, "colecaoSchoolar" => $colecaoSchoolar]);
    }

    /* SCHOOLAR */
    //schoolar home
    public function school()
    {
        \Log::info('=== INÍCIO VERIFICAÇÃO SCHOOLAR ===');

        if (session()->has('tipoUsuario') && session()->get('tipoUsuario') === 'schoolar') {
            $schoolar = session()->get('usuario');

            \Log::info('Usuário schoolar encontrado na sessão', [
                'user_id' => $schoolar->id ?? 'N/A',
                'apostilas_count' => isset($schoolar->turmas) ? array_sum(array_map(function ($turma) {
                    return count($turma->apostilas ?? []);
                }, $schoolar->turmas)) : 0,
                'turmas_count' => count($schoolar->turmas ?? [])
            ]);

            // Verificar se há token válido para fazer a verificação
            if (session()->has('tokenschoolar')) {
                \Log::info('Token encontrado, fazendo requisição para API...');

                try {
                    // Buscar dados atuais da API
                    $ch = curl_init('http://127.0.0.1:8081/api/aluno/dados');
                    $authorization = "Authorization: Bearer " . session()->get('tokenschoolar');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        $authorization
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout de 5 segundos
                    $resultado = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    \Log::info('Resposta da API recebida', [
                        'http_code' => $httpCode,
                        'resultado_length' => $resultado ? strlen($resultado) : 0
                    ]);

                    if ($resultado !== false && $httpCode === 200) {
                        $dadosAtuais = json_decode($resultado);

                        // Verificar se a resposta é válida
                        if (isset($dadosAtuais->status) && $dadosAtuais->status === 'ok') {
                            \Log::info('Dados atuais da API', [
                                'user_id' => $dadosAtuais->id ?? 'N/A',
                                'apostilas_count' => isset($dadosAtuais->turmas) ? array_sum(array_map(function ($turma) {
                                    return count($turma->apostilas ?? []);
                                }, $dadosAtuais->turmas)) : 0,
                                'turmas_count' => count($dadosAtuais->turmas ?? [])
                            ]);

                            $precisaAtualizar = false;
                            $alteracoes = [];

                            // Comparar logo da instituição
                            $logoAtual = $dadosAtuais->turmas[0]->instituicao->logo ?? null;
                            $logoSession = $schoolar->turmas[0]->instituicao->logo ?? null;
                            if ($logoAtual !== $logoSession) {
                                $precisaAtualizar = true;
                                $alteracoes[] = 'Logo da instituição alterado';
                                \Log::info('Logo da instituição alterado', [
                                    'session_logo' => $logoSession,
                                    'current_logo' => $logoAtual
                                ]);
                            }

                            // Comparar apostilas disponíveis
                            $apostilasAtuais = [];
                            $apostilasSession = [];

                            // Extrair apostilas dos dados atuais
                            if (isset($dadosAtuais->turmas)) {
                                foreach ($dadosAtuais->turmas as $turma) {
                                    if (isset($turma->apostilas)) {
                                        foreach ($turma->apostilas as $apostila) {
                                            // A estrutura da API retorna: apostila->apostila->id
                                            if (isset($apostila->apostila->id)) {
                                                $apostilasAtuais[] = $apostila->apostila->id;
                                            } elseif (isset($apostila->id)) {
                                                $apostilasAtuais[] = $apostila->id;
                                            } elseif (isset($apostila->apostila_id)) {
                                                $apostilasAtuais[] = $apostila->apostila_id;
                                            } else {
                                                \Log::warning('Apostila sem ID encontrada', ['apostila' => $apostila]);
                                            }
                                        }
                                    }
                                }
                            }

                            // Extrair apostilas da sessão
                            if (isset($schoolar->turmas)) {
                                foreach ($schoolar->turmas as $turma) {
                                    if (isset($turma->apostilas)) {
                                        foreach ($turma->apostilas as $apostila) {
                                            // A estrutura da sessão também deve seguir o mesmo padrão: apostila->apostila->id
                                            if (isset($apostila->apostila->id)) {
                                                $apostilasSession[] = $apostila->apostila->id;
                                            } elseif (isset($apostila->id)) {
                                                $apostilasSession[] = $apostila->id;
                                            } elseif (isset($apostila->apostila_id)) {
                                                $apostilasSession[] = $apostila->apostila_id;
                                            } else {
                                                \Log::warning('Apostila da sessão sem ID encontrada', ['apostila' => $apostila]);
                                            }
                                        }
                                    }
                                }
                            }

                            // Comparar arrays de apostilas
                            sort($apostilasAtuais);
                            sort($apostilasSession);

                            \Log::info('Comparando apostilas', [
                                'session_apostilas' => $apostilasSession,
                                'current_apostilas' => $apostilasAtuais
                            ]);

                            if ($apostilasAtuais !== $apostilasSession) {
                                $precisaAtualizar = true;
                                $novasApostilas = array_diff($apostilasAtuais, $apostilasSession);
                                $apostilasRemovidas = array_diff($apostilasSession, $apostilasAtuais);

                                if (!empty($novasApostilas)) {
                                    $alteracoes[] = 'Novas apostilas disponíveis: ' . implode(', ', $novasApostilas);
                                    \Log::info('Novas apostilas detectadas', ['added' => $novasApostilas]);
                                }
                                if (!empty($apostilasRemovidas)) {
                                    $alteracoes[] = 'Apostilas removidas: ' . implode(', ', $apostilasRemovidas);
                                    \Log::info('Apostilas removidas detectadas', ['removed' => $apostilasRemovidas]);
                                }
                            }

                            // Comparar número de turmas
                            $numTurmasAtual = count($dadosAtuais->turmas ?? []);
                            $numTurmasSession = count($schoolar->turmas ?? []);
                            if ($numTurmasAtual !== $numTurmasSession) {
                                $precisaAtualizar = true;
                                $alteracoes[] = "Número de turmas alterado: {$numTurmasSession} → {$numTurmasAtual}";
                                \Log::info('Número de turmas alterado', [
                                    'session_count' => $numTurmasSession,
                                    'current_count' => $numTurmasAtual
                                ]);
                            }

                            // Se houver alterações, atualizar session
                            if ($precisaAtualizar) {
                                session()->put('usuario', $dadosAtuais);
                                $schoolar = $dadosAtuais;

                                // Log da atualização
                                \Log::info('✅ DADOS ATUALIZADOS AUTOMATICAMENTE', [
                                    'alteracoes' => $alteracoes,
                                    'usuario_id' => $schoolar->id ?? 'N/A',
                                    'timestamp' => now()->format('Y-m-d H:i:s')
                                ]);
                            } else {
                                \Log::info('✅ Nenhuma mudança detectada - dados já estão atualizados');
                            }
                        }
                    } else {
                        \Log::warning('API retornou erro', [
                            'http_code' => $httpCode,
                            'resultado' => $resultado
                        ]);
                    }
                } catch (\Exception $e) {
                    // Em caso de erro na verificação, continuar com os dados da session
                    \Log::error('❌ Erro ao verificar atualização da session', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                \Log::warning('Token não encontrado na sessão');
            }

            // Carregamento dinâmico das revistas (seguindo padrão da home do DentalGo)
            $idsColecoes = [5, 6, 67, 79, 4, 1, 2, 50];
            $ultimasRevistas = [];
            $colecoes = [];

            foreach ($idsColecoes as $id) {
                $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);

                // Armazena a primeira coleção para uso na view (padrão DentalGo)
                if (empty($colecoes)) {
                    $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
                }

                $ultimaRevista = end($colecao[0]->products);

                if ($ultimaRevista) {
                    $ultimasRevistas[] = $ultimaRevista;
                }
            }

            // Organizar apostilas por turma para exibição
            $apostilasPorTurma = [];
            if (isset($schoolar->turmas)) {
                foreach ($schoolar->turmas as $turma) {
                    $turmaInfo = [
                        'id' => $turma->turma->id ?? null,
                        'nome' => $turma->turma->nome ?? 'Turma sem nome',
                        'especialidade' => $turma->turma->especialidade ?? null,
                        'apostilas' => []
                    ];

                    if (isset($turma->apostilas)) {
                        foreach ($turma->apostilas as $vinculo) {
                            $apostila = $vinculo->apostila ?? null;
                            if ($apostila) {
                                $turmaInfo['apostilas'][] = [
                                    'id' => $apostila->id,
                                    'nome' => $apostila->nome,
                                    'descricao' => $apostila->descricao ?? null,
                                    'capa' => $apostila->capa ?? null,
                                    'ordem' => $vinculo->vinculo_apostila->ordem ?? 0
                                ];
                            }
                        }

                        // Ordenar apostilas por ordem
                        usort($turmaInfo['apostilas'], function ($a, $b) {
                            return $a['ordem'] <=> $b['ordem'];
                        });
                    }

                    $apostilasPorTurma[] = $turmaInfo;
                }
            }

            \Log::info('=== FIM VERIFICAÇÃO SCHOOLAR ===');

            return view("schoolar.home", [
                "schoolar" => $schoolar,
                "ultimasRevistas" => $ultimasRevistas,
                "colecoes" => $colecoes,
                "apostilasPorTurma" => $apostilasPorTurma
            ]);
        } else {
            echo 'deu erro aqui ó';
        }

    }
    public function schoologin()
    {

        return view("schoolar.login");

    }

    public function apostila()
    {
        if (session()->has('tipoUsuario') && session()->get('tipoUsuario') === 'schoolar') {
            $schoolar = session()->get('usuario');
            return view("schoolar.apostila", ["schoolar" => $schoolar]);
        } else {
            echo 'deu erro aqui ó';
        }
    }


    /* LANDINGPAGE DENTALGO ASSINE */
    public function assine()
    {
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';
        $ultimasRevistas = app('App\Http\Controllers\ProdutofiltroController')->produto($tipo);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas->rows[0]->id);
        $id = Request()->segment(2);
        $videos = app('App\Http\Controllers\VideosController')->videos();



        //return view('assine', ["colecoes"=>$colecoes, "ultimasRevistas"=>$ultimasRevistas, "ultimaRevista"=>$ultimaRevista, "colecao"=>$colecao, "idColecao"=>$idColecao]);
        return view("assine", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista, "videos" => $videos]);
    }

    public function assinemobile()
    {
        return view('assinemobile');
    }

    public function checkoutnovo()
    {

        $initialStep = 1; // Por padrão, a etapa inicial é a 1
        $usuario = null;  // Por padrão, não temos dados do usuário



        // Verifica se o usuário JÁ ESTÁ LOGADO
        if (session()->has('token')) {
            $initialStep = 2;
            $usuario = session()->get('usuario');


            // CORREÇÃO: Verificamos o status da assinatura diretamente do objeto de usuário
            // que já está na sessão. Isso elimina a necessidade de uma nova chamada à API.
            if (isset($usuario->subscription) && isset($usuario->subscription->status)) {
                $statusLimpo = trim($usuario->subscription->status);

                if ($statusLimpo === 'active') {
                    $subscriptionStatus = 'active';
                }
            }
        }



        // Carrega a view 'checkoutnovo' e envia para ela:
        // 1. Qual a etapa inicial a ser exibida ($initialStep)
        // 2. Os dados do usuário, se ele estiver logado ($usuario)
        return view('checkoutnovo', [
            'initialStep' => $initialStep,
            'usuario' => $usuario,
            'subscriptionStatus' => $subscriptionStatus
        ]);
    }




    /*  LADINGPAGE DENTALGO SETE DIAS */
    // public function setedias() 
    // {
    //     return view('setedias');
    // }
    // public function setediasemail() 
    // {
    //     $plano = request()->input('plano');
    //     if(request()->input('email') != null){
    //         $email = request()->input('email');
    //         $SeteDias = app('App\Http\Controllers\SeteDiasController')->userID($email);
    //     }else{
    //         return view('setediasemail');
    //     }
    // }

    public function promosurya()
    {
        return view('promosurya');
    }
    public function promosuryaemail()
    {
        $plano = request()->input('plano');
        if (request()->input('email') != null) {
            $email = request()->input('email');
            $PromoSurya = app('App\Http\Controllers\PromoSuryaController')->userID($email);
        } else {
            return view('promosuryaemail');
        }
    }

    /*  LADINGPAGE ALADO  */
    public function alado()
    {
        session()->put('plano', '277');
        return view('alado');
    }
    public function aladoemail()
    {
        session()->put('plano', '277');
        if (request()->input('email') != null) {
            $email = request()->input('email');
        } else {
            return view('aladoemail');
        }
    }

    /* POLITICA */
    public function politica()
    {
        return view('politica');
    }



    public function logar()
    {
        return view('logar');
    }

    public function recuperarsenha()
    {
        if (request()->input('cod') != null) {
            $UserId64 = request()->input('cod');
            $UserId = base64_decode($UserId64);
            $UserById = app('App\Http\Controllers\ConsultaUserIdController')->userID($UserId);
            if (isset($UserById->message)) {
                $localizado = 0;
            } else {
                if ($UserById == null) {
                    $localizado = 0;
                } else {
                    $localizado = 1;
                }
            }
        } else {
            $localizado = 0;
        }
        return view("recuperarsenha", ["usuario" => $UserById, "localizado" => $localizado]);
    }

    public function logarbooks()
    {
        return view('logarbooks');
    }

    public function cadastrar()
    {
        if (request()->input('plano') != null) {
            $plano = request()->input('plano');
            session()->put('plano', $plano);
        }
        return view('cadastrar');
    }


    public function hub()
    {
        if (session()->has('token')) {
            if (session()->get('usuario')->tipoUsuario == 'pessoal') {
                $idproduto = Request()->input('id_produto');
                $idartigos = Request()->input('id_artigos');
                if ($idproduto != null) {
                    // $url = '{"productId":"'.$idproduto.'"}';
                    // $url = base64_encode($url);
                    $url = $idproduto;
                    if (session()->get("lang_code") != null) {
                        $lingua = session()->get("lang_code");
                    } else {
                        $lingua = 'pt';
                    }
                    $url = 'https://dentalgo.com.br/checkout/' . $url;
                    return redirect()->away($url);
                } elseif ($idartigos != null) {
                    $url = '{"productItemsIds":[' . $idartigos . ']}';
                    $url = base64_encode($url);
                    if (session()->get("lang_code") != null) {
                        $lingua = session()->get("lang_code");
                    } else {
                        $lingua = 'pt';
                    }
                    $url = 'https://acervo.dentalgo.com.br/' . $lingua . '/store/purchase/' . $url . '?_t=' . session()->get('token');
                    return redirect()->away($url);
                } else {
                    return view('404');
                }
            } else {
                return view('hubInstitucional');
            }
        } else {
            if (request()->has('lang')) {
                $langcode = 'pt';
                if (request()->input('lang') == 'es') {
                    $langcode = 'es';
                } elseif (request()->input('lang') == 'en') {
                    $langcode = 'en';
                } else {
                    $langcode = 'pt';
                }
                App::setLocale($langcode);
                session()->put("lang_code", $langcode);
            }
            return view('hub');
        }
    }

    public function minhaconta()
    {
        $meusprodutos = app('App\Http\Controllers\minhacontaController')->meusprodutos();
        if ($meusprodutos == 'deslogou') {
            return redirect('/');
        } else {
            return view("minhaconta", ["minhaconta" => $meusprodutos]);
        }
    }

    public function minhacontabooks()
    {
        $meusprodutos = app('App\Http\Controllers\minhacontaController')->meusprodutos();
        if ($meusprodutos == 'deslogou') {
            return redirect('/');
        } else {
            return view("minhacontabooks", ["minhaconta" => $meusprodutos]);
        }
    }

    public function produtocomprado()
    {
        $id = Request()->segment(2);
        $idColecao = Request()->segment(4);
        $revista = app('App\Http\Controllers\RevistaController')->produtocomprado($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('produtocomprado', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function produtocompradobooks()
    {
        $id = Request()->segment(2);
        $idColecao = Request()->segment(4);
        $revista = app('App\Http\Controllers\RevistaController')->produtocomprado($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('produtocompradobooks', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function politicacancelamento()
    {
        return view('politicacancelamento');
    }


    public function politicatroca()
    {
        return view('politicatroca');
    }

    public function politicaentrega()
    {
        return view('politicaentrega');
    }

    public function politicaseguranca()
    {
        return view('politicaseguranca');
    }

    public function perguntasfrequentes()
    {
        return view('perguntasfrequentes');
    }



    //Parceiros
    //DVI
    public function faceparceiro()
    {
        $id = Request()->segment(2);
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/parceiro', ["canal" => $canal]);
    }
    //CLINICORP
    public function faceclinicorp()
    {
        $id = 81;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/clinicorp', ["canal" => $canal]);
    }
    //dentsplysirona
    public function facedentsplysirona()
    {
        $id = 82;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/dentsplysirona', ["canal" => $canal]);
    }
    //CvDentus
    public function cvdentus()
    {
        /*$id = 82;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);*/
        return view('parceiros/cvdentus');
    }
    //Ultradent
    public function ultradent()
    {
        /*$id = 82;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);*/
        return view('parceiros/ultradent');
    }
    //Invisalign
    public function faceinvisalign()
    {
        $id = 86;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/invisalign', ["canal" => $canal]);
    }
    //Biologix
    public function facebiologix()
    {
        $id = 89;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/biologix', ["canal" => $canal]);
    }
    //Shining3D
    public function faceshining3d()
    {
        $id = 90;
        $canal = app('App\Http\Controllers\ParceiroController')->canal($id);
        return view('/facelift2/parceiros/shining3d', ["canal" => $canal]);
    }
    public function teste()
    {
        return view('teste');
    }

    public function colecoes()
    {

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';
        $ultimasRevistas = app('App\Http\Controllers\ProdutofiltroController')->produto($tipo);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas->rows[0]->id);
        if ($colecoes == 'deslogou') {
            return redirect('/');
        } else {
            return view("colecoes", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista]);
        }
    }

    public function colecoesMobile()
    {
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        $tipo = 'magazine';
        $ultimasRevistas = app('App\Http\Controllers\ProdutofiltroController')->produto($tipo);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($ultimasRevistas->rows[0]->id);
        if ($colecoes == 'deslogou') {
            return redirect('/');
        } else {
            return view("mobile/colecoes", ["colecoes" => $colecoes, "ultimasRevistas" => $ultimasRevistas, "ultimaRevista" => $ultimaRevista]);
        }
    }

    public function colecao()
    {
        $idColecao = Request()->segment(4);
        $id = Request()->segment(2);
        $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);
        $pegaUltimaRevista = end($colecao[0]->products);
        $ultimaRevista = app('App\Http\Controllers\RevistaController')->revista($pegaUltimaRevista->id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($colecao == 'deslogou') {
            return redirect('/');
        } else {
            return view('colecao', ["colecao" => $colecao, "colecoes" => $colecoes, "idColecao" => $idColecao, "ultimaRevista" => $ultimaRevista]);
        }
    }

    public function colecaoMobile()
    {
        $id = Request()->segment(2);
        $colecao = app('App\Http\Controllers\ColecaoController')->colecao($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($colecao == 'deslogou') {
            return redirect('/');
        } else {
            return view('mobile/colecao', ["colecao" => $colecao, "colecoes" => $colecoes]);
        }
    }

    public function revista()
    {
        $id = Request()->segment(2);
        $idColecao = Request()->segment(4);
        $revista = app('App\Http\Controllers\RevistaController')->revista($id);

        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('revista', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    // RESTORED METHOD
    public function compraartigo()
    {
        // Route: /compraartigo/{id?}/{nome?}/{id_artigo?}/{nome_artigo?}/{variavel?}
        // Usage in blade: /compraartigo/REV_ID/ART_ID
        // Segment 1: compraartigo
        // Segment 2: id (Revista)
        // Segment 3: nome (used as Artigo ID in blade link)
        // Segment 4: id_artigo (actual Param name for 3rd slot is nome, 4th is id_artigo)

        $id = Request()->segment(2);

        // Logic to determine Article ID based on ambiguous usage
        // If segment 4 exists, use it. Otherwise use segment 3.
        $seg3 = Request()->segment(3);
        $seg4 = Request()->segment(4);

        $idArtigo = $seg4 ? $seg4 : $seg3;

        if (!$idArtigo && $id) {
            $idArtigo = $id; // Fallback if only one param matches
        }

        return redirect()->route('checkout', ['id' => $idArtigo]);
    }

    public function artigo()
    {
        $id = Request()->segment(2);
        $idColecao = Request()->segment(4);
        $revista = app('App\Http\Controllers\RevistaController')->revista($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('artigo', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }

    public function videos()
    {
        $videos = app('App\Http\Controllers\VideosController')->videos();
        if ($videos == 'deslogou') {
            return redirect('/');
        } else {
            return view("videos", ["videos" => $videos]);
        }
    }

    public function video()
    {
        $id = Request()->segment(2);
        $videos = app('App\Http\Controllers\VideosController')->videos();
        $video = app('App\Http\Controllers\VideosController')->video($id);
        if ($video == 'deslogou') {
            return redirect('/');
        } else {
            return view("video", ["videos" => $videos, "video" => $video]);
        }
    }

    public function videoplay()
    {
        return view('videoplay');
    }


    public function livros()
    {
        if (Request()->segment(2)) {
            $barear = Request()->segment(2);
            app('App\Http\Controllers\LoginController')->loginAuto($barear);
        }
        $livros = app('App\Http\Controllers\LivroController')->livros();
        if (null !== session()->get('token')) {
            $livrosComprados = app('App\Http\Controllers\LivroController')->livrosComprados();
        } else {
            $livrosComprados = null;
        }
        if ($livros == 'deslogou') {
            return redirect('/');
        } else {
            return view("livros", ["livros" => $livros, "livrosComprados" => $livrosComprados]);
        }
    }

    public function livro()
    {
        $id = Request()->segment(2);
        $idColecao = Request()->segment(4);
        $revista = app('App\Http\Controllers\RevistaController')->revista($id);
        $colecoes = app('App\Http\Controllers\ColecoesController')->colecoes();
        if ($revista == 'deslogou') {
            return redirect('/');
        } else {
            return view('livro', ["revista" => $revista, "colecoes" => $colecoes, "idColecao" => $idColecao]);
        }
    }


    public function comercialAutores()
    {
        $id = Request()->segment(2);
        $autores = app('App\Http\Controllers\ComercialController')->autores();
        if ($autores == 'deslogou') {
            return redirect('/');
        } else {
            return view("comercial/autores", ["comercial" => $autores]);
        }
    }

    public function comercialAutor()
    {
        $id = Request()->segment(3);
        $autor = app('App\Http\Controllers\ComercialController')->autor($id);
        if ($autor == 'deslogou') {
            return redirect('/');
        } else {
            return view("comercial/autor", ["comercial" => $autor]);
        }
    }

    public function autoresAutores()
    {
        $id = Request()->segment(2);
        $autores = app('App\Http\Controllers\AutoresController')->autores();
        if ($autores == 'deslogou') {
            return redirect('/');
        } else {
            return view("autores", ["autores" => $autores]);
        }
    }

    public function autoresAutor()
    {
        $id = Request()->segment(2);
        $autor = app('App\Http\Controllers\AutoresController')->autor($id);
        if ($autor == 'deslogou') {
            return redirect('/');
        } else {
            return view("autor", ["autor" => $autor]);
        }
    }

    public function busca()
    {
        //return view('manutencao');

        $busca = app('App\Http\Controllers\BuscaController')->busca();
        $buscaColecoes = app('App\Http\Controllers\BuscaController')->colecoes();
        if ($busca == 'deslogou') {
            return redirect('/');
        } else {
            return view("busca", ["buscaColecoes" => $buscaColecoes, "busca" => $busca]);
        }
    }

    public function loadingvideo()
    {
        return view('loadingvideo');
    }

    public function assinatura()
    {
        $assinatura = app('App\Http\Controllers\AssinaturaController')->assinar();
        if ($assinatura == 'deslogou') {
            $assinatura = app('App\Http\Controllers\LoginController')->logout();
            return redirect('/');
        } else {
            return view("assinatura", ["assinatura" => $assinatura]);
        }
    }

    public function checkout()
    {
        $checkout = app('App\Http\Controllers\CheckoutController')->checkout();
        if ($checkout == 'deslogou') {
            $checkout = app('App\Http\Controllers\LoginController')->logout();
            return redirect('/');
        } else {
            return view("checkout", ["checkout" => $checkout]);
        }
    }

    // Método para exibir matéria individual do blog
    public function blogPost($id)
    {
        // Verificar se o usuário está logado como schoolar
        if (session()->has('tipoUsuario') && session()->get('tipoUsuario') === 'schoolar') {
            $schoolar = session()->get('usuario');

            // Buscar o post nos dados já carregados
            if (isset($schoolar->turmas) && count($schoolar->turmas) > 0 && isset($schoolar->turmas[0]->blog_posts)) {
                foreach ($schoolar->turmas[0]->blog_posts as $post) {
                    if ($post->id == $id) {
                        return view("schoolar.blog", ["post" => $post, "schoolar" => $schoolar]);
                    }
                }
            }

            // Se não encontrou o post, redirecionar para home
            return redirect()->route('school')->with('error', 'Matéria não encontrada.');
        } else {
            return redirect()->route('schoologin');
        }
    }

}












































