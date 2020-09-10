<?php

namespace App\Http\Middleware;

use App\ApiToken;
use App\ApiUser;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AppUserAuth
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiToken = ApiToken::where('token', $request->header('token'))->first();
        if ($apiToken != null) {
            Auth::guard('app_users')->login($apiToken->customer);
            $request->user = $apiToken->customer;

            return $next($request);
        }

        return response()->json(['error' => 'Not authorized'], 401);
    }
}
