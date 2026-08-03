@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto">

    <!-- タイトル -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                顧客統計
            </h2>

            <p class="text-gray-500">
                顧客情報の統計データを表示します
            </p>
        </div>

        <a
            href="{{ route('customers.index') }}"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
        >
            一覧へ戻る
        </a>
    </div>

    <!-- 統計カード -->
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

    <!-- 追加統計 -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            統計情報
        </h3>

        <!-- 会社別登録ランキング -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-blue-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    会社別登録人数ランキング
                </h3>
            </div>

            <table class="w-full table-fixed border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-24 border px-4 py-3 text-center">
                            順位
                        </th>

                        <th class="border px-4 py-3 text-left">
                            会社名
                        </th>

                        <th class="w-36 border px-4 py-3 text-center">
                            登録人数
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($companyRanking as $company)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="border px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <td class="border px-4 py-3">
                                {{ $company->company }}
                            </td>

                            <td class="border px-4 py-3 text-center font-semibold text-blue-600">
                                {{ $company->total }} 人
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td
                                colspan="3"
                                class="border px-4 py-8 text-center text-gray-500"
                            >
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 月別登録数 -->
        <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
            <div class="bg-blue-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    月別登録数
                </h3>
            </div>

            <table class="w-full table-fixed border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="w-64 border px-4 py-3 text-left">
                            登録月
                        </th>

                        <th class="w-40 border px-4 py-3 text-center">
                            登録人数
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($monthlyCustomers as $month)
                        <tr class="hover:bg-green-50 transition-colors duration-150">
                            <td class="border px-4 py-3">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('Y年m月') }}
                            </td>

                            <td class="border px-4 py-3 text-center font-semibold text-green-600">
                                {{ $month->total }} 人
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="2" class="border px-4 py-8 text-center text-gray-500">
                                データがありません
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- 会社別割合（円グラフ） -->
        <div class="bg-white rounded-xl shadow overflow-hidden mt-6">

            <!-- ヘッダー -->
            <div class="bg-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">
                    会社別割合
                </h3>
            </div>

            <!-- グラフ表示エリア -->
            <div class="p-6">
                <div class="w-full flex justify-center">
                    <div class="w-80 h-80">
                        <canvas id="companyChart"></canvas>
                    </div>
                </div>

                <p class="text-center text-gray-500 text-sm mt-4">
                    登録顧客の会社別割合
                </p>
            </div>
        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {

            const companyLabels = @json($companyRanking->pluck('company'));
            const companyData = @json($companyRanking->pluck('total'));

            const ctx = document.getElementById('companyChart');

            new Chart(ctx, {
                type: 'pie',

                data: {
                    labels: companyLabels,

                    datasets: [{
                        label: '登録人数',
                        data: companyData,
                        backgroundColor: [
                            '#3B82F6',
                            '#10B981',
                            '#F59E0B',
                            '#EF4444',
                            '#8B5CF6',
                            '#06B6D4',
                            '#EC4899',
                            '#84CC16',
                            '#F97316',
                            '#6B7280'
                        ],

                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },

                        tooltip: {
                            callbacks: {
                                label: function(context) {

                                    const total = context.dataset.data.reduce(
                                        (sum, value) => sum + value,
                                        0
                                    );

                                    const value = context.raw;
                                    const percent = (value / total * 100).toFixed(1);

                                    return context.label + '：' +
                                        value + '人 (' +
                                        percent + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
        </script>   
    </div>
</div>
@endsection
