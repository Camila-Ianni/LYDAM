@extends('layouts.guest')

@section('content')
<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-24 flex flex-col items-center">
    <div class="bg-white border border-surface-container-highest p-8 max-w-2xl w-full text-center shadow-sm">
        
        <div class="mx-auto flex h-20 w-20 items-center justify-center border border-blood-red bg-surface-container-low text-3xl font-headline-lg text-blood-red mb-6 shadow-sm">
            !
        </div>
        
        <h1 class="font-headline-lg text-headline-lg text-zinc-950 uppercase tracking-tight font-bold">{{ __('messages.payment_failure_title') }}</h1>
        <p class="mt-4 text-ash-grey font-label-caps text-sm">{{ __('messages.payment_failure_copy') }}</p>

        @if ($paymentId || $externalReference)
            <div class="mt-8 bg-surface-container-low border border-surface-container-highest p-6 text-left">
                <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block font-bold">{{ __('messages.payment_reference') }}</span>
                <span class="font-label-caps text-lg text-zinc-950 block mt-1 font-bold">{{ $paymentId ?? $externalReference }}</span>
            </div>
        @endif

        <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('cart.index') }}" class="inline-block bg-blood-red text-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-blood-red hover:bg-black hover:text-white transition-colors duration-300 font-bold shadow-md">
                {{ __('messages.return_to_cart') }}
            </a>
            <a href="{{ route('products.index') }}" class="inline-block bg-white text-zinc-900 font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-surface-container-highest hover:bg-black hover:text-white transition-colors duration-300 font-bold shadow-sm">
                {{ __('messages.back_to_catalog') }}
            </a>
        </div>
    </div>
</main>
@endsection
