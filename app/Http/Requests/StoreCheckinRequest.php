<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Siapa saja bisa submit form ini
    }

    public function rules(): array
    {
        return [
            'participant_name' => 'required|string|max:255',
            'team_name' => 'nullable|string|max:255',
            'selfie_image_data' => 'required|string', // Data URL base64
            'displayed_emoticon' => 'required|string|max:10',
            'status_at_checkin' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'participant_name.required' => 'Nama lengkap wajib diisi.',
            'selfie_image_data.required' => 'Foto selfie wajib diambil.',
        ];
    }
}
