<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()
                ->latest()
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']['es']);
        $data['is_active'] = $request->boolean('is_active');

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('Producto creado correctamente.'));
    }

    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);

        if ($request->hasFile('image')) {
            if ($product->image_path && ! Str::startsWith($product->image_path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']['es']);
        $data['is_active'] = $request->boolean('is_active');

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('Producto actualizado correctamente.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orderItems()->exists()) {
            $product->update(['is_active' => false]);

            return redirect()
                ->route('admin.products.index')
                ->with('status', __('El producto tiene ventas asociadas, por eso fue desactivado.'));
        }

        if ($product->image_path && ! Str::startsWith($product->image_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('Producto eliminado correctamente.'));
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        $productId = $product?->id;

        if (! $request->filled('slug') && $request->filled('name.es')) {
            $request->merge([
                'slug' => Str::slug($request->input('name.es')),
            ]);
        }

        return $request->validate([
            'name.es' => ['required', 'string', 'max:255'],
            'name.en' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description.es' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
