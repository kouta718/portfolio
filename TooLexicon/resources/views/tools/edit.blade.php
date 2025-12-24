<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight flex items-center gap-2">
            <x-icon name="pencil" class="w-6 h-6"/>
            編集
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto m-4 p-6 w-full border border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-800 rounded-md">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('tools.update', $tool)}}">@csrf
            @method('patch')

            {{-- 正式名称 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="official_name" class="font-semibold mt-4 ml-2">正式名称</x-input-label>
                <x-input-error :messages="$errors->get('official_name')" class="mt-2" />
                <x-text-input type="text" name="official_name" id="official_name"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('official_name', $tool->official_name) }}">
                </x-text-input>
            </div>

            {{-- カテゴリ --}}
            <div class="w-full flex flex-col">
                <x-input-label for="category" class="font-semibold mt-4 ml-2">カテゴリ</x-input-label>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                <x-text-input type="text" name="category" id="category"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('category', $tool->category) }}">
                </x-text-input>
            </div>

            {{-- 別名（呼び名） --}}
            <div class="mt-6">
                <x-input-label for="name" class="font-semibold ml-2">別名（呼び名）</x-input-label>

                {{-- 全体コンテナ 最低1件のフォームを表示する --}}
                <div id="tool-names-container" class="space-y-4" data-count="{{ max(count($tool->toolNames), 1) }}"> 

                    {{-- 既存のtoolNamesを表示 --}}
                    @forelse($tool->toolNames as $i => $name)
                    <div class="tool-name-item flex items-start gap-4 p-4 bg-white dark:bg-gray-700 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

                        {{-- テキスト入力 --}}
                        <div class="flex-1">
                            <x-text-input
                                type="text"
                                name="tool_names[{{ $i }}][name]"
                                class="w-full"
                                value="{{ old('tool_names.'.$i.'.name', $name->name) }}"
                                placeholder="別名を入力"
                            />
                            <x-input-error :messages="$errors->get('tool_names.'.$i.'.name')" class="mt-2" />
                        </div>

                        {{-- 代表チェック --}}
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox"
                                name="tool_names[{{ $i }}][is_primary]"
                                value="1"
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                {{ old('tool_names.'.$i.'.is_primary', $name->is_primary) ? 'checked' : '' }}>
                            <span>代表</span>
                        </label>

                        {{-- 削除ボタン --}}
                        <x-danger-button class="remove-tool-name">
                            <x-icon name="cancel-circle" class="pointer-events-none" />
                        </x-danger-button>

                    </div>
                    @empty
                    {{-- toolNamesが空の場合の初期行 --}}
                    <div class="tool-name-item flex items-start gap-4 p-4 bg-white dark:bg-gray-700 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
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
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox"
                                name="tool_names[0][is_primary]"
                                value="1"
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                {{ old('tool_names.0.is_primary') ? 'checked' : '' }}>
                            <span>代表</span>
                        </label>
                        <x-danger-button class="remove-tool-name">
                            <x-icon name="cancel-circle" class="pointer-events-none" />
                        </x-danger-button>
                    </div>
                    @endforelse

                    {{-- ２つ目以降のテンプレート --}}
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
                            <x-danger-button class="remove-tool-name">
                                <x-icon name="cancel-circle" class="pointer-events-none" />
                            </x-danger-button>

                        </div>
                    </template>
                </div>
                {{-- 追加ボタン --}}
                <button type="button" class="mt-2 ml-2 text-blue-600 hover:text-blue-700 inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 add-tool-name gap-1" id="add-tool-name-button">
                    <x-icon name="plus" class="w-2 h-2"/>
                    別名を追加
                </button>

                <x-input-error :messages="$errors->get('tool_names')" class="mt-2" />
            </div>

            {{-- 使用用途 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="usage" class="font-semibold mt-4 ml-2">使用用途</x-input-label>
                <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                <x-textarea name="usage" id="usage"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    rows="3">{{ old('usage', $tool->usage) }}</x-textarea>
            </div>

            {{-- 安全上の注意 --}}
            <div class="w-full flex flex-col">
                <x-input-label for="safety_notes" class="font-semibold mt-4 ml-2">安全上の注意</x-input-label>
                <x-input-error :messages="$errors->get('safety_notes')" class="mt-2" />
                <x-textarea name="safety_notes" id="safety_notes"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    rows="3">{{ old('safety_notes', $tool->safety_notes) }}</x-textarea>
            </div>

            <x-primary-button class="mt-4 ml-2">
                登録する
            </x-primary-button>
        </form>
    </div>
    @vite('resources/js/addToolNames.js')
</x-app-layout>