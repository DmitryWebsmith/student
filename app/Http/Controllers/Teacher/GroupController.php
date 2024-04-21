<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreGroupRequest;
use App\Http\Requests\Teacher\DeleteGroupRequest;
use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use App\Services\ExporterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Barryvdh\DomPDF\Facade\Pdf;

class GroupController extends Controller
{
    public function index(): Response
    {
        $data['groups'] = Group::query()
            ->where(
                [
                    'teacher_id' => Auth::id(),
                ]
            )->get();
        return Inertia::render('Teacher/Groups/List', $data);
    }

    public function showGroup(int $id): Response
    {
        $data['group'] = $group = Group::query()
            ->findOrFail($id);

        $data['students'] = $group->students;

        return Inertia::render('Teacher/Groups/ShowGroup', $data);
    }

    public function exportStudentsToPdf(int $groupId)
    {
        $studentsData = app(ExporterService::class)->getStudentsAuthData($groupId);
        $pdf = PDF::loadView('teacher.pdf.students', ['students' => $studentsData]);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('pdf_file.pdf');
    }

    public function delete(DeleteGroupRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $students = Student::query()
            ->where('group_id', $data['group_id'])
            ->get();

        foreach ($students as $student) {
            User::query()
                ->where('id', $student->user_id)
                ->delete();
        }

        Group::query()
            ->where('id', $data['group_id'])
            ->delete();

        return redirect()->route('groups');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $groupName = $request->post('name');
        $userId = Auth::id();

        $group = Group::query()
            ->where(
                [
                    'name' => $groupName,
                    'teacher_id' => $userId,
                ]
            );

        if ($group->exists()) {
            return back()->withErrors(
                [
                    'name' => 'Имя класса должно быть уникальным.',
                ]
            );
        }

        Group::query()
            ->insert(
                [
                    'name' => $groupName,
                    'teacher_id' => $userId,
                ]
            );

        return redirect(route('groups', absolute: false));
    }

    public function patch(StoreGroupRequest $request): RedirectResponse
    {
        $groupName = $request->post('name');
        $groupId = $request->post('group_id');

        $userId = Auth::id();

        $group = Group::query()
            ->where(
                [
                    'name' => $groupName,
                    'teacher_id' => $userId,
                ]
            );

        if ($group->exists()) {
            return back()->withErrors(
                [
                    'name' => 'Имя класса должно быть уникальным.',
                ]
            );
        }

        $group = Group::query()
            ->findOrFail($groupId);

        $group->name = $groupName;
        $group->save();

        return redirect(route('groups', absolute: false));
    }

    public function transliterate(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'transliterated_text' => str_slug($request->post('text')),
            ], ResponseAlias::HTTP_OK
        );
    }
}
