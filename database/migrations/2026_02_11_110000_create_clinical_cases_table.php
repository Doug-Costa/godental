<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('clinical_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('title');
            $table->enum('status', ['Ativo', 'Encerrado'])->default('Ativo');
            $table->date('opened_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clinical_cases');
    }
};
