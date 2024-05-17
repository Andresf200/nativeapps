<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document' => [
                'required',
                'numeric',
                'digits_between:1,20',
                Rule::unique('patients', 'document')->ignore($this->patient),
            ],
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'birth_date' => ['required', 'date'],
            'email' => [
                'required',
                'email',
                Rule::unique('patients', 'email')->ignore($this->patient),
            ],
            'phone' => ['required', 'numeric', 'digits_between:1,20'],
            'genre' => ['required', 'string', 'max:30', Rule::in(Patient::FEMALE, Patient::MALE)]
        ];
    }
}
