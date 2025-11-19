<?php

namespace App\DataTransferObjects\Patient;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorDiscoveryResult
{
    /**
     * @param list<string> $activeFilters
     */
    public function __construct(
        public readonly LengthAwarePaginator $doctors,
        public readonly array $activeFilters,
        public readonly int $recommendedMatches
    ) {
    }
}


