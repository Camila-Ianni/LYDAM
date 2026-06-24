@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4">
    <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.admin_panel') }}</span>
    <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">{{ __('messages.orders') }}</h1>
</div>

<div class="bg-surface-container-low border border-surface-container-highest p-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left font-label-caps text-sm border-collapse">
            <thead>
                <tr class="bg-void-black text-ash-grey border-b border-surface-container-highest text-xs uppercase font-bold">
                    <th class="px-6 py-4">{{ __('messages.order') }}</th>
                    <th class="px-6 py-4">{{ __('messages.customer') }}</th>
                    <th class="px-6 py-4">{{ __('messages.payment_method') }}</th>
                    <th class="px-6 py-4 text-center">{{ __('messages.status') }}</th>
                    <th class="px-6 py-4 text-right">{{ __('messages.total') }}</th>
                    <th class="px-6 py-4 text-center">{{ __('messages.date') }}</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-highest">
                @foreach ($orders as $order)
                    <tr class="hover:bg-void-black transition-colors">
                        <td class="px-6 py-4 font-bold text-blood-red">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-raw-white uppercase leading-tight">{{ $order->buyer_name }}</p>
                            <p class="text-xs text-ash-grey mt-1 font-mono">{{ $order->buyer_email }}</p>
                        </td>
                        <td class="px-6 py-4 text-ash-grey uppercase text-xs">{{ $order->payment_method }}</td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClass = match($order->status) {
                                    \App\Models\Order::STATUS_PAID => 'border-emerald-500 text-emerald-500',
                                    \App\Models\Order::STATUS_SHIPPED => 'border-sky-500 text-sky-500',
                                    \App\Models\Order::STATUS_PENDING => 'border-amber-500 text-amber-500',
                                    default => 'border-blood-red text-blood-red',
                                };
                            @endphp
                            <span class="border {{ $statusClass }} px-3 py-1 text-xs uppercase tracking-wider">
                                {{ $statuses[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-raw-white font-bold">${{ number_format((float) $order->total, 0, ',', '.') }} ARS</td>
                        <td class="px-6 py-4 text-center text-ash-grey text-xs">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="bg-surface-container border border-surface-container-highest px-3 py-2 text-xs font-label-caps text-raw-white hover:border-blood-red hover:text-blood-red transition-colors inline-block">
                                {{ __('messages.view') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if (method_exists($orders, 'links'))
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
@endif
@endsection
