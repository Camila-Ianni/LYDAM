@extends('layouts.guest')

@section('content')
@php
    $featuredProducts = $featuredProducts ?? collect();
@endphp

<!-- Hero Section -->
<section class="relative w-full h-[80vh] flex items-center justify-center overflow-hidden border-b border-surface-variant">
    <div class="absolute inset-0 z-0">
        <img alt="Models wearing Burzaco underground streetwear" class="w-full h-full object-cover opacity-60" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAekGYfj06rDpWHhCWaJ8uCW2M6QjPRM48Min7x0CHOdRbu2xTxTqDiPzVaRBX89zcXR6rdpDH-rXYTK4gYFqbCEQEujmMgCSj6WcTaaXqR9_JXekcUAo5jp6dISsiOUaA85Op5GtSWFU9x73Q25uhUYJMOinYQV_J8qoZcca7peYu3_Mj_Ei316FdVoMLdXeCMrkg0h3uV8YyjCBZLA_KcBXM2onkECexCTw0jeiiWdZHF9sSzcFVxgYJG3xkcgo-bLZsvbeKawEfV"/>
        <div class="absolute inset-0 bg-gradient-to-t from-void-black to-transparent"></div>
    </div>
    <div class="relative z-10 text-center px-margin-mobile flex flex-col items-center">
        <h1 class="font-display-xl text-headline-lg-mobile md:text-display-xl text-raw-white mb-8 drop-shadow-lg gothic-text tracking-widest leading-none">
            COLECCIÓN TRIBAL UNDER
        </h1>
        <a class="inline-block bg-blood-red text-raw-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-raw-white hover:bg-void-black hover:text-blood-red hover:border-blood-red transition-colors duration-300" href="#new-drop">
            VER CATÁLOGO MAYORISTA
        </a>
    </div>
</section>

<!-- Marquee -->
<div class="bg-surface-container border-b border-surface-variant py-4 marquee-container">
    <div class="marquee-content font-label-caps text-label-caps text-blood-red">
        <span class="mx-4">VENTA MAYORISTA EXCLUSIVA</span> • <span class="mx-4">COMPRA MÍNIMA 1 CURVA</span> • <span class="mx-4">ENVÍOS A TODO EL PAÍS</span> • <span class="mx-4">VENTA POR CURVA CERRADA</span> •
        <span class="mx-4">VENTA MAYORISTA EXCLUSIVA</span> • <span class="mx-4">COMPRA MÍNIMA 1 CURVA</span> • <span class="mx-4">ENVÍOS A TODO EL PAÍS</span> • <span class="mx-4">VENTA POR CURVA CERRADA</span> •
    </div>
</div>

<!-- NEW IN Grid -->
<section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" id="new-drop">
    <h2 class="font-headline-lg text-headline-lg text-raw-white mb-12 border-l-4 border-blood-red pl-4">CATÁLOGO MAYORISTA</h2>
    
    @include('catalog._product_grid', ['products' => $featuredProducts])
</section>

<!-- Categories / Bento Grid -->
<section class="py-12 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 min-h-[60vh]">
        <a class="relative group overflow-hidden border border-surface-variant flex items-center justify-center min-h-[300px]" href="{{ route('products.index') }}">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105 mix-blend-luminosity opacity-60" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAXYv5WPFWuSXPu4_eGIMKxFCII3E6Ot4B06cNNAtKueAkeauO6P4gh2j4Wz7r_pPI7uiP-8ZtzaRjUHvF-JR2mKzisnGTHVFL8i8GOL8QzRSmRl_Qk2apHCbgHayeqb0Ze6UtdEs40j9YltX2Nv_RWl6_G3NnJyxeLid2IiIZKBpY5CafrT_ekLEx1Sny1BrZNmUn0OVPpNOBwJ10EeFcnKwcSKKdVPxyCZRdX8y0kKImit1hezDCxV3iZv6OeB8ETJUJDv6n4LypH');"></div>
            <div class="absolute inset-0 bg-void-black/40 group-hover:bg-blood-red/20 transition-colors duration-500"></div>
            <h2 class="relative z-10 font-display-xl text-headline-lg-mobile md:text-display-xl text-raw-white text-center border border-raw-white px-8 py-4 bg-void-black/80 backdrop-blur-sm group-hover:border-blood-red group-hover:text-blood-red transition-colors">
                VER PANTALONES
            </h2>
        </a>
        <a class="relative group overflow-hidden border border-surface-variant flex items-center justify-center min-h-[300px]" href="{{ route('products.index') }}">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105 mix-blend-luminosity opacity-60" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAYeeos9TCOkna4TxZq2A5uwDmc5H7xWaaMfAXZxF6kky6bQ3mt91zebG8IYYn5wHBY9Li-91PPrOQ5U8k3yEUzKjhBlSvM3PL_eTOVS_Fc5bxBIYt0Tk5n4yBjQY7YQOWislE6c-M-OUa_wlufI8C9_UbCy7Cef3NOQac0wa8JO3PGVK6-AG1rja0JqeYiUXtvqIB-XyIkFEULueJdpEUzuWaGH4tj_8kaD5u2a4wCX6ktzaEVqgsgNajkkMEByBWEvVlhVNsuSgd7');"></div>
            <div class="absolute inset-0 bg-void-black/40 group-hover:bg-blood-red/20 transition-colors duration-500"></div>
            <h2 class="relative z-10 font-display-xl text-headline-lg-mobile md:text-display-xl text-raw-white text-center border border-raw-white px-8 py-4 bg-void-black/80 backdrop-blur-sm group-hover:border-blood-red group-hover:text-blood-red transition-colors">
                VER SWEATERS
            </h2>
        </a>
    </div>
</section>
@endsection
