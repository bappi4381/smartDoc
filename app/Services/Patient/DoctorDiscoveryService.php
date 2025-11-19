<?php

namespace App\Services\Patient;

use App\DataTransferObjects\Patient\DoctorCardData;
use App\DataTransferObjects\Patient\DoctorDiscoveryFilterData;
use App\DataTransferObjects\Patient\DoctorDiscoveryResult;
use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DoctorDiscoveryService
{
    public function __construct(
        private readonly DoctorRepositoryInterface $doctorRepository
    ) {
    }

    public function discover(DoctorDiscoveryFilterData $filters): DoctorDiscoveryResult
    {
        $paginator = $this->doctorRepository->searchForPatient(
            $filters->diagnosticCenterId,
            $filters->toRepositoryFilters(),
            $filters->perPage
        );

        $collection = $paginator->getCollection()->map(function (Doctor $doctor) use ($filters) {
            return $this->mapToCardData($doctor, $filters->recommendedSpecializations);
        });

        $paginator->setCollection($collection);

        return new DoctorDiscoveryResult(
            doctors: $paginator,
            activeFilters: $this->buildFilterBadges($filters),
            recommendedMatches: $collection->filter(fn (DoctorCardData $card) => $card->isRecommended)->count()
        );
    }

    /**
     * @param list<string> $recommendedSpecializations
     */
    private function mapToCardData(Doctor $doctor, array $recommendedSpecializations): DoctorCardData
    {
        $user = $doctor->user;
        $upcomingCount = (int) ($doctor->upcoming_appointments_count ?? 0);
        $nextAvailableSlot = $doctor->next_available_slot
            ? Carbon::parse($doctor->next_available_slot)
            : null;

        [$availabilityLabel, $availabilityTone] = $this->availabilityBadge($upcomingCount, $nextAvailableSlot);

        return new DoctorCardData(
            id: $doctor->id,
            name: $user?->name ?? __('Doctor'),
            specialization: $doctor->specialization,
            qualifications: $doctor->qualifications,
            experienceYears: (int) $doctor->experience_years,
            rating: $doctor->rating ? (float) $doctor->rating : null,
            ratingCount: (int) $doctor->rating_count,
            consultationFee: $doctor->consultation_fee ? (float) $doctor->consultation_fee : null,
            bio: $doctor->bio,
            isRecommended: ! empty($recommendedSpecializations)
                ? in_array($doctor->specialization, $recommendedSpecializations, true)
                : false,
            availabilityLabel: $availabilityLabel,
            availabilityTone: $availabilityTone,
            nextAvailableSlot: $nextAvailableSlot,
            contactPhone: $user?->phone,
            contactEmail: $user?->email
        );
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function availabilityBadge(int $upcoming, ?CarbonInterface $nextAvailableSlot): array
    {
        $thresholds = config('medical.doctor_availability');
        $comfortable = (int) Arr::get($thresholds, 'comfortable_load', 6);
        $maximum = (int) Arr::get($thresholds, 'maximum_load', 12);

        if ($upcoming <= $comfortable) {
            return [__('Slots open today'), 'positive'];
        }

        if ($upcoming <= $maximum) {
            return [
                $nextAvailableSlot
                    ? __('Next slot :time', ['time' => $nextAvailableSlot->diffForHumans(['parts' => 2, 'short' => true])])
                    : __('Booking fast'),
                'warning',
            ];
        }

        return [
            $nextAvailableSlot
                ? __('Fully booked until :date', ['date' => $nextAvailableSlot->translatedFormat('M d, g:i A')])
                : __('Fully booked'),
            'danger',
        ];
    }

    /**
     * @return list<string>
     */
    private function buildFilterBadges(DoctorDiscoveryFilterData $filters): array
    {
        $badges = [];

        if ($filters->specialization) {
            $badges[] = __('Specialization: :value', ['value' => $filters->specialization]);
        }

        if ($filters->availability === 'available_now') {
            $badges[] = __('Availability: Open slots');
        } elseif ($filters->availability === 'limited') {
            $badges[] = __('Availability: Limited');
        }

        if ($filters->minRating) {
            $badges[] = __('Rating ≥ :value', ['value' => number_format($filters->minRating, 1)]);
        }

        if ($filters->minConsultationFee) {
            $badges[] = __('Fee ≥ ৳:value', ['value' => number_format($filters->minConsultationFee, 0)]);
        }

        if ($filters->maxConsultationFee) {
            $badges[] = __('Fee ≤ ৳:value', ['value' => number_format($filters->maxConsultationFee, 0)]);
        }

        if ($filters->onlyRecommended) {
            $badges[] = __('Showing AI recommended first');
        }

        return $badges;
    }
}


