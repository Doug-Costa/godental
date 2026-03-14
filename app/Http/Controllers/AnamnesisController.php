<?php

namespace App\Http\Controllers;

use App\Models\AnamnesisInstance;
use App\Models\AnamnesisResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnamnesisController extends Controller
{
    public function show($token)
    {
        $instance = AnamnesisInstance::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->with(['template', 'patient'])
            ->firstOrFail();

        return view('anamnesis.form', compact('instance'));
    }

    public function store(Request $request, $token)
    {
        $instance = AnamnesisInstance::where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $answers = $request->input('answers', []);

        foreach ($instance->template->questions as $question) {
            $qId = $question['id'];
            $answer = $answers[$qId] ?? null;

            // Handle multiple choice (array) answers
            if (is_array($answer)) {
                $answer = implode(', ', $answer);
            }

            AnamnesisResponse::create([
                'instance_id' => $instance->id,
                'question_id' => $qId,
                'question_text' => $question['text'],
                'answer_type' => $question['type'],
                'answer_value' => $answer,
            ]);
        }

        $instance->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return view('anamnesis.success');
    }

    public function checkStatus($id)
    {
        $instance = AnamnesisInstance::findOrFail($id);
        return response()->json([
            'status' => $instance->status,
            'completed_at' => $instance->completed_at ? $instance->completed_at->toDateTimeString() : null,
        ]);
    }
}
