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
    <div class="bg-white border border-surface-container-highest p-8 max-w-2xl w-full text-center shadow-sm">
        
        <div class="mx-auto flex h-20 w-20 items-center justify-center border border-blood-red bg-surface-container-low text-3xl font-headline-lg text-blood-red mb-6 shadow-sm">
            OK
        </div>
        
        <h1 class="font-headline-lg text-headline-lg text-zinc-950 uppercase tracking-tight font-bold">{{ __('messages.order_success_title') }}</h1>
        <p class="mt-4 text-ash-grey font-label-caps text-sm">{{ __('messages.order_success_copy') }}</p>

        @isset($order)
            <div class="mt-8 bg-surface-container-low border border-surface-container-highest p-6 text-left">
                <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block font-bold">{{ __('messages.order_number') }}</span>
                <span class="font-headline-lg text-3xl text-blood-red block mt-1 font-bold">#{{ $order->id }}</span>
                
                <div class="mt-4 flex justify-between font-label-caps text-sm border-t border-surface-container-highest pt-4 text-ash-grey font-bold">
                    <span>{{ __('messages.order_status') }}: <strong class="text-zinc-950">{{ strtoupper($order->status) }}</strong></span>
                    <span>{{ __('messages.total') }}: <strong class="text-zinc-950">${{ number_format((float) $order->total, 0, ',', '.') }} ARS</strong></span>
                </div>
            </div>
        @endisset

        @if ($isTransfer)
            <div class="mt-8 border border-blood-red bg-surface-container-low p-6 text-left shadow-sm">
                <h2 class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest border-b border-surface-container-highest pb-2 mb-4 font-bold">{{ __('messages.transfer_instructions_title') }}</h2>
                <p class="text-ash-grey font-body-sm mb-6">{{ __('messages.transfer_instructions_copy', ['email' => $bank['receipt_email']]) }}</p>
                
                <dl class="grid gap-4 sm:grid-cols-2 font-label-caps text-xs">
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1 font-bold">{{ __('messages.bank_holder') }}</dt>
                        <dd class="font-bold text-zinc-950">{{ $bank['holder'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1 font-bold">{{ __('messages.bank_name') }}</dt>
                        <dd class="font-bold text-zinc-950">{{ $bank['bank'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1 font-bold">{{ __('messages.bank_cbu') }}</dt>
                        <dd class="font-bold text-zinc-950">{{ $bank['cbu'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-ash-grey uppercase tracking-wider mb-1 font-bold">{{ __('messages.bank_alias') }}</dt>
                        <dd class="font-bold text-zinc-950">{{ $bank['alias'] }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        <a href="{{ route('products.index') }}" class="mt-12 inline-block bg-blood-red text-white font-headline-lg-mobile text-headline-lg-mobile py-4 px-12 border border-blood-red hover:bg-black hover:text-white transition-colors duration-300 font-bold shadow-md">
            {{ __('messages.back_to_catalog') }}
        </a>
    </div>
</main>
@endsection
