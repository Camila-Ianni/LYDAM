<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LYDAM ADMIN') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Hanken+Grotesk:wght@400;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-void-black text-on-surface font-body-md antialiased selection:bg-blood-red selection:text-raw-white min-h-screen flex flex-col">
    <!-- Top Bar -->
    <div class="bg-blood-red text-raw-white text-center py-2 font-label-caps text-label-caps border-b border-surface-variant">
        PANEL DE ADMINISTRACIÓN • LYDAM STORE
    </div>

    @include('layouts.navigation')

    <main class="flex-grow max-w-max-width mx-auto w-full px-margin-mobile md:px-margin-desktop py-12">
        @if (session('status'))
            <div class="mb-6 bg-surface-container border border-blood-red px-4 py-3 text-sm font-label-caps text-blood-red">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-surface-container border border-blood-red px-4 py-3 text-sm text-raw-white">
                <p class="font-bold font-label-caps text-blood-red">{{ __('Revisá los datos ingresados.') }}</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 font-label-caps">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <!-- Footer -->
    <footer class="bg-void-black dark:bg-surface-container-lowest border-t border-surface-variant">
        <div class="flex justify-between items-center w-full px-margin-desktop py-12 max-w-max-width mx-auto font-label-caps text-label-caps text-ash-grey">
            <div>LYDAM PANEL</div>
            <div>© 2026 LYDAM. TODOS LOS DERECHOS RESERVADOS.</div>
        </div>
    </footer>
</body>
</html>
