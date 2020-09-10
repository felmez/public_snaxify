<?php

namespace App\Http\Middleware;

use Closure;

class CustomerMiddleware
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
    //     if ($request->user() && $request->user()->role != 'customer') {
    //         return new Response(view("unauthorized")->with('role', 'CUSTOMER')
    //         );
    //     }
    //     return $next($request);
    // }
}
