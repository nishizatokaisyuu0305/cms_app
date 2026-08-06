<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name', 'CMS') }}</title>

        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    </head>

    <body class="bg-gray-100">
        <header class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
            <div class="px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <h1 class="text-xl sm:text-2xl font-bold text-center md:text-left">
                    顧客管理システム
                </h1>

                <div class="flex items-center">
                    <div class="bg-white text-gray-700 rounded-xl shadow-md px-4 py-3 flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                        </div>

                        <div>
                            <p class="font-semibold">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Administrator
                            </p>
                        </div>

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="w-full sm:w-auto sm:ml-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                            >
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-col md:flex-row">
            <aside class="w-full md:w-64 bg-white md:min-h-screen shadow-lg">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-bold text-gray-700">
                        メニュー
                    </h2>
                </div>

                <nav class="p-4 flex flex-wrap md:block gap-2 md:space-y-2">
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center justify-center md:justify-start px-4 py-3 rounded-lg transition duration-200 flex-1 md:flex-none"
                        {{ request()->routeIs('dashboard')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        🏠 ホーム
                    </a>

                    <a
                        href="{{ route('customers.index') }}"
                        class="flex items-center justify-center md:justify-start px-4 py-3 rounded-lg transition duration-200 flex-1 md:flex-none"
                        {{ request()->routeIs('customers.index')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        👥 顧客一覧
                    </a>

                    @role('admin')
                    <a
                        href="{{ route('customers.create') }}"
                        class="flex items-center justify-center md:justify-start px-4 py-3 rounded-lg transition duration-200 flex-1 md:flex-none"
                        {{ request()->routeIs('customers.create')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        ➕ 顧客登録
                    </a>
                    @endrole

                    @role('admin')
                    <a
                        href="{{ route('customers.statistics') }}"
                        class="flex items-center justify-center md:justify-start px-4 py-3 rounded-lg transition duration-200 flex-1 md:flex-none"
                        {{ request()->routeIs('customers.statistics')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        📈 顧客統計
                    </a>
                    @endrole
                </nav>
            </aside>
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div
                        class="mb-6 flex items-center gap-3 bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-lg shadow"
                    >
                        <span class="text-xl">
                            ✅
                        </span>
                        {{ session('success') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </body>
</html>