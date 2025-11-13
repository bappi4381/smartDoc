<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiagnosticCenter\StoreDiagnosticCenterRequest;
use App\Http\Requests\Admin\DiagnosticCenter\UpdateDiagnosticCenterRequest;
use App\Services\Admin\AdminDiagnosticCenterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DiagnosticCenterController extends Controller
{
    public function __construct(
        private readonly AdminDiagnosticCenterService $centerService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'city', 'specialization', 'is_active']);

        $centers = $this->centerService->paginate($filters, perPage: 15);

        return view('admin.centers.index', [
            'centers' => $centers,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.centers.create');
    }

    public function store(StoreDiagnosticCenterRequest $request): RedirectResponse
    {
        $center = $this->centerService->create($request->toDto());

        return redirect()
            ->route('admin.centers.edit', $center->id)
            ->with('status', 'Diagnostic center created successfully.');
    }

    public function edit(int $center): View
    {
        $centerModel = $this->centerService->find($center);

        return view('admin.centers.edit', [
            'center' => $centerModel,
        ]);
    }

    public function update(UpdateDiagnosticCenterRequest $request, int $center): RedirectResponse
    {
        $this->centerService->update($center, $request->toDto());

        return redirect()
            ->route('admin.centers.edit', $center)
            ->with('status', 'Diagnostic center updated successfully.');
    }

    public function destroy(int $center): RedirectResponse
    {
        $this->centerService->delete($center);

        return redirect()
            ->route('admin.centers.index')
            ->with('status', 'Diagnostic center removed.');
    }
}

