<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\AnamnesisTemplate;

echo "Starting manual schema creation...\n";

try {
    // 1. anamneses
    if (!Schema::hasTable('anamneses')) {
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->json('data');
            $table->integer('version')->default(1);
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
        echo "Created 'anamneses' table.\n";
    }

    // 2. anamnesis_templates
    if (!Schema::hasTable('anamnesis_templates')) {
        Schema::create('anamnesis_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->json('questions'); 
            $table->timestamps();
        });
        echo "Created 'anamnesis_templates' table.\n";
    }

    // 3. anamnesis_instances
    if (!Schema::hasTable('anamnesis_instances')) {
        Schema::create('anamnesis_instances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('template_id');
            $table->string('token', 64)->unique()->index();
            $table->enum('status', ['pending', 'completed', 'expired'])->default('pending');
            $table->timestamp('expires_at')->nullable(); // Made nullable for compatibility
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('anamnesis_templates')->onDelete('cascade');
        });
        echo "Created 'anamnesis_instances' table.\n";
    }

    // 4. anamnesis_responses
    if (!Schema::hasTable('anamnesis_responses')) {
        Schema::create('anamnesis_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instance_id');
            $table->string('question_id');
            $table->string('question_text');
            $table->string('answer_type');
            $table->text('answer_value')->nullable();
            $table->timestamps();

            $table->foreign('instance_id')->references('id')->on('anamnesis_instances')->onDelete('cascade');
        });
        echo "Created 'anamnesis_responses' table.\n";
    }

    // 5. consultations column
    Schema::table('consultations', function (Blueprint $table) {
        if (!Schema::hasColumn('consultations', 'requires_anamnesis')) {
            $table->boolean('requires_anamnesis')->default(false)->after('status');
            echo "Added 'requires_anamnesis' column to 'consultations'.\n";
        }
    });

    // 6. Seeding default template
    if (AnamnesisTemplate::count() == 0) {
        AnamnesisTemplate::create([
            'name' => 'Ficha de Anamnese Geral',
            'description' => 'Modelo padrão para novas consultas.',
            'is_default' => true,
            'is_active' => true,
            'questions' => [
                ['id' => 'q1', 'text' => 'Possui alguma alergia?', 'type' => 'yes_no'],
                ['id' => 'q2', 'text' => 'Está tomando algum medicamento?', 'type' => 'yes_no'],
                ['id' => 'q3', 'text' => 'Já passou por cirurgia?', 'type' => 'text']
            ]
        ]);
        echo "Seeded default Anamnesis template.\n";
    }

    echo "Manual update completed successfully!\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
