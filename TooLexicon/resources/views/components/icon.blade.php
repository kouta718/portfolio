{{-- コンポーネントが受け取る 引数 --}}
@props([
    'name',
    'class' => 'w-5 h-5 pointer-events-none',
])

{{-- SVGファイルのパス --}}
@php
    $path = public_path("icons/{$name}.svg");
@endphp

@if (file_exists($path))
    {!! str_replace(
        '<svg',
        '<svg '.$attributes->merge(['class' => $class]),
        file_get_contents($path)
    ) !!}
@else
    <!-- icon not found: {{ $name }} -->
@endif
