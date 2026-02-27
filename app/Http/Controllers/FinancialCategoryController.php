<?php

namespace App\Http\Controllers;

use App\Models\FinancialCategory;
use Illuminate\Http\Request;

class FinancialCategoryController extends Controller
{
    public function index()
    {
        return FinancialCategory::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        FinancialCategory::create($validated);

        return redirect()->back()->with('success', 'Categoria criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $category = FinancialCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = FinancialCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Categoria excluída com sucesso!');
    }
}
