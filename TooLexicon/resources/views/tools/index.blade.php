<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight flex items-center gap-2">
            <x-icon name="briefcase" class="w-6 h-6"/>
            工具一覧
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif

        {{-- 検索機能 --}}
        <form action="{{ route('tools.index') }}" method="GET" class="m-4 p-4 border border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-700 rounded-md">
            <div class="px-4 w-auto flex flex-row item-center">
                <x-input-error :messages="$errors->get('keyword')" class="mt-2" />
                <x-text-input type="text" name="keyword" id="keyword"
                    class="w-auto py-2 grow border border-gray-300 rounded-md"
                    value="{{ request('keyword') }}"
                    placeholder="検索">
                </x-text-input>
                <button type="submit" class="ml-2 px-4 py-2 shrink-0 bg-blue-500 text-white rounded-md">
                    <x-icon name="search"/>
                </button>
            </div>
        </form>

        <div class="mt-4">
            @if($tools->isEmpty())
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <x-icon name="info" class="w-5 h-5"/>
                    <p>検索結果が見つかりませんでした。</p>
                </div>
            @else
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2">
                    @foreach($tools as $tool)
                    <div class="mt-4 p-6 border border-gray-300 dark:border-gray-700 bg-gray-50  dark:bg-gray-800 dark:text-gray-300 rounded-2xl shadow-sm">

                        {{-- 正式名称 --}}
                        <h1 class="p-4 text-xl font-semibold">
                            <a href="{{ route('tools.show', $tool) }}" class="text-blue-600 hover:underline">
                                {{ $tool->official_name }}
                            </a>
                        </h1>

                        <hr class="w-full">

                        {{-- 別名（呼び名） --}}
                        <div class="p-2 rounded-md flex">
                            <x-input-label class="mt-2 font-semibold items-center">
                                <x-icon name="price-tag" class="w-4 h-4"/>
                            </x-input-label>
                            <div class="ml-2 flex">
                                @foreach($tool->toolNames as $i => $name)
                                    <x-text-block class="p-1 mr-2">
                                        {{ $name->name }}
                                    </x-text-block>
                                @endforeach
                            </div>
                        </div>

                        {{-- 登録日時 --}}
                        <div class="p-2 text-sm text-gray-600 dark:text-gray-400 font-semibold flex items-center gap-1">
                            <x-icon name="history" class="w-4 h-4"/>
                            <p>
                                {{ $tool->created_at->format('Y-m-d') }}
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