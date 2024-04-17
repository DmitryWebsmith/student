<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Task;
use App\Services\DateFormatService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $data['student'] = Student::query()
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data['current_time'] = $currentTime = App(DateFormatService::class)->getLocalDateTime(Carbon::now()->format('Y-m-d H:i:s'));

        $data['tasks'] = Task::query()
            ->with(['test', 'group', 'test_passed'])
            ->where('end_time', '>' , $currentTime)
            ->get();

        $data['message'] = '';

        return Inertia::render('Student/Dashboard/index', $data);
    }
}
