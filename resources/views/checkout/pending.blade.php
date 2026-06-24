@extends('layouts.guest')

@section('content')
<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-24 flex flex-col items-center">
    <div class="bg-surface-container-low border border-surface-container-highest p-8 max-w-2xl w-full text-center">
        
        <div class="mx-auto flex h-20 w-20 items-center justify-center border border-blood-red bg-void-black text-3xl font-headline-lg text-blood-red mb-6">
            ...
        </div>
        
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase tracking-tight">{{ __('messages.payment_pending_title') }}</h1>
        <p class="mt-4 text-ash-grey font-label-caps text-sm">{{ __('messages.payment_pending_copy') }}</p>

        @if ($paymentId || $externalReference)
            <div class="mt-8 bg-void-black border border-surface-container-highest p-6 text-left">
                <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block">{{ __('messages.payment_reference') }}</span>
                <span class="font-label-caps text-lg text-raw-white block mt-1">{{ $paymentId ?? $externalReference }}</span>
            </div>
        @endif

        <a href="{{ route('products.index') }}" class="mt-12 inline-block bg-blood-red text-raw-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-raw-white hover:bg-void-black hover:text-blood-red hover:border-blood-red transition-colors duration-300">
            {{ __('messages.back_to_catalog') }}
        </a>
    </div>
</main>
@endsection
