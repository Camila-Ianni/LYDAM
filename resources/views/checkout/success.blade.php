@extends('layouts.guest')

@section('content')
@php
    $isTransfer = isset($order) && $order?->payment_method === \App\Models\Order::PAYMENT_TRANSFER;
    
    if ($isTransfer) {
        $threshold = (float) \App\Models\Setting::get('bank_threshold', 300000);
        $orderTotal = isset($order) ? (float) $order->total : 0.0;
        
        $selectedAlias = $orderTotal < $threshold
            ? \App\Models\Setting::get('bank_alias_1', 'LYDAM.TRIBAL.UNO')
            : \App\Models\Setting::get('bank_alias_2', 'LYDAM.TRIBAL.DOS');

        $bank = [
            'holder' => \App\Models\Setting::get('bank_holder', 'LYDAM Store'),
            'bank' => \App\Models\Setting::get('bank_name', 'Banco de la Nación Argentina'),
            'cbu' => \App\Models\Setting::get('bank_cbu', '0000003100098765432101'),
            'alias' => $selectedAlias,
            'receipt_email' => \App\Models\Setting::get('bank_receipt_email', 'hello@lydam.com'),
        ];
    }
@endphp

<main class="flex-grow w-full max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-24 flex flex-col items-center">
    <div class="bg-surface-container-low border border-surface-container-highest p-8 max-w-2xl w-full text-center">
        
        <div class="mx-auto flex h-20 w-20 items-center justify-center border border-blood-red bg-void-black text-3xl font-headline-lg text-blood-red mb-6">
            OK
        </div>
        
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase tracking-tight">{{ __('messages.order_success_title') }}</h1>
        <p class="mt-4 text-ash-grey font-label-caps text-sm">{{ __('messages.order_success_copy') }}</p>

        @isset($order)
            <div class="mt-8 bg-void-black border border-surface-container-highest p-6 text-left">
                <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block">{{ __('messages.order_number') }}</span>
                <span class="font-headline-lg text-3xl text-blood-red block mt-1">#{{ $order->id }}</span>
                
                <div class="mt-4 flex justify-between font-label-caps text-sm border-t border-surface-container/60 pt-4 text-ash-grey">
                    <span>{{ __('messages.order_status') }}: <strong class="text-raw-white">{{ strtoupper($order->status) }}</strong></span>
                    <span>{{ __('messages.total') }}: <strong class="text-raw-white">${{ number_format((float) $order->total, 0, ',', '.') }} ARS</strong></span>
                </div>
            </div>
        @endisset

        @if ($isTransfer)
            <div class="mt-8 border border-blood-red bg-void-black p-6 text-left">
                <h2 class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest border-b border-surface-container-highest pb-2 mb-4">{{ __('messages.transfer_instructions_title') }}</h2>
                <p class="text-ash-grey font-body-sm mb-6">{{ __('messages.transfer_instructions_copy', ['email' => $bank['receipt_email']]) }}</p>
                
                <dl class="grid gap-4 sm:grid-cols-2 font-label-caps text-xs">
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.bank_holder') }}</dt>
                        <dd class="font-bold text-raw-white">{{ $bank['holder'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.bank_name') }}</dt>
                        <dd class="font-bold text-raw-white">{{ $bank['bank'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.bank_cbu') }}</dt>
                        <dd class="font-bold text-raw-white">{{ $bank['cbu'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.bank_alias') }}</dt>
                        <dd class="font-bold text-raw-white">{{ $bank['alias'] }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        <a href="{{ route('products.index') }}" class="mt-12 inline-block bg-blood-red text-raw-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-raw-white hover:bg-void-black hover:text-blood-red hover:border-blood-red transition-colors duration-300">
            {{ __('messages.back_to_catalog') }}
        </a>
    </div>
</main>
@endsection
