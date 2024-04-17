<?php

declare(strict_types=1);

namespace App\Services;


use App\Models\Student;
use Illuminate\Support\Facades\Auth;

final class RoleService
{
    public function isStudent(): bool
    {
        $student = Student::query()
            ->where('user_id', Auth::id());

        if ($student->exists()) {
            return true;
        }

        return false;
    }

    public function isTeacher(): bool
    {
        $student = Student::query()
            ->where('user_id', Auth::id());

        if ($student->exists()) {
            return false;
        }

        return true;
    }
}
