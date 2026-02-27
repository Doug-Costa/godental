<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_identifier')->nullable();
            $table->string('consultation_type')->nullable();
            $table->text('observations')->nullable();
            $table->string('audio_path')->nullable();
            $table->longText('transcription')->nullable();
            $table->string('status')->default('pending'); // pending, recorded, transcribed, analyzed
            $table->integer('user_id')->nullable(); // doctor id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};
