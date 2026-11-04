@extends('layouts.guest')

@section('content')
@php
    $cart = $cart ?? session()->get('cart', []);
    $subtotal = collect($cart)->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);

    $discountThreshold = (float) \App\Models\Setting::get('discount_threshold', 0);
    $discountPercent = (float) \App\Models\Setting::get('discount_percent', 0);

    $discount = 0;
    if ($discountPercent > 0 && $subtotal >= $discountThreshold) {
        $discount = $subtotal * ($discountPercent / 100);
    }
    $total = $subtotal - $discount;
@endphp

<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-24 md:py-32 flex flex-col items-center">
    <!-- Header -->
    <header class="w-full text-center mb-16 md:mb-24">
        <h1 class="font-display-xl text-headline-lg-mobile md:text-display-xl text-zinc-950 uppercase tracking-tighter">TU CARRITO</h1>
    </header>

    @if (count($cart))
        @guest
            <div class="w-full mb-8 border border-blood-red/45 bg-blood-red/5 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden group shadow-sm">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-blood-red"></div>
                
                <div class="max-w-md pl-2">
                    <h3 class="font-headline-lg-mobile text-lg text-zinc-950 uppercase tracking-wider mb-2 font-bold">¿Ya tenés una cuenta?</h3>
                    <p class="font-label-caps text-[11px] text-zinc-600 leading-relaxed uppercase">Iniciá sesión o registrate ahora para poder finalizar tu compra y guardar tus datos.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 shrink-0">
                    <a href="{{ route('login', ['redirect' => route('checkout.create')]) }}" class="bg-blood-red text-white border border-blood-red px-6 py-3 font-label-caps text-xs text-center hover:bg-black hover:text-white transition-all duration-300 font-bold">
                        INICIAR SESIÓN
                    </a>
                    <a href="{{ route('register', ['redirect' => route('checkout.create')]) }}" class="bg-white text-zinc-900 border border-surface-container-highest px-6 py-3 font-label-caps text-xs text-center hover:border-black hover:text-black transition-all duration-300 font-bold">
                        CREAR CUENTA
                    </a>
                </div>
            </div>
        @endguest

        <!-- Cart Layout -->
        <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-gutter">
            
            <!-- Items List (Left Side) -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                @foreach ($cart as $item)
                    <!-- Cart Item -->
                    <div class="flex flex-col sm:flex-row gap-6 border-b border-surface-container-highest pb-8">
                        <div class="w-full sm:w-48 h-64 bg-surface-container-low shrink-0 relative overflow-hidden group border border-surface-container-highest">
                            @if (!empty($item['image_url']))
                                <img class="absolute inset-0 w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500" src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-surface-container-low p-6">
                                    <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="max-w-[100px] w-full h-auto object-contain opacity-40 brand-logo-dark">
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col flex-grow justify-between py-2">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h2 class="font-label-caps text-label-caps text-zinc-950 uppercase tracking-widest font-bold">
                                        {{ $item['name'] }}
                                    </h2>
                                    <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Remove item" class="text-zinc-500 hover:text-blood-red transition-colors">
                                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">close</span>
                                        </button>
                                    </form>
                                </div>
                                <p class="font-body-sm text-body-sm text-ash-grey mb-4">SKU: {{ $item['sku'] }}</p>
                                <p class="font-body-sm text-body-sm text-ash-grey mb-4">CURVA (5 UNIDADES)</p>
                            </div>
                            
                            <div class="flex justify-between items-end mt-auto">
                                <!-- Quantity Selector Form -->
                                <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="flex items-center border border-surface-container-highest bg-white">
                                    @csrf
                                    @method('PATCH')
                                    <input name="quantity" class="w-16 h-10 bg-transparent text-center font-label-caps text-label-caps text-zinc-950 border-none focus:ring-0 p-0 m-0 font-bold" type="number" min="1" value="{{ $item['quantity'] }}">
                                    <button type="submit" class="h-10 px-3 bg-surface-container-low text-zinc-900 font-label-caps hover:bg-blood-red hover:text-white transition-colors text-xs uppercase border-l border-surface-container-highest font-bold">
                                        ACTUALIZAR
                                    </button>
                                </form>
                                <p class="font-label-caps text-label-caps text-zinc-950 font-bold">
                                    ${{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', '.') }} ARS
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary Sidebar (Right Side) -->
            <div class="lg:col-span-4">
                <div class="bg-surface-container-low border border-surface-container-highest p-8 sticky top-32 shadow-sm">
                    <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-zinc-950 mb-8 tracking-wide font-bold">RESUMEN DEL PEDIDO</h2>
                    
                    <div class="space-y-4 font-label-caps text-label-caps mb-8 border-b border-surface-container-highest pb-8">
                        <div class="flex justify-between items-center text-ash-grey font-bold">
                            <span>SUBTOTAL</span>
                            <span class="text-zinc-950">${{ number_format($subtotal, 0, ',', '.') }} ARS</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between items-center text-emerald-600 text-xs font-bold">
                                <span>DESCUENTO ({{ $discountPercent }}%)</span>
                                <span>-${{ number_format($discount, 0, ',', '.') }} ARS</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center text-ash-grey font-bold">
                            <span>ENVÍO</span>
                            <span class="text-zinc-950 text-xs">CALCULADO AL FINALIZAR</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center font-headline-lg-mobile text-headline-lg-mobile mb-10">
                        <span class="text-zinc-950 font-bold">TOTAL</span>
                        <span class="text-blood-red font-bold">${{ number_format($total, 0, ',', '.') }} ARS</span>
                    </div>
                    
                    <a href="{{ route('checkout.create') }}" class="block text-center w-full bg-blood-red text-white font-headline-lg-mobile text-headline-lg-mobile py-4 border border-blood-red hover:bg-black hover:text-white transition-colors duration-300 tracking-wider font-bold">
                        FINALIZAR COMPRA
                    </a>
                    
                    <p class="font-body-sm text-body-sm text-ash-grey text-center mt-6">
                        IMPUESTOS Y ENVÍO CALCULADOS AL FINALIZAR LA COMPRA.
                    </p>
                    
                    <!-- Vaciar Carrito -->
                    <form method="POST" action="{{ route('cart.clear') }}" class="mt-6 border-t border-surface-container-highest pt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors text-xs uppercase font-bold">
                            VACIAR CARRITO
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    @else
        <!-- Empty Cart -->
        <div class="border border-dashed border-surface-container-highest bg-surface-container/20 p-12 text-center w-full max-w-2xl">
            <h2 class="font-headline-lg-mobile text-raw-white uppercase mb-4">TU CARRITO ESTÁ VACÍO</h2>
            <p class="text-ash-grey font-label-caps text-xs mb-8">Agrega curvas de talles al carrito para continuar.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-blood-red text-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-blood-red hover:bg-zinc-950 hover:text-white transition-colors duration-300">
                VER CATÁLOGO
            </a>
        </div>
    @endif

    <!-- Continue Shopping Link -->
    <div class="w-full mt-16 text-left">
        <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-ash-grey hover:text-raw-white transition-colors group" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_back</span>
            SEGUIR COMPRANDO
        </a>
    </div>
</main>
@endsection
