<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Doctor\AssignDoctorRequest;
use App\Http\Requests\Admin\Doctor\StoreDoctorRequest;
use App\Http\Requests\Admin\Doctor\UpdateDoctorRequest;
use App\Services\Admin\AdminDiagnosticCenterService;
use App\Services\Admin\AdminDoctorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        private readonly AdminDoctorService $doctorService,
        private readonly AdminDiagnosticCenterService $centerService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'specialization', 'diagnostic_center_id', 'is_active']);
        $doctors = $this->doctorService->paginate($filters, perPage: 15);
        $centers = $this->centerService->allForSelect();

        return view('admin.doctors.index', [
            'doctors' => $doctors,
            'filters' => $filters,
            'centers' => $centers,
        ]);
    }

    public function create(): View
    {
        return view('admin.doctors.create', [
            'centers' => $this->centerService->allForSelect(),
        ]);
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        $doctor = $this->doctorService->create($request->toDto());

        return redirect()
            ->route('admin.doctors.edit', $doctor->id)
            ->with('status', 'Doctor profile created successfully.');
    }

    public function edit(int $doctor): View
    {
        return view('admin.doctors.edit', [
            'doctor' => $this->doctorService->find($doctor),
            'centers' => $this->centerService->allForSelect(),
        ]);
    }

    public function update(UpdateDoctorRequest $request, int $doctor): RedirectResponse
    {
        $this->doctorService->update($doctor, $request->toDto());

        return redirect()
            ->route('admin.doctors.edit', $doctor)
            ->with('status', 'Doctor profile updated successfully.');
    }

    public function destroy(int $doctor): RedirectResponse
    {
        $this->doctorService->delete($doctor);

        return redirect()
            ->route('admin.doctors.index')
            ->with('status', 'Doctor profile removed.');
    }

    public function assign(AssignDoctorRequest $request, int $doctor): RedirectResponse
    {
        $this->doctorService->assign($doctor, (int) $request->validated('diagnostic_center_id'));

        return redirect()
            ->route('admin.doctors.edit', $doctor)
            ->with('status', 'Doctor assigned to diagnostic center.');
    }
}

