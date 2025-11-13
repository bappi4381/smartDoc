<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Appointment\ReassignAppointmentDoctorRequest;
use App\Http\Requests\Admin\Appointment\RescheduleAppointmentRequest;
use App\Http\Requests\Admin\Appointment\UpdateAppointmentStatusRequest;
use App\Services\Admin\AdminAppointmentService;
use App\Services\Admin\AdminDiagnosticCenterService;
use App\Services\Admin\AdminDoctorService;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        private readonly AdminAppointmentService $appointmentService,
        private readonly AdminDoctorService $doctorService,
        private readonly AdminDiagnosticCenterService $centerService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'diagnostic_center_id', 'doctor_id', 'patient_name', 'date_from', 'date_to']);

        $dateRange = [
            $filters['date_from'] ?? null,
            $filters['date_to'] ?? null,
        ];

        $appointments = $this->appointmentService->paginate(
            array_merge($filters, ['date_range' => $dateRange]),
            perPage: 20
        );

        return view('admin.appointments.index', [
            'appointments' => $appointments,
            'filters' => $filters,
            'centers' => $this->centerService->allForSelect(),
            'doctors' => $this->doctorService->allWithUser(),
            'statusSummary' => $this->appointmentService->aggregateByStatus(),
        ]);
    }

    public function show(int $appointment): View
    {
        return view('admin.appointments.show', [
            'appointment' => $this->appointmentService->find($appointment),
            'doctors' => $this->doctorService->allWithUser(),
        ]);
    }

    public function updateStatus(UpdateAppointmentStatusRequest $request, int $appointment): RedirectResponse
    {
        $this->appointmentService->updateStatus($appointment, $request->validated('status'));

        return back()->with('status', 'Appointment status updated.');
    }

    public function reschedule(RescheduleAppointmentRequest $request, int $appointment): RedirectResponse
    {
        $this->appointmentService->reschedule($appointment, Carbon::parse($request->validated('scheduled_at')));

        return back()->with('status', 'Appointment rescheduled.');
    }

    public function reassign(ReassignAppointmentDoctorRequest $request, int $appointment): RedirectResponse
    {
        $this->appointmentService->reassignDoctor($appointment, (int) $request->validated('doctor_id'));

        return back()->with('status', 'Appointment reassigned to doctor.');
    }
}

