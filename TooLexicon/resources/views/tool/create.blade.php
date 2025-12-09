<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            新規登録
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        <form method="POST" action="{{ route('tool.store')}}">@csrf

            {{-- 正式名称 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="official_name" class="font-semibold mt-4">正式名称</x-input-label>
                <x-input-error :messages="$errors->get('official_name')" class="mt-2" />
                <x-text-input type="text" name="official_name" id="official_name"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('official_name') }}">
                </x-text-input>
            </div>

            {{-- カテゴリ --}}
            <div class="w-full flex flex-col">
                <x-input-label for="category" class="font-semibold mt-4">カテゴリ</x-input-label>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                <x-text-input type="text" name="category" id="category"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('category') }}">
                </x-text-input>
            </div>

            {{-- 別名（呼び名） --}}
            <div class="mt-6 space-y-4">
                <x-input-label for="name" class="font-semibold">別名（呼び名）</x-input-label>

                {{-- 全体コンテナ --}}
                <template id="tool-names-container" class="space-y-4">

                    {{-- 1つ目の行 --}}
                    <div class="tool-name-item flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

                        {{-- テキスト入力 --}}
                        <div class="flex-1">
                            <x-text-input
                                type="text"
                                name="tool_names[0][name]"
                                class="w-full"
                                value="{{ old('tool_names.0.name') }}"
                                placeholder="別名を入力"
                            />
                            <x-input-error :messages="$errors->get('tool_names.0.name')" class="mt-2" />
                        </div>

                        {{-- 代表チェック --}}
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox"
                                name="tool_names[0][is_primary]"
                                value="1"
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                {{ old('tool_names.0.is_primary') ? 'checked' : '' }}>
                            <span>代表</span>
                        </label>

                        {{-- 削除ボタン --}}
                        <button type="button" class="shrink-0 text-red-600 hover:text-red-700 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 remove-tool-name">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            削除
                        </button>

                    </div>

                    {{-- ２つ目以降の行 --}}
                    <template id="tool-name-template">
                        <div class="tool-name-item flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

                            {{-- テキスト入力 --}}
                            <div class="flex-1">
                                <x-text-input
                                    type="text"
                                    name="tool_names[__index__][name]"
                                    class="w-full"
                                    value="{{ old('tool_names.__index__.name') }}"
                                    placeholder="別名を入力"
                                />
                                <x-input-error :messages="$errors->get('tool_names.__index__.name')" class="mt-2" />
                            </div>

                            {{-- 代表チェック --}}
                            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <input type="checkbox"
                                    name="tool_names[__index__][is_primary]"
                                    value="1"
                                    class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                    {{ old('tool_names.__index__.is_primary') ? 'checked' : '' }}>
                                <span>代表</span>
                            </label>

                            {{-- 削除ボタン --}}
                            <button type="button" class="shrink-0 text-red-600 hover:text-red-700 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 remove-tool-name">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                削除
                            </button>

                        </div>
                    </template>

                    {{-- 追加ボタン --}}
                    <button type="button" class="text-blue-600 hover:text-blue-700 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 add-tool-name" id="add-tool-name-button">
                        + 別名を追加
                    </button>

                    <x-input-error :messages="$errors->get('tool_names')" class="mt-2" />
                </template>

            {{-- 使用用途 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="usage" class="font-semibold mt-4">使用用途</x-input-label>
                <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                <x-textarea name="usage" id="usage"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    rows="3"/>{{ old('usage') }}
            </div>

            {{-- 安全上の注意 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="safety_notes" class="font-semibold mt-4">安全上の注意</x-input-label>
                <x-input-error :messages="$errors->get('safety_notes')" class="mt-2" />
                <x-textarea name="safety_notes" id="safety_notes"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    rows="3"/>{{ old('safety_notes') }}
            </div>

            <x-primary-button class="mt-4">
                登録する
            </x-primary-button>
        </form>
    </div>
    @vite('resources/js/addToolNames.js')
</x-app-layout>


