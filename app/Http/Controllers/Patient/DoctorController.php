<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\DoctorDiscoveryFilterRequest;
use App\Services\Patient\DoctorDiscoveryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DoctorController extends Controller
{
    public function __construct(
        private readonly DoctorDiscoveryService $doctorDiscoveryService
    ) {
    }

    public function index(DoctorDiscoveryFilterRequest $request): View|RedirectResponse
    {
        $centerId = session('patient.selected_center_id');

        if (! $centerId) {
            return $this->redirectToCenterSelection();
        }

        $recommendationMeta = $this->aiRecommendationMeta();

        $filters = $request->toDto($centerId, $recommendationMeta['specializations']);
        $result = $this->doctorDiscoveryService->discover($filters);

        return view('patient.doctor-list', [
            'selectedCenterName' => session('patient.selected_center_name', __('Not selected')),
            'aiPrediction' => $recommendationMeta['prediction'],
            'aiGeneratedAt' => $recommendationMeta['generated_at'],
            'recommendedSpecializations' => $recommendationMeta['specializations'],
            'filters' => $filters,
            'result' => $result,
        ]);
    }

    private function aiRecommendationMeta(): array
    {
        $data = session('patient.ai_recommendations', []);

        return [
            'prediction' => $data['primary_prediction'] ?? null,
            'generated_at' => $data['generated_at'] ?? null,
            'specializations' => isset($data['specializations']) && is_array($data['specializations'])
                ? array_values(array_filter($data['specializations']))
                : [],
        ];
    }

    private function redirectToCenterSelection(): RedirectResponse
    {
        return redirect()
            ->route('patient.diagnostic-centers.index')
            ->with('status', __('Please select a diagnostic center to browse doctors.'));
    }
}


