let toolNameIndex = {{ count($oldToolNames) }};

function addToolName() {

    newItem.innerHTML = `
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

        <x-primary-button class="shrink-0" onclick="removeToolName(this)">
            削除
        </x-primary-button>

    </div>
    `;
};