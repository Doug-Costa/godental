<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // ─── 1. Tabela: doctors ───
        if (!Schema::hasTable('doctors')) {
            Schema::create('doctors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('specialty')->nullable();
                $table->string('crm')->nullable()->comment('CRO/CRM');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('color', 7)->default('#CA1D53')->comment('Cor no calendário');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // ─── 2. Tabela: service_prices ───
        if (!Schema::hasTable('service_prices')) {
            Schema::create('service_prices', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category')->default('Consulta');
                $table->decimal('default_price', 10, 2)->default(0.00);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // ─── 3. Tabela: doctor_schedules ───
        if (!Schema::hasTable('doctor_schedules')) {
            Schema::create('doctor_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
                $table->tinyInteger('day_of_week')->comment('0=Dom, 1=Seg...6=Sab');
                $table->time('start_time');
                $table->time('end_time');
                $table->integer('slot_duration')->default(30)->comment('Duração em minutos');
                $table->timestamps();
            });
        }

        // ─── 4. Tabela: timeline_events ───
        if (!Schema::hasTable('timeline_events')) {
            Schema::create('timeline_events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
                $table->foreignId('clinical_case_id')->nullable()->constrained('clinical_cases')->onDelete('set null');
                $table->string('event_type', 50);
                $table->text('description');
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }

        // ─── 5. Alterar: clinical_cases ───
        if (!Schema::hasColumn('clinical_cases', 'tipo_tratamento')) {
            Schema::table('clinical_cases', function (Blueprint $table) {
                $table->string('tipo_tratamento')->nullable()->after('title');
            });
        }
        if (!Schema::hasColumn('clinical_cases', 'etapa_atual')) {
            Schema::table('clinical_cases', function (Blueprint $table) {
                $table->string('etapa_atual', 30)->default('CONSULTA_INICIAL')->after('tipo_tratamento');
            });
        }
        if (!Schema::hasColumn('clinical_cases', 'data_inicio')) {
            Schema::table('clinical_cases', function (Blueprint $table) {
                $table->date('data_inicio')->nullable()->after('etapa_atual');
                $table->date('data_fim')->nullable()->after('data_inicio');
            });
        }

        // Migrar status existente
        DB::table('clinical_cases')->where('status', 'Ativo')->update(['status' => 'ATIVO']);
        DB::table('clinical_cases')->where('status', 'Encerrado')->update(['status' => 'FINALIZADO']);

        // ─── 6. Alterar: consultations ───
        if (!Schema::hasColumn('consultations', 'valor')) {
            Schema::table('consultations', function (Blueprint $table) {
                $table->decimal('valor', 10, 2)->default(0.00)->after('clinical_step');
                $table->foreignId('service_price_id')->nullable()->after('valor')
                    ->constrained('service_prices')->onDelete('set null');
            });
        }

        // ─── 7. Alterar: schedules ───
        if (!Schema::hasColumn('schedules', 'valor')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->decimal('valor', 10, 2)->default(0.00)->after('consultation_type');
                $table->foreignId('service_price_id')->nullable()->after('valor')
                    ->constrained('service_prices')->onDelete('set null');
            });
        }
        if (!Schema::hasColumn('schedules', 'doctor_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreignId('doctor_id')->nullable()->after('service_price_id')
                    ->constrained('doctors')->onDelete('set null');
            });
        }
        // Re-add clinical_case_id if the previous rollback removed it
        if (!Schema::hasColumn('schedules', 'clinical_case_id')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->foreignId('clinical_case_id')->nullable()->after('doctor_id')
                    ->constrained('clinical_cases')->onDelete('set null');
            });
        }
        if (!Schema::hasColumn('schedules', 'dentista')) {
            Schema::table('schedules', function (Blueprint $table) {
                $table->string('dentista')->nullable()->after('clinical_case_id');
            });
        }
    }

    public function down(): void
    {
        // Reverter schedules additions
        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'doctor_id')) {
                $table->dropForeign(['doctor_id']);
                $table->dropColumn('doctor_id');
            }
            if (Schema::hasColumn('schedules', 'service_price_id')) {
                $table->dropForeign(['service_price_id']);
                $table->dropColumn('service_price_id');
            }
            if (Schema::hasColumn('schedules', 'valor')) {
                $table->dropColumn('valor');
            }
        });

        Schema::table('consultations', function (Blueprint $table) {
            if (Schema::hasColumn('consultations', 'service_price_id')) {
                $table->dropForeign(['service_price_id']);
                $table->dropColumn('service_price_id');
            }
            if (Schema::hasColumn('consultations', 'valor')) {
                $table->dropColumn('valor');
            }
        });

        // Reverter clinical_cases
        DB::table('clinical_cases')->where('status', 'ATIVO')->update(['status' => 'Ativo']);
        DB::table('clinical_cases')->where('status', 'FINALIZADO')->update(['status' => 'Encerrado']);

        Schema::table('clinical_cases', function (Blueprint $table) {
            $cols = ['tipo_tratamento', 'etapa_atual', 'data_inicio', 'data_fim'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('clinical_cases', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::dropIfExists('timeline_events');
        Schema::dropIfExists('doctor_schedules');
        Schema::dropIfExists('service_prices');
        Schema::dropIfExists('doctors');
    }
};
