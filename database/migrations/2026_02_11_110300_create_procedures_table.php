<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('treatment_plan_id');
            $table->string('name');
            $table->string('region')->nullable();
            $table->string('status')->default('Pendente'); // Pendente, EmAndamento, Concluido
            $table->date('expected_date')->nullable();
            $table->timestamps();

            $table->foreign('treatment_plan_id')->references('id')->on('treatment_plans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('procedures');
    }
};
