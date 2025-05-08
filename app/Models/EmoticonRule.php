<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmoticonRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_list_id',
        'status_name',
        'time_window_start_offset_minutes',
        'time_window_end_offset_minutes',
        'emoticons',
    ];

    protected $casts = [
        'emoticons' => 'array', // Otomatis cast JSON ke array dan sebaliknya
    ];

    public function attendanceList(): BelongsTo
    {
        return $this->belongsTo(AttendanceList::class);
    }
}
