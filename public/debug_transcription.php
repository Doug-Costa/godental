<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Consultation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

$id = 13;
$consultation = Consultation::find($id);

if (!$consultation) {
    die("Consultation $id not found\n");
}

$apiUrl = env('WHISPER_API_URL', 'http://127.0.0.1:9001/transcribe');
$audioFile = public_path($consultation->audio_path);

echo "Testing transcription for ID: $id\n";
echo "File: $audioFile\n";
echo "API URL: $apiUrl\n";

if (!file_exists($audioFile)) {
    die("Audio file does not exist!\n");
}

try {
    $response = Http::timeout(300)->attach(
        'file',
        file_get_contents($audioFile),
        basename($audioFile)
    )->post($apiUrl);

    echo "Status: " . $response->status() . "\n";
    echo "Body: " . $response->body() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
