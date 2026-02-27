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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('role')->default('dentist'); // dentist, collaborator
            $table->string('contract_type')->nullable(); // clt, pj
            $table->string('remuneration_type')->nullable(); // fixed, percentage, mixed
            $table->decimal('fixed_salary', 10, 2)->nullable();
            $table->decimal('commission_percentage', 5, 2)->nullable();
            $table->string('pix_key')->nullable();
            $table->text('bank_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'contract_type',
                'remuneration_type',
                'fixed_salary',
                'commission_percentage',
                'pix_key',
                'bank_details'
            ]);
        });
    }
};
