<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiToken
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
        // Verifica se o usuário NÃO tem um 'token' guardado na sessão.
        if (!session()->has('token')) {
            // Se for uma requisição do nosso JavaScript (AJAX), retorna um erro JSON.
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Sessão expirada. Por favor, faça o login novamente.'], 401);
            }
            // Se for uma tentativa de acesso direto pela URL, redireciona para a home.
            return redirect('/');
        }

        // Se o token existir, o segurança deixa a requisição continuar.
        return $next($request);
    }
}