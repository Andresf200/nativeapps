<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosticPatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['integer', 'required', 'exists:patients,id'],
            'diagnostic_id' => ['uuid','required', 'exists:diagnostics,id'],
            'observation' => ['nullable', 'string'],
        ];
    }
}
