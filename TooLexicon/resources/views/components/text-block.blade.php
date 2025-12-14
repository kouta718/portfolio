<p {{ $attributes->merge(['class' => 'block rounded-md font-medium text-lg text-gray-700 dark:text-gray-300 bg-gray-300 dark:bg-gray-700']) }}>
    {{ $value ?? $slot }}
</p>