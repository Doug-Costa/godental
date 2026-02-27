<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Supplier;
use App\Models\FinancialTransaction;
use App\Models\FinancialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display the inventory list.
     */
    public function index()
    {
        $items = InventoryItem::with('supplier')->orderBy('name')->paginate(20);
        $suppliers = Supplier::all();
        $financialCategories = FinancialCategory::where('type', 'expense')->get();

        return view('inventory.index', compact('items', 'suppliers', 'financialCategories'));
    }

    /**
     * Store a new inventory item.
     */
    /**
     * Store a new inventory item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:10',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'current_stock' => 'integer|min:0',
            'min_stock' => 'integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $item = InventoryItem::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'item' => $item->load('supplier')]);
        }
        return redirect()->route('inventory.index')->with('success', 'Item cadastrado com sucesso.');
    }

    /**
     * Update an inventory item.
     */
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:10',
            'cost_price' => 'numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'min_stock' => 'integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $item->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'item' => $item->load('supplier')]);
        }
        return redirect()->back()->with('success', 'Item atualizado.');
    }

    /**
     * Destroy an inventory item.
     */
    public function destroy(Request $request, $id)
    {
        InventoryItem::findOrFail($id)->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('inventory.index')->with('success', 'Item removido.');
    }

    /**
     * Add stock to an item (Purchase).
     * Optionally creates a financial expense.
     */
    public function stockEntry(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'nullable|numeric|min:0', // Allows updating cost price
            'create_expense' => 'boolean',
            'expense_description' => 'required_if:create_expense,1',
            'expense_category_id' => 'required_if:create_expense,1',
        ]);

        DB::transaction(function () use ($item, $validated) {
            // Update stock
            $item->current_stock += $validated['quantity'];

            // Update cost price if provided
            if (!empty($validated['cost_price'])) {
                $item->cost_price = $validated['cost_price'];
            }

            $item->save();

            // Create Financial Transaction
            if (!empty($validated['create_expense']) && $validated['create_expense']) {
                $amount = ($validated['cost_price'] ?? $item->cost_price) * $validated['quantity'];

                FinancialTransaction::create([
                    'description' => $validated['expense_description'],
                    'amount' => $amount,
                    'type' => 'expense',
                    'date' => now(),
                    'due_date' => now(),
                    'status' => 'paid', // Assuming stock purchase is immediate or credit. For now 'paid'.
                    'paid_at' => now(),
                    'category_id' => $validated['expense_category_id'],
                    'supplier_id' => $item->supplier_id,
                    'related_type' => InventoryItem::class,
                    'related_id' => $item->id,
                ]);
            }
        });

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'item' => $item->fresh()]);
        }
        return redirect()->back()->with('success', 'Entrada de estoque realizada.');
    }
}
