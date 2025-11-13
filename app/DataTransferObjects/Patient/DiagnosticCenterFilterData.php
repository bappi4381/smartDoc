<?php

namespace App\DataTransferObjects\Patient;

class DiagnosticCenterFilterData
{
    public function __construct(
        public readonly ?string $search,
        public readonly ?string $city,
        public readonly ?string $specialization,
        public readonly ?bool $hasAvailableSlots,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly ?float $maxDistance,
        public readonly string $sortBy,
        public readonly string $sortDirection,
        public readonly int $perPage,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            city: $data['city'] ?? null,
            specialization: $data['specialization'] ?? null,
            hasAvailableSlots: isset($data['has_available_slots'])
                ? filter_var($data['has_available_slots'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
                : null,
            latitude: isset($data['latitude']) ? (float) $data['latitude'] : null,
            longitude: isset($data['longitude']) ? (float) $data['longitude'] : null,
            maxDistance: isset($data['max_distance']) ? (float) $data['max_distance'] : null,
            sortBy: $data['sort_by'] ?? $data['sort'] ?? 'name',
            sortDirection: $data['sort_direction'] ?? 'asc',
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : 12,
        );
    }

    public function filters(): array
    {
        return [
            'search' => $this->search,
            'city' => $this->city,
            'specialization' => $this->specialization,
            'has_available_slots' => $this->hasAvailableSlots,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'max_distance' => $this->maxDistance,
        ];
    }

    public function sort(): array
    {
        return [
            'by' => $this->sortBy,
            'direction' => $this->sortDirection,
        ];
    }
}

