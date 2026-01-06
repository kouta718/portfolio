<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-700 dark:text-gray-300">
            <x-icon name="pencil" class="w-6 h-6"/>
            編集
        </h2>
    </x-slot>
    <div class="m-auto w-full max-w-7xl rounded-md border border-gray-300 bg-gray-50 p-6 dark:border-gray-500 dark:bg-gray-800">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 font-semibold text-green-700 dark:bg-green-800 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('tools.update', $tool)}}" enctype="multipart/form-data">@csrf
            @method('patch')

            <div class="flex gap-6 flex-col sm:flex-row-reverse">

                {{-- 画像 --}}
                <div class="w-full sm:w-1/2 flex flex-col">
                    <x-input-label for="image_path" class="font-semibold mt-4 ml-2">画像</x-input-label>
                    <x-input-error :messages="$errors->get('image_path')" class="mt-2" />

                    <!-- inputは隠す -->
                    <input
                        type="file"
                        id="image_path"
                        name="image_path"
                        accept="image/*"
                        class="hidden"
                    >

                    <!-- UI本体 -->
                    <label for="image_path"
                        class="relative block aspect-video cursor-pointer border-2 border-dashed border-gray-300 bg-white transition hover:border-indigo-400 focus-within:ring-2 focus-within:ring-indigo-500 dark:bg-gray-400">

                        <!-- プレビュー画像 -->
                        <img id="imagePreview"
                            class="absolute inset-0 h-full w-full object-cover {{ $tool->image_path ? '' : 'hidden' }}"
                            src="{{ $tool->image_path ? asset('storage/'.$tool->image_path) : '' }}"
                            alt="画像プレビュー"
                        >
                        <!-- 中央テキスト -->
                        <div id="placeholder"
                            class="absolute inset-0 flex items-center justify-center text-xl font-medium text-gray-400 {{ $tool->image_path ? 'hidden' : '' }} dark:text-gray-800">
                            <x-icon name="image" class="w-16 h-16" />
                        </div>

                        <!-- 右下カメラアイコン -->
                        <div class="absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 text-white shadow">
                            <!-- SVG -->
                            <x-icon name="camera" />
                        </div>
                    </label>
                </div>

                <div class="w-full sm:w-1/2"> {{-- グループ化 --}}
                    {{-- 正式名称 --}}
                    <div class="flex flex-col">
                        <x-input-label for="official_name" class="font-semibold mt-4 ml-2">正式名称</x-input-label>
                        <x-input-error :messages="$errors->get('official_name')" class="mt-2" />
                        <x-text-input type="text" name="official_name" id="official_name"
                            class="w-full rounded-md border border-gray-300 py-2"
                            value="{{ old('official_name', $tool->official_name) }}">
                        </x-text-input>
                    </div>

                    {{-- カテゴリ --}}
                    <div class="flex flex-col">
                        <x-input-label for="category" class="font-semibold mt-4 ml-2">カテゴリ</x-input-label>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        <x-text-input type="text" name="category" id="category"
                            class="w-full rounded-md border border-gray-300 py-2"
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
                            <div class="tool-name-item flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-700">

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
                                {{-- <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                    <input type="checkbox"
                                        name="tool_names[{{ $i }}][is_primary]"
                                        value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-600 dark:focus:ring-indigo-600"
                                        {{ old('tool_names.'.$i.'.is_primary', $name->is_primary) ? 'checked' : '' }}>
                                    <span>代表</span>
                                </label> --}}

                                {{-- 削除ボタン --}}
                                <x-danger-button class="remove-tool-name">
                                    <x-icon name="cancel-circle" />
                                </x-danger-button>

                            </div>
                            @empty
                            {{-- toolNamesが空の場合の初期行 --}}
                            <div class="tool-name-item flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-700">
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
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-600 dark:focus:ring-indigo-600"
                                        {{ old('tool_names.0.is_primary') ? 'checked' : '' }}>
                                    <span>代表</span>
                                </label>
                                <x-danger-button class="remove-tool-name">
                                    <x-icon name="cancel-circle" />
                                </x-danger-button>
                            </div>
                            @endforelse

                            {{-- ２つ目以降のテンプレート --}}
                            <template id="tool-name-template">
                                <div class="tool-name-item flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-700">

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
                                    {{-- <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                        <input type="checkbox"
                                            name="tool_names[__index__][is_primary]"
                                            value="1"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-600 dark:focus:ring-indigo-600"
                                            {{ old('tool_names.__index__.is_primary') ? 'checked' : '' }}>
                                        <span>代表</span>
                                    </label> --}}

                                    {{-- 削除ボタン --}}
                                    <x-danger-button class="remove-tool-name">
                                        <x-icon name="cancel-circle" />
                                    </x-danger-button>

                                </div>
                            </template>
                        </div>
                        {{-- 追加ボタン --}}
                        <button type="button" class="add-tool-name mt-2 ml-2 inline-flex items-center gap-1 rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue-600 transition duration-150 ease-in-out hover:bg-gray-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-500 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800" id="add-tool-name-button">
                            <x-icon name="plus" class="w-2 h-2"/>
                            別名を追加
                        </button>

                        <x-input-error :messages="$errors->get('tool_names')" class="mt-2" />
                    </div>
                </div>
            </div>


            {{-- 使用用途 --}}
            <div class="flex flex-col">
                <x-input-label for="usage" class="font-semibold mt-4 ml-2">使用用途</x-input-label>
                <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                <x-textarea name="usage" id="usage"
                    class="w-full rounded-md border border-gray-300 py-2"
                    rows="3">{{ old('usage', $tool->usage) }}</x-textarea>
            </div>

            {{-- 安全上の注意 --}}
            <div class="flex flex-col">
                <x-input-label for="safety_notes" class="font-semibold mt-4 ml-2">安全上の注意</x-input-label>
                <x-input-error :messages="$errors->get('safety_notes')" class="mt-2" />
                <x-textarea name="safety_notes" id="safety_notes"
                    class="w-full rounded-md border border-gray-300 py-2"
                    rows="3">{{ old('safety_notes', $tool->safety_notes) }}</x-textarea>
            </div>

            <div class="flex flex-col">
                <x-input-label for="amazon_url" class="font-semibold mt-4 ml-2">Amazon URL</x-input-label>
                <x-input-error :messages="$errors->get('amazon_url')" class="mt-2" />
                <x-text-input type="text" name="amazon_url" id="amazon_url"
                    class="w-full rounded-md border border-gray-300 py-2"
                    value="{{ old('amazon_url', $tool->amazon_url) }}"
                    placeholder="https://www.amazon.co.jp/...">
                </x-text-input>
            </div>

            <div class="flex flex-col">
                <x-input-label for="monotaro_url" class="font-semibold mt-4 ml-2">モノタロウ URL</x-input-label>
                <x-input-error :messages="$errors->get('monotaro_url')" class="mt-2" />
                <x-text-input type="text" name="monotaro_url" id="monotaro_url"
                    class="w-full rounded-md border border-gray-300 py-2"
                    value="{{ old('monotaro_url', $tool->monotaro_url) }}"
                    placeholder="https://www.monotaro.com/...">
                </x-text-input>
            </div>

            <x-primary-button class="mt-4 ml-2">
                登録する
            </x-primary-button>
        </form>
    </div>
    @vite('resources/js/tool.js')
</x-app-layout>