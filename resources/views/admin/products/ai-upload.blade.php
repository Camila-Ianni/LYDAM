@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.admin_panel') }}</span>
            <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">Crear Producto con IA</h1>
            <p class="text-ash-grey text-sm mt-1 font-label-caps">Subí una foto de tu prenda y nuestra IA generará el nombre, descripción, SKU, precio, costo y talles automáticamente.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="bg-void-black border border-surface-container-highest px-6 py-3 text-xs font-label-caps text-raw-white hover:border-blood-red hover:text-blood-red transition-colors uppercase text-center shrink-0">
            Volver al listado
        </a>
    </div>
</div>

<div class="grid gap-8 lg:grid-cols-12">
    <!-- LEFT: IMAGE UPLOAD AND PREVIEW -->
    <div class="lg:col-span-4 flex flex-col gap-6">
        <div class="bg-surface-container-low border border-surface-container-highest p-6 flex flex-col items-center">
            <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-4">Paso 1: Carga la imagen</span>
            
            <div id="drop-zone" class="w-full aspect-square border-2 border-dashed border-surface-container-highest hover:border-blood-red transition-colors flex flex-col items-center justify-center p-4 text-center cursor-pointer bg-void-black relative group">
                <input type="file" id="ai-image-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                <div class="flex flex-col items-center gap-3 z-0" id="upload-placeholder">
                    <span class="material-symbols-outlined text-blood-red text-4xl group-hover:scale-110 transition-transform">image</span>
                    <p class="font-label-caps text-xs text-raw-white uppercase tracking-wider">Arrastrá una foto aquí o haz clic para buscar</p>
                    <p class="text-[10px] text-ash-grey font-label-caps">Formatos: JPG, PNG, WEBP, GIF</p>
                </div>
                <img id="image-preview" class="hidden w-full h-full object-contain z-0" alt="Vista previa del producto">
            </div>
            
            <button type="button" id="analyze-btn" disabled class="mt-6 w-full bg-void-black border border-surface-container-highest text-ash-grey font-label-caps text-xs py-3 px-6 hover:border-blood-red hover:text-blood-red transition-all duration-200 uppercase tracking-widest disabled:opacity-50 disabled:cursor-not-allowed text-center">
                Analizar con IA
            </button>
        </div>

        <!-- AI STATUS PANEL -->
        <div id="status-panel" class="bg-surface-container-low border border-surface-container-highest p-6 hidden">
            <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-3 block">Estado de la IA</span>
            <div class="flex items-center gap-4">
                <div id="status-spinner" class="h-6 w-6 border-2 border-blood-red border-t-transparent animate-spin rounded-full hidden"></div>
                <span id="status-icon" class="material-symbols-outlined text-blood-red text-2xl">info</span>
                <span id="status-text" class="font-label-caps text-xs text-raw-white uppercase tracking-wider">Esperando inicio...</span>
            </div>
            <div id="progress-bar-container" class="w-full bg-void-black h-1.5 mt-4 border border-surface-container-highest overflow-hidden hidden">
                <div id="progress-bar" class="bg-blood-red h-full w-0 transition-all duration-300"></div>
            </div>
        </div>
    </div>

    <!-- RIGHT: PRODUCT FORM PREFILL -->
    <div class="lg:col-span-8">
        <form id="ai-product-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-surface-container-low border border-surface-container-highest p-8 relative">
            <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-4 block">Paso 2: Revisa y confirma los detalles</span>
            
            <!-- Standard form inputs -->
            @include('admin.products._form', [
                'product' => $product,
                'buttonText' => __('messages.save_product'),
            ])

            <!-- Hidden duplicate file input to bind the image to the form submit -->
            <input type="file" id="hidden-image-submit" name="images[]" class="hidden">
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('ai-image-input');
    const dropZone = document.getElementById('drop-zone');
    const imagePreview = document.getElementById('image-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const analyzeBtn = document.getElementById('analyze-btn');
    
    const statusPanel = document.getElementById('status-panel');
    const statusSpinner = document.getElementById('status-spinner');
    const statusIcon = document.getElementById('status-icon');
    const statusText = document.getElementById('status-text');
    const progressBarContainer = document.getElementById('progress-bar-container');
    const progressBar = document.getElementById('progress-bar');
    
    const productForm = document.getElementById('ai-product-form');
    const hiddenImageSubmit = document.getElementById('hidden-image-submit');
    
    let selectedFile = null;

    // Handle Image Input Selection
    imageInput.addEventListener('change', handleFileSelect);

    // Drag & Drop effects
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blood-red');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blood-red');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blood-red');
        if (e.dataTransfer.files.length) {
            imageInput.files = e.dataTransfer.files;
            handleFileSelect({ target: imageInput });
        }
    });

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        selectedFile = file;

        // Show preview
        const reader = new FileReader();
        reader.onload = function(event) {
            imagePreview.src = event.target.result;
            imagePreview.classList.remove('hidden');
            uploadPlaceholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);

        // Bind this file to the hidden file input inside the form so Laravel store route receives it
        const dt = new DataTransfer();
        dt.items.add(file);
        hiddenImageSubmit.files = dt.files;

        // Enable analyze button
        analyzeBtn.disabled = false;
        analyzeBtn.classList.remove('bg-void-black', 'text-ash-grey');
        analyzeBtn.classList.add('bg-blood-red', 'text-raw-white', 'border-blood-red');
    }

    // Analyze with IA
    analyzeBtn.addEventListener('click', async function() {
        const apiKey = "{{ config('services.gemini.key') }}";
        if (!apiKey) {
            alert('La clave de API de Gemini no está configurada en el servidor. Por favor, añádela en tu archivo .env.');
            return;
        }

        if (!selectedFile) {
            alert('Por favor, selecciona una imagen primero.');
            return;
        }

        // Show status panel
        statusPanel.classList.remove('hidden');
        statusSpinner.classList.remove('hidden');
        statusIcon.classList.add('hidden');
        progressBarContainer.classList.remove('hidden');
        progressBar.style.width = '20%';
        statusText.innerText = 'Leyendo archivo de imagen...';

        try {
            // Read image as base64
            const base64Data = await getBase64(selectedFile);
            progressBar.style.width = '40%';
            statusText.innerText = 'Enviando imagen a Gemini AI...';

            const payload = {
                contents: [
                    {
                        parts: [
                            {
                                text: "Analiza la imagen de este producto de ropa. Genera un objeto JSON estructurado que contenga:\n- 'name': Un nombre de producto corto e impactante en español (en mayúsculas) al estilo brutalista / gothic streetwear (ej: 'BAGGY JEAN TRIBAL CROSS', 'REMERÓN VOID WHITE', 'SWEATER OVERSIZED RIP').\n- 'description': Una descripción detallada en español que venda el producto, mencionando la estética brutalista, urbana y de alta calidad (1 o 2 párrafos).\n- 'price': Precio sugerido en pesos argentinos (ARS), razonable y similar a otros productos (entre 120.000 y 550.000 ARS).\n- 'cost': Costo estimado (aproximadamente la mitad o el 40% del precio de venta).\n- 'sku': Un SKU único en mayúsculas (ej: 'LYD-TEE-VOD').\n- 'sizes': Una lista de talles sugeridos separados por coma (ej: 'S, M, L, XL' si es remera/sweater, o '38, 40, 42, 44, 46' si es pantalón/jean).\n- 'stock': Un stock por defecto (número entero entre 10 y 50).\n- 'slug': Un slug amigable para URL generado a partir del nombre en minúsculas y separado por guiones (ej: 'baggy-jean-tribal-cross')."
                            },
                            {
                                inlineData: {
                                    mimeType: selectedFile.type,
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

            progressBar.style.width = '60%';
            statusText.innerText = 'Procesando respuesta...';

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

            progressBar.style.width = '80%';
            const result = await response.json();
            
            // Extract text
            let responseText = result.candidates?.[0]?.content?.parts?.[0]?.text;
            if (!responseText) {
                throw new Error('La IA no devolvió contenido.');
            }

            // Parse response JSON
            responseText = responseText.replace(/```json/gi, '').replace(/```/gi, '').trim();
            const productData = JSON.parse(responseText);

            // Populate Form Fields
            document.getElementById('name_es').value = productData.name || '';
            document.getElementById('slug').value = productData.slug || '';
            document.getElementById('description_es').value = productData.description || '';
            document.getElementById('sku').value = productData.sku || '';
            document.getElementById('price').value = productData.price ? Number(productData.price).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '';
            document.getElementById('cost').value = productData.cost ? Number(productData.cost).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '';
            document.getElementById('stock').value = productData.stock || '15';
            document.getElementById('sizes').value = productData.sizes || '';

            progressBar.style.width = '100%';
            statusSpinner.classList.add('hidden');
            statusIcon.classList.remove('hidden', 'text-blood-red');
            statusIcon.innerText = 'check_circle';
            statusIcon.style.color = '#ff0000'; // Blood red color
            statusText.innerText = '¡Análisis completo! Campos rellenados.';

        } catch (error) {
            console.error(error);
            progressBar.style.width = '0%';
            statusSpinner.classList.add('hidden');
            statusIcon.classList.remove('hidden');
            statusIcon.innerText = 'error';
            statusText.innerText = `Error: ${error.message}`;
            alert(`Error al analizar la imagen: ${error.message}`);
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

    // Intercept form submit to ensure image is validated and submitted
    productForm.addEventListener('submit', function(e) {
        // If the standard images file input is empty but we have selectedFile, we ensure hiddenImageSubmit is populated
        if (hiddenImageSubmit.files.length === 0 && selectedFile) {
            const dt = new DataTransfer();
            dt.items.add(selectedFile);
            hiddenImageSubmit.files = dt.files;
        }
    });
});
</script>
@endsection
