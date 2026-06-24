@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4">
    <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">ESTADÍSTICAS DE VENTAS</span>
    <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">DASHBOARD DE VENTAS</h1>
</div>

<!-- Sales overview card -->
<div class="bg-surface-container-low border border-blood-red p-8 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
    <div class="text-center md:text-left">
        <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block mb-1">TOTAL FACTURADO</span>
        <span class="font-headline-lg text-4xl md:text-5xl text-blood-red">${{ number_format($totalSalesSum, 0, ',', '.') }} ARS</span>
    </div>
    <div class="text-center md:text-right">
        <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block mb-1">TIPO DE ORDENES</span>
        <span class="font-label-caps text-raw-white block text-sm">SÓLO ÓRDENES PAGADAS O ENVIADAS</span>
    </div>
</div>

<!-- Products Sales Table -->
<div class="bg-surface-container-low border border-surface-container-highest p-8">
    <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-6 uppercase tracking-wide">VENTAS POR PRODUCTO</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left font-label-caps text-sm border-collapse">
            <thead>
                <tr class="bg-void-black text-ash-grey border-b border-surface-container-highest text-xs uppercase font-bold">
                    <th class="px-6 py-4">PRODUCTO</th>
                    <th class="px-6 py-4">SKU</th>
                    <th class="px-6 py-4 text-center">CANTIDAD VENDIDA (CURVAS)</th>
                    <th class="px-6 py-4 text-right">TOTAL RECAUDADO</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-highest">
                @forelse ($productSales as $sales)
                    <tr class="hover:bg-void-black transition-colors">
                        <td class="px-6 py-4 font-bold text-raw-white uppercase">{{ $sales['name'] }}</td>
                        <td class="px-6 py-4 text-ash-grey">{{ $sales['sku'] }}</td>
                        <td class="px-6 py-4 text-center text-raw-white font-bold">{{ $sales['quantity'] }}</td>
                        <td class="px-6 py-4 text-right text-blood-red font-bold">${{ number_format($sales['total'], 0, ',', '.') }} ARS</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-ash-grey">No se registraron ventas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
