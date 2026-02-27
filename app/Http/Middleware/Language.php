<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Debug: Log incoming request
        if (strpos($request->getRequestUri(), 'painel-consultas') !== false) {
            \Illuminate\Support\Facades\Log::info('Consultas Request:', [
                'method' => $request->getMethod(),
                'uri' => $request->getRequestUri(),
                'all' => $request->all()
            ]);
        }

        // Configura o idioma da aplicação
        if (Session::has('lang_code')) {
            App::setLocale(Session::get('lang_code'));
        }

        // Verifica o id_filiado na sessão ou na requisição
        if (!Session::has('id_filiado')) {
            $getfiliado = $request->input('filiation');
            if ($getfiliado !== null) {
                Session::put('id_filiado', $getfiliado);
            }
        }

        // Verifica se o usuário está logado
        if (Session::has('token')) {
            // Verifica se é usuário Schoolar - se for, pula a verificação da API DentalGo
            if (Session::get('tipoUsuario') !== 'schoolar') {
                // Consulta se o usuário está autorizado (apenas para usuários DentalGo)
                $response = Http::withToken(Session::get('token'))
                    ->post('https://api.dentalgo.com.br/catalog/subscriptions');

                $retorno = $response->json();

                if (isset($retorno['code']) && $retorno['code'] === 'unauthorized') {
                    Session::flush();
                    return redirect()->back();
                }
            }
        }

        return $next($request);
    }
}