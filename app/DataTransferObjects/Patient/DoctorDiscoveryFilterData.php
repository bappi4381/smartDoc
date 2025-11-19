<?php

namespace App\DataTransferObjects\Patient;

class DoctorDiscoveryFilterData
{
    /**
     * @param list<string> $recommendedSpecializations
     */
    public function __construct(
        public readonly int $diagnosticCenterId,
        public readonly ?string $specialization,
        public readonly ?string $availability,
        public readonly ?float $minRating,
        public readonly ?float $minConsultationFee,
        public readonly ?float $maxConsultationFee,
        public readonly string $sort,
        public readonly int $perPage,
        public readonly array $recommendedSpecializations,
        public readonly bool $onlyRecommended
    ) {
    }

    public function toRepositoryFilters(): array
    {
        return [
            'specialization' => $this->specialization,
            'availability' => $this->availability,
            'min_rating' => $this->minRating,
            'min_fee' => $this->minConsultationFee,
            'max_fee' => $this->maxConsultationFee,
            'sort' => $this->sort,
            'recommended_specializations' => $this->recommendedSpecializations,
            'only_recommended' => $this->onlyRecommended,
        ];
    }
}


