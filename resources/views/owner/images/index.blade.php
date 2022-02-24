<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- flashメッセージ -->
                    <x-flash-message status="session('status')" />
                    <!-- 新規作成 -->
                    <div class="flex justify-end mb-4">
                        <button onclick="location.href='{{ route('owner.images.create') }}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
                    </div>
                    <!-- 画像一覧 -->
                    @foreach ($images as $image)
                        <div class="w-1/4 p-4">
                            <a href="{{ route('owner.images.edit',['image' => $image->id]) }}">
                                <div class="border rounded-md p-4">
                                    <div class="mb-4">
                                        <!-- タイトル -->
                                        <div class="text-xl mt-4">
                                            {{ $image->title }}
                                        </div>
                                        <!-- サムネイル -->
                                        <x-thumbnail :filename="$image->filename" type="products" />
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
