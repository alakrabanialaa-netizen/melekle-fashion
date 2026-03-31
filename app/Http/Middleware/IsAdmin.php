<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->is_admin) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'ليس لديك صلاحية الدخول']);
        }

        return $next($request);
    }
}
