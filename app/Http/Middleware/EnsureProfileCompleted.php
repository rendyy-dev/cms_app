<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            auth()->check() &&
            auth()->user()->email_verified_at !== null &&
            ! auth()->user()->profile_completed
        ) {
            return redirect()->route('profile.complete');
        }

        return $next($request);
    }
}
