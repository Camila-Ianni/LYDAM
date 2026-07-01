<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View|\Illuminate\Http\JsonResponse
    {
        $query = Product::query()->where('is_active', true);

        // 1. Category Filter
        if ($request->has('categories')) {
            $categories = (array) $request->input('categories');
            $query->where(function ($q) use ($categories) {
                $first = true;
                if (in_array('pantalones', $categories)) {
                    $q->where(function ($sub) {
                        $sub->where('name', 'like', '%jean%')
                            ->orWhere('name', 'like', '%pants%')
                            ->orWhere('name', 'like', '%baggy%')
                            ->orWhere('name', 'like', '%denim%')
                            ->orWhere('name', 'like', '%pantalon%');
                    });
                    $first = false;
                }
                if (in_array('remeras', $categories)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clause(function ($sub) {
                        $sub->where('name', 'like', '%tee%')
                            ->orWhere('name', 'like', '%remera%')
                            ->orWhere('name', 'like', '%remeron%')
                            ->orWhere('name', 'like', '%shirt%')
                            ->orWhere('name', 'like', '%cyber%');
                    });
                    $first = false;
                }
                if (in_array('sweaters', $categories)) {
                    $clause = $first ? 'where' : 'orWhere';
                    $q->$clause(function ($sub) {
                        $sub->where('name', 'like', '%sweater%');
                    });
                }
            });
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

        return view('catalog.index', compact('products'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('catalog.show', [
            'product' => $product,
        ]);
    }
}
