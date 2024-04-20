<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\Task;
use App\Models\Test;
use App\Models\TestPassed;
use App\Services\DateFormatService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(
            [
                "task_id" => "required|numeric",
            ]
        );

        $data['user_id'] = Auth::id();

        $currentTime = App(DateFormatService::class)->getLocalDateTime(Carbon::now()->format('Y-m-d H:i:s'));

        $data['task'] = $task = Task::query()
            ->where('id', $request->get('task_id'))
            ->firstOrFail();

        $startTime = Carbon::parse($task->start_time);
        $endTime = Carbon::parse($task->end_time);

        $data['test'] = $test = Test::query()
            ->with('questions')
            ->where('id', $task->test_id)
            ->firstOrFail();

        $data['questions'] = Question::query()
            ->where('test_id', $test->id)
            ->with(['answers', 'student_answers'])
            ->get();

        $data['student'] = Student::query()
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($startTime <= $currentTime && $endTime > $currentTime) {
            return Inertia::render('Student/Tests/PassTest', $data);
        }

        $data['current_time'] = $currentTime = App(DateFormatService::class)->getLocalDateTime(
            Carbon::now()->format('Y-m-d H:i:s')
        );

        $data['tasks'] = Task::query()
            ->with(['test', 'group', 'test_passed'])
            ->where('end_time', '>', $currentTime)
            ->get();

        $data['message'] = 'Текущее время не соответствует диапазону времени прохождения теста.';

        return Inertia::render('Student/Dashboard/index', $data);
    }

    public function storeStudentAnswer(Request $request): JsonResponse
    {
        $request->validate(
            [
                "task_id" => "required|numeric",
                "student_id" => "required|numeric",
                "question_id" => "required|numeric",
            ]
        );

        $question = Question::query()
            ->findOrFail($request->post('question_id'));

        $task = Task::query()
            ->findOrFail($request->post('task_id'));

        $currentTime = App(DateFormatService::class)->getLocalDateTime(Carbon::now()->format('Y-m-d H:i:s'));

        $startTime = Carbon::parse($task->start_time);
        $endTime = Carbon::parse($task->end_time);

        if ($startTime > $currentTime || $endTime < $currentTime) {
            $message = 'Текущее время не соответствует диапазону времени прохождения теста.';

            return new JsonResponse(['message' => $message], JsonResponse::HTTP_OK);
        }

        $student = Student::query()
            ->findOrFail($request->post('student_id'));

        $studentAnswer = StudentAnswer::query()
            ->where(
                [
                    'task_id' => $task->id,
                    'student_id' => $student->id,
                    'question_id' => $question->id,
                ]
            );

        if ($studentAnswer->exists()) {
            $studentAnswer->delete();
        }

        if ($request->post('answer') === null) {
            return new JsonResponse([], JsonResponse::HTTP_OK);
        }

        $answer = Answer::query()
            ->where('question_id', $question->id)
            ->first();

        $studentAnswer = new StudentAnswer();
        $studentAnswer->task_id = $task->id;
        $studentAnswer->student_id = $student->id;
        $studentAnswer->question_id = $question->id;

        if ($answer->type === 'text') {
            $studentAnswer->answer_id = $answer->id;
            $studentAnswer->text = $request->post('answer');
            $studentAnswer->type = 'text';
            $studentAnswer->save();
        }

        if ($answer->type === 'radiobutton') {
            $studentAnswer->answer_id = $request->post('answer');
            $studentAnswer->truth = true;
            $studentAnswer->type = 'radiobutton';
            $studentAnswer->save();
        }

        if ($answer->type === 'checkbox') {
            $studentAnswer->delete();

            foreach ($request->post('answer') as $answerId) {
                $studentAnswer = new StudentAnswer();
                $studentAnswer->task_id = $task->id;
                $studentAnswer->student_id = $student->id;
                $studentAnswer->question_id = $question->id;
                $studentAnswer->answer_id = $answerId;
                $studentAnswer->truth = true;
                $studentAnswer->type = 'checkbox';
                $studentAnswer->save();
            }
        }

        $data['testPassed'] = $this->checkIfTestWasPassed($student->id, $question->test_id);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    public function markTestPassing(Request $request): JsonResponse
    {
        $request->validate(
            [
                "student_id" => "required|numeric",
                "task_id" => "required|numeric",
            ]
        );

        $testPassed = TestPassed::query()
            ->where(
                [
                    'task_id' => $request->task_id,
                    'student_id' => $request->student_id,
                ]
            );

        if (!$testPassed->exists()) {
            TestPassed::query()
                ->insert(
                    [
                        'task_id' => $request->task_id,
                        'student_id' => $request->student_id,
                    ]
                );
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

    private function checkIfTestWasPassed(int $studentId, int $testId): bool
    {
        $test = Test::query()
            ->findOrFail($testId);

        foreach ($test->questions as $question) {
            $studentAnswer = StudentAnswer::query()
                ->where(
                    [
                        'student_id' => $studentId,
                        'question_id' => $question->id,
                    ]
                );

            if (!$studentAnswer->exists()) {
                return false;
            }
        }

        return true;
    }
}
