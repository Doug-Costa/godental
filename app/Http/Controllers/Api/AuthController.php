<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Autentica um usuário admin
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autenticar(Request $request)
    {
        try {
            // Validação dos dados de entrada
            $validator = Validator::make($request->all(), [
                'user' => 'required|string',
                'senha' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dados inválidos',
                    'errors' => $validator->errors()
                ], 400);
            }

            $user = $request->input('user');
            $senha = $request->input('senha');

            // Log da tentativa de autenticação (sem a senha)
            Log::info('Tentativa de autenticação API', [
                'user' => $user,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Busca o usuário admin no banco
            $admin = DB::table('admin')
                ->where('user', $user)
                ->first();

            if (!$admin) {
                Log::warning('Usuário não encontrado na autenticação API', ['user' => $user]);
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciais inválidas'
                ], 401);
            }

            // Verifica a senha
            if (!Hash::check($senha, $admin->senha)) {
                Log::warning('Senha incorreta na autenticação API', ['user' => $user]);
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciais inválidas'
                ], 401);
            }

            // Autenticação bem-sucedida
            Log::info('Autenticação API bem-sucedida', ['user' => $user, 'admin_id' => $admin->id]);

            return response()->json([
                'success' => true,
                'message' => 'Autenticação realizada com sucesso',
                'data' => [
                    'id' => $admin->id,
                    'nome' => $admin->nome,
                    'user' => $admin->user,
                    'email' => $admin->email,
                    'telefone' => $admin->telefone,
                    'authenticated_at' => now()->toISOString()
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erro na autenticação API', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro interno do servidor'
            ], 500);
        }
    }

    /**
     * Verifica o status de autenticação
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API funcionando',
            'timestamp' => now()->toISOString()
        ]);
    }
}