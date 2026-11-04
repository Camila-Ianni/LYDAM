<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LYDAM') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Hanken+Grotesk:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-on-surface font-body-md antialiased selection:bg-blood-red selection:text-white min-h-screen flex flex-col">
    <!-- Top Bar -->
    <div class="bg-blood-red text-white text-center py-2 font-label-caps text-label-caps border-b border-blood-red/20 font-bold tracking-wider">
        VENTA MAYORISTA EXCLUSIVA • VENTA POR CURVA
    </div>

    @include('layouts.navigation')

    <main class="flex-grow">
        @if (session('status'))
            <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="bg-surface-container border border-blood-red px-4 py-3 text-sm font-label-caps text-blood-red">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="bg-surface-container border border-blood-red px-4 py-3 text-sm text-on-surface">
                    <p class="font-bold font-label-caps text-blood-red">{{ __('Revisá los datos ingresados.') }}</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 font-label-caps">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <!-- Footer -->
    <footer class="bg-surface-container-low border-t border-surface-container-highest">
        <div class="flex flex-col md:flex-row justify-between items-center w-full px-margin-desktop py-12 max-w-max-width mx-auto">
            <div class="mb-8 md:mb-0 text-center md:text-left">
                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="h-10 w-auto object-contain mb-4 mx-auto md:mx-0 brand-logo-dark">
                <p class="font-label-caps text-label-caps text-ash-grey mb-4">SUSCRIBITE AL NEWSLETTER MAYORISTA</p>
                <form class="flex border border-surface-container-highest w-full max-w-sm bg-white">
                    <input class="bg-white text-on-surface font-label-caps border-none focus:ring-0 w-full px-4 py-2 placeholder:text-ash-grey" placeholder="TU EMAIL..." type="email"/>
                    <button class="bg-black text-white px-4 hover:bg-blood-red transition-colors" type="submit">
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </form>
            </div>
            <div class="flex flex-col items-center md:items-end space-y-4">
                <nav class="flex space-x-6">
                    <a class="font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors" href="#">POLÍTICA DE PRIVACIDAD</a>
                    <a class="font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors" href="#">TÉRMINOS DE SERVICIO</a>
                    <a class="font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors" href="#">INFORMACIÓN DE ENVÍO</a>
                    <a class="font-label-caps text-label-caps text-ash-grey hover:text-blood-red transition-colors" href="#">CONTACTO</a>
                </nav>
                <div class="font-body-sm text-body-sm text-ash-grey mt-8">© 2026 LYDAM. TODOS LOS DERECHOS RESERVADOS.</div>
            </div>
        </div>
    </footer>
</body>
</html>
