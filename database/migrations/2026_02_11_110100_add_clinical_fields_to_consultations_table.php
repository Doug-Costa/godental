<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->unsignedBigInteger('clinical_case_id')->nullable()->after('patient_id');
            $table->enum('clinical_step', ['ENTRADA', 'ANAMNESE', 'DIAGNOSTICO', 'PROGNOSTICO', 'PLANO'])
                ->default('ENTRADA')->after('consultation_type');
            $table->longText('ai_summary')->nullable()->after('transcription');
            $table->longText('diagnosis')->nullable()->after('ai_summary');
            $table->longText('prognosis')->nullable()->after('diagnosis');
            $table->longText('suggested_plan')->nullable()->after('prognosis');

            $table->foreign('clinical_case_id')->references('id')->on('clinical_cases')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['clinical_case_id']);
            $table->dropColumn([
                'clinical_case_id',
                'clinical_step',
                'ai_summary',
                'diagnosis',
                'prognosis',
                'suggested_plan'
            ]);
        });
    }
};
