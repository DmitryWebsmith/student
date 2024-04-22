<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\DeleteTaskRequest;
use App\Http\Requests\Teacher\StoreTaskRequest;
use App\Models\Category;
use App\Models\Group;
use App\Models\Task;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $tasks = Task::query()
            ->where('teacher_id', Auth::id())
            ->with(['test', 'group'])
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render('Teacher/Tasks/List', ["tasks" => $tasks]);
    }

    public function showTask($id): Response
    {
        logger("TaskController | showTask", ["id" => $id]);

        $task = Task::query()
            ->where('id', $id)
            ->where('teacher_id', Auth::id())
            ->with(['test', 'test_passed'])
            ->get();

        logger("TaskController | showTask", ["task" => $task]);

        return Inertia::render('Teacher/Tasks/ShowTask', ["task" => $task]);
    }

    public function getTestsByCategory(Request $request): JsonResponse
    {
        $tests = Test::query()
            ->where('teacher_id', Auth::id())
            ->where('category_id', $request->post('category_id'))
            ->get(['id', 'name']);

        return new JsonResponse(
            [
                'tests' => $tests,
            ], JsonResponse::HTTP_OK
        );
    }

    public function addTask(): Response
    {
        $data['categories'] = Category::query()
            ->where('teacher_id', Auth::id())
            ->get(['id', 'name']);

        $data['groups'] = Group::query()
            ->where('teacher_id', Auth::id())
            ->get(['id', 'name']);

        return Inertia::render('Teacher/Tasks/AddTask', $data);
    }

    public function store(StoreTaskRequest $request): Response
    {
        $task = new Task();
        $task->teacher_id = Auth::id();
        $task->group_id = $request->post('group')['value'];
        $task->test_id = $request->post('test')['value'];
        $task->start_time = Carbon::parse($request->post('date_time'));
        $task->end_time = Carbon::parse($task->start_time)->addMinutes($request->post('duration'));
        $task->created_at = Carbon::now();
        $task->save();

        $tasks = Task::query()
            ->with(['test', 'group'])
            ->where('teacher_id', Auth::id())
            ->get();

        return Inertia::render('Teacher/Tasks/List', ["tasks" => $tasks]);
    }

    public function destroy(DeleteTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Task::query()
            ->where('id', $data['id'])
            ->delete();

        return redirect()->route('tasks');
    }
}
