<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $userStatus = $request->user()->status;

        if ($userStatus == 'ADMIN') {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
