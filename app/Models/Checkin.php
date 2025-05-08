<?php

// app/Models/Checkin.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_list_id',
        'participant_name',
        'team_name',
        'checkin_time',
        'status_at_checkin',
        'selfie_image_path',
        'displayed_emoticon',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
    ];

    public function attendanceList(): BelongsTo
    {
        return $this->belongsTo(AttendanceList::class);
    }
}
