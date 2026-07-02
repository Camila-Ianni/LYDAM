@csrf

<div class="mt-6">
    <label for="name_es" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Nombre del Producto</label>
    <input id="name_es" name="name[es]" type="text" value="{{ old('name.es', $product->name['es'] ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
</div>

<div class="mt-6 grid gap-6 md:grid-cols-2">
    <div>
        <label for="slug" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.slug') }}</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>
    <div>
        <label for="category_id" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Categoría del Producto</label>
        <select id="category_id" name="category_id" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full appearance-none">
            <option value="">-- Sin Categoría --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
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
        <input id="price" name="price" type="text" value="{{ old('price', $product->price ? number_format((float) $product->price, 2, ',', '.') : '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
    </div>

    <div>
        <label for="cost" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.cost') }}</label>
        <input id="cost" name="cost" type="text" value="{{ old('cost', $product->cost ? number_format((float) $product->cost, 2, ',', '.') : '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imagesInput = document.getElementById('images');
    if (!imagesInput) return;

    // Create AI button container dynamically
    const aiContainer = document.createElement('div');
    aiContainer.className = 'mt-3 flex items-center gap-3';
    aiContainer.innerHTML = `
        <button type="button" id="ai-fill-btn" class="bg-surface-container border border-surface-container-highest text-raw-white font-label-caps text-[10px] py-2 px-4 hover:border-blood-red hover:text-blood-red transition-all duration-200 uppercase tracking-wider hidden">
            Autocompletar campos con IA usando esta imagen
        </button>
        <span id="ai-fill-status" class="font-label-caps text-[10px] text-ash-grey uppercase"></span>
    `;
    imagesInput.parentNode.appendChild(aiContainer);

    const aiFillBtn = document.getElementById('ai-fill-btn');
    const aiFillStatus = document.getElementById('ai-fill-status');

    imagesInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
            aiFillBtn.classList.remove('hidden');
            aiFillStatus.innerText = 'Nueva imagen seleccionada. Haz clic en el botón para analizar.';
        } else {
            aiFillBtn.classList.add('hidden');
            aiFillStatus.innerText = '';
        }
    });

    aiFillBtn.addEventListener('click', async function() {
        const apiKey = "{{ config('services.gemini.key') }}";
        if (!apiKey) {
            alert('La clave de API de Gemini no está configurada en el servidor. Por favor, añádela en tu archivo .env.');
            return;
        }

        const file = imagesInput.files[0];
        if (!file) return;

        aiFillBtn.disabled = true;
        aiFillStatus.innerText = 'Analizando con IA...';

        try {
            const base64Data = await getBase64(file);
            
            const payload = {
                contents: [
                    {
                        parts: [
                            {
                                text: "Analiza la imagen de este producto de ropa. Genera un objeto JSON estructurado que contenga:\n- 'name': Un nombre de producto corto e impactante en español (en mayúsculas) al estilo brutalista / gothic streetwear (ej: 'BAGGY JEAN TRIBAL CROSS', 'REMERÓN VOID WHITE', 'SWEATER OVERSIZED RIP').\n- 'description': Una descripción detallada en español que venda el producto, mencionando la estética brutalista, urbana y de alta calidad (1 o 2 párrafos).\n- 'price': Precio sugerido en pesos argentinos (ARS), razonable y similar a otros productos (entre 120.000 y 550.000 ARS).\n- 'cost': Costo estimado (aproximadamente la mitad o el 40% del precio de venta).\n- 'sku': Un SKU único en mayúsculas (ej: 'LYD-TEE-VOD').\n- 'sizes': Una lista de talles sugeridos separados por coma (ej: 'S, M, L, XL' si es remera/sweater, o '38, 40, 42, 44, 46' si es pantalón/jean).\n- 'stock': Un stock por defecto (número entero entre 10 y 50).\n- 'slug': Un slug amigable para URL generado a partir del nombre en minúsculas y separado por guiones (ej: 'baggy-jean-tribal-cross')."
                            },
                            {
                                inlineData: {
                                    mimeType: file.type,
                                    data: base64Data.split(',')[1]
                                }
                            }
                        ]
                    }
                ],
                generationConfig: {
                    responseMimeType: "application/json"
                }
            };

            const response = await fetch(`https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${apiKey}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const errData = await response.json();
                throw new Error(errData.error?.message || 'Error en la petición de Gemini.');
            }

            const result = await response.json();
            let responseText = result.candidates?.[0]?.content?.parts?.[0]?.text;
            if (!responseText) {
                throw new Error('La IA no devolvió contenido.');
            }

            responseText = responseText.replace(/```json/gi, '').replace(/```/gi, '').trim();
            const productData = JSON.parse(responseText);

            // Populate fields if they exist
            const nameEl = document.getElementById('name_es');
            const slugEl = document.getElementById('slug');
            const descEl = document.getElementById('description_es');
            const skuEl = document.getElementById('sku');
            const priceEl = document.getElementById('price');
            const costEl = document.getElementById('cost');
            const stockEl = document.getElementById('stock');
            const sizesEl = document.getElementById('sizes');

            if (nameEl && productData.name) nameEl.value = productData.name;
            if (slugEl && productData.slug) slugEl.value = productData.slug;
            if (descEl && productData.description) descEl.value = productData.description;
            if (skuEl && productData.sku) skuEl.value = productData.sku;
            if (priceEl && productData.price) priceEl.value = Number(productData.price).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            if (costEl && productData.cost) costEl.value = Number(productData.cost).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            if (stockEl && productData.stock) stockEl.value = productData.stock;
            if (sizesEl && productData.sizes) sizesEl.value = productData.sizes;

            aiFillStatus.innerText = '¡Autocompletado con éxito!';
            aiFillBtn.classList.add('hidden');
        } catch (error) {
            console.error(error);
            aiFillStatus.innerText = `Error: ${error.message}`;
            alert(`Error al analizar la imagen con IA: ${error.message}`);
        } finally {
            aiFillBtn.disabled = false;
        }
    });

    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
    }
});
</script>
