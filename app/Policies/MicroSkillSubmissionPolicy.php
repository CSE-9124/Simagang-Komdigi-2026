<?php

namespace App\Policies;

use App\Models\MicroSkillSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MicroSkillSubmissionPolicy
{
    public function view(User $user, MicroSkillSubmission $submission): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isIntern()) {
            return optional($user->intern)->id === $submission->intern_id;
        }

        if ($user->isMentor()) {
            $mentorId = optional($user->mentor)->id;

            return $mentorId
                ? DB::table('interns')
                    ->where('id', $submission->intern_id)
                    ->where('mentor_id', $mentorId)
                    ->exists()
                : false;
        }

        if ($user->isInstitusi()) {
            $institusiId = optional($user->institusi)->id;

            return $institusiId
                ? DB::table('interns')
                    ->join('users', 'users.id', '=', 'interns.user_id')
                    ->join('pengajuan_details', 'pengajuan_details.email', '=', 'users.email')
                    ->join('pengajuans', 'pengajuans.id', '=', 'pengajuan_details.pengajuan_id')
                    ->where('pengajuans.institusi_id', $institusiId)
                    ->where('interns.id', $submission->intern_id)
                    ->exists()
                : false;
        }

        return false;
    }

    public function update(User $user, MicroSkillSubmission $submission): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isIntern() && optional($user->intern)->id === $submission->intern_id;
    }

    public function delete(User $user, MicroSkillSubmission $submission): bool
    {
        return $this->update($user, $submission);
    }
}