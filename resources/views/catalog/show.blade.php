@extends('layouts.guest')

@section('content')
<main class="flex-grow max-w-max-width mx-auto w-full px-margin-mobile md:px-margin-desktop py-8 md:py-16">
    <!-- Back link -->
    <div class="w-full mb-8">
        <a class="inline-flex items-center gap-2 font-label-caps text-label-caps text-ash-grey hover:text-raw-white transition-colors group" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined text-sm transform group-hover:-translate-x-1 transition-transform">arrow_back</span>
            VOLVER AL CATÁLOGO
        </a>
    </div>

    <!-- Product Section: Bento-ish Grid -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter md:gap-8 items-start">
        
        <!-- Left: Thumbnail Gallery -->
        <div class="md:col-span-1 order-2 md:order-1 flex md:flex-col gap-4 overflow-x-auto md:overflow-visible no-scrollbar pb-4 md:pb-0">
            @foreach ($product->imageUrls() as $index => $url)
                <button type="button" class="thumbnail-btn flex-shrink-0 w-20 h-24 md:w-full md:h-32 border {{ $loop->first ? 'border-blood-red' : 'border-surface-container-highest hover:border-raw-white' }} relative overflow-hidden group transition-colors duration-200" data-large-url="{{ $url }}" data-index="{{ $index }}">
                    <img class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all duration-300" src="{{ $url }}"/>
                </button>
            @endforeach
        </div>
        
        <!-- Center: Main Image -->
        <div id="main-image-container" class="md:col-span-7 order-1 md:order-2 bg-void-black relative w-full max-w-[500px] aspect-[2/3] mx-auto border border-surface-container-highest overflow-hidden group select-none">
            @if ($product->imageUrl())
                <img id="main-image" alt="{{ $product->translatedName() }}" class="absolute inset-0 w-full h-full object-cover object-center z-10" src="{{ $product->imageUrl() }}"/>
            @else
                <div class="absolute inset-0 flex items-center justify-center bg-surface-container-low font-display-xl text-blood-red">
                    LYDAM
                </div>
            @endif
            <!-- Overlay for depth -->
            <div class="absolute inset-0 bg-gradient-to-t from-void-black via-transparent to-transparent opacity-80 pointer-events-none z-20"></div>
            <!-- Drop Badge -->
            <div class="absolute top-4 left-4 bg-blood-red text-void-black font-label-caps text-label-caps px-4 py-2 uppercase tracking-widest font-bold border border-void-black z-20">
                NUEVO DROP
            </div>
        </div>
        
        <!-- Right: Product Info -->
        <div class="md:col-span-4 order-3 flex flex-col gap-8 md:pl-8">
            <div class="flex flex-col gap-2">
                <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-raw-white uppercase gothic-font leading-none">
                    {{ $product->translatedName() }}
                </h1>
                <p class="font-label-caps text-label-caps text-blood-red text-xl tracking-widest mt-2">
                    ${{ number_format($product->price, 0, ',', '.') }} ARS <span class="text-sm text-ash-grey ml-2">(PRECIO POR CURVA)</span>
                </p>
            </div>
            
            <div class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                <p>{{ $product->translatedDescription() }}</p>
            </div>
            
            <!-- Size Selector -->
            @if(!empty($product->sizes))
                <div class="flex flex-col gap-4">
                    <span class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest">VENTA POR CURVA (TALLES INCLUIDOS)</span>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->sizes as $size)
                            <div class="px-4 h-12 min-w-[3rem] flex items-center justify-center border border-surface-container-highest bg-surface-container text-raw-white font-label-caps rounded-none">
                                {{ $size }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Action Form -->
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <div class="flex flex-col gap-4 mb-4">
                    <label for="quantity" class="font-label-caps text-label-caps text-ash-grey uppercase tracking-widest">CANTIDAD DE CURVAS</label>
                    <div class="flex items-center">
                        <input id="quantity" name="quantity" type="number" min="1" max="{{ max($product->stock, 1) }}" value="{{ old('quantity', 1) }}" class="bg-void-black text-raw-white border border-surface-container-highest px-4 py-3 font-label-caps text-center w-24 focus:border-blood-red focus:ring-0 rounded-none">
                    </div>
                </div>
                
                <button type="submit" @disabled($product->stock < 1) class="w-full bg-blood-red text-raw-white font-headline-lg-mobile text-2xl uppercase py-4 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-300 rounded-none tracking-wider disabled:bg-surface-container-highest disabled:text-ash-grey disabled:border-surface-container-highest disabled:cursor-not-allowed">
                    {{ $product->stock < 1 ? 'SIN STOCK' : 'AGREGAR CURVA' }}
                </button>
            </form>
            
            <!-- Accordion details (simulated) -->
            <div class="border-t border-surface-container-highest mt-8 pt-6 flex flex-col gap-4">
                <div class="flex justify-between items-center cursor-pointer group">
                    <span class="font-label-caps text-label-caps uppercase tracking-widest text-raw-white group-hover:text-blood-red transition-colors">DETALLES Y CUIDADO</span>
                    <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red">add</span>
                </div>
                <div class="flex justify-between items-center cursor-pointer group border-t border-surface-container-highest pt-4">
                    <span class="font-label-caps text-label-caps uppercase tracking-widest text-raw-white group-hover:text-blood-red transition-colors">INFORMACIÓN DE ENVÍO</span>
                    <span class="material-symbols-outlined text-raw-white group-hover:text-blood-red">add</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnailBtns = document.querySelectorAll('.thumbnail-btn');
        const mainImage = document.getElementById('main-image');

        thumbnailBtns.forEach(btn => {
            const updateImage = () => {
                const largeUrl = btn.getAttribute('data-large-url');
                if (mainImage && largeUrl) {
                    mainImage.src = largeUrl;
                }
                thumbnailBtns.forEach(b => {
                    b.classList.remove('border-blood-red');
                    b.classList.add('border-surface-container-highest', 'hover:border-raw-white');
                });
                btn.classList.add('border-blood-red');
                btn.classList.remove('border-surface-container-highest', 'hover:border-raw-white');
            };

            btn.addEventListener('click', updateImage);
            btn.addEventListener('mouseenter', updateImage);
        });
    });
</script>
@endsection
