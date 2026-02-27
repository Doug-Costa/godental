<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\ServicePrice;
use App\Models\DoctorSchedule;
use App\Models\BankAccount;
use App\Models\Supplier;
use App\Models\FinancialCategory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Painel principal da Administração
     */
    public function index()
    {
        $doctors = Doctor::with('scheduleSlots')->orderBy('name')->get();
        $servicePrices = ServicePrice::with('materials')->orderBy('category')->orderBy('name')->get();
        $doctorSchedules = DoctorSchedule::with('doctor')->orderBy('doctor_id')->orderBy('day_of_week')->get();
        $inventoryItems = \App\Models\InventoryItem::with('supplier')->orderBy('name')->get();

        // New Administrative Data
        $bankAccounts = BankAccount::all();
        $suppliers = Supplier::all();
        $financialCategories = FinancialCategory::all();

        return view('admin.index', compact(
            'doctors',
            'servicePrices',
            'doctorSchedules',
            'inventoryItems',
            'bankAccounts',
            'suppliers',
            'financialCategories'
        ));
    }

    // ─── DOCTORS/COLLABORATORS CRUD ───

    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'crm' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'color' => 'nullable|string|max:7',

            // Remuneration & Contract
            'role' => 'nullable|in:dentist,collaborator',
            'contract_type' => 'nullable|in:clt,pj',
            'remuneration_type' => 'nullable|in:fixed,percentage,mixed',
            'fixed_salary' => 'nullable|numeric',
            'commission_percentage' => 'nullable|numeric',
            'pix_key' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
        ]);

        $doctor = Doctor::create($validated);

        return response()->json(['success' => true, 'doctor' => $doctor]);
    }

    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'crm' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'color' => 'nullable|string|max:7',
            'is_active' => 'sometimes|boolean',

            // Remuneration & Contract
            'role' => 'nullable|in:dentist,collaborator',
            'contract_type' => 'nullable|in:clt,pj',
            'remuneration_type' => 'nullable|in:fixed,percentage,mixed',
            'fixed_salary' => 'nullable|numeric',
            'commission_percentage' => 'nullable|numeric',
            'pix_key' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
        ]);

        $doctor->update($validated);

        return response()->json(['success' => true, 'doctor' => $doctor]);
    }

    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return response()->json(['success' => true]);
    }

    // ─── SERVICE PRICES CRUD ───

    public function storeServicePrice(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Consulta,Procedimento,Retorno',
            'default_price' => 'required|numeric|min:0',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:inventory_items,id',
            'materials.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $price = ServicePrice::create($validated);

        if (!empty($validated['materials'])) {
            $syncData = [];
            foreach ($validated['materials'] as $mat) {
                $syncData[$mat['id']] = ['quantity_used' => $mat['quantity']];
            }
            $price->materials()->sync($syncData);
        }

        return response()->json(['success' => true, 'price' => $price->load('materials')]);
    }

    public function updateServicePrice(Request $request, $id)
    {
        $price = ServicePrice::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Consulta,Procedimento,Retorno',
            'default_price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:inventory_items,id',
            'materials.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $price->update($validated);

        if (isset($validated['materials'])) {
            $syncData = [];
            foreach ($validated['materials'] as $mat) {
                $syncData[$mat['id']] = ['quantity_used' => $mat['quantity']];
            }
            $price->materials()->sync($syncData);
        }

        return response()->json(['success' => true, 'price' => $price->load('materials')]);
    }

    public function deleteServicePrice($id)
    {
        $price = ServicePrice::findOrFail($id);
        $price->delete();

        return response()->json(['success' => true]);
    }

    // ─── DOCTOR SCHEDULES CRUD ───

    public function storeDoctorSchedule(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'nullable|integer|min:10|max:120',
        ]);

        $validated['slot_duration'] = $validated['slot_duration'] ?? 30;
        $schedule = DoctorSchedule::create($validated);

        return response()->json(['success' => true, 'schedule' => $schedule->load('doctor')]);
    }

    public function updateDoctorSchedule(Request $request, $id)
    {
        $schedule = DoctorSchedule::findOrFail($id);

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'nullable|integer|min:10|max:120',
        ]);

        $schedule->update($validated);

        return response()->json(['success' => true, 'schedule' => $schedule->load('doctor')]);
    }

    public function deleteDoctorSchedule($id)
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['success' => true]);
    }
}
