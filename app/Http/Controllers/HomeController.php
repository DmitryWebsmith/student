<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): RedirectResponse|Response
    {
        if (!Auth::check()) {
            return Inertia::render(
                'Home',
                [
                    'canResetPassword' => Route::has('password.request'),
                    'status' => session('status'),
                ]
            );
        }

        if (App(RoleService::class)->isStudent()) {
            return redirect()->intended(route('student.dashboard', absolute: false));
        }

        return redirect()->intended(route('groups', absolute: false));
    }
}
