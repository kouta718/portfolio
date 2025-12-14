<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex items-center px-4 py-2
            rounded-md border border-transparent
            text-xs font-semibold uppercase tracking-widest
            transition ease-in-out duration-150

            bg-red-700 text-white
            hover:bg-red-600 active:bg-red-800
            focus:ring-red-500

            dark:bg-red-400
            dark:text-gray-900
            dark:hover:bg-red-300
            dark:active:bg-red-500
        '
    ]) }}
>
    {{ $slot }}
</button>
