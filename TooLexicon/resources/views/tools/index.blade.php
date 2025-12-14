<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            一覧表示
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-2">
            <a href="{{ route('tools.create') }}">
                <x-primary-button>
                    新規登録
                </x-primary-button>
            </a>
        </div>

        @foreach($tools as $tool)
            <div class="mt-4 p-6 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-2xl shadow-sm">

                {{-- 正式名称 --}}
                <h1 class="p-4 text-xl font-semibold">
                    <a href="{{ route('tools.show', $tool) }}" class="text-blue-600 hover:underline">
                        {{ $tool->official_name }}
                    </a>
                </h1>

                <hr class="w-full">

                {{-- 別名（呼び名） --}}
                <div class="p-2 rounded-md flex">
                    <x-input-label class="p-1 font-semibold block ">別名</x-input-label>
                    <div class="ml-2 flex">
                        @foreach($tool->toolNames as $i => $name)
                            <x-text-block class="p-1 mr-2">
                                {{ $name->name }}
                            </x-text-block>
                        @endforeach
                    </div>
                </div>

                {{-- 投稿日時 & 作成ユーザー --}}
                <div class="p-2 text-sm text-gray-600 dark:text-gray-400 font-semibold">
                    <p>
                        {{ $tool->created_at->format('Y-m-d') }}
                        @if($tool->user)
                            / {{ $tool->user->name }}
                        @endif
                    </p>
                </div>
            </div>
        @endforeach

        {{-- ページネーション --}}
        <div class="mt-6">
            {{ $tools->links() }}
        </div>
    </div>
</x-app-layout>