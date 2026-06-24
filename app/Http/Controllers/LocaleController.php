<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if (! in_array($locale, config('app.available_locales', ['es', 'en']), true)) {
            abort(404);
        }

        session()->put('locale', $locale);

        return back()->with('status', __('Idioma actualizado.'));
    }
}
