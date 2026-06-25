@extends('layouts.app')

@section('content')
<div class="mb-8 border-b border-surface-container-highest pb-4">
    <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">CONFIGURACIÓN GENERAL</span>
    <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">CONFIGURACIÓN BANCARIA</h1>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" class="bg-surface-container-low border border-surface-container-highest p-8">
    @csrf

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="bank_holder" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Titular de la Cuenta</label>
            <input id="bank_holder" name="bank_holder" type="text" value="{{ old('bank_holder', $bank_holder) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
        </div>

        <div>
            <label for="bank_name" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Nombre del Banco</label>
            <input id="bank_name" name="bank_name" type="text" value="{{ old('bank_name', $bank_name) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
        </div>
    </div>

    <div class="mt-6 grid gap-6 md:grid-cols-2">
        <div>
            <label for="bank_cbu" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">CBU / CVU</label>
            <input id="bank_cbu" name="bank_cbu" type="text" value="{{ old('bank_cbu', $bank_cbu) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
        </div>

        <div>
            <label for="bank_threshold" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Límite para cambiar de Alias ($ ARS)</label>
            <input id="bank_threshold" name="bank_threshold" type="number" step="1" min="0" value="{{ old('bank_threshold', $bank_threshold) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
            <p class="mt-2 text-xs text-ash-grey font-label-caps">Monto total a partir del cual se utilizará el Alias 2 en vez del Alias 1.</p>
        </div>
    </div>

    <div class="mt-6">
        <label for="bank_receipt_email" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Email para Recibir Comprobantes de Transferencia</label>
        <input id="bank_receipt_email" name="bank_receipt_email" type="email" value="{{ old('bank_receipt_email', $bank_receipt_email) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
        <p class="mt-2 text-xs text-ash-grey font-label-caps">La dirección de correo electrónico que se mostrará a los clientes al finalizar el checkout para que envíen el comprobante de pago.</p>
    </div>

    <div class="mt-6 border-t border-surface-container-highest pt-6">
        <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-4 uppercase tracking-wide">Cuentas / Alias Destino</h2>
        
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="bank_alias_1" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Alias 1 (Compras < Límite)</label>
                <input id="bank_alias_1" name="bank_alias_1" type="text" value="{{ old('bank_alias_1', $bank_alias_1) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                <p class="mt-2 text-xs text-ash-grey font-label-caps">Se muestra para pedidos con un total inferior al límite configurado arriba.</p>
            </div>

            <div>
                <label for="bank_alias_2" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Alias 2 (Compras >= Límite)</label>
                <input id="bank_alias_2" name="bank_alias_2" type="text" value="{{ old('bank_alias_2', $bank_alias_2) }}" required class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
                <p class="mt-2 text-xs text-ash-grey font-label-caps">Se muestra para pedidos con un total igual o superior al límite configurado arriba.</p>
            </div>
        </div>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <button type="submit" class="bg-blood-red text-raw-white font-label-caps text-xs py-3 px-6 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-200 uppercase tracking-widest">
            Guardar Configuración
        </button>
    </div>
</form>
@endsection
