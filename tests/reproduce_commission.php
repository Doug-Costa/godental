<?php

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\FinancialTransaction;
use App\Services\RemunerationService;
use Illuminate\Http\Request;
use App\Http\Controllers\ClinicalCaseController;

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

function logMsg($msg)
{
    file_put_contents(__DIR__ . '/result.log', $msg . "\n", FILE_APPEND);
}

logMsg("Starting Commission Verification...");

try {
    // 1. Create a Doctor (PJ, 50% Commission)
    $doctor = Doctor::create([
        'name' => 'Dr. Verification ' . uniqid(),
        'role' => 'dentist',
        'contract_type' => 'pj',
        'remuneration_type' => 'percentage',
        'commission_percentage' => 50.00,
        'is_active' => true,
    ]);
    logMsg("Created Doctor: {$doctor->name} (50%)");

    // 2. Create a Patient
    logMsg("Creating Patient...");
    $patient = Patient::create([
        'full_name' => 'Patient Verification ' . uniqid(),
        'phone' => '11999999999',
        'email' => 'test' . uniqid() . '@example.com',
    ]);
    logMsg("Created Patient: {$patient->full_name}");

    // 3. Create a Consultation via Controller
    $service = app(RemunerationService::class);
    logMsg("Service Class: " . get_class($service));

    $controller = app(ClinicalCaseController::class);
    $request = new Request([
        'patient_id' => $patient->id,
        'consultation_type' => 'Avaliação',
        'valor' => 100.00,
        'doctor_id' => $doctor->id,
        'status' => 'pending',
    ]);

    logMsg("Creating Consultation (Value: 100.00)....");

    try {
        $response = $controller->storeConsultation($request, $service);
        $data = $response->getData(true);
    } catch (\Throwable $inner) {
        logMsg("Error inside storeConsultation: " . $inner->getMessage());
        logMsg($inner->getTraceAsString());
        exit(1);
    }

    if (!$data['success']) {
        logMsg("Failed to create consultation: " . json_encode($data));
        exit(1);
    }

    $consultationId = $data['id'];
    logMsg("Consultation Created: #{$consultationId}");

    // 4. Verify Commission Expense
    $expense = FinancialTransaction::where('type', 'expense')
        ->where('related_type', Consultation::class)
        ->where('related_id', $consultationId)
        ->first();

    if ($expense) {
        logMsg("Expense Found: {$expense->description}");
        logMsg("Amount: {$expense->amount}");

        if (abs($expense->amount - 50.00) < 0.01) {
            logMsg("SUCCESS: Commission amount is correct (50.00).");
        } else {
            logMsg("FAILURE: Commission amount is wrong. Expected 50.00, got {$expense->amount}.");
        }
    } else {
        logMsg("FAILURE: No commission expense found.");
    }

    // Clean up
    $doctor->delete();
    $patient->delete();
    // Consultation cleanup omitted

} catch (\Throwable $e) {
    logMsg("ERROR: " . $e->getMessage());
    logMsg($e->getTraceAsString());
}
