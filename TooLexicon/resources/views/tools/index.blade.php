<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-700 dark:text-gray-300">
            <x-icon name="briefcase" class="w-6 h-6"/>
            検索・一覧
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 font-semibold text-green-700 dark:bg-green-800 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- 検索機能 --}}
        <form action="{{ route('tools.index') }}" method="GET" class="mx-4 mb-4 rounded-md border border-gray-300 bg-gray-50 p-4 dark:border-gray-500 dark:bg-gray-700">
            <div class="flex w-auto gap-2 flex-row items-center md:px-4">
                <x-input-error :messages="$errors->get('keyword')" class="mt-2" />
                <x-text-input type="text" name="keyword" id="keyword"
                    class="w-auto min-w-0 grow rounded-md border border-gray-300 text-sm md:text-base"
                    value="{{ request('keyword') }}"
                    placeholder="検索">
                </x-text-input>
                <button type="submit" class="ml-2 shrink-0 rounded-md bg-blue-500 px-4 py-2 text-white">
                    <x-icon name="search" class="w-4 h-4 md:w-5 md:h-5"/>
                </button>
            </div>
        </form>

        <div class="mt-2 md:mt-4">
            @if($tools->isEmpty())
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <x-icon name="info" class="w-5 h-5"/>
                    <p>検索結果が見つかりませんでした。</p>
                </div>
            @else
                <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
                    @foreach($tools as $tool)
                    <div class="mt-0 md:mt-4 rounded-2xl border border-gray-300 bg-gray-50 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">

                        <a href="{{ route('tools.show', $tool) }}" class="p-4 md:p-6 flex flex-row">
                            {{-- 画像 --}}
                            <div class="mr-4 my-auto w-16 md:w-32 aspect-square shrink-0 overflow-hidden">
                                @if($tool->image_path)
                                    <img src="{{ asset('storage/'.$tool->image_path) }}" class="block h-full w-full object-cover" alt="{{ $tool->official_name }}"/>
                                @else
                                    <div class="flex flex-col h-full w-full items-center justify-center text-gray-400 bg-gray-200 dark:bg-gray-700">
                                        <x-icon name="image" class="w-6 h-6 md:w-12 md:h-12"/>
                                        <p class="text-xs">no-image</p>
                                    </div>
                                @endif
                            </div>

                            <div class="w-full">
                                {{-- 正式名称 --}}
                                <h1 class="p-4 text-2xl font-semibold">
                                    <p>
                                        {{ $tool->official_name }}
                                    </p>
                                </h1>

                                <hr class="w-full">

                                {{-- 別名（呼び名） --}}
                                <div class="ml-2 py-2 flex flex-wrap rounded-md ">
                                    @foreach($tool->toolNames as $i => $name)
                                        <x-text-block class="py-1 m-1 text-xs">
                                            {{ $name->name }}
                                        </x-text-block>
                                    @endforeach
                                </div>

                                {{-- 登録日時 --}}
                                <div class="flex items-center gap-1 p-2 text-sm font-semibold text-gray-600 dark:text-gray-400">
                                    <x-icon name="history" class="w-4 h-4"/>
                                    <p>
                                        {{ $tool->created_at->format('Y-m-d') }}
                                    </p>
                                </div>
                            </div>
                        </a>
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