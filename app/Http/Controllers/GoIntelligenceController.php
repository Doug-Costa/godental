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
     * Proxy streaming request to Go Intelligence API.
     */
    public function proxy(Request $request)
    {
        $apiUrl = env('GOINTELLIGENCE_API_URL', 'http://host.docker.internal:8001');
        $apiKey = env('GOINTELLIGENCE_API_KEY', 'test_key_123');
        $message = $request->input('message');

        // endpoint de streaming sugerido pelo usuário
        $url = rtrim($apiUrl, '/') . '/query/stream';

        return new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($url, $apiKey, $message) {
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['message' => $message]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'X-API-Key: ' . $apiKey,
                'Content-Type: application/x-www-form-urlencoded',
            ]);
            
            // Timeout de conexão e total
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);
            
            // Função para repassar os chunks assim que chegarem
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
                echo $data;
                if (ob_get_level() > 0) ob_flush();
                flush();
                return strlen($data);
            });

            curl_exec($ch);
            
            if (curl_errno($ch)) {
                Log::error('Go Intelligence Streaming Proxy Error: ' . curl_error($ch));
                echo json_encode(['error' => true, 'response' => 'Erro na conexão de streaming: ' . curl_error($ch)]);
            }
            
            curl_close($ch);
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // Importante para Nginx
        ]);
    }
}
