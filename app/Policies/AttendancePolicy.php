<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;

class AttendancePolicy
{
    public function view(User $user, Attendance $attendance): bool
    {
        return $user->id === $attendance->intern?->user_id || $user->isAdmin();
    }
}