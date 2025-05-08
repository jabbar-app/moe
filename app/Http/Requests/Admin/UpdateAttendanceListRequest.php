<?php
// app/Http/Requests/Admin/UpdateAttendanceListRequest.php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Untuk status

class UpdateAttendanceListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_start_time' => 'required|date_format:H:i',
            'checkin_open_time' => 'required|date_format:H:i',
            'target_ontime_time' => 'required|date_format:H:i',
            'checkin_close_time' => 'required|date_format:H:i|after:checkin_open_time',
            'status' => ['required', Rule::in(['pending', 'active', 'finished', 'cancelled'])],
            'rules' => 'required|array|min:1',
            'rules.*.id' => 'nullable|integer|exists:emoticon_rules,id', // ID jika rule sudah ada
            'rules.*.status_name' => 'required|string|max:100',
            'rules.*.start_offset' => 'required|integer',
            'rules.*.end_offset' => 'required|integer|gte:rules.*.start_offset',
            'rules.*.emoticons' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'rules.*.end_offset.gte' => 'Offset akhir harus lebih besar atau sama dengan offset mulai.',
        ];
    }
}
