<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'featuredProducts' => Product::query()
                ->where('is_active', true)
                ->where('stock', '>', 0)
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }

    public function contact(): View
    {
        return view('contact', [
            'instagram' => \App\Models\Setting::get('contact_instagram', 'https://instagram.com/lydam'),
            'tiktok' => \App\Models\Setting::get('contact_tiktok', 'https://tiktok.com/@lydam'),
            'whatsapp' => \App\Models\Setting::get('contact_whatsapp', 'https://wa.me/5491122334455'),
            'faqs' => json_decode(\App\Models\Setting::get('faq_data', '[]'), true),
        ]);
    }
}
