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
}
