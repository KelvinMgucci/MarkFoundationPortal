<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecruiterAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('recruiter')->check()) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Please sign in to access the admin panel.');
        }

        return $next($request);
    }
}
