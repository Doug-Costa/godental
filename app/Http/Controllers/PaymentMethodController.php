<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        return response()->json(PaymentMethod::all());
    }

    public function store(Request $request)
    {
        return redirect()->back()->with('error', 'Ação não permitida. As formas de pagamento são padronizadas.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->back()->with('error', 'Ação não permitida. As formas de pagamento são padronizadas.');
    }

    public function destroy($id)
    {
        // Optional: allow deleting custom ones if really needed, but user asked to stick to standard.
        // Let's block it for now or check if it's a standard one. 
        // Simpler to just block all as per "Retirar funcionalidade de cadastrar...".
        return redirect()->back()->with('error', 'Ação não permitida. As formas de pagamento são padronizadas.');
    }
}
