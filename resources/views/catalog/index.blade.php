@extends('layouts.guest')

@section('content')
@php
    $selectedPrices = (array) request('prices');
    $selectedCurves = (array) request('curves');
@endphp
<main class="flex-grow pt-16 pb-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto w-full">
    
    @if(!$selectedCategory)
        <!-- STATE A: CATEGORIES GRID -->
        <!-- Header -->
        <header class="mb-12 border-b border-surface-container-highest pb-8 flex flex-col gap-2">
            <div class="bg-blood-red text-void-black font-label-caps text-label-caps px-3 py-1 self-start inline-block uppercase tracking-wider mb-2">
                COLECCIONES LYDAM
            </div>
            <h1 class="font-display-xl text-display-xl text-raw-white uppercase leading-none">
                CATÁLOGO
            </h1>
            <p class="text-ash-grey mt-4 max-w-2xl font-body-md">
                Elegí una categoría para explorar nuestros drops. Venta mayorista por curva cerrada para revendedores.
            </p>
        </header>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-gutter">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group relative aspect-square block overflow-hidden border border-surface-container-highest hover:border-blood-red transition-colors duration-300 bg-void-black">
                    <!-- Background Image -->
                    @if($category->imageUrl())
                        <img src="{{ $category->imageUrl() }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    @endif
                    <!-- Darkened Overlay -->
                    <div class="absolute inset-0 bg-void-black/70 group-hover:bg-void-black/45 transition-colors duration-300 z-10"></div>
                    <!-- Text -->
                    <div class="absolute inset-0 flex items-center justify-center p-4 z-20 text-center">
                        <span class="font-headline-lg-mobile md:font-headline-lg text-raw-white uppercase tracking-wider group-hover:text-blood-red transition-colors duration-300 leading-tight">
                            {{ $category->name }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- STATE B: PRODUCTS GRID (FILTERED) -->
        <!-- Header -->
        <header class="mb-12 border-b border-surface-container-highest pb-8 flex flex-col gap-2">
            <!-- Back to categories link -->
            <div class="w-full mb-4">
                <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-ash-grey hover:text-raw-white transition-colors group" href="{{ route('products.index') }}">
                    <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    VOLVER A CATEGORÍAS
                </a>
            </div>

            <div class="bg-blood-red text-void-black font-label-caps text-label-caps px-3 py-1 self-start inline-block uppercase tracking-wider mb-2">
                CATEGORÍA
            </div>
            <h1 class="font-display-xl text-display-xl text-raw-white uppercase leading-none">
                {{ $selectedCategory->name }}
            </h1>
            <p class="text-ash-grey mt-4 max-w-2xl font-body-md">
                Mostrando productos disponibles para la categoría seleccionada.
            </p>
        </header>

        <!-- Mobile Filter Toggle Button -->
        <div class="md:hidden mb-6 flex justify-between items-center border border-surface-container-highest p-4 bg-surface-container-lowest">
            <span class="font-label-caps text-label-caps text-raw-white">FILTRAR PRODUCTOS</span>
            <button id="mobile-filter-toggle" class="border border-outline-variant px-3 py-1 flex items-center justify-center font-label-caps text-label-caps hover:bg-raw-white hover:text-void-black transition-colors text-raw-white text-xs">
                MOSTRAR FILTROS
            </button>
        </div>

        <!-- Mobile Filter Content (collapsible) -->
        <div id="mobile-filter-drawer" class="hidden md:hidden mb-8 border border-surface-container-highest p-6 bg-surface-container-lowest flex flex-col gap-6">
            <!-- Prices -->
            <div>
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-3 tracking-widest border-b border-outline-variant pb-2">PRECIO POR CURVA</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('less_300k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="less_300k"/>
                        <span class="group-hover:text-raw-white transition-colors">Menos de $300k</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('300k_600k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="300k_600k"/>
                        <span class="group-hover:text-raw-white transition-colors">$300k - $600k</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('more_600k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="more_600k"/>
                        <span class="group-hover:text-raw-white transition-colors">Más de $600k</span>
                    </label>
                </div>
            </div>

            <!-- Curves -->
            <div>
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-3 tracking-widest border-b border-outline-variant pb-2">TIPO DE CURVA</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('x5', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x5"/>
                        <span class="group-hover:text-raw-white transition-colors">Curva x5 (38-46)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('x6', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x6"/>
                        <span class="group-hover:text-raw-white transition-colors">Curva x6 (38-48)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('x10', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x10"/>
                        <span class="group-hover:text-raw-white transition-colors">Surtido Pack x10</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-gutter">
            <!-- Sidebar Filters (Preserves visual identity) -->
            <aside class="w-full md:w-64 flex-shrink-0 border-r border-surface-container-highest pr-8 hidden md:block">
                <!-- Filter Section: Price -->
                <div class="mb-8">
                    <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">PRECIO POR CURVA</h3>
                    <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('less_300k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="less_300k"/>
                            <span class="group-hover:text-raw-white transition-colors">Menos de $300k</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('300k_600k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="300k_600k"/>
                            <span class="group-hover:text-raw-white transition-colors">$300k - $600k</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('more_600k', $selectedPrices) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="prices" value="more_600k"/>
                            <span class="group-hover:text-raw-white transition-colors">Más de $600k</span>
                        </label>
                    </div>
                </div>

                <!-- Filter Section: Curve Type -->
                <div class="mb-8">
                    <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">TIPO DE CURVA</h3>
                    <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('x5', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x5"/>
                            <span class="group-hover:text-raw-white transition-colors">Curva x5 (38-46)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('x6', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x6"/>
                            <span class="group-hover:text-raw-white transition-colors">Curva x6 (38-48)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input {{ in_array('x10', $selectedCurves) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="curves" value="x10"/>
                            <span class="group-hover:text-raw-white transition-colors">Surtido Pack x10</span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1 min-h-[400px] relative" id="product-grid-container">
                @include('catalog._product_grid', ['products' => $products ?? collect()])
            </div>
        </div>
    @endif
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle mobile filter drawer
        const mobileToggle = document.getElementById('mobile-filter-toggle');
        const mobileDrawer = document.getElementById('mobile-filter-drawer');
        if (mobileToggle && mobileDrawer) {
            mobileToggle.addEventListener('click', function () {
                mobileDrawer.classList.toggle('hidden');
                mobileToggle.textContent = mobileDrawer.classList.contains('hidden') ? 'MOSTRAR FILTROS' : 'OCULTAR FILTROS';
            });
        }

        // AJAX Filtering Logic
        const container = document.getElementById('product-grid-container');
        const checkboxes = document.querySelectorAll('.filter-checkbox');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                // Sync state between mobile and desktop checkboxes
                const type = this.getAttribute('data-type');
                const val = this.value;
                const matches = document.querySelectorAll(`.filter-checkbox[data-type="${type}"][value="${val}"]`);
                matches.forEach(match => {
                    match.checked = this.checked;
                });

                applyFilters();
            });
        });

        function applyFilters() {
            // Show subtle visual loading state
            if (container) {
                container.style.opacity = '0.5';
                container.style.pointerEvents = 'none';
            }

            // Gather values
            const params = new URLSearchParams();
            
            // Maintain category if present in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('category');
            if (category) {
                params.append('category', category);
            }

            const checkedBoxes = document.querySelectorAll('.filter-checkbox:checked');
            
            // Map types to parameter keys
            checkedBoxes.forEach(cb => {
                const type = cb.getAttribute('data-type');
                params.append(`${type}[]`, cb.value);
            });

            const queryString = params.toString();
            const targetUrl = `${window.location.pathname}?${queryString}`;

            // Fetch and update grid
            fetch(targetUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (container && data.html) {
                    container.innerHTML = data.html;
                    container.style.opacity = '1';
                    container.style.pointerEvents = 'auto';
                    
                    // Update address bar
                    window.history.pushState({}, '', targetUrl);
                }
            })
            .catch(error => {
                console.error('Error fetching filtered products:', error);
                if (container) {
                    container.style.opacity = '1';
                    container.style.pointerEvents = 'auto';
                }
            });
        }
    });
</script>
@endsection
