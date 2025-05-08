<?php

namespace Database\Seeders;

use App\Models\AttendanceList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceListSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->error('Seeder gagal: tidak ada user di database.');
            return;
        }

        $attendanceList = AttendanceList::create([
            'user_id' => $user->id,
            'event_name' => 'Sesi Check-in Hari Ini',
            'description' => 'Presensi untuk semua peserta hari ini.',
            'event_date' => Carbon::now('Asia/Jakarta')->toDateString(),
            'event_start_time' => Carbon::now('Asia/Jakarta')->addHour()->toTimeString(),
            'checkin_open_time' => Carbon::now('Asia/Jakarta')->subMinutes(30)->toTimeString(),
            'target_ontime_time' => Carbon::now('Asia/Jakarta')->addHour()->toTimeString(),
            'checkin_close_time' => Carbon::now('Asia/Jakarta')->addHours(2)->toTimeString(),
            'unique_link_token' => Str::uuid()->toString(),
            'status' => 'active',
        ]);

        $attendanceList->emoticonRules()->createMany([
            [
                'status_name' => 'Sangat Awal',
                'time_window_start_offset_minutes' => -60,
                'time_window_end_offset_minutes' => -31,
                'emoticons' => json_encode(['😀', '😎']),
            ],
            [
                'status_name' => 'Lebih Awal',
                'time_window_start_offset_minutes' => -30,
                'time_window_end_offset_minutes' => -6,
                'emoticons' => json_encode(['🙂', '👍']),
            ],
            [
                'status_name' => 'Tepat Waktu',
                'time_window_start_offset_minutes' => -5,
                'time_window_end_offset_minutes' => 10,
                'emoticons' => json_encode(['😄', '🎉']),
            ],
            [
                'status_name' => 'Terlambat',
                'time_window_start_offset_minutes' => 11,
                'time_window_end_offset_minutes' => 30,
                'emoticons' => json_encode(['😅', '🤔']),
            ],
            [
                'status_name' => 'Sangat Terlambat',
                'time_window_start_offset_minutes' => 31,
                'time_window_end_offset_minutes' => 60,
                'emoticons' => json_encode(['😱', '😥']),
            ],
        ]);
    }
}
