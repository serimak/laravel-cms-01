<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
        if (!env('REDIRECT_HTTPS')) {

            return $next($request);
        } else {

        	return redirect()->secure($request->getRequestUri());
        }
    }
}
?>