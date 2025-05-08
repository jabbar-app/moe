<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttendanceList;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\Admin\UpdateAttendanceListRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AttendanceListController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $attendanceLists = AttendanceList::where('user_id', Auth::id())
            ->orderBy('event_date', 'desc')
            ->paginate(10);

        return view('admin.attendance_lists.index', compact('attendanceLists'));
    }

    public function create()
    {
        $defaultRules = [
            ['status_name' => 'Sangat Awal', 'start_offset' => -60, 'end_offset' => -31, 'emoticons' => '😀,😎'],
            ['status_name' => 'Lebih Awal', 'start_offset' => -30, 'end_offset' => -6, 'emoticons' => '🙂,👍'],
            ['status_name' => 'Tepat Waktu', 'start_offset' => -5, 'end_offset' => 10, 'emoticons' => '😄,🎉'],
            ['status_name' => 'Terlambat', 'start_offset' => 11, 'end_offset' => 30, 'emoticons' => '😅,🤔'],
            ['status_name' => 'Sangat Terlambat', 'start_offset' => 31, 'end_offset' => 60, 'emoticons' => '😱,😥'],
        ];

        return view('admin.attendance_lists.create', compact('defaultRules'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_start_time' => 'required|date_format:H:i',
            'checkin_open_time' => 'required|date_format:H:i',
            'target_ontime_time' => 'required|date_format:H:i',
            'checkin_close_time' => 'required|date_format:H:i',
            'rules' => 'required|array|min:1',
            'rules.*.status_name' => 'required|string|max:255',
            'rules.*.start_offset' => 'required|integer',
            'rules.*.end_offset' => 'required|integer',
            'rules.*.emoticons' => 'required|string',
        ]);

        $uniqueToken = Str::uuid()->toString();

        $attendanceList = AttendanceList::create([
            'user_id' => Auth::id(),
            'event_name' => $validatedData['event_name'],
            'description' => $validatedData['description'] ?? null,
            'event_date' => $validatedData['event_date'],
            'event_start_time' => $validatedData['event_start_time'],
            'checkin_open_time' => $validatedData['checkin_open_time'],
            'target_ontime_time' => $validatedData['target_ontime_time'],
            'checkin_close_time' => $validatedData['checkin_close_time'],
            'unique_link_token' => $uniqueToken,
            'status' => 'pending',
        ]);

        foreach ($validatedData['rules'] as $rule) {
            $attendanceList->emoticonRules()->create([
                'status_name' => $rule['status_name'],
                'time_window_start_offset_minutes' => $rule['start_offset'],
                'time_window_end_offset_minutes' => $rule['end_offset'],
                'emoticons' => array_map('trim', explode(',', $rule['emoticons'])),
            ]);
        }

        return redirect()->route('admin.attendance-lists.show', $attendanceList)
            ->with('success', 'Daftar hadir berhasil dibuat.');
    }

    public function show(AttendanceList $attendanceList)
    {
        $this->authorize('view', $attendanceList);

        $checkinUrl = '#';
        $qrCode = null;

        if ($attendanceList->unique_link_token) {
            $checkinUrl = route('checkin.show', $attendanceList->unique_link_token);
            $qrCode = QrCode::size(250)->generate($checkinUrl);
        }

        $checkins = $attendanceList->checkins()
            ->orderBy('checkin_time', 'desc')
            ->paginate(15, ['*'], 'checkins_page');

        return view('admin.attendance_lists.show', compact('attendanceList', 'qrCode', 'checkinUrl', 'checkins'));
    }

    public function edit(AttendanceList $attendanceList)
    {
        $this->authorize('update', $attendanceList);
        return view('admin.attendance_lists.edit', compact('attendanceList'));
    }

    public function update(UpdateAttendanceListRequest $request, AttendanceList $attendanceList)
    {
        $this->authorize('update', $attendanceList);
        $validatedData = $request->validated();

        $attendanceList->update([
            'event_name' => $validatedData['event_name'],
            'description' => $validatedData['description'],
            'event_date' => $validatedData['event_date'],
            'event_start_time' => $validatedData['event_start_time'],
            'checkin_open_time' => $validatedData['checkin_open_time'],
            'target_ontime_time' => $validatedData['target_ontime_time'],
            'checkin_close_time' => $validatedData['checkin_close_time'],
            'status' => $validatedData['status'],
        ]);

        $existingRuleIds = $attendanceList->emoticonRules->pluck('id')->toArray();
        $submittedRuleIds = [];

        foreach ($validatedData['rules'] as $ruleData) {
            $emoticonsArray = array_map('trim', explode(',', $ruleData['emoticons']));
            $dataToUpdateOrCreate = [
                'status_name' => $ruleData['status_name'],
                'time_window_start_offset_minutes' => $ruleData['start_offset'],
                'time_window_end_offset_minutes' => $ruleData['end_offset'],
                'emoticons' => $emoticonsArray,
            ];

            if (isset($ruleData['id'])) {
                $rule = $attendanceList->emoticonRules()->find($ruleData['id']);
                if ($rule) {
                    $rule->update($dataToUpdateOrCreate);
                    $submittedRuleIds[] = $rule->id;
                }
            } else {
                $newRule = $attendanceList->emoticonRules()->create($dataToUpdateOrCreate);
                $submittedRuleIds[] = $newRule->id;
            }
        }

        $rulesToDelete = array_diff($existingRuleIds, $submittedRuleIds);
        if (!empty($rulesToDelete)) {
            $attendanceList->emoticonRules()->whereIn('id', $rulesToDelete)->delete();
        }

        return redirect()->route('admin.attendance-lists.show', $attendanceList)
            ->with('success', 'Daftar hadir berhasil diperbarui!');
    }

    public function destroy(AttendanceList $attendanceList)
    {
        $this->authorize('delete', $attendanceList);

        $attendanceList->delete();

        return redirect()->route('admin.attendance-lists.index')
            ->with('success', 'Daftar hadir berhasil dihapus.');
    }

    public function regenerateLink(AttendanceList $attendanceList)
    {
        $this->authorize('update', $attendanceList);
        $attendanceList->update(['unique_link_token' => Str::uuid()->toString()]);
        return redirect()->back()->with('success', 'Link presensi berhasil diperbarui.');
    }
}
