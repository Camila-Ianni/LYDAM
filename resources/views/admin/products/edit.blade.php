@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.admin_panel') }}</span>
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">{{ __('messages.edit_product') }}</h1>
    </div>
    @if($product->imageUrl())
        <button type="button" id="ai-edit-analyze-btn" class="bg-surface-container border border-surface-container-highest text-raw-white font-label-caps text-xs py-3 px-6 hover:border-blood-red hover:text-blood-red transition-all duration-200 uppercase tracking-widest text-center shrink-0">
            Optimizar campos con IA
        </button>
    @endif
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-surface-container-low border border-surface-container-highest p-8">
    @method('PUT')
    @include('admin.products._form', [
        'product' => $product,
        'buttonText' => __('messages.update_product'),
    ])
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiEditBtn = document.getElementById('ai-edit-analyze-btn');
    if (!aiEditBtn) return;

    aiEditBtn.addEventListener('click', async function() {
        const apiKey = "{{ config('services.gemini.key') }}";
        if (!apiKey) {
            alert('La clave de API de Gemini no está configurada en el servidor. Por favor, añádela en tu archivo .env.');
            return;
        }

        const originalText = aiEditBtn.innerText;
        aiEditBtn.disabled = true;
        aiEditBtn.innerText = 'OBTENIENDO IMAGEN...';

        try {
            // Step 1: Fetch base64 of the existing image from server
            const imageResponse = await fetch("{{ route('admin.products.image-base64', $product) }}");
            if (!imageResponse.ok) {
                throw new Error('No se pudo recuperar la imagen del servidor.');
            }
            
            const imageData = await imageResponse.json();
            if (imageData.error) {
                throw new Error(imageData.error);
            }

            aiEditBtn.innerText = 'ANALIZANDO CON IA...';

            // Step 2: Call Gemini API
            const payload = {
                contents: [
                    {
                        parts: [
                            {
                                text: "Analiza la imagen de este producto de ropa. Genera un objeto JSON estructurado que contenga:\n- 'name': Un nombre de producto corto e impactante en español (en mayúsculas) al estilo brutalista / gothic streetwear (ej: 'BAGGY JEAN TRIBAL CROSS', 'REMERÓN VOID WHITE', 'SWEATER OVERSIZED RIP').\n- 'description': Una descripción detallada en español que venda el producto, mencionando la estética brutalista, urbana y de alta calidad (1 o 2 párrafos).\n- 'price': Precio sugerido en pesos argentinos (ARS), razonable y similar a otros productos (entre 120.000 y 550.000 ARS).\n- 'cost': Costo estimado (aproximadamente la mitad o el 40% del precio de venta).\n- 'sku': Un SKU único en mayúsculas (ej: 'LYD-TEE-VOD').\n- 'sizes': Una lista de talles sugeridos separados por coma (ej: 'S, M, L, XL' si es remera/sweater, o '38, 40, 42, 44, 46' si es pantalón/jean).\n- 'stock': Un stock por defecto (número entero entre 10 y 50).\n- 'slug': Un slug amigable para URL generado a partir del nombre en minúsculas y separado por guiones (ej: 'baggy-jean-tribal-cross')."
                            },
                            {
                                inlineData: {
                                    mimeType: imageData.mime_type,
                                    data: imageData.base64
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

            // Populate Form Fields
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
            if (priceEl && productData.price) priceEl.value = productData.price;
            if (costEl && productData.cost) costEl.value = productData.cost;
            if (stockEl && productData.stock) stockEl.value = productData.stock;
            if (sizesEl && productData.sizes) sizesEl.value = productData.sizes;

            alert('¡Los campos del producto fueron optimizados con éxito usando la IA!');

        } catch (error) {
            console.error(error);
            alert(`Error al analizar el producto con IA: ${error.message}`);
        } finally {
            aiEditBtn.disabled = false;
            aiEditBtn.innerText = originalText;
        }
    });
});
</script>
@endsection
