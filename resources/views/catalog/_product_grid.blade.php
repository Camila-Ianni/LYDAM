@php
    $products = $products ?? collect();
@endphp

@if ($products->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-gutter gap-y-12">
        @foreach ($products as $product)
            <div class="group flex flex-col border border-transparent hover:border-blood-red transition-all duration-300 relative bg-surface-container-lowest">
                <!-- Image Container -->
                <div class="relative aspect-[3/4] overflow-hidden bg-surface-container w-full">
                    <!-- Link around Image -->
                    <a href="{{ route('products.show', $product) }}" class="block w-full h-full absolute inset-0 z-10">
                        @if ($product->imageUrl())
                            <img alt="{{ $product->translatedName() }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="{{ $product->imageUrl() }}"/>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-surface-container-low font-headline-lg text-blood-red">
                                LYDAM
                            </div>
                        @endif
                    </a>

                    @if($product->stock <= 5)
                        <div class="absolute top-2 left-2 z-20 bg-raw-white text-void-black font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider border border-void-black pointer-events-none">
                            STOCK BAJO
                        </div>
                    @else
                        <div class="absolute top-2 left-2 z-20 bg-blood-red text-void-black font-label-caps text-label-caps px-2 py-1 uppercase tracking-wider border border-void-black pointer-events-none">
                            NUEVO DROP
                        </div>
                    @endif
                    
                    <!-- Add to Cart Overlay on Hover -->
                    <div class="absolute bottom-0 left-0 w-full bg-void-black/90 backdrop-blur-sm border-t border-surface-container-highest p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-30 flex flex-col gap-2">
                        <span class="font-label-caps text-label-caps text-ash-grey uppercase text-center block mb-1">VENTA POR CURVA</span>
                        @if ($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="border border-outline-variant px-2 py-1 w-full flex items-center justify-center font-label-caps text-label-caps hover:bg-raw-white hover:text-void-black transition-colors text-raw-white text-xs">
                                    AGREGAR CURVA (x5 U.)
                                </button>
                            </form>
                        @else
                            <button disabled class="border border-outline-variant px-2 py-1 w-full flex items-center justify-center font-label-caps text-label-caps text-ash-grey text-xs cursor-not-allowed">
                                SIN STOCK
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4 flex flex-col flex-grow bg-surface-container-lowest border-t border-surface-container-highest">
                    <h3 class="font-label-caps text-label-caps text-raw-white mb-2 uppercase tracking-wide leading-tight line-clamp-2">
                        <a href="{{ route('products.show', $product) }}" class="hover:text-blood-red transition-colors">
                            {{ $product->translatedName() }}
                        </a>
                    </h3>
                    <p class="font-label-caps text-label-caps text-blood-red mb-1">CURVA: 38 - 40 - 42 - 44 - 46</p>
                    <div class="mt-auto pt-2">
                        <span class="font-label-caps text-label-caps text-ash-grey">
                            ${{ number_format($product->price, 0, ',', '.') }} ARS / CURVA
                        </span>
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
