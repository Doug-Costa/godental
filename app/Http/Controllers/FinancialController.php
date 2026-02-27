<?php

namespace App\Http\Controllers;

use App\Models\FinancialCategory;
use App\Models\FinancialTransaction;
use App\Models\Supplier;
use App\Models\Patient;
use App\Models\BankAccount;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller
{
    /**
     * Display the financial dashboard and transaction list.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query Transactions
        $query = FinancialTransaction::with(['category', 'supplier', 'patient'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'delinquent') {
                $query->where('type', 'income')
                    ->where(function ($q) {
                        $q->where('status', 'overdue')
                            ->orWhere(function ($q2) {
                                $q2->where('status', 'pending')
                                    ->where('due_date', '<', now()->format('Y-m-d'));
                            });
                    });
            } else {
                $query->where('status', $request->status);
            }
        }

        $transactions = $query->paginate(20);

        // Calculate Totals (for the filtered period)
        $totals = [
            'income' => FinancialTransaction::whereBetween('date', [$startDate, $endDate])
                ->where('type', 'income')->sum('amount'),
            'expense' => FinancialTransaction::whereBetween('date', [$startDate, $endDate])
                ->where('type', 'expense')->sum('amount'),
            'pending_income' => FinancialTransaction::whereBetween('date', [$startDate, $endDate])
                ->where('type', 'income')->where('status', 'pending')->sum('amount'),
            'pending_expense' => FinancialTransaction::whereBetween('date', [$startDate, $endDate])
                ->where('type', 'expense')->where('status', 'pending')->sum('amount'),
        ];

        $totals['balance'] = $totals['income'] - $totals['expense'];

        // Load auxiliary data for forms
        $categories = FinancialCategory::all();
        $suppliers = Supplier::all();
        $bankAccounts = BankAccount::all();
        $paymentMethods = PaymentMethod::all();

        return view('financial.index', compact('transactions', 'totals', 'categories', 'suppliers', 'bankAccounts', 'paymentMethods', 'startDate', 'endDate'));
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,pending,overdue',
            'category_id' => 'required|exists:financial_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'patient_id' => 'nullable|exists:patients,id',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'recurrence_frequency' => 'nullable|in:weekly,monthly,yearly', // If set, create recurrence
        ]);

        DB::transaction(function () use ($validated, $request) {
            $validated['paid_at'] = $validated['status'] === 'paid' ? ($request->filled('paid_at') ? $request->paid_at : Carbon::now()) : null;

            $transaction = FinancialTransaction::create($validated);

            // Handle Recurrence
            if ($request->filled('recurrence_frequency')) {
                $transaction->recurrence()->create([
                    'frequency' => $request->input('recurrence_frequency'),
                    'end_date' => $request->input('recurrence_end_date'),
                ]);

                // Logic to generate future transactions immediately? 
                // Usually better to have a command. For now, we just mark it as recurring.
            }
        });

        return redirect()->route('financial.index')
            ->with('success', 'Movimentação registrada com sucesso.');
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, $id)
    {
        $transaction = FinancialTransaction::findOrFail($id);

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,pending,overdue',
            'category_id' => 'required|exists:financial_categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'patient_id' => 'nullable|exists:patients,id',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
        ]);

        if ($validated['status'] === 'paid' && $transaction->status !== 'paid') {
            $validated['paid_at'] = Carbon::now();
        } elseif ($validated['status'] !== 'paid') {
            $validated['paid_at'] = null;
        }

        $transaction->update($validated);

        return redirect()->back()->with('success', 'Movimentação atualizada.');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy($id)
    {
        FinancialTransaction::findOrFail($id)->delete();
        return redirect()->route('financial.index')->with('success', 'Movimentação removida.');
    }

    /**
     * Store a new category via AJAX or common form.
     */
    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required', 'type' => 'required']);
        FinancialCategory::create($request->all());
        return redirect()->back()->with('success', 'Categoria criada.');
    }

    /**
     * Store a new supplier via AJAX or common form.
     */
    public function storeSupplier(Request $request)
    {
        $request->validate(['name' => 'required']);
        Supplier::create($request->all());
        return redirect()->back()->with('success', 'Fornecedor cadastrado.');
    }

    /**
     * Confirm a payment (mark as paid).
     */
    public function confirmPayment(Request $request, $id)
    {
        $transaction = FinancialTransaction::findOrFail($id);

        $validated = $request->validate([
            'payment_date' => 'required|date',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
        ]);

        $transaction->update([
            'status' => 'paid',
            'paid_at' => $validated['payment_date'],
            'bank_account_id' => $validated['bank_account_id'],
            'payment_method_id' => $validated['payment_method_id'],
        ]);

        return redirect()->back()->with('success', 'Pagamento confirmado.');
    }
}
