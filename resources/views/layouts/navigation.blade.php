@php
    $cartCount = collect(session()->get('cart', []))->sum('quantity');
@endphp
<header class="bg-void-black border-b border-surface-variant sticky top-0 z-50">
    <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-max-width mx-auto">
        <!-- Brand Logo -->
        <a class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg tracking-tighter text-raw-white gothic-text" href="{{ route('home') }}">LYDAM</a>
        
        <!-- Navigation Links (Desktop) -->
        <nav class="hidden md:flex space-x-8">
            <a class="font-label-caps text-label-caps {{ request()->routeIs('products.index') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('products.index') }}">CATÁLOGO</a>
            <a class="font-label-caps text-label-caps text-raw-white font-normal hover:text-blood-red transition-all duration-200" href="{{ route('products.index') }}">PANTALONES</a>
            <a class="font-label-caps text-label-caps text-raw-white font-normal hover:text-blood-red transition-all duration-200" href="{{ route('products.index') }}">REMERAS</a>
        </nav>
        
        <!-- Trailing Icons / Auth -->
        <div class="flex items-center space-x-4">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="font-label-caps text-label-caps text-raw-white hover:text-blood-red transition-colors text-xs">
                        ADMIN
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="font-label-caps text-label-caps text-raw-white hover:text-blood-red transition-colors text-xs">
                    {{ strtoupper(auth()->user()->name) }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors text-xs">
                        SALIR
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="font-label-caps text-label-caps text-raw-white hover:text-blood-red transition-colors text-xs">
                    INGRESAR
                </a>
            @endauth

            <a href="{{ route('cart.index') }}" class="text-blood-red hover:text-raw-white transition-all duration-200 scale-95 active:opacity-80 flex items-center gap-1">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">shopping_bag</span>
                @if ($cartCount > 0)
                    <span class="font-label-caps text-label-caps bg-blood-red text-raw-white px-2 py-0.5 text-xs">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </div>
</header>
