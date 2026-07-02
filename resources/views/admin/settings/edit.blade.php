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

    <!-- Contact & Social Networks -->
    <div class="mt-6 border-t border-surface-container-highest pt-6">
        <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-4 uppercase tracking-wide">Redes Sociales y Contacto</h2>
        
        <div class="grid gap-6 md:grid-cols-3">
            <div>
                <label for="contact_instagram" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Enlace de Instagram</label>
                <input id="contact_instagram" name="contact_instagram" type="url" value="{{ old('contact_instagram', $contact_instagram) }}" placeholder="https://instagram.com/tu_usuario" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
            </div>

            <div>
                <label for="contact_tiktok" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Enlace de TikTok</label>
                <input id="contact_tiktok" name="contact_tiktok" type="url" value="{{ old('contact_tiktok', $contact_tiktok) }}" placeholder="https://tiktok.com/@tu_usuario" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
            </div>

            <div>
                <label for="contact_whatsapp" class="block font-label-caps text-label-caps text-ash-grey uppercase tracking-widest mb-2">Enlace de WhatsApp (wa.me)</label>
                <input id="contact_whatsapp" name="contact_whatsapp" type="text" value="{{ old('contact_whatsapp', $contact_whatsapp) }}" placeholder="https://wa.me/5491122334455" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full">
            </div>
        </div>
    </div>

    <!-- FAQ Manager -->
    <div class="mt-6 border-t border-surface-container-highest pt-6">
        <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white mb-2 uppercase tracking-wide">Preguntas Frecuentes (FAQs)</h2>
        <p class="text-ash-grey text-xs font-label-caps mb-4 uppercase tracking-wider">Añadí, reordená o eliminá las preguntas que verán los clientes en la sección de contacto.</p>
        
        <input type="hidden" id="faq_data_input" name="faq_data" value="{{ old('faq_data', $faq_data) }}">
        
        <div id="faq-items-container" class="space-y-4 mb-6"></div>
        
        <button type="button" id="add-faq-btn" class="bg-surface-container border border-surface-container-highest text-raw-white font-label-caps text-xs py-3 px-6 hover:border-blood-red hover:text-blood-red transition-all duration-200 uppercase tracking-widest">
            Añadir Pregunta
        </button>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <button type="submit" class="bg-blood-red text-raw-white font-label-caps text-xs py-3 px-6 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-200 uppercase tracking-widest">
            Guardar Configuración
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqDataInput = document.getElementById('faq_data_input');
    const container = document.getElementById('faq-items-container');
    const addBtn = document.getElementById('add-faq-btn');

    let faqs = [];
    try {
        faqs = JSON.parse(faqDataInput.value || '[]');
    } catch(e) {
        faqs = [];
    }

    function renderFaqs() {
        container.innerHTML = '';
        if (faqs.length === 0) {
            container.innerHTML = '<div class="border border-dashed border-surface-container-highest bg-void-black p-6 text-center text-ash-grey text-xs font-label-caps">No hay preguntas frecuentes configuradas. Haz clic en "Añadir Pregunta" para empezar.</div>';
            return;
        }

        faqs.forEach((faq, index) => {
            const item = document.createElement('div');
            item.className = 'border border-surface-container-highest bg-void-black/50 p-4 flex flex-col gap-3 relative';
            item.innerHTML = `
                <div class="flex justify-between items-center border-b border-surface-container-highest pb-2">
                    <span class="font-label-caps text-[10px] text-blood-red font-bold tracking-widest">PREGUNTA #${index + 1}</span>
                    <div class="flex gap-4">
                        <button type="button" class="move-up-btn text-ash-grey hover:text-raw-white text-[10px] font-label-caps uppercase disabled:opacity-30" ${index === 0 ? 'disabled' : ''} data-index="${index}">↑ Subir</button>
                        <button type="button" class="move-down-btn text-ash-grey hover:text-raw-white text-[10px] font-label-caps uppercase disabled:opacity-30" ${index === faqs.length - 1 ? 'disabled' : ''} data-index="${index}">↓ Bajar</button>
                        <button type="button" class="delete-faq-btn text-blood-red hover:underline text-[10px] font-label-caps uppercase" data-index="${index}">Eliminar</button>
                    </div>
                </div>
                <div>
                    <label class="block font-label-caps text-[10px] text-ash-grey uppercase tracking-wider mb-1">Pregunta (Español)</label>
                    <input type="text" class="faq-q bg-void-black text-raw-white border border-surface-container-highest px-3 py-2 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full" value="${escapeHtml(faq.q || '')}" data-index="${index}">
                </div>
                <div>
                    <label class="block font-label-caps text-[10px] text-ash-grey uppercase tracking-wider mb-1">Respuesta (Español)</label>
                    <textarea class="faq-a bg-void-black text-raw-white border border-surface-container-highest px-3 py-2 font-label-caps focus:border-blood-red focus:ring-0 rounded-none w-full" rows="2" data-index="${index}">${escapeHtml(faq.a || '')}</textarea>
                </div>
            `;
            container.appendChild(item);
        });

        // Add event listeners to input updates
        document.querySelectorAll('.faq-q').forEach(input => {
            input.addEventListener('input', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                faqs[idx].q = this.value;
                updateHiddenInput();
            });
        });

        document.querySelectorAll('.faq-a').forEach(textarea => {
            textarea.addEventListener('input', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                faqs[idx].a = this.value;
                updateHiddenInput();
            });
        });

        document.querySelectorAll('.delete-faq-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                faqs.splice(idx, 1);
                renderFaqs();
                updateHiddenInput();
            });
        });

        document.querySelectorAll('.move-up-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                if (idx > 0) {
                    const temp = faqs[idx];
                    faqs[idx] = faqs[idx - 1];
                    faqs[idx - 1] = temp;
                    renderFaqs();
                    updateHiddenInput();
                }
            });
        });

        document.querySelectorAll('.move-down-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'));
                if (idx < faqs.length - 1) {
                    const temp = faqs[idx];
                    faqs[idx] = faqs[idx + 1];
                    faqs[idx + 1] = temp;
                    renderFaqs();
                    updateHiddenInput();
                }
            });
        });
    }

    function updateHiddenInput() {
        faqDataInput.value = JSON.stringify(faqs);
    }

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    addBtn.addEventListener('click', function() {
        faqs.push({ q: '', a: '' });
        renderFaqs();
        updateHiddenInput();
    });

    renderFaqs();
});
</script>
@endsection
