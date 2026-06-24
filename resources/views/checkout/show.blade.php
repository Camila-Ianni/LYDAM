@extends('layouts.guest')

@section('content')
@php
    $cart = $cart ?? session()->get('cart', []);
    $total = $total ?? collect($cart)->sum(fn ($item) => (float) $item['price'] * (int) $item['quantity']);
@endphp

<section class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_420px] lg:px-8">
    <div class="rounded-3xl border border-sky-100 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.checkout_badge') }}</p>
        <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.checkout_title') }}</h1>

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-8 grid gap-5">
            @csrf

            <div>
                <label for="buyer_name" class="block text-sm font-bold text-stitch-navy">{{ __('messages.buyer_name') }}</label>
                <input id="buyer_name" name="buyer_name" type="text" value="{{ old('buyer_name', auth()->user()->name ?? '') }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="buyer_dni" class="block text-sm font-bold text-stitch-navy">{{ __('messages.buyer_dni') }}</label>
                    <input id="buyer_dni" name="buyer_dni" type="text" value="{{ old('buyer_dni') }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
                </div>
                <div>
                    <label for="buyer_phone" class="block text-sm font-bold text-stitch-navy">{{ __('messages.buyer_phone') }}</label>
                    <input id="buyer_phone" name="buyer_phone" type="tel" value="{{ old('buyer_phone') }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
                </div>
            </div>

            <div>
                <label for="buyer_email" class="block text-sm font-bold text-stitch-navy">{{ __('messages.buyer_email') }}</label>
                <input id="buyer_email" name="buyer_email" type="email" value="{{ old('buyer_email', auth()->user()->email ?? '') }}" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-bold text-stitch-navy">{{ __('messages.payment_method') }}</label>
                <select id="payment_method" name="payment_method" required class="mt-2 w-full rounded-xl border-sky-200 px-4 py-3 focus:border-stitch-blue focus:ring-stitch-blue">
                    <option value="transferencia" @selected(old('payment_method') === 'transferencia')>{{ __('messages.payment_transfer') }}</option>
                    <option value="mercadopago" @selected(old('payment_method') === 'mercadopago')>{{ __('messages.payment_mercadopago') }}</option>
                    <option value="paypal" @selected(old('payment_method') === 'paypal')>{{ __('messages.payment_paypal') }}</option>
                </select>
            </div>

            <button type="submit" class="rounded-full bg-stitch-hibiscus px-6 py-4 text-sm font-black uppercase tracking-wide text-white shadow-lg hover:bg-pink-500">
                {{ __('messages.confirm_order') }}
            </button>
        </form>
    </div>

    <aside class="h-fit rounded-3xl bg-stitch-navy p-6 text-white shadow-lg">
        <h2 class="text-xl font-black">{{ __('messages.order_summary') }}</h2>
        <div class="mt-5 space-y-4">
            @foreach ($cart as $item)
                <div class="flex justify-between gap-4 border-b border-white/10 pb-4">
                    <div>
                        <p class="font-bold">{{ $item['name'] }}</p>
                        <p class="text-sm text-sky-100">{{ __('messages.quantity') }}: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-black">${{ number_format((float) $item['price'] * (int) $item['quantity'], 2, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex items-center justify-between">
            <span class="text-sm font-bold uppercase tracking-wide text-sky-100">{{ __('messages.total') }}</span>
            <span class="text-3xl font-black">${{ number_format($total, 2, ',', '.') }}</span>
        </div>
    </aside>
</section>
@endsection
