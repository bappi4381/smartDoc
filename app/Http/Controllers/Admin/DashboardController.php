<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAppointmentService;
use App\Services\Admin\AdminDiagnosticCenterService;
use App\Services\Admin\AdminDoctorService;
use App\Services\Admin\AdminReportingService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AdminReportingService $reportingService,
        private readonly AdminAppointmentService $appointmentService,
        private readonly AdminDoctorService $doctorService,
        private readonly AdminDiagnosticCenterService $centerService
    ) {
    }

    public function __invoke(): View
    {
        $overview = $this->reportingService->overview();
        $appointmentTrends = $this->reportingService->appointmentTrends();
        $specializations = $this->reportingService->specializationBreakdown();
        $topCenters = $this->reportingService->topDiagnosticCenters();

        $statusSummary = $this->appointmentService->aggregateByStatus();
        $centers = $this->centerService->allForSelect();
        $doctors = $this->doctorService->allWithUser();

        return view('admin.dashboard', [
            'overview' => $overview,
            'appointmentTrends' => $appointmentTrends,
            'specializations' => $specializations,
            'topCenters' => $topCenters,
            'statusSummary' => $statusSummary,
            'centers' => $centers,
            'doctors' => $doctors,
        ]);
    }
}

