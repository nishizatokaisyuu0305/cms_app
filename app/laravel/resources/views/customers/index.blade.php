@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">
                登録顧客数
            </p>

            <h2 class="text-3xl sm:text-4xl font-bold text-blue-600 mt-2">
                {{ $totalCustomers }}
            </h2>

            <p class="text-gray-400 mt-1">
                Customers
            </p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">
                登録会社数
            </p>

            <h2 class="text-3xl sm:text-4xl font-bold text-green-600 mt-2">
                {{ $totalCompanies }}
            </h2>

            <p class="text-gray-400 mt-1">
                Companies
            </p>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form
            action="{{ route('customers.index') }}"
            method="GET"
            class="flex flex-col sm:flex-row sm:items-center gap-3"
        >
            <input
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="顧客名で検索"
                class="border rounded px-4 py-2 w-full sm:w-80"
            >
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto"
            >
                検索
            </button>
            <a
                href="{{ route('customers.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 w-full sm:w-auto text-center"
            >
                クリア
            </a>
        </form>
        
        <p class="text-sm text-gray-500 mb-4">
            検索結果：{{ $customers->count() }} 件
        </p>
    </div>

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-left gap-4 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                顧客一覧
            </h2>
            <p class="text-gray-500">
                登録済み顧客の確認・編集・削除を行えます
            </p>
        </div>
        @role('admin')
        <a
            href="{{ route('customers.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center"
        >
            新規登録
        </a>
        @endrole
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-[900px] w-full table-fixed border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="border px-4 py-3 w-16">ID</th>
                    <th class="border px-4 py-3 w-40">名前</th>
                    <th class="border px-4 py-3">Email</th>
                    <th class="border px-4 py-3 w-40">電話番号</th>
                    <th class="border px-4 py-3 w-40">会社名</th>
                    <th class="border px-4 py-3 w-48 text-center">操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="border px-3 py-2">
                            {{ $customer->id }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $customer->name }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $customer->email }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $customer->phone }}
                        </td>
                        <td class="border px-3 py-2">
                            {{ $customer->company }}
                        </td>

                        <td class="border px-3 py-2">
                            <div class="flex flex-wrap justify-center items-center gap-2">
                                <button
                                    type="button"
                                    onclick="openModal(
                                        @js($customer->name),
                                        @js($customer->email),
                                        @js($customer->phone),
                                        @js($customer->company),
                                        @js($customer->memo)
                                    )"
                                    class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 whitespace-nowrap"
                                >
                                    詳細
                                </button>

                                @role('admin')
                                <a
                                    href="{{ route('customers.edit', $customer->id) }}"
                                    class="inline-block bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600 whitespace-nowrap"
                                >
                                    編集
                                </a>
                                @endrole

                                @role('admin')
                                <form
                                    action="{{ route('customers.destroy', $customer->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('本当に削除しますか？')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 whitespace-nowrap"
                                    >
                                        削除
                                    </button>
                                </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="6"
                            class="text-center py-8 text-gray-500"
                        >
                            登録されている顧客はありません
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>

<!-- 顧客詳細モーダル -->
<div
    id="customerModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4"
>
    <div 
        class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
        onclick="event.stopPropagation()"
    >

        <!-- ヘッダー -->
        <div class="bg-blue-600 text-white px-4 py-3 rounded-t-lg">
            <h2 class="text-lg font-semibold">
                顧客詳細
            </h2>
        </div>

        <!-- 本文 -->
        <div class="p-4 space-y-3 text-sm">
            <div class="grid grid-cols-[90px_1fr] gap-2">
                <span class="font-semibold text-gray-600">名前</span>
                <span id="modalName"></span>
            </div>

            <div class="grid grid-cols-[90px_1fr] gap-2">
                <span class="font-semibold text-gray-600">Email</span>
                <span id="modalEmail"></span>
            </div>

            <div class="grid grid-cols-[90px_1fr] gap-2">
                <span class="font-semibold text-gray-600">電話番号</span>
                <span id="modalPhone"></span>
            </div>

            <div class="grid grid-cols-[90px_1fr] gap-2">
                <span class="font-semibold text-gray-600">会社名</span>
                <span id="modalCompany"></span>
            </div>

            <div class="grid grid-cols-[90px_1fr] gap-2 items-start">
                <span class="font-semibold text-gray-600">備考</span>
                <span
                    id="modalMemo"
                    class="whitespace-pre-wrap break-words"
                ></span>
            </div>     
        </div>

        <!-- フッター -->
        <div class="px-4 py-3 border-t flex justify-end">

            <button
                type="button"
                onclick="closeModal()"
                class="bg-gray-500 text-white px-3 py-1.5 rounded text-sm hover:bg-gray-600"
            >
                閉じる
            </button>
        </div>
    </div>
</div>

<script>
function openModal(name, email, phone, company, memo) {

    document.getElementById('modalName').textContent = name;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('modalPhone').textContent = phone;
    document.getElementById('modalCompany').textContent = company;
    document.getElementById('modalMemo').textContent = memo ?? '';

    const customerModal = document.getElementById('customerModal');

    customerModal.classList.remove('hidden');
    customerModal.classList.add('flex');
}

function closeModal() {

    const customerModal = document.getElementById('customerModal');
    customerModal.classList.remove('flex');
    customerModal.classList.add('hidden');
}

// モーダル外クリックで閉じる
document.getElementById('customerModal').addEventListener('click', function () {
    closeModal();
});

// Escキーで閉じる
document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection
