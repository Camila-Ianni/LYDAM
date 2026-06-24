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

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('products', 'public');
            }
        }
        $data['image_path'] = !empty($imagePaths) ? json_encode($imagePaths) : null;

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

        $currentPaths = [];
        if ($product->image_path) {
            $decoded = json_decode($product->image_path, true);
            $currentPaths = is_array($decoded) ? $decoded : [$product->image_path];
        }

        if ($request->has('delete_images') && is_array($request->input('delete_images'))) {
            $indicesToDelete = array_map('intval', $request->input('delete_images'));
            rsort($indicesToDelete);
            foreach ($indicesToDelete as $index) {
                if (isset($currentPaths[$index])) {
                    $pathToDelete = $currentPaths[$index];
                    if ($pathToDelete && ! Str::startsWith($pathToDelete, ['http://', 'https://'])) {
                        Storage::disk('public')->delete($pathToDelete);
                    }
                    unset($currentPaths[$index]);
                }
            }
            $currentPaths = array_values($currentPaths);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentPaths[] = $image->store('products', 'public');
            }
        }

        $data['image_path'] = !empty($currentPaths) ? json_encode($currentPaths) : null;
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

        if ($product->image_path) {
            $decoded = json_decode($product->image_path, true);
            $paths = is_array($decoded) ? $decoded : [$product->image_path];
            foreach ($paths as $path) {
                if ($path && ! Str::startsWith($path, ['http://', 'https://'])) {
                    Storage::disk('public')->delete($path);
                }
            }
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
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description.es' => ['nullable', 'string'],
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:8192'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
