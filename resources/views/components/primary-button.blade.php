<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-blood-red text-white font-headline-lg-mobile text-xl uppercase py-3 border border-blood-red hover:bg-black hover:text-white transition-all duration-300 rounded-none tracking-wider text-center justify-center inline-flex items-center font-bold shadow-sm']) }}>
    {{ $slot }}
</button>
