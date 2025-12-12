<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            一覧表示
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{ session('message') }}
            </div>
        @endif

        @foreach($tools as $tool)
            <div class="mt-4 p-8 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300  w-full rounded-2xl shadow-sm">

                {{-- 正式名称 --}}
                <h1 class="p-4 text-lg font-semibold">
                    正式名称:
                    <a href="{{ route('tools.show', $tool) }}" class="text-blue-600 hover:underline">
                        {{ $tool->official_name }}
                    </a>
                </h1>

                <hr class="w-full">

                {{-- 使用用途（整形表示） --}}
                <p class="mt-4 p-4 whitespace-pre-line">
                    {{ $tool->usage }}
                </p>

                {{-- 投稿日時 & 作成ユーザー --}}
                <div class="p-4 text-sm text-gray-600 dark:text-gray-400 font-semibold">
                    <p>
                        {{ $tool->created_at->format('Y-m-d') }}
                        @if($tool->user)
                            / {{ $tool->user->name }}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>