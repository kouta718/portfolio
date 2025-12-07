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
                <div id="tool-names-container" class="space-y-4">

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
                        <x-primary-button class="shrink-0" onclick="removeToolName(this)">
                            削除
                        </x-primary-button>

                    </div>
                </div>

                    {{-- 追加ボタン --}}
                    <x-primary-button onclick="addToolName()">
                        + 別名を追加
                    </x-primary-button>

                    <x-input-error :messages="$errors->get('tool_names')" class="mt-2" />
                </div>

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
    <script src="{{ asset('js/toolplus.js') }}"></script>
</x-app-layout>


