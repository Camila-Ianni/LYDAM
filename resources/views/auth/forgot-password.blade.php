<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md bg-surface-container-low border border-surface-container-highest p-8 flex flex-col gap-6">
            
            <div class="text-center border-b border-surface-container-highest pb-4 mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="h-24 w-auto object-contain mx-auto mb-2">
                <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">RECUPERAR</h1>
            </div>

            <div class="text-xs font-label-caps text-ash-grey leading-relaxed">
                {{ __('¿Olvidaste tu contraseña? Ingresa tu email y te enviaremos un enlace para restablecerla.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <x-primary-button>
                        {{ __('ENVIAR ENLACE') }}
                    </x-primary-button>

                    <div class="text-center text-xs font-label-caps mt-2">
                        <a class="underline text-ash-grey hover:text-raw-white transition-colors" href="{{ route('login') }}">
                            Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
