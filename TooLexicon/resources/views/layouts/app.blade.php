<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-gray-200 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-indigo-200 dark:bg-indigo-500 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="m-6 flex-1">
                {{ $slot }}
            </main>

            {{-- フッター --}}
            <footer class="mt-8 border-t border-gray-500 bg-white/80 backdrop-blur-sm dark:bg-gray-900/80">
                <div class="mx-auto max-w-5xl px-4 py-4 flex flex-col gap-2 text-xs text-gray-500 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-2">
                        <img src="/img/logo.png" alt="TooLexicon" class="h-5 w-5">
                        <span class="font-semibold text-gray-700 dark:text-gray-200">TooLexicon</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span>&copy; {{ date('Y') }} TooLexicon. All rights reserved.</span>
                        <a href="{{ route('tools.index') }}" class="underline-offset-2 hover:underline">工具一覧</a>
                        <a href="https://github.com/kouta718" target="_blank" class="underline-offset-2 hover:underline">GitHub</a>
                    </div>
                </div>
            </footer>

            {{-- ページが増えた際にスマホのボトムナビを追加 --}}
            <nav class="p-2 flex text-[8px] hidden">
                <a href="{{ route('tools.index') }}" class="flex flex-col grow text-white items-center gap-2">
                    <x-icon name="home" class="w-6 h-6"/>
                    <p class="font-semibold text-gray-700 dark:text-gray-200">ホーム</p>
                </a>
                <a href="{{ route('tools.create') }}" class="flex flex-col grow text-white items-center gap-2">
                    <x-icon name="plus" class="w-6 h-6"/>
                    <p class="font-semibold text-gray-700 dark:text-gray-200">新規登録</p>
                </a>
            </nav>
        </div>
    </body>
</html>
