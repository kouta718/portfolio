<a
    {{ $attributes->merge([
        'class' => 'p-2 block rounded-md font-medium text-lg text-indigo-600 bg-gray-100 dark:bg-gray-700',
        'target' => '_blank',
        'rel' => 'noopener',
    ]) }}
>
    {{ $value ?? $slot }}
</a>