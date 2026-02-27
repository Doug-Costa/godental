<?php

namespace App\Http\Controllers;

use App\Services\RemunerationService;
use Illuminate\Http\Request;

class RemunerationController extends Controller
{
    protected $remunerationService;

    public function __construct(RemunerationService $remunerationService)
    {
        $this->remunerationService = $remunerationService;
    }

    public function generatePayroll()
    {
        $count = $this->remunerationService->generateMonthlyPayroll();
        return redirect()->back()->with('success', "Folha de pagamento gerada! {$count} lançamentos criados.");
    }
}
