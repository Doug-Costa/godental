<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Consultation;

$fixes = [
    12 => ['audio_path' => 'consultas/consulta_2026-03-11_17-57-45.webm', 'status' => 'transcribed', 'transcription' => 'Áudio processado (Nenhuma voz detectada no Whisper).'],
    13 => ['audio_path' => 'consultas/consulta_2026-03-11_18-11-44.webm', 'status' => 'transcribed', 'transcription' => 'Áudio processado (Nenhuma voz detectada no Whisper).'],
];

foreach ($fixes as $id => $data) {
    $c = Consultation::find($id);
    if ($c) {
        $c->update($data);
        echo "Updated consultation $id\n";
    } else {
        echo "Consultation $id not found\n";
    }
}
