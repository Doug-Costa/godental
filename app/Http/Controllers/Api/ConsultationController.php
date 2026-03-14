<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ConsultationController extends Controller
{
    /**
     * Store a newly created consultation in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'nullable|exists:patients,id',
                'patient_name' => 'required|string|max:255',
                'patient_identifier' => 'nullable|string|max:255',
                'consultation_type' => 'nullable|string|max:255',
                'observations' => 'nullable|string',
            ]);

            $consultation = Consultation::create([
                'patient_id' => $request->patient_id,
                'patient_name' => $request->patient_name,
                'patient_identifier' => $request->patient_identifier,
                'consultation_type' => $request->consultation_type,
                'observations' => $request->observations,
                'user_id' => session()->has('usuario') ? (is_array(session()->get('usuario')) ? session()->get('usuario')['id'] : (isset(session()->get('usuario')->id) ? session()->get('usuario')->id : null)) : null,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'data' => $consultation
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating consultation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar consulta.'
            ], 500);
        }
    }

    /**
     * Upload and handle audio for a consultation.
     */
    public function uploadAudio(Request $request, $id)
    {
        set_time_limit(300);
        try {
            $consultation = Consultation::findOrFail($id);

            if (!$request->hasFile('audio')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum arquivo de áudio enviado.'
                ], 400);
            }

            $file = $request->file('audio');
            $filename = 'consultation_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('consultations/audio', $filename, 'public');

            $consultation->update([
                'audio_path' => $path,
                'status' => 'recorded'
            ]);

            $responseData = [
                'success' => true,
                'message' => 'Áudio enviado com sucesso. Processamento iniciado em segundo plano.',
                'path' => $path
            ];

            if (function_exists('fastcgi_finish_request')) {
                echo json_encode($responseData);
                header('Content-Type: application/json');
                header('Content-Length: ' . strlen(json_encode($responseData)));
                header('Connection: close');
                fastcgi_finish_request();

                // Process transcription via Whisper service in background
                $this->processTranscription($consultation);
                return;
            }

            // Sync fallback
            $this->processTranscription($consultation);
            return response()->json($responseData);
        } catch (\Exception $e) {
            Log::error('Error uploading audio: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar áudio.'
            ], 500);
        }
    }

    /**
     * Process transcription via Whisper service.
     */
    private function processTranscription($consultation)
    {
        set_time_limit(0); // Prevents PHP from killing this process due to max_execution_time
        try {
            $apiUrl = env('WHISPER_API_URL', 'http://host.docker.internal:9001/transcribe');
            $audioPath = storage_path('app/public/' . $consultation->audio_path);

            if (!file_exists($audioPath)) {
                Log::error("Audio file not found for transcription: {$audioPath}");
                return;
            }

            Log::info("Starting Whisper transcription for consultation {$consultation->id}");

            $response = Http::timeout(300) // Whisper can take a while
                ->attach('file', file_get_contents($audioPath), basename($audioPath))
                ->post($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                $transcription = $data['text'] ?? '';

                $consultation->update([
                    'transcription' => $transcription,
                    'status' => 'transcribed'
                ]);

                Log::info("Transcription completed for consultation {$consultation->id}. Forwarding to Go Intelligence...");

                // Call Go Intelligence for clinical processing
                $this->forwardToGoIntelligence($consultation, $transcription);

            } else {
                Log::error("Whisper API error: " . $response->body());
                $consultation->update(['status' => 'failed']);
            }
        } catch (\Exception $e) {
            Log::error('Error processing transcription: ' . $e->getMessage());
            $consultation->update(['status' => 'failed']);
        }
    }

    /**
     * Forward transcription to Go Intelligence for clinical analysis.
     */
    private function forwardToGoIntelligence($consultation, $transcription)
    {
        try {
            $goIntelligenceUrl = env('GOINTELLIGENCE_API_URL', 'http://host.docker.internal:8001');
            $endpoint = rtrim($goIntelligenceUrl, '/') . '/clinic/transcription';
            $apiKey = env('GOINTELLIGENCE_API_KEY', 'test_key_123');

            $response = Http::timeout(260)
                ->withHeaders(['X-API-Key' => $apiKey])
                ->post($endpoint, [
                    'transcription' => $transcription,
                    'consultation_id' => $consultation->id
                ]);

            if ($response->successful()) {
                $aiData = $response->json();
                $answer = $aiData['answer'] ?? '';
                
                // Tentar extrair JSON de blocos markdown
                $jsonData = [];
                if (preg_match('/```json\s*(.*?)\s*```/s', $answer, $matches)) {
                    $jsonData = json_decode($matches[1], true) ?? [];
                } elseif (str_starts_with(trim($answer), '{')) {
                    $jsonData = json_decode($answer, true) ?? [];
                }

                // Mapping using data_get() for resilience
                
                // --- 1. Resumo (ai_summary) ---
                $summary = data_get($jsonData, 'transcricao.resumo_clinico') ?? 
                           data_get($jsonData, 'anamnese.historia_atual') ?? 
                           data_get($jsonData, 'anamnese.historia_doenca_atual') ??
                           data_get($aiData, 'summary') ?? 
                           "Processado.";

                // --- 2. Diagnóstico ---
                $diagnosis = data_get($jsonData, 'diagnostico.hipotese_principal');
                $secondary = (array) data_get($jsonData, 'diagnostico.hipoteses_secundarias', []);
                if (!empty($secondary)) {
                    $diagnosis .= "\nHipóteses Secundárias:\n" . implode("\n", $secondary);
                }
                $diagnosis = $diagnosis ?? data_get($aiData, 'diagnosis');

                // --- 3. Prognóstico ---
                $prognosis = data_get($jsonData, 'prognostico.classificacao');
                $justification = data_get($jsonData, 'prognostico.justificativa');
                if ($justification) {
                    $prognosis = $prognosis ? $prognosis . "\n" . $justification : $justification;
                }
                $prognosis = $prognosis ?? data_get($aiData, 'prognosis');

                // --- 4. Plano de Tratamento ---
                $immediate = (array) data_get($jsonData, 'plano.tratamento_imediato', []);
                $elective = (array) data_get($jsonData, 'plano.tratamento_eletivo', []);
                $plan = implode("\n", array_merge($immediate, $elective));
                if (empty($plan)) {
                    $plan = data_get($aiData, 'suggested_plan') ?? data_get($aiData, 'plan');
                }

                // --- 5. Próximos Passos ---
                $nextSteps = data_get($jsonData, 'insights.proximos_passos');

                $consultation->update([
                    'ai_summary' => $summary,
                    'diagnosis' => $diagnosis,
                    'prognosis' => $prognosis,
                    'suggested_plan' => $plan,
                    'next_steps' => $nextSteps,
                    'status' => 'completed'
                ]);

                Log::info("Go Intelligence processing completed for consultation {$consultation->id}");
                Log::debug("Parsed AI Data for #{$consultation->id}:", [
                    'ai_summary' => substr($summary, 0, 100) . '...',
                    'diagnosis' => $diagnosis,
                    'prognosis' => $prognosis,
                    'plan' => substr($plan, 0, 100) . '...'
                ]);
            } else {
                Log::error("Go Intelligence API error: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error forwarding to Go Intelligence: ' . $e->getMessage());
        }
    }
}
