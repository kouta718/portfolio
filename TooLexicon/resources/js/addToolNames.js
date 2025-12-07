// 既存の別名の数を取得
let toolNameIndex = {{ count(old('tool_names')) }};

document.getElementById('add-tool-name-button').addEventListener('click', () => {
    // 新しい別名のインデックスを更新
    toolNameIndex++;
    addToolName();
});

function addToolName() {
    // 新しい別名を追加
    const newItem = document.getElementById('tool-names-container');
    // 新しい別名のHTMLを追加
    newItem.innerHTML = `
        <div class="tool-name-item flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

            <div class="flex-1">
                <x-text-input
                    type="text"
                    name="tool_names[${toolNameIndex}][name]"
                    class="w-full"
                    value="{{ old('tool_names.0.name') }}"
                    placeholder="別名を入力"
                />
                <x-input-error :messages="$errors->get('tool_names.0.name')" class="mt-2" />
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                <input type="checkbox"
                    name="tool_names[${toolNameIndex}][is_primary]"
                    value="1"
                    class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                    {{ old('tool_names.0.is_primary') ? 'checked' : '' }}>
                <span>代表</span>
            </label>

            <x-primary-button class="shrink-0" id="remove-tool-name-button">
                削除
            </x-primary-button>
        
        </div>
    `;
};

document.getElementById('remove-tool-name-button').addEventListener('click', () => {
    // 削除ボタンがクリックされたら、そのボタンの親要素を削除
    const button = document.getElementById('remove-tool-name-button');
    button.closest('.tool-name-item').remove();
    // 別名のインデックスを更新
    toolNameIndex--;
});