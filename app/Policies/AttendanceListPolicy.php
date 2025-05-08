<?php
// app/Policies/AttendanceListPolicy.php
namespace App\Policies;

use App\Models\AttendanceList;
use App\Models\User;

class AttendanceListPolicy
{
    public function view(User $user, AttendanceList $attendanceList): bool
    {
        return $user->id === $attendanceList->user_id;
    }

    public function update(User $user, AttendanceList $attendanceList): bool
    {
        return $user->id === $attendanceList->user_id;
    }

    public function delete(User $user, AttendanceList $attendanceList): bool
    {
        return $user->id === $attendanceList->user_id;
    }
}
