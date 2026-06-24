@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end border-b border-surface-container-highest pb-4">
    <div>
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.order_detail') }}</span>
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">{{ __('messages.order') }} #{{ $order->id }}</h1>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="bg-void-black border border-surface-container-highest px-5 py-3 text-xs font-label-caps text-raw-white hover:border-blood-red hover:text-blood-red transition-colors uppercase">
        {{ __('messages.back_to_orders') }}
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    <div class="lg:col-span-8 space-y-8">
        
        <!-- Items table -->
        <div class="bg-surface-container-low border border-surface-container-highest p-8">
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-6 uppercase tracking-wide">{{ __('messages.items_purchased') }}</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left font-label-caps text-sm border-collapse">
                    <thead>
                        <tr class="bg-void-black text-ash-grey border-b border-surface-container-highest text-xs uppercase font-bold">
                            <th class="px-6 py-4">PRODUCTO</th>
                            <th class="px-6 py-4 text-center">CANTIDAD</th>
                            <th class="px-6 py-4 text-right">PRECIO UNITARIO</th>
                            <th class="px-6 py-4 text-right">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-highest">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-raw-white uppercase leading-tight">{{ $item->product_name }}</p>
                                    <p class="text-xs text-ash-grey mt-1 font-mono">{{ $item->product_sku }}</p>
                                </td>
                                <td class="px-6 py-4 text-center text-raw-white">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right text-raw-white">${{ number_format((float) $item->unit_price, 0, ',', '.') }} ARS</td>
                                <td class="px-6 py-4 text-right text-blood-red font-bold">${{ number_format((float) $item->total, 0, ',', '.') }} ARS</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Customer data -->
        <div class="bg-surface-container-low border border-surface-container-highest p-8">
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-6 uppercase tracking-wide">{{ __('messages.customer_data') }}</h2>
            
            <dl class="grid gap-6 sm:grid-cols-2 font-label-caps text-sm">
                <div>
                    <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.buyer_name') }}</dt>
                    <dd class="font-bold text-raw-white">{{ $order->buyer_name }}</dd>
                </div>
                <div>
                    <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.buyer_dni') }}</dt>
                    <dd class="font-bold text-raw-white font-mono">{{ $order->buyer_dni }}</dd>
                </div>
                <div>
                    <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.buyer_email') }}</dt>
                    <dd class="font-bold text-raw-white font-mono">{{ $order->buyer_email }}</dd>
                </div>
                <div>
                    <dt class="text-ash-grey uppercase tracking-wider mb-1">{{ __('messages.buyer_phone') }}</dt>
                    <dd class="font-bold text-raw-white font-mono">{{ $order->buyer_phone }}</dd>
                </div>
            </dl>
        </div>

    </div>

    <!-- Summary & actions -->
    <div class="lg:col-span-4 space-y-8">
        <div class="bg-surface-container-low border border-surface-container-highest p-8">
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-6 uppercase tracking-wide">{{ __('messages.order_summary') }}</h2>
            
            <dl class="space-y-4 font-label-caps text-sm border-b border-surface-container-highest pb-6 mb-6">
                <div class="flex justify-between gap-4 text-ash-grey">
                    <dt>{{ __('messages.payment_method') }}</dt>
                    <dd class="font-bold text-raw-white uppercase">{{ $order->payment_method }}</dd>
                </div>
                <div class="flex justify-between gap-4 text-ash-grey">
                    <dt>{{ __('messages.payment_reference') }}</dt>
                    <dd class="font-bold text-raw-white font-mono">{{ $order->payment_reference ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-4 text-ash-grey">
                    <dt>{{ __('messages.subtotal') }}</dt>
                    <dd class="font-bold text-raw-white">${{ number_format((float) $order->subtotal, 0, ',', '.') }}</dd>
                </div>
            </dl>
            
            <div class="flex justify-between items-center font-headline-lg-mobile text-headline-lg-mobile mb-8">
                <span class="text-raw-white">TOTAL</span>
                <span class="text-blood-red">${{ number_format((float) $order->total, 0, ',', '.') }} ARS</span>
            </div>

            <!-- Update status form -->
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="border-t border-surface-container-highest pt-6">
                @csrf
                @method('PATCH')
                <label for="status" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-3">{{ __('messages.update_status') }}</label>
                <select id="status" name="status" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full appearance-none mb-4">
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-blood-red text-raw-white font-headline-lg-mobile text-xl uppercase py-3 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-300 rounded-none tracking-wider text-center justify-center">
                    {{ __('messages.save_status') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
