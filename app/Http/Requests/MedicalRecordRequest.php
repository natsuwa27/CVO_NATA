<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class MedicalRecordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'appointment_id'  => 'required|exists:appointments,id|unique:medical_records,appointment_id',
            'weight'          => 'nullable|numeric|min:0',
            'temperature'     => 'nullable|numeric|min:30|max:45',
            'symptoms'        => 'nullable|string|max:1000',
            'diagnosis'       => 'nullable|string|max:1000',
            'treatment'       => 'nullable|string|max:1000',
            'prescriptions'   => 'nullable|string|max:1000',
            'observations'    => 'nullable|string|max:1000',
            'next_visit'      => 'nullable|date|after:today',
        ];
    }
}
