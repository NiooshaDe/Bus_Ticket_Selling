<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();
//        $userRoles = $user->roles()->pluck('role')->toArray();
        dd($user);
//        $userRoles = $user;
        foreach ($roles as $role) {
            if (!in_array($role, $userRoles)) {
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
            }
        }
        return $next($request);
    }
}
