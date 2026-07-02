@extends('layouts.guest')

@section('content')
<main class="flex-grow max-w-max-width mx-auto w-full px-margin-mobile md:px-margin-desktop py-8 md:py-16">
    <div class="mb-12 border-b border-surface-container-highest pb-6 text-center md:text-left">
        <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">¿CÓMO PODEMOS AYUDARTE?</span>
        <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">CONTACTO Y PREGUNTAS</h1>
    </div>

    <!-- Social Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        <!-- Instagram -->
        <a href="{{ $instagram ?? '#' }}" target="_blank" class="group block bg-surface-container-low border border-surface-container-highest p-8 hover:border-blood-red transition-all duration-300 relative overflow-hidden">
            <div class="flex flex-col h-full justify-between gap-8">
                <div>
                    <span class="font-label-caps text-[10px] text-blood-red tracking-wider block mb-1">COMUNIDAD</span>
                    <h3 class="font-headline-lg-mobile text-raw-white uppercase group-hover:text-blood-red transition-colors">INSTAGRAM</h3>
                    <p class="text-xs text-ash-grey font-label-caps mt-2 uppercase tracking-wide">Enterate de los nuevos drops y novedades diarias.</p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-[10px] font-label-caps text-raw-white group-hover:underline">@LYDAM.STORE</span>
                    <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red transform group-hover:translate-x-1 transition-all">arrow_forward</span>
                </div>
            </div>
        </a>

        <!-- TikTok -->
        <a href="{{ $tiktok ?? '#' }}" target="_blank" class="group block bg-surface-container-low border border-surface-container-highest p-8 hover:border-blood-red transition-all duration-300 relative overflow-hidden">
            <div class="flex flex-col h-full justify-between gap-8">
                <div>
                    <span class="font-label-caps text-[10px] text-blood-red tracking-wider block mb-1">INSPIRACIÓN</span>
                    <h3 class="font-headline-lg-mobile text-raw-white uppercase group-hover:text-blood-red transition-colors">TIKTOK</h3>
                    <p class="text-xs text-ash-grey font-label-caps mt-2 uppercase tracking-wide">Descubrí el detrás de escena de la colección.</p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-[10px] font-label-caps text-raw-white group-hover:underline">VER NUESTRO FEED</span>
                    <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red transform group-hover:translate-x-1 transition-all">arrow_forward</span>
                </div>
            </div>
        </a>

        <!-- WhatsApp -->
        <a href="{{ $whatsapp ?? '#' }}" target="_blank" class="group block bg-surface-container-low border border-surface-container-highest p-8 hover:border-blood-red transition-all duration-300 relative overflow-hidden">
            <div class="flex flex-col h-full justify-between gap-8">
                <div>
                    <span class="font-label-caps text-[10px] text-blood-red tracking-wider block mb-1">ATENCIÓN MAYORISTA</span>
                    <h3 class="font-headline-lg-mobile text-raw-white uppercase group-hover:text-blood-red transition-colors">WHATSAPP</h3>
                    <p class="text-xs text-ash-grey font-label-caps mt-2 uppercase tracking-wide">Soporte directo para compras por curva cerrada.</p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <span class="text-[10px] font-label-caps text-raw-white group-hover:underline">ENVIAR MENSAJE</span>
                    <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red transform group-hover:translate-x-1 transition-all">arrow_forward</span>
                </div>
            </div>
        </a>
    </div>

    <!-- FAQ Accordion -->
    <div class="max-w-3xl mx-auto">
        <div class="mb-8 border-b border-surface-container-highest pb-4 text-center">
            <h2 class="font-headline-lg-mobile text-headline-lg-mobile text-raw-white uppercase tracking-wider">PREGUNTAS FRECUENTES</h2>
        </div>

        @if(!empty($faqs) && count($faqs) > 0)
            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                    @if(!empty($faq['q']) && !empty($faq['a']))
                        <div class="border border-surface-container-highest bg-surface-container-low/30 transition-colors duration-300">
                            <!-- Header Trigger -->
                            <button type="button" class="w-full flex justify-between items-center p-6 text-left focus:outline-none faq-trigger group" data-target="faq-answer-{{ $index }}">
                                <span class="font-headline-lg-mobile text-sm text-raw-white uppercase tracking-wider group-hover:text-blood-red transition-colors duration-200">
                                    {{ $faq['q'] }}
                                </span>
                                <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red transition-transform duration-300 faq-icon">
                                    expand_more
                                </span>
                            </button>
                            <!-- Content Area -->
                            <div id="faq-answer-{{ $index }}" class="faq-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                                <div class="p-6 pt-0 border-t border-surface-container-highest/20 font-body-md text-on-surface-variant leading-relaxed text-sm">
                                    {!! nl2br(e($faq['a'])) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="border border-dashed border-surface-container-highest bg-surface-container-low/20 p-10 text-center">
                <h3 class="font-headline-lg-mobile text-raw-white uppercase">MUY PRONTO MÁS NOVEDADES</h3>
                <p class="mt-2 text-ash-grey font-label-caps text-xs">Estamos configurando las preguntas frecuentes. Comunícate mediante WhatsApp ante cualquier consulta.</p>
            </div>
        @endif
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const triggers = document.querySelectorAll('.faq-trigger');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = this.querySelector('.faq-icon');

            if (!content) return;

            const isOpened = content.style.maxHeight && content.style.maxHeight !== '0px';

            // Close all other FAQs
            document.querySelectorAll('.faq-content').forEach(el => {
                el.style.maxHeight = '0px';
            });
            document.querySelectorAll('.faq-icon').forEach(el => {
                el.style.transform = 'rotate(0deg)';
            });

            // Toggle selected FAQ
            if (!isOpened) {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.style.maxHeight = '0px';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
});
</script>
@endsection
