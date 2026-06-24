@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label for="name_es" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.product_name_es') }}</label>
        <input id="name_es" name="name[es]" type="text" value="{{ old('name.es', $product->name['es'] ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="name_en" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.product_name_en') }}</label>
        <input id="name_en" name="name[en]" type="text" value="{{ old('name.en', $product->name['en'] ?? '') }}" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>
</div>

<div class="mt-6">
    <label for="slug" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.slug') }}</label>
    <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-2">
    <div>
        <label for="description_es" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.description_es') }}</label>
        <textarea id="description_es" name="description[es]" rows="5" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">{{ old('description.es', $product->description['es'] ?? '') }}</textarea>
    </div>

    <div>
        <label for="description_en" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.description_en') }}</label>
        <textarea id="description_en" name="description[en]" rows="5" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">{{ old('description.en', $product->description['en'] ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 grid gap-6 md:grid-cols-3">
    <div>
        <label for="sku" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.sku') }}</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product->sku) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="price" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.price') }}</label>
        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $product->price) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="stock" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.stock') }}</label>
        <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-[1fr_220px]">
    <div>
        <label for="image" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.product_image') }}</label>
        <input id="image" name="image" type="file" accept="image/*" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full file:bg-blood-red file:border-none file:text-raw-white file:px-4 file:py-2 file:font-bold file:cursor-pointer uppercase file:font-label-caps">
        <p class="mt-2 text-xs text-ash-grey font-label-caps">{{ __('messages.image_help') }}</p>
    </div>

    <div class="overflow-hidden border border-surface-container-highest bg-void-black">
        @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->translatedName() }}" class="h-44 w-full object-cover">
        @else
            <div class="flex h-44 items-center justify-center text-4xl font-headline-lg text-blood-red">LYDAM</div>
        @endif
    </div>
</div>

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
