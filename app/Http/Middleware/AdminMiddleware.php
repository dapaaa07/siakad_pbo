<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ((int) $request->user()->level !== 1) {
            return response()->view('errors.403', [
                'requiredRole' => 'Admin',
            ], 403);
        }

        return $next($request);
    }
}
