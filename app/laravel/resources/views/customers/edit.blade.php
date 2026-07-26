@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">

        <!-- タイトル -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                顧客編集
            </h2>

            <p class="text-gray-500">
                登録済み顧客情報を編集します
            </p>
        </div>

        <!-- エラー表示 -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 編集フォーム -->
        <form
            action="{{ route('customers.update', $customer->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <!-- 名前 -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    名前
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
                    class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $customer->email) }}"
                    class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- 電話番号 -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    電話番号
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $customer->phone) }}"
                    class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- 会社名 -->
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">
                    会社名
                </label>

                <input
                    type="text"
                    name="company"
                    value="{{ old('company', $customer->company) }}"
                    class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <!-- ボタン -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="
                    bg-blue-600
                    text-white
                    px-6
                    py-2
                    rounded
                    hover:bg-blue-700
                    "
                >
                    更新
                </button>

                <a
                    href="{{ route('customers.index') }}"
                    class="
                    bg-gray-500
                    text-white
                    px-6
                    py-2
                    rounded
                    hover:bg-gray-600
                    "
                >
                    一覧へ戻る
                </a>
            </div>
        </form>
    </div>
</div>

@endsection