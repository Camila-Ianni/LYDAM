<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md bg-white border border-surface-container-highest p-8 flex flex-col gap-6 shadow-sm">
            
            <div class="text-center border-b border-surface-container-highest pb-4 mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="h-16 w-auto object-contain mx-auto mb-2 brand-logo-dark">
                <h1 class="font-headline-lg text-headline-lg text-zinc-950 uppercase mt-2 font-bold">REGISTRARSE</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nombre')" class="text-zinc-950 font-bold" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-zinc-950 font-bold" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="text-zinc-950 font-bold" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-zinc-950 font-bold" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <x-primary-button>
                        {{ __('CREAR CUENTA') }}
                    </x-primary-button>

                    <div class="text-center text-xs font-label-caps mt-2">
                        <a class="underline text-ash-grey hover:text-black transition-colors" href="{{ route('login') }}">
                            ¿Ya tienes una cuenta? Iniciar Sesión
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
