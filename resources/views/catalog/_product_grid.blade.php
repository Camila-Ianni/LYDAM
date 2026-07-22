@php
    $products = $products ?? collect();
@endphp

@if ($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-gutter gap-y-12">
        @foreach ($products as $product)
            <div class="group flex flex-col border border-transparent hover:border-blood-red transition-all duration-300 relative bg-surface-container-lowest">
                <!-- Image Container -->
                <div class="relative aspect-[3/4] overflow-hidden bg-surface-container w-full">
                    <!-- Link around Image / Slider -->
                    <div class="w-full h-full absolute inset-0 z-10 product-slider" data-product-id="{{ $product->id }}">
                        @php
                            $urls = $product->imageUrls();
                        @endphp
                        
                        @if (count($urls) > 0)
                            @foreach ($urls as $index => $url)
                                <img alt="{{ $product->translatedName() }}" 
                                     class="product-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-300 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" 
                                     src="{{ $url }}" 
                                     data-index="{{ $index }}" />
                            @endforeach
                            
                            @if (count($urls) > 1)
                                <!-- Arrows -->
                                <button type="button" class="prev-slide absolute left-2 top-1/2 -translate-y-1/2 bg-void-black/70 hover:bg-blood-red text-raw-white w-8 h-8 rounded-none flex items-center justify-center border border-surface-container-highest transition-colors z-20" onclick="event.preventDefault(); event.stopPropagation(); navigateSlide(this, -1);">
                                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                                </button>
                                <button type="button" class="next-slide absolute right-2 top-1/2 -translate-y-1/2 bg-void-black/70 hover:bg-blood-red text-raw-white w-8 h-8 rounded-none flex items-center justify-center border border-surface-container-highest transition-colors z-20" onclick="event.preventDefault(); event.stopPropagation(); navigateSlide(this, 1);">
                                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                                </button>
                            @endif
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-surface-container-low p-8 z-10">
                                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="max-w-[120px] w-full h-auto object-contain opacity-40">
                            </div>
                        @endif
                        
                        <!-- Invisible click layer to go to product details -->
                        <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-0 block"></a>
                    </div>

                    @if($product->in_restock)
                        <div class="absolute top-2 left-2 z-20 bg-void-black text-blood-red border border-blood-red font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider pointer-events-none">
                            @if($product->restock_date)
                                REINGRESO: {{ $product->restock_date->format('d/m') }}
                            @else
                                EN REPOSICIÓN
                            @endif
                        </div>
                    @elseif($product->stock <= 0)
                        <div class="absolute top-2 left-2 z-20 bg-surface-container-highest text-ash-grey font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider border border-void-black pointer-events-none">
                            AGOTADO
                        </div>
                    @elseif($product->stock <= 5)
                        <div class="absolute top-2 left-2 z-20 bg-raw-white text-void-black font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider border border-void-black pointer-events-none">
                            STOCK BAJO
                        </div>
                    @else
                        <div class="absolute top-2 left-2 z-20 bg-blood-red text-void-black font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider border border-void-black pointer-events-none">
                            NUEVO DROP
                        </div>
                    @endif
                    
                </div>

                <!-- Product Info -->
                <div class="p-4 flex flex-col flex-grow bg-surface-container-lowest border-t border-surface-container-highest">
                    <h3 class="font-label-caps text-label-caps text-raw-white mb-2 uppercase tracking-wide leading-tight line-clamp-2">
                        <a href="{{ route('products.show', $product) }}" class="hover:text-blood-red transition-colors">
                            {{ $product->translatedName() }}
                        </a>
                    </h3>
                    @if(!empty($product->sizes) && is_array($product->sizes))
                        <p class="font-label-caps text-label-caps text-blood-red mb-1">CURVA: {{ implode(' - ', $product->sizes) }}</p>
                    @else
                        <p class="font-label-caps text-label-caps text-blood-red mb-1">CURVA: ÚNICA</p>
                    @endif
                    <div class="pt-2 mb-4">
                        <span class="font-label-caps text-label-caps text-ash-grey">
                            ${{ number_format($product->price, 0, ',', '.') }} ARS / CURVA
                        </span>
                    </div>

                    <!-- Action Form at the Bottom of Card -->
                    <div class="mt-auto pt-4 border-t border-surface-container/40">
                        @if ($product->stock > 0 && !$product->in_restock)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full flex flex-col gap-2">
                                @csrf
                                <!-- Quantity controls -->
                                <div class="flex items-center justify-between border border-surface-container-highest bg-void-black">
                                    <button type="button" 
                                            class="w-8 h-8 flex items-center justify-center text-raw-white hover:bg-blood-red hover:text-raw-white transition-colors"
                                            onclick="decrementCardQty(this)">
                                        <span class="material-symbols-outlined text-sm font-light">remove</span>
                                    </button>
                                    <input type="number" 
                                           name="quantity" 
                                           value="1" 
                                           min="1" 
                                           max="{{ $product->stock }}" 
                                           class="w-12 h-8 bg-transparent text-center font-label-caps text-label-caps text-raw-white border-none focus:ring-0 p-0 m-0 card-qty-input" 
                                           readonly>
                                    <button type="button" 
                                            class="w-8 h-8 flex items-center justify-center text-raw-white hover:bg-blood-red hover:text-raw-white transition-colors"
                                            onclick="incrementCardQty(this, {{ $product->stock }})">
                                        <span class="material-symbols-outlined text-sm font-light">add</span>
                                    </button>
                                </div>
                                <button type="submit" 
                                        class="bg-blood-red border border-blood-red px-2 py-2 w-full flex items-center justify-center font-label-caps text-label-caps hover:bg-void-black hover:text-blood-red transition-all text-raw-white text-xs tracking-wider">
                                    AGREGAR AL CARRITO
                                </button>
                            </form>
                        @elseif ($product->in_restock)
                            <button disabled class="border border-blood-red px-2 py-2 w-full flex items-center justify-center font-label-caps text-label-caps text-blood-red text-xs cursor-not-allowed bg-void-black uppercase tracking-wider">
                                EN REPOSICIÓN
                            </button>
                        @else
                            <button disabled class="border border-outline-variant px-2 py-2 w-full flex items-center justify-center font-label-caps text-label-caps text-ash-grey text-xs cursor-not-allowed uppercase tracking-wider">
                                SIN STOCK
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if (method_exists($products, 'links'))
        <div class="mt-16 flex justify-center border-t border-surface-container-highest pt-8">
            {{ $products->links() }}
        </div>
    @endif
@else
    <div class="border border-dashed border-surface-container-highest bg-surface-container/20 p-10 text-center">
        <h3 class="font-headline-lg-mobile text-raw-white uppercase">{{ __('messages.no_products_title') }}</h3>
        <p class="mt-2 text-ash-grey font-label-caps text-xs">{{ __('messages.no_products_copy') }}</p>
    </div>
@endif

<script>
    if (typeof navigateSlide !== 'function') {
        window.navigateSlide = function(button, direction) {
            const container = button.closest('.product-slider');
            if (!container) return;
            
            const slides = container.querySelectorAll('.product-slide');
            if (slides.length <= 1) return;
            
            let activeIndex = 0;
            slides.forEach((slide, i) => {
                if (slide.classList.contains('opacity-100')) {
                    activeIndex = i;
                }
            });
            
            // Hide current
            slides[activeIndex].classList.remove('opacity-100', 'z-10');
            slides[activeIndex].classList.add('opacity-0', 'z-0');
            
            // Calculate next
            let nextIndex = activeIndex + direction;
            if (nextIndex >= slides.length) nextIndex = 0;
            if (nextIndex < 0) nextIndex = slides.length - 1;
            
            // Show next
            slides[nextIndex].classList.remove('opacity-0', 'z-0');
            slides[nextIndex].classList.add('opacity-100', 'z-10');
        };
    }

    if (typeof decrementCardQty !== 'function') {
        window.decrementCardQty = function(btn) {
            const input = btn.closest('form').querySelector('.card-qty-input');
            if (!input) return;
            let val = parseInt(input.value) || 1;
            if (val > 1) {
                input.value = val - 1;
            }
        };
    }
    
    if (typeof incrementCardQty !== 'function') {
        window.incrementCardQty = function(btn, maxStock) {
            const input = btn.closest('form').querySelector('.card-qty-input');
            if (!input) return;
            let val = parseInt(input.value) || 1;
            if (val < maxStock) {
                input.value = val + 1;
            }
        };
    }
</script>
