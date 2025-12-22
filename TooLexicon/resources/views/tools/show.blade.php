<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight flex items-center gap-2">
            <x-icon name="wrench" class="w-6 h-6"/>
            詳細表示
        </h2>
    </x-slot>
    <div class="m-4 max-w-7xl mx-auto px-6 w-full border border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-800 rounded-md">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 rounded-lg font-semibold">
            {{ session('success') }}
        </div>
        @endif
        <div class="mt-4 p-4">
            <x-input-label class="p-1 font-semibold block">正式名称</x-input-label>
            <div class="p-1 flex rounded-md">
                <h1 class="ml-4 text-3xl font-semibold text-gray-700 dark:text-gray-300 flex-1">
                    {{$tool->official_name}}
                </h1>
                <div class="text-right flex-2 flex">
                    <a href="{{route('tools.edit', $tool)}}" class="flex-1">
                        <x-primary-button class="items-center gap-1">
                            <x-icon name="pencil" class="w-4 h-4" />
                            編集
                        </x-primary-button>
                    </a>
                    <form method="POST" action="{{route('tools.destroy', $tool)}}" class="flex-2">
                        @csrf
                        @method('delete')
                        <x-danger-button class="ml-4 flex items-center gap-1">
                            <x-icon name="bin2" class="w-4 h-4" />
                            削除
                        </x-danger-button>
                    </form>
                </div>
            </div>

            <hr class="w-full mt-2">

            {{-- 別名（呼び名） --}}
            <div class="p-2 mt-4 rounded-md">
                <x-input-label class="p-1 font-semibold block">別名</x-input-label>
                <div class="flex">
                    @foreach($tool->toolNames as $i => $name)
                        <x-text-block class="p-2 mr-2 bg-gray-100 dark:bg-gray-700">
                            {{ $name->name }}
                        </x-text-block>
                    @endforeach
                </div>
            </div>

            {{-- カテゴリ --}}
            <div class="p-2 mt-4 rounded-md">
                <x-input-label class="p-1 font-semibold block">カテゴリ</x-input-label>
                <x-text-block class="p-2 bg-gray-100 dark:bg-gray-700">
                    {{ $tool->category ?? '未設定' }}
                </x-text-block>
            </div>

            {{-- 使用用途 --}}
            <div class="p-2 mt-4 rounded-md">
                <x-input-label class="p-1 font-semibold block">使用用途</x-input-label>
                <x-text-block class="p-2 bg-gray-100 dark:bg-gray-700">
                    {{ $tool->usage ?? '未設定' }}
                </x-text-block>
            </div>

            {{-- 安全上の注意 --}}
            <div class="p-2 mt-4 rounded-md">
                <x-input-label class="ml-2 font-semibold block">安全上の注意</x-input-label>
                <x-text-block class="p-2 bg-gray-100 dark:bg-gray-700">
                    {{ $tool->safety_notes ?? '未設定' }}
                </x-text-block>
            </div>

            {{-- 登録日時 --}}
            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 font-semibold flex flex-row-reverse items-center gap-1">
                <p class="font-medium">
                    {{$tool->created_at}}
                </p>
                <x-icon name="history" class="w-4 h-4"/>
            </div>
        </div>
    </div>
</x-app-layout>