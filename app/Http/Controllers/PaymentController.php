<?php

namespace App\Http\Controllers;

// CORREÇÃO: Adicionadas as declarações 'use' que estavam faltando
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        try {
            // 1. Valida se o 'token' (cardHash da Iugu) e o 'plan_id' foram recebidos
            $validator = Validator::make($request->all(), [
                'token' => 'required|string',
                'plan_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Dados de pagamento ou plano inválidos.'], 422);
            }

            // 2. Recupera o token do usuário da sessão
            $userToken = session()->get('token');
            if (!$userToken) {
                return response()->json(['message' => 'Sua sessão expirou. Por favor, faça o login novamente.'], 401);
            }

            // 3. Monta o payload para a API, como no seu AssinaturaController
            $payload = [
                "cardHash" => $request->token,
                "paymentGatewayType" => "iugu",
                "plan" => ["id" => $request->plan_id]
            ];
            $jsonPayload = json_encode($payload);

            // 4. Faz a chamada final para a API usando cURL, replicando sua lógica original
            $url = 'https://api.dentalgo.com.br/catalog/subscriptions';
            $ch = curl_init($url); 
            $authorization = "Authorization: Bearer " . $userToken;
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json' , $authorization]);
            $result = curl_exec($ch);
            curl_close($ch);

            $retorno = json_decode($result);

            // 5. Trata a resposta da API
            if (isset($retorno->status) && !isset($retorno->code)) {
                session()->forget('selected_plan_id');
                return response()->json(['success' => true, 'message' => 'Assinatura criada com sucesso!']);
            } else {
                $errorMessage = 'Seu pagamento foi recusado.';
                if (isset($retorno->additionalProperties->errors->cpf_cnpj)) {
                    $errorMessage = 'O CPF associado à sua conta é inválido.';
                } elseif (isset($retorno->message)) {
                    $errorMessage = $retorno->message;
                }
                return response()->json(['message' => $errorMessage], 400);
            }

        } catch (\Exception $e) {
            // Se um erro fatal ocorrer, ele será capturado aqui.
            return response()->json([
                'message' => 'Ocorreu um erro fatal no servidor.',
                'error_details' => $e->getMessage() . ' na linha ' . $e->getLine()
            ], 500);
        }
    }
}
