<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale', 'es'));
        $availableLocales = config('app.available_locales', ['es', 'en']);

        if (! in_array($locale, $availableLocales, true)) {
            $locale = config('app.fallback_locale', 'es');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
