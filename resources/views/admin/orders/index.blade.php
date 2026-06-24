@extends('layouts.app')

@section('content')
<div class="mb-8">
    <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.admin_panel') }}</p>
    <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.orders') }}</h1>
</div>

<div class="overflow-hidden rounded-2xl border border-sky-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-sky-100">
            <thead class="bg-sky-50 text-left text-xs font-black uppercase tracking-wide text-stitch-navy">
                <tr>
                    <th class="px-5 py-4">{{ __('messages.order') }}</th>
                    <th class="px-5 py-4">{{ __('messages.customer') }}</th>
                    <th class="px-5 py-4">{{ __('messages.payment_method') }}</th>
                    <th class="px-5 py-4">{{ __('messages.status') }}</th>
                    <th class="px-5 py-4">{{ __('messages.total') }}</th>
                    <th class="px-5 py-4">{{ __('messages.date') }}</th>
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sky-100">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-5 py-4 font-black text-stitch-blue">#{{ $order->id }}</td>
                        <td class="px-5 py-4">
                            <p class="font-bold text-stitch-navy">{{ $order->buyer_name }}</p>
                            <p class="text-sm text-slate-500">{{ $order->buyer_email }}</p>
                        </td>
                        <td class="px-5 py-4 text-sm font-bold text-slate-700">{{ $order->payment_method }}</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-bold text-stitch-navy">{{ $statuses[$order->status] ?? $order->status }}</span>
                        </td>
                        <td class="px-5 py-4 font-black text-stitch-blue">${{ number_format((float) $order->total, 2, ',', '.') }}</td>
                        <td class="px-5 py-4 text-sm text-slate-600">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="rounded-xl bg-stitch-blue px-3 py-2 text-xs font-bold text-white hover:bg-stitch-navy">
                                {{ __('messages.view') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $orders->links() }}
</div>
@endsection
