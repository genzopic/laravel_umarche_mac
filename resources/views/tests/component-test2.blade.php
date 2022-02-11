<x-tests.app>
    <x-slot name="header">
        ヘッダー２
    </x-slot>
    コンポーネントテスト２
    <div class="mb-4"></div>
    <x-test-class-base classBaseMessage="クラスでのメッセージです" />
    <div class="mb-4"></div>
    <x-test-class-base classBaseMessage="クラスでのメッセージです" defaultMessage="初期値から変更しています" />
</x-tests.app>
