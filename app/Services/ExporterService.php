<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Group;

final class ExporterService
{
    public function getStudentsAuthData($groupId): array
    {
        $studentList = [
            [
                'ФИО',
                'Логин',
                'Пароль',
            ]
        ];

        $group = Group::query()->findOrFail($groupId);

        foreach ($group->students as $student) {
            $studentData = [];

            $studentData[] = $student->fullName();
            $studentData[] = $student->user->email;
            $studentData[] = $student->password;

            $studentList[] = $studentData;
        }

        return $studentList;
    }
}
