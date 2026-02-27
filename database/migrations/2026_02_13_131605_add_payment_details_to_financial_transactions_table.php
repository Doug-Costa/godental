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
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->foreignId('bank_account_id')->nullable()->constrained('bank_accounts')->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_transactions', function (Blueprint $table) {
            $table->dropForeign(['bank_account_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn(['bank_account_id', 'payment_method_id']);
        });
    }
};
