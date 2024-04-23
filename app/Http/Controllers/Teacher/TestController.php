<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\SaveTestNameRequest;
use App\Http\Requests\Teacher\SaveTestQuestionRequest;
use App\Http\Requests\Teacher\SaveTextAnswerRequest;
use App\Http\Requests\Teacher\UpdateTextRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TestController extends Controller
{
    public function index(): Response
    {
        $tests = Test::query()
            ->where('teacher_id', Auth::id())
            ->get();

        return Inertia::render('Teacher/Tests/List', ["tests" => $tests]);
    }

    public function showAddTestPage(): Response
    {
        $data['categories'] = Category::query()
            ->where('teacher_id', Auth::id())
            ->get(['id', 'name']);

        return Inertia::render('Teacher/Tests/StoreTest', $data);
    }

    public function showTest(int $id): Response
    {
        $test = Test::query()
            ->findOrFail($id);

        $questions = Question::query()
            ->where('test_id', $test->id)
            ->with('answers')
            ->get();

        $data = [
            'test' => $test,
            'questions' => $questions,
        ];

        return Inertia::render('Teacher/Tests/ShowTest', $data);
    }

    public function showUpdateTestPage(int $id): Response
    {
        $test = Test::query()
            ->findOrFail($id);

        $questions = Question::query()
            ->where('test_id', $test->id)
            ->with('answers')
            ->get();

        $data = [
            'test' => $test,
            'questions' => $questions,
        ];

        return Inertia::render('Teacher/Tests/UpdateTest', $data);
    }

    public function destroy(int $id): Response
    {
        $test = Test::query()
            ->where(
                [
                    'teacher_id' => Auth::id(),
                    'id' => $id,
                ]
            )
            ->first();

        if ($test !== null) {
            $test->delete();
        }

        $tests = Test::query()
            ->where('teacher_id', Auth::id())
            ->get();

        return Inertia::render('Teacher/Tests/List', ["tests" => $tests]);
    }

    public function destroyQuestion(int $id): JsonResponse
    {
        $question = Question::query()->findOrFail($id);

        $questions = Question::query()
            ->where('test_id', $question->test_id);

        if ($questions->count() === 1) {
            return new JsonResponse('Не очень хорошая идея удалять последний вопрос теста. Лучше удалите тест.', ResponseAlias::HTTP_BAD_REQUEST);
        }

        $question->delete();

        return new JsonResponse('ok', ResponseAlias::HTTP_OK);
    }

    public function saveTestName(SaveTestNameRequest $request): JsonResponse
    {
        $data = $request->validated();

        $test = new Test();
        $test->teacher_id = Auth::id();
        $test->category_id = $data['category_id'];
        $test->created_at = Carbon::now();
        $test->name = $data['name'];
        $test->updated_at = Carbon::now();
        $test->save();

        return new JsonResponse(['testId' => $test->id], JsonResponse::HTTP_OK);
    }

    public function saveTestQuestion(SaveTestQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $question = new Question();
        $question->test_id = $data['test_id'];
        $question->created_at = Carbon::now();
        $question->question = $data['test_question'];
        $question->updated_at = Carbon::now();
        $question->save();

        return new JsonResponse(['questionId' => $question->id], JsonResponse::HTTP_OK);
    }

    public function saveTextAnswer(SaveTextAnswerRequest $request): JsonResponse
    {
        $data = $request->validated();

        $answer = new Answer();
        $answer->question_id = $data['question_id'];
        $answer->created_at = Carbon::now();
        $answer->type = 'text';
        $answer->answer = $data['answer'];
        $answer->updated_at = Carbon::now();
        $answer->save();

        return new JsonResponse(['answerId' => $answer->id], JsonResponse::HTTP_OK);
    }

    public function saveMultipleAnswer(Request $request): JsonResponse
    {
        $data = $request->all();

        foreach ($data['answers'] as $answerData) {
            $answer = new Answer();
            $answer->answer = $answerData['text'];
            $answer->question_id = $request->post('question_id');
            $answer->truth = $answerData['truth'];
            $answer->created_at = Carbon::now();
            $answer->type = $request->post('type');
            $answer->save();
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

    public function updateText(UpdateTextRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($data['type'] == 'answer') {
            $answer = Answer::query()->findOrFail($data['id']);
            $answer->updated_at = Carbon::now();
            $answer->answer = $data['text'];
            $answer->save();
        }

        if ($data['type'] == 'question') {
            $question = Question::query()->findOrFail($data['id']);
            $question->updated_at = Carbon::now();
            $question->question = $data['text'];
            $question->save();
        }

        return new JsonResponse('ok', ResponseAlias::HTTP_OK);
    }

    public function updateRightAnswer(Request $request): JsonResponse
    {
        $data = $request->validate([
            "right_answers" => "required|array",
        ]);

        $answer = Answer::query()->findOrFail($data["right_answers"][0]);

        Answer::query()
            ->where('question_id', $answer->question_id)
            ->update(
                [
                    'truth' => 0,
                ]);

        Answer::query()
            ->whereIn('id', $data["right_answers"])
            ->update(
                [
                    'truth' => 1,
                ]);

        return new JsonResponse('ok', ResponseAlias::HTTP_OK);
    }
}
