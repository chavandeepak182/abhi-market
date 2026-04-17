<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class IsAgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle(Request $request, Closure $next): Response
{
    $sessionRole = session('role_id');
    $agentRole   = config('constants.roles.agent');

    Log::info('IsAgentMiddleware Check', [
        'session_role_id' => $sessionRole,
        'agent_role_id'   => $agentRole,
        'url'             => $request->fullUrl(),
    ]);

    if ((int)$sessionRole === (int)$agentRole) {
        Log::info('IsAgentMiddleware: ACCESS GRANTED');
        return $next($request);
    }

    Log::warning('IsAgentMiddleware: ACCESS DENIED');

    return redirect('/')->with('error', 'Unauthorized access');
}
}
