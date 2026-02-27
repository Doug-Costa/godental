<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        // Typically returns a view or JSON. 
        // For now, let's assume it might return JSON for AJAX or be part of a settings page.
        return response()->json(BankAccount::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency' => 'nullable|string|max:20',
            'account_number' => 'nullable|string|max:50',
            'account_type' => 'required|string|in:checking,savings,other',
            'description' => 'required|string|max:255',
            'initial_balance' => 'nullable|numeric',
        ]);

        BankAccount::create($validated);

        return redirect()->back()->with('success', 'Conta bancária cadastrada com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $account = BankAccount::findOrFail($id);

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'agency' => 'nullable|string|max:20',
            'account_number' => 'nullable|string|max:50',
            'account_type' => 'required|string|in:checking,savings,other',
            'description' => 'required|string|max:255',
            'initial_balance' => 'nullable|numeric',
        ]);

        $account->update($validated);

        return redirect()->back()->with('success', 'Conta bancária atualizada.');
    }

    public function destroy($id)
    {
        BankAccount::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Conta bancária removida.');
    }
}
