@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.order_detail') }}</p>
        <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.order') }} #{{ $order->id }}</h1>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-sky-200 px-5 py-3 text-sm font-black uppercase tracking-wide text-stitch-navy hover:bg-sky-50">
        {{ __('messages.back_to_orders') }}
    </a>
</div>

<div class="grid gap-6 lg:grid-cols-[1fr_360px]">
    <div class="space-y-6">
        <section class="rounded-3xl border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-stitch-navy">{{ __('messages.items_purchased') }}</h2>
            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full divide-y divide-sky-100">
                    <thead class="bg-sky-50 text-left text-xs font-black uppercase tracking-wide text-stitch-navy">
                        <tr>
                            <th class="px-4 py-3">{{ __('messages.product') }}</th>
                            <th class="px-4 py-3">{{ __('messages.quantity') }}</th>
                            <th class="px-4 py-3">{{ __('messages.unit_price') }}</th>
                            <th class="px-4 py-3">{{ __('messages.subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-stitch-navy">{{ $item->product_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $item->product_sku }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-700">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-700">${{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 font-black text-stitch-blue">${{ number_format((float) $item->total, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-3xl border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-black text-stitch-navy">{{ __('messages.customer_data') }}</h2>
            <dl class="mt-5 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.buyer_name') }}</dt>
                    <dd class="font-bold text-stitch-navy">{{ $order->buyer_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.buyer_dni') }}</dt>
                    <dd class="font-bold text-stitch-navy">{{ $order->buyer_dni }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.buyer_email') }}</dt>
                    <dd class="font-bold text-stitch-navy">{{ $order->buyer_email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-black uppercase tracking-wide text-slate-500">{{ __('messages.buyer_phone') }}</dt>
                    <dd class="font-bold text-stitch-navy">{{ $order->buyer_phone }}</dd>
                </div>
            </dl>
        </section>
    </div>

    <aside class="h-fit rounded-3xl bg-stitch-navy p-6 text-white shadow-lg">
        <h2 class="text-xl font-black">{{ __('messages.order_summary') }}</h2>
        <dl class="mt-5 space-y-4">
            <div class="flex justify-between gap-4">
                <dt class="text-sky-100">{{ __('messages.payment_method') }}</dt>
                <dd class="font-bold">{{ $order->payment_method }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-sky-100">{{ __('messages.payment_reference') }}</dt>
                <dd class="text-right font-bold">{{ $order->payment_reference ?? '-' }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-sky-100">{{ __('messages.subtotal') }}</dt>
                <dd class="font-bold">${{ number_format((float) $order->subtotal, 2, ',', '.') }}</dd>
            </div>
            <div class="flex justify-between gap-4 border-t border-white/10 pt-4">
                <dt class="font-black">{{ __('messages.total') }}</dt>
                <dd class="text-2xl font-black">${{ number_format((float) $order->total, 2, ',', '.') }}</dd>
            </div>
        </dl>

        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mt-6 rounded-2xl bg-white/10 p-4">
            @csrf
            @method('PATCH')
            <label for="status" class="block text-sm font-bold text-sky-50">{{ __('messages.update_status') }}</label>
            <select id="status" name="status" class="mt-2 w-full rounded-xl border-0 px-4 py-3 text-stitch-navy">
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="mt-4 w-full rounded-full bg-stitch-hibiscus px-5 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-pink-500">
                {{ __('messages.save_status') }}
            </button>
        </form>
    </aside>
</div>
@endsection
