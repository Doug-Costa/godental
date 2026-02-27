<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recurrence;
use App\Models\FinancialTransaction;
use Carbon\Carbon;

class ProcessFinancialRecurrences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'financial:process-recurrences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process recurring financial transactions and generate new entries if due.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting financial recurrence processing...');

        $recurrences = Recurrence::with('transaction')
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', Carbon::now());
            })->get();

        $count = 0;

        foreach ($recurrences as $recurrence) {
            // Find last transaction generated for this recurrence
            $lastGenerated = FinancialTransaction::where('related_type', Recurrence::class)
                ->where('related_id', $recurrence->id)
                ->orderBy('date', 'desc')
                ->first();

            // Determining reference date
            if ($lastGenerated) {
                $lastDate = Carbon::parse($lastGenerated->date);
            } else {
                // Should use the original transaction date if no recurrence generated yet
                if (!$recurrence->transaction) {
                    continue; // Skip if original transaction deleted
                }
                $lastDate = Carbon::parse($recurrence->transaction->date);
            }

            // Calculate next due date
            $nextDate = $lastDate->copy();
            switch ($recurrence->frequency) {
                case 'weekly':
                    $nextDate->addWeek();
                    break;
                case 'monthly':
                    $nextDate->addMonth();
                    break;
                case 'yearly':
                    $nextDate->addYear();
                    break;
            }

            // Check if due (today or past)
            if ($nextDate->lte(Carbon::now())) {
                $this->info("Generating new transaction for recurrence ID: {$recurrence->id} - Next Date: {$nextDate->toDateString()}");

                $original = $recurrence->transaction;

                $newTransaction = $original->replicate(['id', 'created_at', 'updated_at']);
                $newTransaction->date = $nextDate;
                $newTransaction->due_date = $nextDate; // Assuming due date logic matches date
                $newTransaction->paid_at = null;
                $newTransaction->status = 'pending';

                // Link to the recurrence so we can track it next time
                $newTransaction->related_type = Recurrence::class;
                $newTransaction->related_id = $recurrence->id;

                $newTransaction->save();
                $count++;
            }
        }

        $this->info("Processing complete. Generated {$count} new recurrence transactions.");

        // Process Monthly Payroll
        $this->info('Starting monthly payroll generation...');
        $remunerationService = app(\App\Services\RemunerationService::class);
        $payrollCount = $remunerationService->generateMonthlyPayroll();
        $this->info("Payroll complete. Generated {$payrollCount} salary transactions.");

        return Command::SUCCESS;
    }
}
