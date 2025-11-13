<?php

namespace App\Repositories\Contracts;

use App\Models\DiagnosticCenter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DiagnosticCenterRepositoryInterface
{
    public function paginateActive(array $filters, array $sort, int $perPage = 12): LengthAwarePaginator;

    public function findActive(int $id): ?DiagnosticCenter;
}

