@extends('layouts.guest')

@section('content')
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

    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Sidebar Filters (Mockup to preserve visual identity) -->
        <aside class="w-full md:w-64 flex-shrink-0 border-r border-surface-container-highest pr-8 hidden md:block">
            <!-- Filter Section: Categories -->
            <div class="mb-8">
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">CATEGORÍAS</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input checked class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Pantalones</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Remeras</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Sweaters</span>
                    </label>
                </div>
            </div>

            <!-- Filter Section: Price -->
            <div class="mb-8">
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">PRECIO POR CURVA</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Menos de $300k</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input checked class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">$300k - $600k</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Más de $600k</span>
                    </label>
                </div>
            </div>

            <!-- Filter Section: Curve Type -->
            <div class="mb-8">
                <h3 class="font-label-caps text-label-caps text-ash-grey uppercase mb-4 tracking-widest border-b border-outline-variant pb-2">TIPO DE CURVA</h3>
                <div class="flex flex-col gap-2 font-label-caps text-label-caps text-on-surface">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Curva x5 (38-46)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Curva x6 (38-48)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input checked class="form-checkbox bg-void-black border-outline-variant text-blood-red focus:ring-blood-red focus:ring-offset-void-black rounded-none" type="checkbox"/>
                        <span class="group-hover:text-raw-white transition-colors">Surtido Pack x10</span>
                    </label>
                </div>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1">
            @include('catalog._product_grid', ['products' => $products ?? collect()])
        </div>
    </div>
</main>
@endsection
