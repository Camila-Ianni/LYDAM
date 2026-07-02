<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function aiUpload(): View
    {
        return view('admin.products.ai-upload', [
            'product' => new Product(),
            'categories' => Category::all(),
        ]);
    }

    public function getProductImageBase64(Product $product): \Illuminate\Http\JsonResponse
    {
        $imageUrl = $product->imageUrl();
        if (!$imageUrl) {
            return response()->json(['error' => 'No image found'], 404);
        }

        try {
            $imageContent = file_get_contents($imageUrl);
            if ($imageContent === false) {
                return response()->json(['error' => 'Failed to read image'], 500);
            }
            
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageContent);
            $base64 = base64_encode($imageContent);
            
            return response()->json([
                'mime_type' => $mimeType,
                'base64' => $base64
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => Category::all(),
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

        $sizesString = $request->input('sizes');
        $data['sizes'] = $sizesString ? array_filter(array_map('trim', explode(',', $sizesString))) : [];

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
            'categories' => Category::all(),
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

        $sizesString = $request->input('sizes');
        $data['sizes'] = $sizesString ? array_filter(array_map('trim', explode(',', $sizesString))) : [];

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', __('Producto actualizado correctamente.'));
    }

    public function destroy(Product $product): RedirectResponse
    {
        // 1. Get associated order items and unique order IDs
        $orderItems = $product->orderItems;
        $orderIds = $orderItems->pluck('order_id')->unique();

        // 2. Delete linked order items
        $product->orderItems()->delete();

        // 3. Delete any orders that are left with zero items
        foreach ($orderIds as $orderId) {
            $order = \App\Models\Order::find($orderId);
            if ($order && $order->items()->count() === 0) {
                $order->delete();
            }
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

        if ($request->has('price')) {
            $request->merge([
                'price' => $this->parseLocalizedNumber($request->input('price')),
            ]);
        }

        if ($request->has('cost')) {
            $request->merge([
                'cost' => $this->parseLocalizedNumber($request->input('cost')),
            ]);
        }

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
            'sizes' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:8192'],
            'is_active' => ['nullable', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);
    }

    private function parseLocalizedNumber($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        // Remove spaces
        $value = str_replace(' ', '', $value);

        // If contains both dot and comma (e.g. 120.000,00)
        if (strpos($value, '.') !== false && strpos($value, ',') !== false) {
            if (strrpos($value, ',') > strrpos($value, '.')) {
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
            } else {
                $value = str_replace(',', '', $value);
            }
        } else {
            // Contains only comma
            if (strpos($value, ',') !== false) {
                $parts = explode(',', $value);
                if (strlen(end($parts)) === 3) {
                    $value = str_replace(',', '', $value);
                } else {
                    $value = str_replace(',', '.', $value);
                }
            } else if (strpos($value, '.') !== false) {
                // Contains only dot (e.g. 120.000)
                $parts = explode('.', $value);
                if (strlen(end($parts)) === 3) {
                    $value = str_replace('.', '', $value);
                }
            }
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
