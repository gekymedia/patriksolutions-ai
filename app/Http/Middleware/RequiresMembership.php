<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequiresMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->hasCourseAccess()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An active membership is required to access courses.',
                    'upgrade_url' => route('membership.index'),
                ], 403);
            }

            return redirect()->route('membership.index')
                ->with('upgrade_message', 'Become a member to enroll in courses and unlock the AI tutor.');
        }

        return $next($request);
    }
}
