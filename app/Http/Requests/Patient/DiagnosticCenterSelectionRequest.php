<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosticCenterSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'center_id' => ['required', 'integer', 'exists:diagnostic_centers,id'],
        ];
    }
}

