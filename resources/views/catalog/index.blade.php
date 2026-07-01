@extends('layouts.guest')

@section('content')
@php
    $selectedCategories = (array) request('categories');
    $selectedPrices = (array) request('prices');
    $selectedCurves = (array) request('curves');
@endphp
<main class="flex-grow pt-16 pb-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto w-full">
    <!-- Header -->
    <header class="mb-12 border-b border-surface-container-highest pb-8 flex flex-col gap-2">
        <div class="bg-blood-red text-void-black font-label-caps text-label-caps px-3 py-1 self-start inline-block uppercase tracking-wider mb-2">
            VENTA MAYORISTA - POR CURVA
        </div>
        <h1 class="font-display-xl text-display-xl text-raw-white uppercase leading-none">
            CATÁLOGO
        </h1>
        <p class="text-ash-grey mt-4 max-w-2xl font-body-md">
            Venta exclusiva por curva de talles. Precios mayoristas para revendedores.
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
        <!-- Categories -->
        <div>
            <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-3 tracking-widest border-b border-outline-variant pb-2">CATEGORÍAS</h3>
            <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input {{ in_array('pantalones', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="pantalones"/>
                    <span class="group-hover:text-raw-white transition-colors">Pantalones</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input {{ in_array('remeras', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="remeras"/>
                    <span class="group-hover:text-raw-white transition-colors">Remeras</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input {{ in_array('sweaters', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="sweaters"/>
                    <span class="group-hover:text-raw-white transition-colors">Sweaters</span>
                </label>
            </div>
        </div>

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
            <!-- Filter Section: Categories -->
            <div class="mb-8">
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">CATEGORÍAS</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('pantalones', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="pantalones"/>
                        <span class="group-hover:text-raw-white transition-colors">Pantalones</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('remeras', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="remeras"/>
                        <span class="group-hover:text-raw-white transition-colors">Remeras</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input {{ in_array('sweaters', $selectedCategories) ? 'checked' : '' }} class="filter-checkbox form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox" data-type="categories" value="sweaters"/>
                        <span class="group-hover:text-raw-white transition-colors">Sweaters</span>
                    </label>
                </div>
            </div>

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

