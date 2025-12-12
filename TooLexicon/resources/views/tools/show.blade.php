<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-300 leading-tight">
            個別表示
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-6">
        @if(session('message'))
        <div class="text-red-600 font-bold">
            {{session('message')}}
        </div>
        @endif
        <div class="mt-4 p-4">
            <h1 class="text-lg font-semibold ">
                {{$tool->official_name}}
            </h1>
            <div class="text-right flex">
                <a href="{{route('tools.edit', $tool)}}" class="flex-1">
                    <x-primary-button>
                        編集
                    </x-primary-button>
                </a>
                <form method="POST" action="{{route('tools.destroy', $tool)}}" class="flex-2">
                    @csrf
                    @method('delete')
                    <x-primary-button class="bg-red-700 ml-2">
                        削除
                    </x-primary-button>
                </form>
            </div>

            {{-- 別名（呼び名） --}}
            @foreach($tool->toolNames as $name)
            <x-input-label class="font-semibold mt-4 block">別名（呼び名）</x-input-label>
            <x-text-block class="mt-2 whitespace-pre-line">
                {{ $name->name }}
            </x-text-block>
            @endforeach

            {{-- カテゴリ --}}
            <x-input-label class="font-semibold mt-4 block">カテゴリ</x-input-label>
            <x-text-block class="mt-2 whitespace-pre-line">
                {{ $tool->category }}
            </x-text-block>

            {{-- 使用用途 --}}
            <x-input-label class="font-semibold mt-4 block">使用用途</x-input-label>
            <x-text-block class="mt-2 whitespace-pre-line">
                {{ $tool->usage }}
            </x-text-block>

            {{-- 安全上の注意 --}}
            <x-input-label class="font-semibold mt-4 block">安全上の注意</x-input-label>
            <x-text-block class="mt-2 whitespace-pre-line">
                {{ $tool->safety_notes }}
            </x-text-block>

            <div class="text-sm font-semibold flex flex-row-reverse">
                <x-text-block> {{$tool->created_at}} </x-text-block>
            </div>
        </div>
    </div>
</x-app-layout>