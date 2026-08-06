@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
            ダッシュボード
        </h1>

        <p class="text-sm sm:text-base text-gray-500 mt-2">
            顧客管理システムの概要
        </p>
    </div>

    <!-- サマリー -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-5 sm:p-6">
            <p class="text-gray-500">
                登録顧客数
            </p>

            <h2 class="text-3xl sm:text-4xl  font-bold text-blue-600 mt-2">
                {{ $totalCustomers }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 sm:p-6">
            <p class="text-gray-500">
                登録会社数
            </p>

            <h2 class="text-3xl sm:text-4xl font-bold text-green-600 mt-2">
                {{ $totalCompanies }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-5 sm:p-6">
            <p class="text-gray-500">
                今月の登録数
            </p>

            <h2 class="text-3xl sm:text-4xl font-bold text-purple-600 mt-2">
                {{ $monthlyCustomers }}
            </h2>
        </div>
    </div>

    <!-- メニュー -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a 
            href="{{ route('customers.index') }}"
            class="bg-white rounded-xl shadow p-5 sm:p-6 hover:bg-blue-50 transition flex flex-col justify-between"
        >

            <h3 class="text-lg sm:text-xl font-semibold mb-2">
                顧客一覧
            </h3>

            <p class="text-sm sm:text-base text-gray-500">
                登録済み顧客を確認・編集します。
            </p>
        </a>

        @role('admin')
        <a 
            href="{{ route('customers.create') }}"
            class="bg-white rounded-xl shadow p-5 sm:p-6 hover:bg-green-50 transition"
        >

            <h3 class="text-xl font-semibold mb-2">
                顧客登録
            </h3>

            <p class="text-gray-500">
                新しい顧客を登録します。
            </p>
        </a>
        @endrole

        <a 
            href="{{ route('customers.statistics') }}"
            class="bg-white rounded-xl shadow p-5 sm:p-6 hover:bg-purple-50 transition"
        >
            <h3 class="text-xl font-semibold mb-2">
                顧客統計
            </h3>

            <p class="text-gray-500">
                統計情報を表示します。
            </p>
        </a>
    </div>

    <!-- 最新登録 -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b">
            <h2 class="text-lg sm:text-xl font-semibold">
                最近登録された顧客
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[600px] w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            名前
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            会社名
                        </th>

                        <th class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            登録日
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($latestCustomers as $customer)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            {{ $customer->name }}
                        </td>

                        <td class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            {{ $customer->company }}
                        </td>

                        <td class="px-3 sm:px-4 py-3 text-sm sm:text-base">
                            {{ $customer->created_at->format('Y/m/d') }}
                        </td>
                    </tr>
                @empty

                    <tr>
                        <td colspan="3"
                            class="text-center py-6 text-gray-500">

                            顧客データがありません
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection