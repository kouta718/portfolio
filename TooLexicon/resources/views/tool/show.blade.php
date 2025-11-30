<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            個別表示
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        @if(session('message'))
        <div class="text-red-600 font-bold">
            {{session('message')}}
        </div>
        @endif
        <div class="mt-4 p-4">
            <h1 class="text-lg font-semibold">
                {{$tool->name}}
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
            <label class="font-semibold mt-4 block">別名（呼び名）</label>
            <p class="mt-2 whitespace-pre-line">
                {{ $tool_name->name }}
            </p>

            {{-- 代表の呼び名：true/false --}}
            <label class="font-semibold mt-4 block">代表の呼び名</label>
            <p class="mt-2 whitespace-pre-line">
                {{ $tool_name->is_primary }}
            </p>

            {{-- カテゴリ --}}
            <label class="font-semibold mt-4 block">カテゴリ</label>
            <p class="mt-2 whitespace-pre-line">
                {{ $tool_name->category }}
            </p>

            {{-- 使用用途 --}}
            <label class="font-semibold mt-4 block">使用用途</label>
            <p class="mt-2 whitespace-pre-line">
                {{ $tool->usage }}
            </p>

            {{-- 安全上の注意 --}}
            <label class="font-semibold mt-4 block">安全上の注意</label>
            <p class="mt-2 whitespace-pre-line">
                {{ $tool->safety_notes }}
            </p>

            <div class="text-sm font-semibold flex flex-row-reverse">
                <p> {{$tool->created_at}} </p>
            </div>
        </div>
    </div>
</x-app-layout>