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
            <div class="px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold">
                    顧客管理システム
                </h1>

                <div class="flex items-center">
                    <div class="bg-white text-gray-700 rounded-xl shadow-md px-5 py-3 flex items-center gap-4">
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
                                class="ml-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                            >
                                ログアウト
                            </button>
                        </form>
                    </div>
                </div>
        </header>

        <div class="flex">
            <aside class="w-64 bg-white min-h-screen shadow-lg">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-bold text-gray-700">
                        メニュー
                    </h2>
                </div>

                <nav class="p-4 space-y-2">
                    <a
                        href="{{ route('customers.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200
                        {{ request()->routeIs('customers.index')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        👥 顧客一覧
                    </a>
                    @role('admin')
                    <a
                        href="{{ route('customers.create') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition duration-200
                        {{ request()->routeIs('customers.create')
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-blue-100 hover:text-blue-700' }}"
                    >
                        ➕ 顧客登録
                    </a>
                    @endrole
                </nav>
            </aside>
            <main class="flex-1 p-8">
                @yield('content')
            </main>

        </div>
    </body>
</html>