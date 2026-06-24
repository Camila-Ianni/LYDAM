@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end border-b border-surface-container-highest pb-4">
    <div>
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">{{ __('messages.admin_panel') }}</span>
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">{{ __('messages.products') }}</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-blood-red text-raw-white font-label-caps text-xs py-3 px-6 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-200 uppercase tracking-widest text-center">
        {{ __('messages.new_product') }}
    </a>
</div>

<div class="bg-surface-container-low border border-surface-container-highest p-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left font-label-caps text-sm border-collapse">
            <thead>
                <tr class="bg-void-black text-ash-grey border-b border-surface-container-highest text-xs uppercase font-bold">
                    <th class="px-6 py-4">{{ __('messages.product') }}</th>
                    <th class="px-6 py-4">{{ __('messages.sku') }}</th>
                    <th class="px-6 py-4">{{ __('messages.price') }}</th>
                    <th class="px-6 py-4 text-center">{{ __('messages.stock') }}</th>
                    <th class="px-6 py-4 text-center">{{ __('messages.status') }}</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-highest">
                @foreach ($products as $product)
                    <tr class="hover:bg-void-black transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-14 w-14 overflow-hidden border border-surface-container-highest shrink-0 bg-void-black">
                                    @if ($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->translatedName() }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full items-center justify-center font-bold text-blood-red">LYD</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-raw-white uppercase leading-tight">{{ $product->translatedName('es') }}</p>
                                    <p class="text-xs text-ash-grey mt-1 font-mono">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ash-grey font-mono">{{ $product->sku }}</td>
                        <td class="px-6 py-4 text-raw-white font-bold">${{ number_format((float) $product->price, 0, ',', '.') }} ARS</td>
                        <td class="px-6 py-4 text-center text-raw-white">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="border {{ $product->is_active ? 'border-blood-red text-blood-red' : 'border-surface-container-highest text-ash-grey' }} px-3 py-1 text-xs uppercase tracking-wider">
                                {{ $product->is_active ? __('messages.active') : __('messages.inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="bg-surface-container border border-surface-container-highest px-3 py-2 text-xs font-label-caps text-raw-white hover:border-blood-red hover:text-blood-red transition-colors">
                                    {{ __('messages.edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('{{ __('messages.confirm_delete_product') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-void-black border border-surface-container-highest px-3 py-2 text-xs font-label-caps text-blood-red hover:bg-blood-red hover:text-raw-white transition-colors">
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

@if (method_exists($products, 'links'))
    <div class="mt-8">
        {{ $products->links() }}
    </div>
@endif
@endsection
