<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RemoveCsp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only remove CSP headers in local/dev environment
        if (app()->environment('local')) {
            $response->headers->remove('Content-Security-Policy');
            $response->headers->remove('Content-Security-Policy-Report-Only');
        }

        return $response;
    }
}
