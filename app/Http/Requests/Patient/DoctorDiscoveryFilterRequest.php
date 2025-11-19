<?php

namespace App\Http\Requests\Patient;

use App\DataTransferObjects\Patient\DoctorDiscoveryFilterData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorDiscoveryFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->has('specialization')) {
            $recommended = $this->recommendedSpecializations();
            if (! empty($recommended)) {
                $this->merge([
                    'specialization' => $recommended[0],
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'specialization' => ['nullable', 'string', 'max:120'],
            'availability' => ['nullable', Rule::in(['available_now', 'limited'])],
            'min_rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'min_fee' => ['nullable', 'numeric', 'min:0', 'max:5000'],
            'max_fee' => ['nullable', 'numeric', 'min:0', 'max:5000', 'gte:min_fee'],
            'sort' => ['nullable', Rule::in([
                'recommended',
                'rating',
                'experience',
                'fee_low_high',
                'fee_high_low',
                'availability',
            ])],
            'per_page' => ['nullable', 'integer', 'min:6', 'max:24'],
            'only_recommended' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @param list<string> $recommendedSpecializations
     */
    public function toDto(int $diagnosticCenterId, array $recommendedSpecializations): DoctorDiscoveryFilterData
    {
        $specializationInput = $this->string('specialization')->trim()->value();
        $specialization = ($specializationInput === '' || $specializationInput === 'all')
            ? null
            : $specializationInput;

        return new DoctorDiscoveryFilterData(
            diagnosticCenterId: $diagnosticCenterId,
            specialization: $specialization,
            availability: $this->string('availability')->trim()->value() ?: null,
            minRating: $this->filled('min_rating') ? (float) $this->input('min_rating') : null,
            minConsultationFee: $this->filled('min_fee') ? (float) $this->input('min_fee') : null,
            maxConsultationFee: $this->filled('max_fee') ? (float) $this->input('max_fee') : null,
            sort: $this->string('sort')->trim()->value() ?: 'recommended',
            perPage: $this->integer('per_page') ?: 9,
            recommendedSpecializations: $recommendedSpecializations,
            onlyRecommended: $this->boolean('only_recommended')
        );
    }

    /**
     * @return list<string>
     */
    private function recommendedSpecializations(): array
    {
        $values = session('patient.ai_recommendations.specializations', []);

        return is_array($values) ? array_values(array_filter($values)) : [];
    }
}


