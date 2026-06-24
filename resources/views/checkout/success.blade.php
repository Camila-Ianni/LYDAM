@extends('layouts.guest')

@section('content')
@php
    $isTransfer = isset($order) && $order?->payment_method === \App\Models\Order::PAYMENT_TRANSFER;
    $bank = [
        'holder' => config('services.bank.holder', 'Stitch Shop SRL'),
        'bank' => config('services.bank.name', 'Banco Ohana'),
        'cbu' => config('services.bank.cbu', '0000003100098765432101'),
        'alias' => config('services.bank.alias', 'STITCH.OHANA.SHOP'),
    ];
@endphp

<section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="rounded-3xl bg-white p-8 text-center shadow-xl">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-3xl font-black text-emerald-700">OK</div>
        <h1 class="mt-6 text-4xl font-black text-stitch-navy">{{ __('messages.order_success_title') }}</h1>
        <p class="mx-auto mt-3 max-w-2xl text-slate-600">{{ __('messages.order_success_copy') }}</p>

        @isset($order)
            <div class="mx-auto mt-8 max-w-md rounded-2xl bg-sky-50 p-5 text-left">
                <p class="text-sm font-bold text-slate-500">{{ __('messages.order_number') }}</p>
                <p class="text-2xl font-black text-stitch-blue">#{{ $order->id }}</p>
                <p class="mt-3 text-sm text-slate-600">{{ __('messages.order_status') }}: <strong>{{ $order->status }}</strong></p>
                <p class="text-sm text-slate-600">{{ __('messages.total') }}: <strong>${{ number_format((float) $order->total, 2, ',', '.') }}</strong></p>
            </div>
        @endisset

        @if ($isTransfer)
            <div class="mt-8 rounded-2xl border border-stitch-aqua bg-cyan-50 p-6 text-left">
                <h2 class="text-xl font-black text-stitch-navy">{{ __('messages.transfer_instructions_title') }}</h2>
                <p class="mt-2 text-slate-700">{{ __('messages.transfer_instructions_copy') }}</p>
                <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.bank_holder') }}</dt>
                        <dd class="font-bold text-stitch-navy">{{ $bank['holder'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.bank_name') }}</dt>
                        <dd class="font-bold text-stitch-navy">{{ $bank['bank'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.bank_cbu') }}</dt>
                        <dd class="font-bold text-stitch-navy">{{ $bank['cbu'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.bank_alias') }}</dt>
                        <dd class="font-bold text-stitch-navy">{{ $bank['alias'] }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        <a href="{{ route('products.index') }}" class="mt-8 inline-flex rounded-full bg-stitch-blue px-6 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-stitch-navy">
            {{ __('messages.back_to_catalog') }}
        </a>
    </div>
</section>
@endsection
