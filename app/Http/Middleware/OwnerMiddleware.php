<?php

namespace App\Http\Middleware;

use Closure;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // role attach or handle for user role
    // public function handle($request, Closure $next)
    // {
    //     if ($request->user() && $request->user()->role != 'owner') {
    //         return new Response(view("unauthorized")->with('role', 'OWNER')
    //         );
    //     }
    //     return $next($request);
    // }
}
