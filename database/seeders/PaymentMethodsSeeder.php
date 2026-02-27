<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethod;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Standard Payment Methods
        $methods = [
            ['name' => 'Dinheiro', 'type' => 'cash'],
            ['name' => 'Pix', 'type' => 'pix'],
            ['name' => 'Cartão de Débito', 'type' => 'debit'],
            ['name' => 'Cartão de Crédito', 'type' => 'credit'],
            ['name' => 'Transferência', 'type' => 'transfer'],
            ['name' => 'Boleto', 'type' => 'slip'],
            ['name' => 'Outros', 'type' => 'other'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                ['type' => $method['type']]
            );
        }
    }
}
