<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('clinical_case_id')->nullable()->after('patient_id');
            $table->string('dentista')->nullable()->after('consultation_type');

            $table->foreign('clinical_case_id')->references('id')->on('clinical_cases')->onDelete('set null');

            $table->index('start_time');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['clinical_case_id']);
            $table->dropIndex(['start_time']);
            $table->dropIndex(['status']);
            $table->dropColumn(['clinical_case_id', 'dentista']);
        });
    }
};
