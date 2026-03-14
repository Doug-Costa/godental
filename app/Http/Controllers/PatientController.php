<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $query = Patient::withCount('consultations');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $patients = $query->orderBy('full_name')->paginate($perPage);

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'discovery_source' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'clinical_observations' => 'nullable|string',
        ]);

        $patient = Patient::create($validated);

        if ($request->wantsJson()) {
            return response()->json($patient, 201);
        }

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Paciente cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show($id)
    {
        $patient = Patient::with([
            'consultations' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'clinicalCases' => function ($query) {
                $query->withCount('consultations')->orderBy('opened_at', 'desc');
            },
            'clinicalCases.consultations' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'schedules' => function ($query) {
                $query->with('doctor')->orderBy('start_time', 'desc');
            },
            'documents',
            'anamneses',
            'treatmentPlans.steps',
            'treatmentPlans.procedures',
            'timelineEvents',
        ])->findOrFail($id);

        // Separate consultations without a case for the timeline
        $orphanConsultations = $patient->consultations->whereNull('clinical_case_id');

        // Dados para o modal de agendamento
        $servicePrices = \App\Models\ServicePrice::active()->orderBy('name')->get();
        $doctors = \App\Models\Doctor::active()->orderBy('name')->get();

        return view('patients.show', compact('patient', 'orphanConsultations', 'servicePrices', 'doctors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'discovery_source' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
            'clinical_observations' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Dados do paciente atualizados.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Paciente removido com sucesso.');
    }

    /**
     * API search for patients (autocomplete)
     */
    public function search(Request $request)
    {
        // Get search term from various possible parameters
        $term = trim((string) ($request->input('q', $request->input('search', $request->input('busca', $request->input('query', ''))))));

        if (empty($term)) {
            return response()->json([]);
        }

        // Expanded search following the reference of consultation search
        $patients = Patient::where(function ($query) use ($term) {
            $query->where('full_name', 'LIKE', "%{$term}%")
                ->orWhere('phone', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%")
                ->orWhere('clinical_observations', 'LIKE', "%{$term}%");
        })
            ->limit(15)
            ->get(['id', 'full_name', 'phone', 'email'])
            ->map(function ($p) {
                $p->append('is_delinquent'); // Appends the accessor value
                return $p;
            });

        return response()->json($patients);
    }

    /**
     * Check patient history for anamnesis requirements.
     */
    public function checkHistory($id)
    {
        $patient = Patient::findOrFail($id);
        
        $consultationCount = $patient->consultations()->count();
        
        // Verifica se tem anamnese completada (nova estrutura) ou qualquer registro na antiga
        $hasAnamnesis = $patient->anamnesisInstances()->where('status', 'completed')->exists() 
                     || $patient->anamneses()->exists();

        return response()->json([
            'is_new'            => ($consultationCount === 0),
            'has_anamnesis'     => $hasAnamnesis,
            'consultation_count'=> $consultationCount
        ]);
    }
}
