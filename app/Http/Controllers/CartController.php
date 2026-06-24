<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('cart.index', [
            'cart' => session()->get('cart', []),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if (! $product->is_active) {
            return back()->withErrors(['product' => __('El producto no está disponible.')]);
        }

        $quantity = (int) ($data['quantity'] ?? 1);
        $cart = session()->get('cart', []);
        $productId = (string) $product->id;
        $currentQuantity = (int) ($cart[$productId]['quantity'] ?? 0);
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->withErrors(['quantity' => __('No hay stock suficiente para agregar esa cantidad.')]);
        }

        $cart[$productId] = [
            'product_id' => $product->id,
            'name' => $product->translatedName(),
            'sku' => $product->sku,
            'price' => (float) $product->price,
            'quantity' => $newQuantity,
            'image_path' => $product->image_path,
            'image_url' => $product->imageUrl(),
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('status', __('Producto agregado al carrito.'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);
        $productId = (string) $product->id;

        if (! isset($cart[$productId])) {
            return redirect()->route('cart.index')->withErrors(['cart' => __('El producto no está en el carrito.')]);
        }

        if ((int) $data['quantity'] > $product->stock) {
            return back()->withErrors(['quantity' => __('No hay stock suficiente para esa cantidad.')]);
        }

        $cart[$productId]['quantity'] = (int) $data['quantity'];
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('status', __('Carrito actualizado.'));
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[(string) $product->id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('status', __('Producto eliminado del carrito.'));
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('status', __('Carrito vaciado.'));
    }
}
