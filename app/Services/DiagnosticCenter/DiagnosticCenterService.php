<?php

namespace App\Services\DiagnosticCenter;

use App\DataTransferObjects\Patient\DiagnosticCenterFilterData;
use App\Models\DiagnosticCenter;
use App\Repositories\Contracts\DiagnosticCenterRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiagnosticCenterService
{
    public function __construct(
        private readonly DiagnosticCenterRepositoryInterface $diagnosticCenterRepository
    ) {
    }

    public function listDiagnosticCenters(DiagnosticCenterFilterData $filterData): LengthAwarePaginator
    {
        return $this->diagnosticCenterRepository->paginateActive(
            $filterData->filters(),
            $filterData->sort(),
            $filterData->perPage
        );
    }

    public function getActiveDiagnosticCenter(int $id): DiagnosticCenter
    {
        $center = $this->diagnosticCenterRepository->findActive($id);

        if (! $center instanceof DiagnosticCenter) {
            throw new ModelNotFoundException('Diagnostic center not found or inactive.');
        }

        return $center;
    }
}

