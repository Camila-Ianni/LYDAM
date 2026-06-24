@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4 flex flex-wrap justify-between items-end gap-4">
    <div>
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">ESTADÍSTICAS DE VENTAS</span>
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">DASHBOARD DE VENTAS</h1>
    </div>
    <div class="bg-surface-container-low border border-surface-container-highest px-4 py-2">
        <span class="font-label-caps text-[10px] text-ash-grey uppercase tracking-widest block">TIPO DE ÓRDENES</span>
        <span class="font-label-caps text-raw-white block text-xs font-bold">PAGADAS O ENVIADAS</span>
    </div>
</div>

<!-- Sales overview cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container-low border border-surface-container-highest p-8 flex flex-col justify-between">
        <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block mb-2">TOTAL FACTURADO</span>
        <span class="font-headline-lg text-3xl text-raw-white font-bold">${{ number_format($totalSalesSum, 0, ',', '.') }} <span class="text-xs text-ash-grey font-label-caps">ARS</span></span>
    </div>
    <div class="bg-surface-container-low border border-surface-container-highest p-8 flex flex-col justify-between">
        <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest block mb-2">COSTO TOTAL</span>
        <span class="font-headline-lg text-3xl text-ash-grey font-bold">${{ number_format($totalCostSum, 0, ',', '.') }} <span class="text-xs text-ash-grey font-label-caps">ARS</span></span>
    </div>
    <div class="bg-surface-container-low border border-blood-red p-8 flex flex-col justify-between">
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest block mb-2">GANANCIA NETA</span>
        <span class="font-headline-lg text-3xl text-blood-red font-bold">${{ number_format($totalProfitSum, 0, ',', '.') }} <span class="text-xs text-blood-red font-label-caps">ARS</span></span>
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
                    <th class="px-6 py-4 text-right">COSTO TOTAL</th>
                    <th class="px-6 py-4 text-right">GANANCIA NETA</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-highest">
                @forelse ($productSales as $sales)
                    <tr class="hover:bg-void-black transition-colors">
                        <td class="px-6 py-4 font-bold text-raw-white uppercase">{{ $sales['name'] }}</td>
                        <td class="px-6 py-4 text-ash-grey">{{ $sales['sku'] }}</td>
                        <td class="px-6 py-4 text-center text-raw-white font-bold">{{ $sales['quantity'] }}</td>
                        <td class="px-6 py-4 text-right text-raw-white font-bold">${{ number_format($sales['total'], 0, ',', '.') }} ARS</td>
                        <td class="px-6 py-4 text-right text-ash-grey">${{ number_format($sales['total_cost'], 0, ',', '.') }} ARS</td>
                        <td class="px-6 py-4 text-right text-blood-red font-bold">${{ number_format($sales['total_profit'], 0, ',', '.') }} ARS</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-ash-grey">No se registraron ventas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
