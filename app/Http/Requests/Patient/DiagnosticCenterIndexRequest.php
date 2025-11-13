<?php

namespace App\Http\Requests\Patient;

use App\DataTransferObjects\Patient\DiagnosticCenterFilterData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiagnosticCenterIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('per_page')) {
            $this->merge(['per_page' => (int) $this->input('per_page')]);
        }

        if ($this->has('max_distance')) {
            $this->merge(['max_distance' => (float) $this->input('max_distance')]);
        }
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'has_available_slots' => ['nullable', 'boolean'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'max_distance' => ['nullable', 'numeric', 'min:1', 'max:200'],
            'sort' => ['nullable', Rule::in(['name', 'rating', 'distance', 'availability'])],
            'sort_by' => ['nullable', Rule::in(['name', 'rating', 'distance', 'availability'])],
            'sort_direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'per_page' => ['nullable', 'integer', 'min:6', 'max:48'],
        ];
    }

    public function toDto(): DiagnosticCenterFilterData
    {
        return DiagnosticCenterFilterData::fromArray($this->validated());
    }
}

