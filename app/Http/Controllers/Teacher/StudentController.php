<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreStudentRequest;
use App\Http\Requests\Teacher\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('teacher.students.list');
    }

    public function showStudent(int $id): Response
    {
        $data['student'] = $student = Student::query()
            ->with('group')
            ->findOrFail($id);

        $data['user'] = User::query()
            ->findOrFail($student->user_id);

        $data['url'] = config('app.url');

        return Inertia::render('Teacher/Students/ShowStudent', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UpdateStudentRequest $request): Response
    {
        $data = $request->validated();

        $student = Student::query()
            ->findOrFail($data['student_id']);

        $student->first_name = $data['first_name'];
        $student->last_name = $data['last_name'];
        $student->password = $data['password'];
        $student->updated_at = Carbon::now();
        $student->save();

        $user = User::query()
            ->findOrFail($student->user_id);

        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->updated_at = Carbon::now();
        $user->save();

        $data = [
            'student' => $student,
            'user' => $user,
        ];

        return Inertia::render('Teacher/Students/ShowStudent', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::query()
            ->where('email', $data['email'])
            ->first();

        if ($user === null) {
            $user = new User();
            $user->name = $data['first_name'] . ' ' . $data['last_name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->created_at = Carbon::now();
            $user->save();
        }

        $student = Student::query()
            ->where(
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'group_id' => $data['group_id'],
                ]
            )
            ->first();

        if ($student === null) {
            $student = new Student();
            $student->user_id = $user->id;
            $student->first_name = $data['first_name'];
            $student->last_name = $data['last_name'];
            $student->password = $data['password'];
            $student->group_id = $data['group_id'];
            $student->created_at = Carbon::now();
            $student->save();
        }

        return redirect(route('show.group', $data['group_id'], absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $student = Student::query()
            ->findOrFail($request->post('student_id'));

        User::query()
            ->where('id', $student->user_id)
            ->delete();

        return redirect()->route('show.group', $student->group_id);
    }
}
