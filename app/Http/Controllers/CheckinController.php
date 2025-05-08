<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttendanceList;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCheckinRequest;
use Carbon\Carbon;

class CheckinController extends Controller
{
    public function show(Request $request, $token)
    {
        $attendanceList = AttendanceList::where('unique_link_token', $token)->firstOrFail();

        if ($attendanceList->status !== 'active') {
            return redirect()->route('checkin.invalid', ['reason' => 'not_active']);
        }

        $appTz = config('app.timezone', 'Asia/Jakarta');
        $now = Carbon::now($appTz);
        $eventDate = Carbon::parse($attendanceList->event_date, $appTz);
        $checkinOpenDateTime = Carbon::parse($attendanceList->checkin_open_time, $appTz)->setDateFrom($eventDate);
        $checkinCloseDateTime = Carbon::parse($attendanceList->checkin_close_time, $appTz)->setDateFrom($eventDate);
        $targetOnTimeDateTime = Carbon::parse($attendanceList->target_ontime_time, $appTz)->setDateFrom($eventDate);

        if ($now->lt($checkinOpenDateTime)) {
            return redirect()->route('checkin.invalid', ['reason' => 'not_yet_open']);
        }

        if ($now->gt($checkinCloseDateTime)) {
            return redirect()->route('checkin.invalid', ['reason' => 'already_closed']);
        }

        $currentStatusName = 'Tidak Diketahui';
        $selectedEmoticon = '❓';

        $emoticonRules = $attendanceList->emoticonRules()
            ->orderBy('time_window_start_offset_minutes', 'asc')
            ->get();

        foreach ($emoticonRules as $rule) {
            $start = $targetOnTimeDateTime->copy()->addMinutes($rule->time_window_start_offset_minutes);
            $end = $targetOnTimeDateTime->copy()->addMinutes($rule->time_window_end_offset_minutes);

            if ($now->betweenIncluded($start, $end)) {
                $currentStatusName = $rule->status_name;
                $emoticonArray = is_string($rule->emoticons) ? json_decode($rule->emoticons, true) : $rule->emoticons;
                $selectedEmoticon = is_array($emoticonArray) && !empty($emoticonArray) ? $emoticonArray[array_rand($emoticonArray)] : '❓';
                break;
            }
        }

        return view('checkin.show', compact('attendanceList', 'selectedEmoticon', 'currentStatusName', 'token'));
    }

    public function store(StoreCheckinRequest $request, $token)
    {
        $attendanceList = AttendanceList::where('unique_link_token', $token)->firstOrFail();

        if ($attendanceList->status !== 'active') {
            return redirect()->route('checkin.invalid', ['reason' => 'not_active']);
        }

        $appTz = config('app.timezone');
        $now = Carbon::now($appTz);
        $eventDate = Carbon::parse($attendanceList->event_date, $appTz);
        $checkinOpenDateTime = $eventDate->copy()->setTimeFromTimeString($attendanceList->checkin_open_time);
        $checkinCloseDateTime = $eventDate->copy()->setTimeFromTimeString($attendanceList->checkin_close_time);

        if ($now->lt($checkinOpenDateTime) || $now->gt($checkinCloseDateTime)) {
            return redirect()->route('checkin.invalid', ['reason' => 'not_in_time']);
        }

        $validatedData = $request->validated();
        $imageData = $validatedData['selfie_image_data'];

        if (!preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            throw new \InvalidArgumentException('Data URI tidak valid.');
        }

        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]);

        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            throw new \InvalidArgumentException('Tipe gambar tidak valid.');
        }

        $decodedImage = base64_decode($imageData);
        if ($decodedImage === false) {
            throw new \RuntimeException('Gagal mendekode base64.');
        }

        $imageName = 'selfies/' . Str::random(20) . '_' . time() . '.' . $type;
        Storage::disk('public')->put($imageName, $decodedImage);

        $attendanceList->checkins()->create([
            'participant_name' => $validatedData['participant_name'],
            'team_name' => $validatedData['team_name'],
            'checkin_time' => $now,
            'status_at_checkin' => $validatedData['status_at_checkin'],
            'selfie_image_path' => $imageName,
            'displayed_emoticon' => $validatedData['displayed_emoticon'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return redirect()->route('checkin.success')->with('successMessage', 'Presensi Anda berhasil dicatat!');
    }

    public function success()
    {
        // return 'hai';
        if (!session('successMessage')) {
            return redirect('/');
        }

        return view('checkin.success');
    }

    public function invalid(Request $request)
    {
        $reason = $request->query('reason', 'unknown');
        $messages = [
            'token_not_found' => 'Link presensi tidak ditemukan.',
            'not_active' => 'Link presensi sudah tidak aktif.',
            'not_yet_open' => 'Sesi presensi belum dibuka. Silakan coba lagi nanti.',
            'already_closed' => 'Sesi presensi sudah ditutup.',
            'not_in_time' => 'Sesi presensi tidak sedang aktif.',
            'unknown' => 'Link presensi tidak valid atau sudah tidak aktif.',
        ];

        return view('checkin.invalid_token', [
            'message' => $messages[$reason] ?? $messages['unknown'],
        ]);
    }
}
