<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Task;
use App\Models\Test;
use App\Services\StudentResultsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    public function index(): Response
    {
        $timezone = Setting::query()
            ->where('name', 'default_timezone')
            ->first()
            ->value;

        $currentTime = Carbon::now($timezone);

        $tasks = Task::query()
            ->where('teacher_id', Auth::id())
            ->where('end_time', '<', $currentTime)
            ->with(['test', 'test.category', 'group'])
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render('Teacher/Statistics/List', ["tasks" => $tasks]);
    }

    public function showStudentResult(Request $request): Response
    {
        $studentId = $request->get('student_id');

        $student = Student::query()
            ->with('group')
            ->where('id', $studentId)
            ->firstOrFail();

        $task = Task::query()
            ->findOrFail($request->get('task_id'));

        $test = Test::query()
            ->with('category')
            ->findOrFail($task->test_id);

        $questions = Question::query()
            ->where('test_id', $test->id)
            ->with(['answers', 'student_answers', 'student_answers.answer'])
            ->get();

        $data = [
            'task' => $task,
            'test' => $test,
            'questions' => $questions,
            'student' => $student,
            'result' => app(StudentResultsService::class)->getResultsOfPassedTest($student->id, $task->id),
        ];

        return Inertia::render('Teacher/Statistics/StudentResult', $data);
    }

    public function showGroupResult(int $taskId): Response
    {
        $task = Task::query()
            ->where('id', $taskId)
            ->with(['test', 'group', 'test_passed'])
            ->first();

        $students = Student::query()
            ->where('group_id', $task->group_id)
            ->get();

        $studentsData = [];
        foreach ($students as $student) {
            $studentsData[$student->id] = [
                'name' => $student->first_name . ' ' . $student->last_name,
                'result' => app(StudentResultsService::class)->getResultsOfPassedTest($student->id, $task->id),
            ];
        }

        return Inertia::render('Teacher/Statistics/GroupResult',
            [
                'task' => $task,
                'students' => $studentsData,
            ]);
    }
}
