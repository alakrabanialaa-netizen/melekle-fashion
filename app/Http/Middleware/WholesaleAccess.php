<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WholesaleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('wholesale_access_code_id')) {
            return redirect()->route('wholesale.login')->with('error', 'يرجى إدخال كود التاجر أولاً.');
        }

        return $next($request);
    }
}
