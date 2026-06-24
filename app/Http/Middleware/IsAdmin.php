<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (! $request->user()?->is_admin) {
            return redirect()
                ->route('home')
                ->withErrors(['admin' => __('No tenés permisos para acceder al panel de administración.')]);
        }

        return $next($request);
    }
}
