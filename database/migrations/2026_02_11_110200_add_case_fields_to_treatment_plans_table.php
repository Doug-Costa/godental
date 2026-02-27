<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('clinical_case_id')->nullable()->after('patient_id');
            $table->text('description')->nullable()->after('title');
            $table->decimal('estimated_value', 10, 2)->nullable()->after('status');

            $table->foreign('clinical_case_id')->references('id')->on('clinical_cases')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('treatment_plans', function (Blueprint $table) {
            $table->dropForeign(['clinical_case_id']);
            $table->dropColumn(['clinical_case_id', 'description', 'estimated_value']);
        });
    }
};
