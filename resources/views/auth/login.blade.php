<x-guest-layout>
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md bg-white border border-surface-container-highest p-8 flex flex-col gap-6 shadow-sm">
            
            <div class="text-center border-b border-surface-container-highest pb-4 mb-2">
                <img src="{{ asset('images/logo.png') }}" alt="LYDAM" class="h-16 w-auto object-contain mx-auto mb-2 brand-logo-dark">
                <h1 class="font-headline-lg text-headline-lg text-zinc-950 uppercase mt-2 font-bold">INGRESAR</h1>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-zinc-950 font-bold" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Contraseña')" class="text-zinc-950 font-bold" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-blood-red font-label-caps text-xs" />
                </div>

                <!-- Remember Me -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="form-checkbox bg-white border-zinc-400 text-blood-red focus:ring-blood-red focus:ring-offset-white rounded-none" name="remember">
                        <span class="ms-2 font-label-caps text-label-caps text-ash-grey group-hover:text-black transition-colors">{{ __('Recordarme') }}</span>
                    </label>
                </div>

                <div class="flex flex-col gap-4 mt-2">
                    <x-primary-button>
                        {{ __('INGRESAR') }}
                    </x-primary-button>

                    <div class="flex justify-between items-center text-xs font-label-caps mt-2">
                        @if (Route::has('password.request'))
                            <a class="underline text-ash-grey hover:text-black transition-colors" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif

                        <a class="underline text-ash-grey hover:text-black transition-colors" href="{{ route('register') }}">
                            Crear cuenta
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
