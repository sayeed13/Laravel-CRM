<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full h-12 text-purple-100 rounded bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:from-sky-500 from-30% hover:to-emerald-500 to-90% px-6 py-2']) }}>
    {{ $slot }}
</button>
