<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\FinancialTransaction;
use App\Models\FinancialCategory;
use Illuminate\Database\Eloquent\Model;

class RemunerationService
{
    /**
     * Calculate and create a commission transaction for a professional.
     *
     * @param Doctor $doctor
     * @param float $amount The base amount (procedure/consultation value)
     * @param string $description
     * @param Model|null $relatedModel Linked model (Consultation/TreatmentPlan)
     * @return FinancialTransaction|null
     */
    public function calculateCommission(Doctor $doctor, float $amount, string $description, ?Model $relatedModel = null)
    {
        // Only calculate if doctor is PJ and has commission logic
        if ($doctor->contract_type !== 'pj') {
            return null;
        }

        if ($doctor->remuneration_type === 'fixed') {
            return null; // Fixed PJ doesnt get per-procedure commission usually, or maybe they do? Assuming not for now.
        }

        $percentage = $doctor->commission_percentage ?? 0;

        if ($percentage <= 0) {
            return null;
        }

        $commissionValue = ($amount * $percentage) / 100;

        if ($commissionValue <= 0) {
            return null;
        }

        // Find or Create 'Comissões' Category
        $category = FinancialCategory::firstOrCreate(
            ['name' => 'Comissões'],
            ['type' => 'expense', 'color' => '#ffc107']
        );

        return FinancialTransaction::create([
            'description' => "Comissão: {$description} ({$percentage}%)",
            'amount' => $commissionValue,
            'type' => 'expense',
            'date' => now(),
            'due_date' => now()->addDays(30), // Default 30 days or next payroll date
            'status' => 'pending',
            'category_id' => $category->id,
            'supplier_id' => null, // Could link to a supplier record if doctor is a supplier? For now, no.
            'related_type' => $relatedModel ? get_class($relatedModel) : null,
            'related_id' => $relatedModel ? $relatedModel->id : null,
        ]);
    }

    /**
     * Generate monthly payroll expenses for CLT/Fixed professionals.
     * 
     * @return int Number of transactions created
     */
    public function generateMonthlyPayroll()
    {
        $doctors = Doctor::where('fixed_salary', '>', 0)
            ->whereIn('contract_type', ['clt', 'pj']) // PJ can also have fixed salary
            ->whereIn('remuneration_type', ['fixed', 'mixed'])
            ->get();

        $count = 0;
        $category = FinancialCategory::firstOrCreate(
            ['name' => 'Salários'],
            ['type' => 'expense', 'color' => '#dc3545']
        );

        foreach ($doctors as $doctor) {
            // Check if already generated for this month
            $exists = FinancialTransaction::where('category_id', $category->id)
                ->where('description', 'LIKE', "Salário " . now()->format('F/Y') . " - {$doctor->name}%")
                ->exists();

            if ($exists) {
                continue;
            }

            FinancialTransaction::create([
                'description' => "Salário " . now()->format('F/Y') . " - {$doctor->name}",
                'amount' => $doctor->fixed_salary,
                'type' => 'expense',
                'date' => now(),
                'due_date' => now()->addDays(5), // 5th working day logic could be complex, simplifying to +5 days or similar
                'status' => 'pending',
                'category_id' => $category->id,
            ]);

            $count++;
        }

        return $count;
    }
}
