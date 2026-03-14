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
        Schema::create('anamnesis_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instance_id');
            $table->string('question_id'); // ID within the JSON template
            $table->string('question_text'); // Snapshot
            $table->string('answer_type'); // yes_no, text, etc.
            $table->text('answer_value')->nullable();
            $table->timestamps();

            $table->foreign('instance_id')->references('id')->on('anamnesis_instances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anamnesis_responses');
    }
};
