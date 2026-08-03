@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto mt-12">
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">

        <!-- アイコン -->
        <div class="text-6xl mb-8">
            🗑️
        </div>

        <!-- タイトル -->
        <h2 class="text-3xl font-bold text-red-600 mb-6">
            顧客情報を削除しました
        </h2>

        <!-- メッセージ -->
        <p class="text-gray-600 text-lg mb-10">
            顧客情報は正常に削除されました。
        </p>

        <!-- ボタン -->
        <a
            href="{{ route('customers.index') }}"
            class="inline-block bg-blue-600 text-white px-10 py-3 rounded-lg shadow hover:bg-blue-700 transition"
        >
            顧客一覧へ戻る
        </a>
    </div>
</div>

@endsection