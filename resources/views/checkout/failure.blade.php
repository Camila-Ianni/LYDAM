@extends('layouts.guest')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-16 text-center sm:px-6 lg:px-8">
    <div class="rounded-3xl border border-rose-200 bg-white p-8 shadow-xl">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-rose-100 text-lg font-black text-rose-700">!</div>
        <h1 class="mt-6 text-4xl font-black text-stitch-navy">{{ __('messages.payment_failure_title') }}</h1>
        <p class="mt-3 text-slate-600">{{ __('messages.payment_failure_copy') }}</p>
        @if ($paymentId || $externalReference)
            <p class="mt-5 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-slate-600">
                {{ __('messages.payment_reference') }}: {{ $paymentId ?? $externalReference }}
            </p>
        @endif
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('cart.index') }}" class="rounded-full bg-stitch-hibiscus px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-pink-500">
                {{ __('messages.return_to_cart') }}
            </a>
            <a href="{{ route('products.index') }}" class="rounded-full border border-sky-200 px-6 py-3 text-sm font-black uppercase tracking-wide text-stitch-navy hover:bg-sky-50">
                {{ __('messages.back_to_catalog') }}
            </a>
        </div>
    </div>
</section>
@endsection
