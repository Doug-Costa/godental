<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            // PHP version of change() needs doctrine/dbal in Laravel 9
            // Using raw SQL instead
        });
        
        \DB::statement('ALTER TABLE consultations MODIFY COLUMN clinical_step VARCHAR(255) DEFAULT "ENTRADA"');
    }

    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
             // In case of rollback, it's safer to leave as string than force back to a restricted enum
             // but if we must:
             // $table->enum('clinical_step', ['ENTRADA', 'ANAMNESE', 'DIAGNOSTICO', 'PROGNOSTICO', 'PLANO'])->change();
        });
    }
};
