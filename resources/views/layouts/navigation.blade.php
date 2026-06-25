@php
    $cartCount = collect(session()->get('cart', []))->sum('quantity');
@endphp
<header class="bg-void-black border-b border-surface-variant sticky top-0 z-50">
    <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-max-width mx-auto">
        <!-- Brand Logo and Hamburger for Mobile -->
        <div class="flex items-center gap-4">
            <button id="mobile-menu-toggle" class="md:hidden text-raw-white hover:text-blood-red focus:outline-none p-1 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
            <a class="flex items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="h-16 md:h-20 w-auto object-contain">
            </a>
        </div>
        
        <!-- Navigation Links (Desktop) -->
        <nav class="hidden md:flex space-x-8">
            @auth
                @if (auth()->user()->isAdmin())
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('admin.products.*') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('admin.products.index') }}">PRODUCTOS</a>
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('admin.orders.*') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('admin.orders.index') }}">PEDIDOS</a>
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('admin.sales.*') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('admin.sales.dashboard') }}">VENTAS</a>
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('admin.settings.*') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('admin.settings.edit') }}">AJUSTES</a>
                    <a class="font-label-caps text-label-caps text-ash-grey font-normal hover:text-blood-red transition-all duration-200" href="{{ route('home') }}">VER TIENDA</a>
                @else
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('home') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('home') }}">INICIO</a>
                    <a class="font-label-caps text-label-caps {{ request()->routeIs('products.index') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('products.index') }}">CATÁLOGO</a>
                @endif
            @else
                <a class="font-label-caps text-label-caps {{ request()->routeIs('home') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('home') }}">INICIO</a>
                <a class="font-label-caps text-label-caps {{ request()->routeIs('products.index') ? 'text-blood-red font-bold border-b border-blood-red' : 'text-raw-white font-normal hover:text-blood-red transition-all duration-200' }}" href="{{ route('products.index') }}">CATÁLOGO</a>
            @endauth
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

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden bg-void-black border-t border-surface-variant px-margin-mobile py-4 flex flex-col gap-4 font-label-caps text-label-caps">
        @auth
            @if (auth()->user()->isAdmin())
                <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('admin.products.index') }}">PRODUCTOS</a>
                <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('admin.orders.index') }}">PEDIDOS</a>
                <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('admin.sales.dashboard') }}">VENTAS</a>
                <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('admin.settings.edit') }}">AJUSTES</a>
                <a class="text-ash-grey hover:text-blood-red py-2" href="{{ route('home') }}">VER TIENDA</a>
            @else
                <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('home') }}">INICIO</a>
                <a class="text-raw-white hover:text-blood-red py-2" href="{{ route('products.index') }}">CATÁLOGO</a>
            @endif
        @else
            <a class="text-raw-white hover:text-blood-red py-2 border-b border-surface-container-highest" href="{{ route('home') }}">INICIO</a>
            <a class="text-raw-white hover:text-blood-red py-2" href="{{ route('products.index') }}">CATÁLOGO</a>
        @endauth
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('mobile-menu-toggle');
        const menu = document.getElementById('mobile-menu');
        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });
        }
    });
</script>
