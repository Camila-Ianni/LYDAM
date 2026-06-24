@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label for="name_es" class="block text-sm font-bold text-stitch-navy">{{ __('messages.product_name_es') }}</label>
        <input id="name_es" name="name[es]" type="text" value="{{ old('name.es', $product->name['es'] ?? '') }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
    </div>

    <div>
        <label for="name_en" class="block text-sm font-bold text-stitch-navy">{{ __('messages.product_name_en') }}</label>
        <input id="name_en" name="name[en]" type="text" value="{{ old('name.en', $product->name['en'] ?? '') }}" class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
    </div>
</div>

<div class="mt-6">
    <label for="slug" class="block text-sm font-bold text-stitch-navy">{{ __('messages.slug') }}</label>
    <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div>
        <label for="description_es" class="block text-sm font-bold text-stitch-navy">{{ __('messages.description_es') }}</label>
        <textarea id="description_es" name="description[es]" rows="5" class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">{{ old('description.es', $product->description['es'] ?? '') }}</textarea>
    </div>

    <div>
        <label for="description_en" class="block text-sm font-bold text-stitch-navy">{{ __('messages.description_en') }}</label>
        <textarea id="description_en" name="description[en]" rows="5" class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">{{ old('description.en', $product->description['en'] ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-3">
    <div>
        <label for="sku" class="block text-sm font-bold text-stitch-navy">{{ __('messages.sku') }}</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
    </div>

    <div>
        <label for="price" class="block text-sm font-bold text-stitch-navy">{{ __('messages.price') }}</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
    </div>

    <div>
        <label for="stock" class="block text-sm font-bold text-stitch-navy">{{ __('messages.stock') }}</label>
        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-[1fr_220px]">
    <div>
        <label for="image" class="block text-sm font-bold text-stitch-navy">{{ __('messages.product_image') }}</label>
        <input id="image" name="image" type="file" accept="image/*" class="mt-2 w-full rounded-xl border border-sky-200 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-full file:border-0 file:bg-stitch-blue file:px-4 file:py-2 file:font-bold file:text-white">
        <p class="mt-2 text-sm text-slate-500">{{ __('messages.image_help') }}</p>
    </div>

    <div class="overflow-hidden rounded-2xl bg-sky-50">
        @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->translatedName() }}" class="h-44 w-full object-cover">
        @else
            <div class="flex h-44 items-center justify-center text-4xl font-black text-stitch-blue">S</div>
        @endif
    </div>
</div>

<label class="mt-6 flex items-center gap-3 rounded-2xl bg-sky-50 p-4">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true)) class="rounded border-sky-300 text-stitch-blue focus:ring-stitch-blue">
    <span class="text-sm font-bold text-stitch-navy">{{ __('messages.product_active') }}</span>
</label>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="rounded-full bg-stitch-hibiscus px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-pink-500">
        {{ $buttonText }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="rounded-full border border-sky-200 px-6 py-3 text-sm font-black uppercase tracking-wide text-stitch-navy hover:bg-sky-50">
        {{ __('messages.cancel') }}
    </a>
</div>
