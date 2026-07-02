<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'bank_holder' => Setting::get('bank_holder', 'LYDAM Store'),
            'bank_name' => Setting::get('bank_name', 'Banco de la Nación Argentina'),
            'bank_cbu' => Setting::get('bank_cbu', '0000003100098765432101'),
            'bank_alias_1' => Setting::get('bank_alias_1', 'LYDAM.TRIBAL.UNO'),
            'bank_alias_2' => Setting::get('bank_alias_2', 'LYDAM.TRIBAL.DOS'),
            'bank_threshold' => Setting::get('bank_threshold', '300000'),
            'bank_receipt_email' => Setting::get('bank_receipt_email', 'hello@lydam.com'),
            'contact_instagram' => Setting::get('contact_instagram', 'https://instagram.com/lydam'),
            'contact_tiktok' => Setting::get('contact_tiktok', 'https://tiktok.com/@lydam'),
            'contact_whatsapp' => Setting::get('contact_whatsapp', 'https://wa.me/5491122334455'),
            'contact_maps' => Setting::get('contact_maps', 'https://maps.app.goo.gl/GkTdDPHLtpZ8qmbz7'),
            'faq_data' => Setting::get('faq_data', '[]'),
            'categories' => \App\Models\Category::all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'bank_holder' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_cbu' => ['required', 'string', 'max:50'],
            'bank_alias_1' => ['required', 'string', 'max:255'],
            'bank_alias_2' => ['required', 'string', 'max:255'],
            'bank_threshold' => ['required', 'numeric', 'min:0'],
            'bank_receipt_email' => ['required', 'email', 'max:255'],
            'contact_instagram' => ['nullable', 'string', 'max:500'],
            'contact_tiktok' => ['nullable', 'string', 'max:500'],
            'contact_whatsapp' => ['nullable', 'string', 'max:500'],
            'contact_maps' => ['nullable', 'string', 'max:500'],
            'faq_data' => ['nullable', 'string'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        // Handle Category Images
        if ($request->hasFile('categories')) {
            foreach ($request->file('categories') as $catId => $catData) {
                if (isset($catData['image'])) {
                    $category = \App\Models\Category::find($catId);
                    if ($category) {
                        $path = $catData['image']->store('categories', 'public');
                        $category->image_path = $path;
                        $category->save();
                    }
                }
            }
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', __('Configuraciones actualizadas correctamente.'));
    }
}
