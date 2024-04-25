<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Setting;
use App\Models\Student;
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
        $student = Student::query()
            ->where('user_id', Auth::id())
            ->with('group')
            ->firstOrFail();

        $timezone = Setting::query()
            ->where('name', 'default_timezone')
            ->first()
            ->value;

        $currentTime = Carbon::now($timezone);

        $tasks = Task::query()
            ->where('group_id', $student->group->id)
            ->where('end_time', '<', $currentTime)
            ->with(['test', 'test.category', 'group'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $studentResults = [];
        foreach ($tasks as $task) {
            $studentResults[] = [
                'task_id' => $task->id,
                'test_id' => $task->test->id,
                'test_name' => $task->test->name,
                'score' => app(StudentResultsService::class)->getResultsOfPassedTest($student->id, $task->id)['score'],
                'pass_date' => Carbon::parse($task->end_time)->format('d/m/Y H:i'),
                'category_name' => $task->test->category->name,
            ];
        }

        return Inertia::render('Student/Statistics/List',
            [
                "student" => $student,
                "results" => $studentResults,
            ]);
    }

    public function showStudentResult(Request $request): Response
    {
        $student = Student::query()
            ->with('group')
            ->where('user_id', Auth::id())
            ->first();

        $task = Task::query()->findOrFail($request->get('task_id'));

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

        return Inertia::render('Student/Statistics/TestResult', $data);
    }
}
