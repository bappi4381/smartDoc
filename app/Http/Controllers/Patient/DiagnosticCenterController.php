<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\DiagnosticCenterIndexRequest;
use App\Http\Requests\Patient\DiagnosticCenterSelectionRequest;
use App\Services\DiagnosticCenter\DiagnosticCenterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiagnosticCenterController extends Controller
{
    public function __construct(
        private readonly DiagnosticCenterService $diagnosticCenterService
    ) {
    }

    public function index(DiagnosticCenterIndexRequest $request): View
    {
        $filterData = $request->toDto();
        $centers = $this->diagnosticCenterService->listDiagnosticCenters($filterData);

        return view('patient.select-center', [
            'centers' => $centers,
            'filters' => $filterData,
        ]);
    }

    public function select(DiagnosticCenterSelectionRequest $request): RedirectResponse
    {
        try {
            $center = $this->diagnosticCenterService->getActiveDiagnosticCenter(
                $request->integer('center_id')
            );
        } catch (ModelNotFoundException) {
            return back()
                ->withErrors([
                    'center_id' => __('The selected diagnostic center is no longer available. Please choose another center.'),
                ])
                ->withInput();
        }

        session()->put('patient.selected_center_id', $center->id);
        session()->put('patient.selected_center_name', $center->name);

        return redirect()
            ->route('patient.symptoms.create')
            ->with('status', __('Diagnostic center selected. Proceed to symptom input.'));
    }
}

