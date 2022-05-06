<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
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
//        dd('Request', $request, 'request->user', $request->user(), 'request->user->role', $request->user()->role(), 'role->first', $request->user()->role()->first(), 'role from users table', $request->user()->role);
        $userRole = $request->user()->role()->first();
        if($userRole) {
            // Set scope as admin/donor based on user role
            $request->request->add([
                'scope' => $userRole->role
            ]);
        }

        return $next($request);
    }
}
