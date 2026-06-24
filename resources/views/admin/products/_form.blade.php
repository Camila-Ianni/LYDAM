@csrf

<div class="mt-6">
    <label for="name_es" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Nombre del Producto</label>
    <input id="name_es" name="name[es]" type="text" value="{{ old('name.es', $product->name['es'] ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
</div>

<div class="mt-6">
    <label for="slug" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.slug') }}</label>
    <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
</div>

<div class="mt-6">
    <label for="description_es" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Descripción</label>
    <textarea id="description_es" name="description[es]" rows="5" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">{{ old('description.es', $product->description['es'] ?? '') }}</textarea>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-4">
    <div>
        <label for="sku" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.sku') }}</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="price" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.price') }}</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="cost" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.cost') }}</label>
        <input id="cost" name="cost" type="number" step="0.01" min="0" value="{{ old('cost', $product->cost) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="stock" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.stock') }}</label>
        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>
</div>

<div class="mt-6">
    <label for="sizes" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Talles incluidos en la curva</label>
    <input id="sizes" name="sizes" type="text" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}" placeholder="Ej: 38, 40, 42, 44, 46 o S, M, L, XL" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    <p class="mt-2 text-xs text-ash-grey font-label-caps">Ingresá los talles separados por coma para que los clientes sepan qué talles incluye cada curva.</p>
</div>

<div class="mt-6">
    <label for="images" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Imágenes del Producto (Subir una o más)</label>
    <input id="images" name="images[]" type="file" accept="image/*" multiple class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full file:bg-blood-red file:border-none file:text-raw-white file:px-4 file:py-2 file:font-bold file:cursor-pointer uppercase file:font-label-caps">
    <p class="mt-2 text-xs text-ash-grey font-label-caps">Formatos soportados: JPG, PNG, WEBP, GIF. Podés seleccionar múltiples archivos. Máximo recomendado: 8MB por imagen.</p>
</div>

@if(!empty($product->imageUrls()))
    <div class="mt-6">
        <span class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-3">Imágenes Actuales (Marcar para eliminar)</span>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($product->imageUrls() as $index => $url)
                <div class="relative border border-surface-container-highest bg-void-black p-2 flex flex-col items-center">
                    <img src="{{ $url }}" class="h-28 w-full object-contain mb-2 bg-black/40">
                    <label class="inline-flex items-center gap-2 cursor-pointer mt-1 select-none">
                        <input type="checkbox" name="delete_images[]" value="{{ $index }}" class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none">
                        <span class="font-label-caps text-[10px] text-ash-grey hover:text-blood-red transition-colors uppercase">Eliminar</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endif

<label class="mt-6 flex items-center gap-3 border border-surface-container-highest bg-void-black p-4 rounded-none cursor-pointer group">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none">
    <span class="font-label-caps text-label-caps text-ash-grey group-hover:text-raw-white transition-colors">{{ __('messages.product_active') }}</span>
</label>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="bg-blood-red text-raw-white font-label-caps text-xs py-3 px-6 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-200 uppercase tracking-widest">
        {{ $buttonText }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="bg-void-black border border-surface-container-highest px-6 py-3 text-xs font-label-caps text-raw-white hover:border-blood-red hover:text-blood-red transition-colors uppercase">
        {{ __('messages.cancel') }}
    </a>
</div>
