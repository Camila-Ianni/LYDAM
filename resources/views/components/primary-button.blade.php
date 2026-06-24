<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-blood-red text-raw-white font-headline-lg-mobile text-xl uppercase py-3 border border-blood-red hover:bg-void-black hover:text-blood-red transition-all duration-300 rounded-none tracking-wider text-center justify-center inline-flex items-center']) }}>
    {{ $slot }}
</button>
