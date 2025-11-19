<?php

namespace App\DataTransferObjects\Patient;

use Carbon\CarbonInterface;

class DoctorCardData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $specialization,
        public readonly ?string $qualifications,
        public readonly int $experienceYears,
        public readonly ?float $rating,
        public readonly int $ratingCount,
        public readonly ?float $consultationFee,
        public readonly ?string $bio,
        public readonly bool $isRecommended,
        public readonly string $availabilityLabel,
        public readonly string $availabilityTone,
        public readonly ?CarbonInterface $nextAvailableSlot,
        public readonly ?string $contactPhone,
        public readonly ?string $contactEmail
    ) {
    }
}


