<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GoIntelligenceController extends Controller
{
    /**
     * Display the Go Intelligence chatbot view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get API URL and Key from env
        $apiUrl = env('GOINTELLIGENCE_API_URL', 'http://host.docker.internal:8001');
        $apiKey = env('GOINTELLIGENCE_API_KEY', 'test_key_123'); // API key for Dentino RAG

        // Em produção, isso virgaria do auth()->user()
        $user = session()->get('user') ?? [
            'name' => 'Dr. Convidado',
            'email' => '',
            'specialty' => 'Odontologia'
        ];

        return view('gointelligence.index', compact('apiUrl', 'apiKey', 'user'));
    }

    /**
     * Proxy request to Go Intelligence API.
     */
    public function proxy(Request $request)
    {
        try {
            $apiUrl = env('GOINTELLIGENCE_API_URL', 'http://host.docker.internal:8001');
            $apiKey = env('GOINTELLIGENCE_API_KEY', 'test_key_123');
            $message = $request->input('message');

            $response = Http::timeout(260)
                ->withHeaders(['X-API-Key' => $apiKey])
                ->asForm()
                ->post(rtrim($apiUrl, '/') . '/chat/message', [
                    'message' => $message
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            Log::error('Go Intelligence Proxy Error: ' . $response->body());
            return response()->json([
                'response' => 'Erro ao processar sua solicitação com a inteligência.',
                'error' => true
            ], 500);

        } catch (\Exception $e) {
            Log::error('Go Intelligence Proxy Exception: ' . $e->getMessage());
            return response()->json([
                'response' => 'Erro interno ao processar a requisição.',
                'error' => true
            ], 500);
        }
    }
}
