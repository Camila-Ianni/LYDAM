<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('catalog.index', [
            'products' => Product::query()
                ->where('is_active', true)
                ->latest()
                ->paginate(12),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('catalog.show', [
            'product' => $product,
        ]);
    }
}
