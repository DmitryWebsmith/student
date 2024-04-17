<?php

namespace App\Http\Middleware;

use App\Services\RoleService;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class TeacherAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$this->auth->user()) {
            return route('index');
        }

        if (app(RoleService::class)->isTeacher()) {
            return $next($request);
        }

        return route('index');
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('index');
    }
}
