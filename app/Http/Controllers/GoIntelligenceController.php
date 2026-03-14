<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
}
