<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (! in_array((int) $request->user()->level, [1, 2], true)) {
            return response()->view('errors.403', [
                'requiredRole' => 'User atau Admin',
            ], 403);
        }

        return $next($request);
    }
}
