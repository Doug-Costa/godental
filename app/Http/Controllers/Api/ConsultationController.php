<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

            // For now, we simulate transcription directly or via a simple job
            $this->mockTranscription($consultation);

            return response()->json([
                'success' => true,
                'message' => 'Áudio enviado com sucesso e processamento iniciado.',
                'path' => $path
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading audio: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar áudio.'
            ], 500);
        }
    }

    /**
     * Mock transcription logic.
     */
    private function mockTranscription($consultation)
    {
        // Simulate background processing delay and mock text
        $mockText = "Transcrição automática da consulta de " . $consultation->patient_name . ".\n\nObservações clínicas do GoTalks: O paciente apresenta quadro estável, com orientações passadas durante a sessão. Recomendado acompanhamento em 30 dias.";

        $consultation->update([
            'transcription' => $mockText,
            'status' => 'transcribed'
        ]);
    }
}
