<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminOrAgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $roleId = (int) session('role_id');

    if (
        $roleId === config('constants.roles.admin') ||
        $roleId === config('constants.roles.agent')
    ) {
        return $next($request);
    }

    return redirect('/')->with('error', 'Unauthorized access');
}
}
