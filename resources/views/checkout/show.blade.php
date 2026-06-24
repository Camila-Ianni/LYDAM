@extends('layouts.guest')

@section('content')
@php
    $cart = $cart ?? session()->get('cart', []);
    $total = $total ?? collect($cart)->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);
@endphp

<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-gutter">
        
        <!-- Form Container (Left Side) -->
        <div class="lg:col-span-8 bg-surface-container-low border border-surface-container-highest p-8">
            <div class="mb-8 border-b border-surface-container-highest pb-4">
                <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.checkout_badge') }}</span>
                <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase leading-tight mt-2">{{ __('messages.checkout_title') }}</h1>
            </div>

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

                <div>
                    <label for="buyer_email" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.buyer_email') }}</label>
                    <input id="buyer_email" name="buyer_email" type="email" value="{{ old('buyer_email', auth()->user()->email ?? '') }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                </div>

                <div>
                    <label for="payment_method" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">{{ __('messages.payment_method') }}</label>
                    <select id="payment_method" name="payment_method" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full appearance-none">
                        <option value="transferencia" @selected(old('payment_method') === 'transferencia')>{{ __('messages.payment_transfer') }}</option>
                        <option value="mercadopago" @selected(old('payment_method') === 'mercadopago')>{{ __('messages.payment_mercadopago') }}</option>
                        <option value="paypal" @selected(old('payment_method') === 'paypal')>{{ __('messages.payment_paypal') }}</option>
                    </select>
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
                </div>
                
                <div class="flex justify-between items-center font-headline-lg-mobile text-headline-lg-mobile mb-6">
                    <span class="text-raw-white">TOTAL</span>
                    <span class="text-blood-red">${{ number_format($total, 0, ',', '.') }} ARS</span>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
