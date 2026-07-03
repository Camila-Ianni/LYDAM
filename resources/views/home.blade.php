@extends('layouts.guest')

@section('content')
@php
    $featuredProducts = $featuredProducts ?? collect();
@endphp

<!-- Hero Section -->
<section class="relative w-full h-[80vh] flex items-center justify-center overflow-hidden border-b border-surface-variant">
    <div class="absolute inset-0 z-0">
        <img alt="Models wearing Burzaco underground streetwear" class="w-full h-full object-cover opacity-60" src="{{ asset('images/header.jpg') }}"/>
        <div class="absolute inset-0 bg-gradient-to-t from-void-black to-transparent"></div>
    </div>
    <div class="relative z-10 text-center px-margin-mobile flex flex-col items-center">
        <h1 class="font-display-xl text-headline-lg-mobile md:text-display-xl text-raw-white mb-8 drop-shadow-lg gothic-text tracking-widest leading-none">
            COLECCIÓN TRIBAL UNDER
        </h1>
        <a class="inline-block bg-blood-red text-raw-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-raw-white hover:bg-void-black hover:text-blood-red hover:border-blood-red transition-colors duration-300" href="{{ route('products.index') }}">
            VER CATÁLOGO MAYORISTA
        </a>
    </div>
</section>

<!-- Marquee -->
<div class="bg-surface-container border-b border-surface-variant py-4 marquee-container">
    <div class="marquee-content font-label-caps text-label-caps text-blood-red">
        <span class="mx-4">VENTA MAYORISTA EXCLUSIVA</span> • <span class="mx-4">COMPRA MÍNIMA 1 CURVA</span> • <span class="mx-4">VENTA POR CURVA CERRADA</span> •
        <span class="mx-4">VENTA MAYORISTA EXCLUSIVA</span> • <span class="mx-4">COMPRA MÍNIMA 1 CURVA</span> • <span class="mx-4">VENTA POR CURVA CERRADA</span> •
    </div>
</div>

<!-- NEW IN Grid -->
<section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" id="new-drop">
    <h2 class="font-headline-lg text-headline-lg text-raw-white mb-12 border-l-4 border-blood-red pl-4">CATÁLOGO MAYORISTA</h2>
    
    @include('catalog._product_grid', ['products' => $featuredProducts])
</section>


@endsection
