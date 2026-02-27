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
        // 1. Financial Categories
        Schema::create('financial_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['income', 'expense']);
            $table->string('color')->nullable()->default('#6c757d');
            $table->timestamps();
        });

        // 2. Suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_info')->nullable();
            $table->string('tax_id')->nullable(); // CNPJ/CPF
            $table->timestamps();
        });

        // 3. Inventory Items
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit')->default('un'); // un, box, ml, etc
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        // 4. Financial Transactions
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['income', 'expense']);
            $table->date('date');
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->enum('status', ['paid', 'pending', 'overdue'])->default('pending');

            $table->foreignId('category_id')->constrained('financial_categories');
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();

            // Polymorphic relation for linking to Consultation, ClinicalCase, TreatmentPlan
            $table->nullableMorphs('related');

            $table->timestamps();
        });

        // 5. Recurrences (for recurring expenses/income)
        Schema::create('recurrences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_transaction_id')->constrained()->onDelete('cascade');
            $table->enum('frequency', ['weekly', 'monthly', 'yearly']);
            $table->date('end_date')->nullable(); // Null means infinite
            $table->timestamps();
        });

        // 6. Procedure Materials (Bill of Materials)
        Schema::create('procedure_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_price_id')->constrained('service_prices')->onDelete('cascade');
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->onDelete('cascade');
            $table->decimal('quantity_used', 8, 2)->default(1);
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
        Schema::dropIfExists('procedure_materials');
        Schema::dropIfExists('recurrences');
        Schema::dropIfExists('financial_transactions');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('financial_categories');
    }
};
