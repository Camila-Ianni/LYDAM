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

<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-gutter">
        
        <!-- Form Container (Left Side) -->
        <div class="lg:col-span-8 bg-surface-container-low border border-surface-container-highest p-8">
            <div class="mb-8 border-b border-surface-container-highest pb-4">
                <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.checkout_badge') }}</span>
                <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase leading-tight mt-2">{{ __('messages.checkout_title') }}</h1>
            </div>

            @guest
                <div class="mb-8 border border-blood-red/45 bg-blood-red/5 p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden group">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-blood-red"></div>
                    
                    <div class="max-w-md pl-2">
                        <h3 class="font-headline-lg-mobile text-lg text-raw-white uppercase tracking-wider mb-2">¿Ya tenés una cuenta?</h3>
                        <p class="font-label-caps text-[11px] text-ash-grey leading-relaxed uppercase">Accedé a tu cuenta para autocompletar tus datos y agilizar tu compra. Si no tenés una cuenta, podés crear una nueva ahora.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 shrink-0">
                        <a href="{{ route('login', ['redirect' => route('checkout.create')]) }}" class="bg-blood-red text-raw-white border border-blood-red px-6 py-3 font-label-caps text-xs text-center hover:bg-void-black hover:text-blood-red transition-all duration-300">
                            INICIAR SESIÓN
                        </a>
                        <a href="{{ route('register', ['redirect' => route('checkout.create')]) }}" class="bg-void-black text-ash-grey border border-surface-container-highest px-6 py-3 font-label-caps text-xs text-center hover:border-raw-white hover:text-raw-white transition-all duration-300">
                            CREAR CUENTA
                        </a>
                    </div>
                </div>
            @endguest

            <form method="POST" action="{{ route('checkout.store') }}" class="grid gap-6">
                @csrf

                <div>
                    <label for="buyer_name" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.buyer_name') }}</label>
                    <input id="buyer_name" name="buyer_name" type="text" value="{{ old('buyer_name', auth()->user()->name ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="buyer_dni" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.buyer_dni') }}</label>
                        <input id="buyer_dni" name="buyer_dni" type="text" value="{{ old('buyer_dni') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                    </div>
                    <div>
                        <label for="buyer_phone" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.buyer_phone') }}</label>
                        <input id="buyer_phone" name="buyer_phone" type="tel" value="{{ old('buyer_phone') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="buyer_email" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.buyer_email') }}</label>
                    <input id="buyer_email" name="buyer_email" type="email" value="{{ old('buyer_email', auth()->user()->email ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                </div>

                <!-- Método de Entrega -->
                <div class="mt-6">
                    <span class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-3">MÉTODO DE ENTREGA</span>
                    <input type="hidden" id="shipping_type" name="shipping_type" value="{{ old('shipping_type', 'retiro') }}" required>
                    
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-3">
                        <!-- Option 1: Retiro en Local -->
                        <button type="button" class="shipping-card-btn text-left p-4 border transition-all duration-300 relative flex flex-col justify-between gap-4 select-none rounded-none focus:outline-none bg-void-black/20 hover:border-raw-white" data-value="retiro">
                            <div class="flex justify-between items-start">
                                <span class="material-symbols-outlined text-raw-white text-2xl font-light">store</span>
                                <div class="shipping-check-indicator w-4 h-4 border border-surface-container-highest flex items-center justify-center">
                                    <div class="shipping-check-dot w-2 h-2 bg-blood-red opacity-0 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-headline-lg-mobile text-sm text-raw-white uppercase tracking-wider mb-1">RETIRO EN LOCAL</h3>
                                <p class="font-label-caps text-[9px] text-ash-grey leading-tight uppercase">Retira por nuestro showroom.</p>
                            </div>
                        </button>

                        <!-- Option 2: Envío a Localidad -->
                        <button type="button" class="shipping-card-btn text-left p-4 border transition-all duration-300 relative flex flex-col justify-between gap-4 select-none rounded-none focus:outline-none bg-void-black/20 hover:border-raw-white" data-value="envio">
                            <div class="flex justify-between items-start">
                                <span class="material-symbols-outlined text-raw-white text-2xl font-light">local_shipping</span>
                                <div class="shipping-check-indicator w-4 h-4 border border-surface-container-highest flex items-center justify-center">
                                    <div class="shipping-check-dot w-2 h-2 bg-blood-red opacity-0 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-headline-lg-mobile text-sm text-raw-white uppercase tracking-wider mb-1">ENVÍO A LOCALIDAD</h3>
                                <p class="font-label-caps text-[9px] text-ash-grey leading-tight uppercase">Envío por transporte o correo.</p>
                            </div>
                        </button>

                        <!-- Option 3: Entrega a los tours en la salada -->
                        <button type="button" class="shipping-card-btn text-left p-4 border transition-all duration-300 relative flex flex-col justify-between gap-4 select-none rounded-none focus:outline-none bg-void-black/20 hover:border-raw-white" data-value="punto_encuentro">
                            <div class="flex justify-between items-start">
                                <span class="material-symbols-outlined text-raw-white text-2xl font-light">handshake</span>
                                <div class="shipping-check-indicator w-4 h-4 border border-surface-container-highest flex items-center justify-center">
                                    <div class="shipping-check-dot w-2 h-2 bg-blood-red opacity-0 transition-opacity duration-200"></div>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-headline-lg-mobile text-sm text-raw-white uppercase tracking-wider mb-1">TOURS EN LA SALADA</h3>
                                <p class="font-label-caps text-[9px] text-ash-grey leading-tight uppercase">Entrega a los tours en La Salada.</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Shipping Address Input (conditional) -->
                <div id="shipping-address-container" class="mt-6 hidden">
                    <label for="shipping_address" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Localidad y Dirección de Envío</label>
                    <input id="shipping_address" name="shipping_address" type="text" value="{{ old('shipping_address') }}" placeholder="Localidad, Provincia, Dirección completa / Datos del transporte o colectivo" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                </div>

                <div class="mt-6">
                    <span class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-3">MÉTODO DE PAGO</span>
                    <input type="hidden" id="payment_method" name="payment_method" value="{{ old('payment_method', 'transferencia') }}" required>
                    
                    <!-- Option: Transferencia -->
                    <button type="button" id="pay-btn-transfer" class="payment-card-btn text-left p-6 border transition-all duration-300 relative flex flex-col justify-between gap-6 select-none rounded-none focus:outline-none bg-void-black/20 hover:border-raw-white w-full" data-value="transferencia">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-raw-white text-3xl font-light">account_balance</span>
                            <div class="payment-check-indicator w-5 h-5 border border-surface-container-highest flex items-center justify-center">
                                <div class="payment-check-dot w-2.5 h-2.5 bg-blood-red opacity-0 transition-opacity duration-200"></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-headline-lg-mobile text-xl text-raw-white uppercase tracking-wider mb-1">TRANSFERENCIA BANCARIA</h3>
                            <p class="font-label-caps text-[10px] text-ash-grey leading-tight uppercase">Datos para depositar al confirmar tu pedido. 10% de descuento adicional.</p>
                        </div>
                    </button>
                </div>

                <button type="submit" class="w-full bg-blood-red text-raw-white font-headline-lg-mobile text-2xl uppercase py-4 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-300 rounded-none tracking-wider mt-4">
                    {{ __('messages.confirm_order') }}
                </button>
            </form>
        </div>

        <!-- Sidebar Summary (Right Side) -->
        <div class="lg:col-span-4">
            <div class="bg-surface-container-low border border-surface-container-highest p-8 sticky top-32">
                <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-8 tracking-wide uppercase">{{ __('messages.order_summary') }}</h2>
                
                <div class="space-y-4 font-label-caps text-label-caps mb-8 border-b border-surface-container-highest pb-8">
                    @foreach ($cart as $item)
                        <div class="flex justify-between items-start gap-4 border-b border-surface-container/40 pb-4">
                            <div>
                                <p class="text-raw-white uppercase font-bold">{{ $item['name'] }}</p>
                                <p class="text-xs text-ash-grey mt-1">{{ __('messages.quantity') }}: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-raw-white">${{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach

                    @if($discount > 0)
                        <div class="flex justify-between items-center text-ash-grey text-xs pt-4">
                            <span>SUBTOTAL</span>
                            <span>${{ number_format($subtotal, 0, ',', '.') }} ARS</span>
                        </div>
                        <div class="flex justify-between items-center text-emerald-500 text-xs">
                            <span>DESCUENTO ({{ $discountPercent }}%)</span>
                            <span>-${{ number_format($discount, 0, ',', '.') }} ARS</span>
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-between items-center font-headline-lg-mobile text-headline-lg-mobile mb-6">
                    <span class="text-raw-white">TOTAL</span>
                    <span class="text-blood-red">${{ number_format($total, 0, ',', '.') }} ARS</span>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentCards = document.querySelectorAll('.payment-card-btn');
        const paymentInput = document.getElementById('payment_method');

        function selectPaymentMethod(value) {
            paymentInput.value = value;
            paymentCards.forEach(card => {
                const cardValue = card.getAttribute('data-value');
                const dot = card.querySelector('.payment-check-dot');
                if (cardValue === value) {
                    card.classList.remove('border-surface-container-highest', 'bg-void-black/20');
                    card.classList.add('border-blood-red', 'bg-void-black/60');
                    if (dot) dot.classList.remove('opacity-0');
                } else {
                    card.classList.remove('border-blood-red', 'bg-void-black/60');
                    card.classList.add('border-surface-container-highest', 'bg-void-black/20');
                    if (dot) dot.classList.add('opacity-0');
                }
            });
        }

        const initialValue = paymentInput.value || 'transferencia';
        selectPaymentMethod(initialValue);

        paymentCards.forEach(card => {
            card.addEventListener('click', function () {
                const val = card.getAttribute('data-value');
                selectPaymentMethod(val);
            });
        });

        // Shipping Selection Logic
        const shippingCards = document.querySelectorAll('.shipping-card-btn');
        const shippingInput = document.getElementById('shipping_type');
        const addressContainer = document.getElementById('shipping-address-container');
        const addressInput = document.getElementById('shipping_address');

        function selectShippingMethod(value) {
            shippingInput.value = value;
            shippingCards.forEach(card => {
                const cardValue = card.getAttribute('data-value');
                const dot = card.querySelector('.shipping-check-dot');
                if (cardValue === value) {
                    card.classList.remove('border-surface-container-highest', 'bg-void-black/20');
                    card.classList.add('border-blood-red', 'bg-void-black/60');
                    if (dot) dot.classList.remove('opacity-0');
                } else {
                    card.classList.remove('border-blood-red', 'bg-void-black/60');
                    card.classList.add('border-surface-container-highest', 'bg-void-black/20');
                    if (dot) dot.classList.add('opacity-0');
                }
            });

            if (value === 'envio') {
                addressContainer.classList.remove('hidden');
                if (addressInput) addressInput.setAttribute('required', 'required');
            } else {
                addressContainer.classList.add('hidden');
                if (addressInput) {
                    addressInput.removeAttribute('required');
                    addressInput.value = '';
                }
            }
        }

        const initialShippingValue = shippingInput.value || 'retiro';
        selectShippingMethod(initialShippingValue);

        shippingCards.forEach(card => {
            card.addEventListener('click', function () {
                const val = card.getAttribute('data-value');
                selectShippingMethod(val);
            });
        });
    });
</script>
@endsection
