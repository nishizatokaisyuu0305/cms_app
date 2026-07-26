@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">
                登録顧客数
            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-2">
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

            <h2 class="text-4xl font-bold text-green-600 mt-2">
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
            class="flex items-center gap-3"
        >
            <input
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="顧客名で検索"
                class="border rounded px-4 py-2 w-80"
            >
            <button
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                検索
            </button>
            <a
                href="{{ route('customers.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
                クリア
            </a>
        </form>
        
        <p class="text-sm text-gray-500 mb-4">
            検索結果：{{ $customers->count() }} 件
        </p>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                顧客一覧
            </h2>
            <p class="text-gray-500">
                登録済み顧客の確認・編集・削除を行えます
            </p>
        </div>
        @role('admin')
        <a
            href="{{ route('customers.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            新規登録
        </a>
        @endrole
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="border px-4 py-3 text-left">ID</th>
                    <th class="border px-4 py-3 text-left">名前</th>
                    <th class="border px-4 py-3 text-left">Email</th>
                    <th class="border px-4 py-3 text-left">電話番号</th>
                    <th class="border px-4 py-3 text-left">会社名</th>
                    <th class="border px-4 py-3 text-left">操作</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="border px-4 py-3">
                            {{ $customer->id }}
                        </td>
                        <td class="border px-4 py-3">
                            {{ $customer->name }}
                        </td>
                        <td class="border px-4 py-3">
                            {{ $customer->email }}
                        </td>
                        <td class="border px-4 py-3">
                            {{ $customer->phone }}
                        </td>
                        <td class="border px-4 py-3">
                            {{ $customer->company }}
                        </td>

                        <td class="border px-4 py-3">
                            @role('admin')
                            <a
                                href="{{ route('customers.edit', $customer->id) }}"
                                class="inline-block bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600"
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
                                    class="ml-2 bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600"
                                >
                                    削除
                                </button>
                            </form>
                            @endrole

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

@endsection