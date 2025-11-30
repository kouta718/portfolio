<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            新規登録
        </h2>
    </x-slot>
    <div class="mx-auto px-6">
        @if(session('message'))
            <div class="text-red-600 font-bold">
                {{session('message')}}
            </div>
        @endif
        <form method="POST" action="{{ route('tools.store')}}">@csrf

            {{-- 正式名称 --}}
            <div class="w-full flex flex-col">
                <label for="official_name" class="font-semibold mt-4">正式名称</label>
                <x-input-error :messages="$errors->get('official_name')" class="mt-2" />
                <input type="text" name="official_name" id="official_name"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('official_name') }}">
            </div>

            {{-- 別名（呼び名） --}}
            <div class="w-full flex flex-col">
                <label for="name" class="font-semibold mt-4">別名（呼び名）</label>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                <input type="text" name="name" id="name"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('name') }}">
            </div>

            {{-- 代表の呼び名：true/false --}}
            <div class="w-full flex flex-col">
                <label for="is_primary" class="font-semibold mt-4">代表の呼び名</label>
                <x-input-error :messages="$errors->get('is_primary')" class="mt-2" />
                <input type="text" name="is_primary" id="is_primary"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('is_primary') }}">
            </div>

            {{-- カテゴリ --}}
            <div class="w-full flex flex-col">
                <label for="category" class="font-semibold mt-4">カテゴリ</label>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                <input type="text" name="category" id="category"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    value="{{ old('category') }}">
            </div>

            {{-- 使用用途 --}}
            <div class="w-full flex flex-col">
                <label for="usage" class="font-semibold mt-4">使用用途</label>
                <x-input-error :messages="$errors->get('usage')" class="mt-2" />
                <textarea name="usage" id="usage"
                        class="w-auto py-2 border border-gray-300 rounded-md"
                        rows="3">{{ old('usage') }}</textarea>
            </div>

            {{-- 安全上の注意 --}}
            <div class="w-full flex flex-col">
                <label for="safety_notes" class="font-semibold mt-4">安全上の注意</label>
                <x-input-error :messages="$errors->get('safety_notes')" class="mt-2" />
                <textarea name="safety_notes" id="safety_notes"
                    class="w-auto py-2 border border-gray-300 rounded-md"
                    rows="3">{{ old('safety_notes') }}</textarea>
            </div>

            <x-primary-button class="mt-4">
                登録する
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
