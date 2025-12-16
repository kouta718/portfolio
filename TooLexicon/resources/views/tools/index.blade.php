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

        {{-- <div class="mt-2">
            <a href="{{ route('tools.create') }}">
                <x-primary-button>
                    新規登録
                </x-primary-button>
            </a>
        </div> --}}

        {{-- 検索機能 --}}
        <form action="{{ route('tools.index') }}" method="GET" class="m-4 p-4 bg-gray-700 rounded-md">
            <div class="px-4 w-auto flex flex-row item-center">
                <x-input-error :messages="$errors->get('keyword')" class="mt-2" />
                <x-text-input type="text" name="keyword" id="keyword"
                    class="w-auto py-2 grow border border-gray-300 rounded-md"
                    value="{{ request('keyword') }}"
                    placeholder="正式名称で入力してください">
                </x-text-input>
                <button type="submit" class="ml-2 px-4 py-2 shrink-0 bg-blue-500 text-white rounded-md">
                    検索
                </button>
            </div>
        </form>

        <div class="mt-4">
            @if($tools->isEmpty())
                <p>検索結果が見つかりませんでした。</p>
            @else
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
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
            </div>

            {{-- ページネーション --}}
            <div class="mt-6">
                {{ $tools->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>