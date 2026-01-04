<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-700 dark:text-gray-300">
            <x-icon name="briefcase" class="w-6 h-6"/>
            工具一覧
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 font-semibold text-green-700 dark:bg-green-800 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- 検索機能 --}}
        <form action="{{ route('tools.index') }}" method="GET" class="m-4 rounded-md border border-gray-300 bg-gray-50 p-4 dark:border-gray-500 dark:bg-gray-700">
            <div class="flex w-auto flex-row items-center px-4">
                <x-input-error :messages="$errors->get('keyword')" class="mt-2" />
                <x-text-input type="text" name="keyword" id="keyword"
                    class="w-auto grow rounded-md border border-gray-300 py-2"
                    value="{{ request('keyword') }}"
                    placeholder="検索">
                </x-text-input>
                <button type="submit" class="ml-2 shrink-0 rounded-md bg-blue-500 px-4 py-2 text-white">
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
                    <div class="mt-4 rounded-2xl border border-gray-300 bg-gray-50 p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">

                        <div class="flex flex-row">
                            {{-- 画像 --}}
                            <div class="mx-4 aspect-square w-48 overflow-hidden">
                                @if($tool->image_path)
                                    <img src="{{ asset('storage/'.$tool->image_path) }}" class="block h-full w-full object-cover" alt="{{ $tool->official_name }}"/>
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-200 dark:bg-gray-700">
                                        <x-icon name="image" class="w-12 h-12 text-gray-400"/>
                                    </div>
                                @endif
                            </div>

                            <div class="w-full">
                                {{-- 正式名称 --}}
                                <h1 class="p-4 text-xl font-semibold">
                                    <a href="{{ route('tools.show', $tool) }}" class="text-blue-600 hover:underline">
                                        {{ $tool->official_name }}
                                    </a>
                                </h1>

                                <hr class="w-full">

                                {{-- 別名（呼び名） --}}
                                <div class="flex rounded-md p-2">
                                    <x-input-label class="mt-2 flex items-center font-semibold">
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
                                <div class="flex items-center gap-1 p-2 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                    <x-icon name="history" class="w-4 h-4"/>
                                    <p>
                                        {{ $tool->created_at->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
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