@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="text-sm font-black uppercase tracking-wide text-stitch-hibiscus">{{ __('messages.admin_panel') }}</p>
        <h1 class="mt-2 text-4xl font-black text-stitch-navy">{{ __('messages.products') }}</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="rounded-full bg-stitch-blue px-5 py-3 text-sm font-black uppercase tracking-wide text-white hover:bg-stitch-navy">
        {{ __('messages.new_product') }}
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-sky-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-sky-100">
            <thead class="bg-sky-50 text-left text-xs font-black uppercase tracking-wide text-stitch-navy">
                <tr>
                    <th class="px-5 py-4">{{ __('messages.product') }}</th>
                    <th class="px-5 py-4">{{ __('messages.sku') }}</th>
                    <th class="px-5 py-4">{{ __('messages.price') }}</th>
                    <th class="px-5 py-4">{{ __('messages.stock') }}</th>
                    <th class="px-5 py-4">{{ __('messages.status') }}</th>
                    <th class="px-5 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sky-100">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 overflow-hidden rounded-xl bg-sky-100">
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->translatedName() }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center font-black text-stitch-blue">S</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-stitch-navy">{{ $product->translatedName('es') }}</p>
                                    <p class="text-sm text-slate-500">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm font-bold text-slate-700">{{ $product->sku }}</td>
                        <td class="px-5 py-4 text-sm font-black text-stitch-blue">${{ number_format((float) $product->price, 2, ',', '.') }}</td>
                        <td class="px-5 py-4 text-sm font-bold text-slate-700">{{ $product->stock }}</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }} px-3 py-1 text-xs font-bold">
                                {{ $product->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="rounded-xl bg-sky-50 px-3 py-2 text-xs font-bold text-stitch-blue hover:bg-sky-100">
                                    {{ __('messages.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('{{ __('messages.confirm_delete_product') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $products->links() }}
</div>
@endsection
