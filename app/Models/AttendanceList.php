<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_name',
        'description',
        'event_date',
        'event_start_time',
        'checkin_open_time',
        'target_ontime_time',
        'checkin_close_time',
        'unique_link_token',
        'status',
    ];

    // Casts untuk tipe data
    protected $casts = [
        'event_date' => 'date',
        'event_start_time' => 'datetime',
        'checkin_open_time' => 'datetime',
        'target_ontime_time' => 'datetime',
        'checkin_close_time' => 'datetime',
    ];

    public function admin(): BelongsTo // Relasi ke user yang membuat
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function emoticonRules(): HasMany
    {
        return $this->hasMany(EmoticonRule::class);
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class);
    }
}
