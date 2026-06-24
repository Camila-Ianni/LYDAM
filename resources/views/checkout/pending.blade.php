@extends('layouts.guest')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-16 text-center sm:px-6 lg:px-8">
    <div class="rounded-3xl border border-amber-200 bg-white p-8 shadow-xl">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 text-lg font-black text-amber-700">...</div>
        <h1 class="mt-6 text-4xl font-black text-stitch-navy">{{ __('messages.payment_pending_title') }}</h1>
        <p class="mt-3 text-slate-600">{{ __('messages.payment_pending_copy') }}</p>
        @if ($paymentId || $externalReference)
            <p class="mt-5 rounded-2xl bg-sky-50 px-4 py-3 text-sm text-slate-600">
                {{ __('messages.payment_reference') }}: {{ $paymentId ?? $externalReference }}
            </p>
        @endif
        <a href="{{ route('products.index') }}" class="mt-8 inline-flex rounded-full bg-stitch-blue px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-stitch-navy">
            {{ __('messages.back_to_catalog') }}
        </a>
    </div>
</section>
@endsection
