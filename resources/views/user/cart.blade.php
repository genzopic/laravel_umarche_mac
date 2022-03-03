<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($products) > 0)
                        @foreach ($products as $product)
                            <div class="md:flex md:items-center mb-2">
                                {{-- 画像 --}}
                                <div class="md:w-3/12">
                                    @if (!is_null($product->imageFirst->filename))
                                        <img src="{{ asset('storage/products/' . $product->imageFirst->filename) }}">
                                    @else
                                        <img src="{{ asset('storage/products/no_image.jpg') }}">
                                    @endif
                                </div>
                                {{-- 商品名 --}}
                                <div class="md:w-4/12 md:ml-2">
                                    {{ $product->name }}
                                </div>
                                <div class="md:w-3/12 flex justify-around">
                                    <div>
                                        {{-- 価格 --}}
                                        {{ number_format($product->price) }}<span class="text-sm text-gray-700">円</span> × 
                                        {{-- 数量 --}}
                                        {{ $product->pivot->quantity }}個
                                    </div>
                                    {{-- 金額 --}}
                                    <div>
                                        {{ number_format($product->pivot->quantity * $product->price) }}<span class="text-sm text-gray-700">円（税込）</span>
                                    </div>
                                </div>
                                {{-- 削除ボタン --}}
                                <div class="md:w-2/12">
                                    削除ボタン
                                </div>
                            </div>
                        @endforeach
                    @else
                        カートに商品がありません
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
