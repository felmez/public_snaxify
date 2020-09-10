<?php

namespace App\Http\Middleware;

use Closure;

class AdjustDomain
{
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
        if (app()->environment('production')) {
            if (str_is('www.*', $request->header('Host'))) {
                $parsedUrl = parse_url(config('app.url'));
                $request->headers->set('Host', $parsedUrl['host']);

                if ( ! $request->secure() && $parsedUrl['scheme'] === 'https') {
                    return redirect()->secure($request->path(), 301);
                }

                return redirect($request->path(), 301);
            }
        }

        return $next($request);
    }
}
