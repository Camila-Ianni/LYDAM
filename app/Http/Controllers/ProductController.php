<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        // 1. If category is not selected and not an AJAX call, display category grid
        if (! $request->has('category') && ! $request->ajax()) {
            $categories = Category::all();
            return view('catalog.index', [
                'categories' => $categories,
                'selectedCategory' => null
            ]);
        }

        $query = Product::query()->where('is_active', true);
        $selectedCategory = null;

        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $selectedCategory = Category::where('slug', $categorySlug)->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        // 2. Price Filter
        if ($request->has('prices')) {
            $prices = (array) $request->input('prices');
            $query->where(function ($q) use ($prices) {
                $first = true;
                if (in_array('less_300k', $prices)) {
                    $q->where('price', '<', 300000);
                    $first = false;
                }
                if (in_array('300k_600k', $prices)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clause(function ($sub) {
                        $sub->where('price', '>=', 300000)
                            ->where('price', '<=', 600000);
                    });
                    $first = false;
                }
                if (in_array('more_600k', $prices)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clause('price', '>', 600000);
                }
            });
        }

        // 3. Curve Type Filter
        if ($request->has('curves')) {
            $curves = (array) $request->input('curves');
            $query->where(function ($q) use ($curves) {
                $first = true;
                if (in_array('x5', $curves)) {
                    $q->whereRaw('json_array_length(sizes) = 5');
                    $first = false;
                }
                if (in_array('x6', $curves)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clauseRaw('json_array_length(sizes) = 6');
                    $first = false;
                }
                if (in_array('x10', $curves)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clauseRaw('json_array_length(sizes) NOT IN (5, 6)');
                }
            });
        }

        $products = $query->latest()->paginate(48);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('catalog._product_grid', compact('products'))->render()
            ]);
        }

        return view('catalog.index', [
            'products' => $products,
            'selectedCategory' => $selectedCategory,
            'categories' => Category::all(),
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
