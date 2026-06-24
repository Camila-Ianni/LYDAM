<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md bg-surface-container-low border border-surface-container-highest p-8 flex flex-col gap-6">
            
            <div class="text-center border-b border-surface-container-highest pb-4 mb-2">
                <span class="font-label-caps text-label-caps text-blood-red uppercase tracking-widest">LYDAM STORE</span>
                <h1 class="font-headline-lg text-headline-lg text-raw-white uppercase mt-2">REGISTRARSE</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <x-primary-button>
                        {{ __('CREAR CUENTA') }}
                    </x-primary-button>

                    <div class="text-center text-xs font-label-caps mt-2">
                        <a class="underline text-ash-grey hover:text-raw-white transition-colors" href="{{ route('login') }}">
                            ¿Ya tienes una cuenta? Iniciar Sesión
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
