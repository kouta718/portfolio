<x-app-layout>
    <x-slot name="header">
        <h2 class="flex items-center gap-2 text-xl font-semibold leading-tight text-gray-700 dark:text-gray-300">
            <x-icon name="wrench" class="w-6 h-6"/>
            詳細表示
        </h2>
    </x-slot>
    <div class="mx-auto m-4 w-full max-w-7xl rounded-md border border-gray-300 bg-gray-50 px-6 dark:border-gray-500 dark:bg-gray-800">
        @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 font-semibold text-green-700 dark:bg-green-800 dark:text-green-300">
            {{ session('success') }}
        </div>
        @endif
        <div class="mt-4 flex p-4">
            {{-- 画像 --}}
            <div class="mx-4 aspect-video w-1/3 overflow-hidden">
                @if($tool->image_path)
                    <img src="{{ asset('storage/'.$tool->image_path) }}" class="block h-full max-h-[480px] w-full object-cover" alt="{{ $tool->official_name }}"/>
                @else
                    <div class="flex h-full w-full items-center justify-center bg-gray-200 dark:bg-gray-700">
                        <x-icon name="image" class="w-16 h-16 text-gray-400"/>
                    </div>
                @endif
            </div>
            <div class="w-2/3">
                <x-input-label class="block p-1 font-semibold">正式名称</x-input-label>
                <div class="flex rounded-md p-1">
                    <h1 class="ml-4 flex-1 text-3xl font-semibold text-gray-700 dark:text-gray-300">
                        {{$tool->official_name}}
                    </h1>
                    <div class="flex flex-2 text-right">
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
                    <x-input-label class="block p-1 font-semibold">別名</x-input-label>
                    <div class="flex">
                        @foreach($tool->toolNames as $i => $name)
                            <x-text-block class="mr-2 bg-gray-100 p-2 dark:bg-gray-700">
                                {{ $name->name }}
                            </x-text-block>
                        @endforeach
                    </div>
                </div>

                {{-- カテゴリ --}}
                <div class="p-2 mt-4 rounded-md">
                    <x-input-label class="block p-1 font-semibold">カテゴリ</x-input-label>
                    <x-text-block class="bg-gray-100 p-2 dark:bg-gray-700">
                        {{ $tool->category ?? '未設定' }}
                    </x-text-block>
                </div>

                {{-- 使用用途 --}}
                <div class="p-2 mt-4 rounded-md">
                    <x-input-label class="block p-1 font-semibold">使用用途</x-input-label>
                    <x-text-block class="bg-gray-100 p-2 dark:bg-gray-700">
                        {{ $tool->usage ?? '未設定' }}
                    </x-text-block>
                </div>

                {{-- 安全上の注意 --}}
                <div class="p-2 mt-4 rounded-md">
                    <x-input-label class="ml-2 block font-semibold">安全上の注意</x-input-label>
                    <x-text-block class="bg-gray-100 p-2 dark:bg-gray-700">
                        {{ $tool->safety_notes ?? '未設定' }}
                    </x-text-block>
                </div>

                {{-- 登録日時 --}}
                <div class="mt-4 flex flex-row-reverse items-center gap-1 text-sm font-semibold text-gray-600 dark:text-gray-400">
                    <p class="font-medium">
                        {{$tool->created_at}}
                    </p>
                    <x-icon name="history" class="w-4 h-4"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>