<?php

namespace App\Repositories\Eloquent;

use App\Models\Doctor;
use App\Repositories\Contracts\DoctorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function findById(int $id, array $relations = []): ?Doctor
    {
        return Doctor::query()
            ->with($relations)
            ->find($id);
    }

    public function findByUserId(int $userId, array $relations = []): ?Doctor
    {
        return Doctor::query()
            ->with($relations)
            ->where('user_id', $userId)
            ->first();
    }

    public function update(Doctor $doctor, array $attributes): Doctor
    {
        $doctor->fill($attributes);
        $doctor->save();

        return $doctor;
    }

    public function paginateForAdmin(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Doctor::query()->with(['user', 'diagnosticCenter']);

        if ($search = Arr::get($filters, 'search')) {
            $query->whereHas('user', function ($builder) use ($search) {
                $builder->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($specialization = Arr::get($filters, 'specialization')) {
            $query->where('specialization', 'like', '%' . $specialization . '%');
        }

        if ($diagnosticCenterId = Arr::get($filters, 'diagnostic_center_id')) {
            $query->where('diagnostic_center_id', $diagnosticCenterId);
        }

        if (Arr::get($filters, 'is_active') !== null) {
            $query->where('is_active', (bool) Arr::get($filters, 'is_active'));
        }

        return $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();
    }

    public function create(array $attributes): Doctor
    {
        return Doctor::query()->create($attributes);
    }

    public function delete(Doctor $doctor): void
    {
        $doctor->delete();
    }

    public function listByDiagnosticCenter(int $diagnosticCenterId): EloquentCollection
    {
        return Doctor::query()
            ->where('diagnostic_center_id', $diagnosticCenterId)
            ->orderBy('user_id')
            ->get();
    }

    public function allWithUser(): EloquentCollection
    {
        return Doctor::query()
            ->with('user')
            ->orderBy('user_id')
            ->get();
    }

    public function listByCenterAndSpecializations(
        int $diagnosticCenterId,
        array $specializations,
        int $limit = 3
    ): EloquentCollection {
        $query = Doctor::query()
            ->with('user')
            ->where('diagnostic_center_id', $diagnosticCenterId)
            ->where('is_active', true);

        if (! empty($specializations)) {
            $query->whereIn('specialization', $specializations);
        }

        return $query
            ->orderByDesc('rating')
            ->orderByDesc('experience_years')
            ->limit($limit)
            ->get();
    }

    public function searchForPatient(
        int $diagnosticCenterId,
        array $filters,
        int $perPage = 9
    ): LengthAwarePaginator {
        $query = Doctor::query()
            ->with('user')
            ->where('diagnostic_center_id', $diagnosticCenterId)
            ->where('is_active', true)
            ->withCount(['appointments as upcoming_appointments_count' => function ($builder) {
                $builder->whereIn('status', ['pending', 'confirmed'])
                    ->where('scheduled_at', '>=', now());
            }])
            ->withMin(['appointments as next_available_slot' => function ($builder) {
                $builder->whereIn('status', ['pending', 'confirmed'])
                    ->where('scheduled_at', '>=', now());
            }], 'scheduled_at');

        if ($specialization = Arr::get($filters, 'specialization')) {
            $query->where('specialization', 'like', '%' . (string) Str::of($specialization)->trim() . '%');
        }

        if ($minRating = Arr::get($filters, 'min_rating')) {
            $query->where('rating', '>=', (float) $minRating);
        }

        if ($minFee = Arr::get($filters, 'min_fee')) {
            $query->where('consultation_fee', '>=', (float) $minFee);
        }

        if ($maxFee = Arr::get($filters, 'max_fee')) {
            $query->where('consultation_fee', '<=', (float) $maxFee);
        }

        $recommendedSpecializations = (array) Arr::get($filters, 'recommended_specializations', []);

        if (Arr::get($filters, 'only_recommended') && ! empty($recommendedSpecializations)) {
            $query->whereIn('specialization', $recommendedSpecializations);
        }

        $availabilityFilter = Arr::get($filters, 'availability');
        $comfortable = config('medical.doctor_availability.comfortable_load', 6);
        $maximum = config('medical.doctor_availability.maximum_load', 12);

        if ($availabilityFilter === 'available_now') {
            $query->having('upcoming_appointments_count', '<=', $comfortable);
        } elseif ($availabilityFilter === 'limited') {
            $query->havingBetween('upcoming_appointments_count', [$comfortable + 1, $maximum]);
        }

        $sort = Arr::get($filters, 'sort', 'recommended');
        switch ($sort) {
            case 'rating':
                $query->orderByDesc('rating')->orderByDesc('rating_count');
                break;
            case 'experience':
                $query->orderByDesc('experience_years')->orderByDesc('rating');
                break;
            case 'fee_low_high':
                $query->orderBy('consultation_fee')->orderByDesc('rating');
                break;
            case 'fee_high_low':
                $query->orderByDesc('consultation_fee')->orderByDesc('rating');
                break;
            case 'availability':
                $query->orderBy('upcoming_appointments_count')->orderBy('next_available_slot');
                break;
            case 'recommended':
            default:
                if (! empty($recommendedSpecializations)) {
                    $placeholders = implode(', ', array_fill(0, count($recommendedSpecializations), '?'));
                    $query->orderByRaw(
                        "CASE WHEN specialization IN ($placeholders) THEN 0 ELSE 1 END",
                        $recommendedSpecializations
                    );
                }
                $query->orderByDesc('rating')->orderByDesc('experience_years');
                break;
        }

        return $query->paginate($perPage)->withQueryString();
    }
}

