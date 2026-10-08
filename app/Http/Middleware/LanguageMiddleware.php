<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//add
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If a language is stored in the session, apply it; otherwise, use the default language (e.g., English).
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }

        return $next($request);
    }
}
