<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-50 min-h-screen">
    <div id="app">
        <nav class="bg-white/80 shadow flex items-center justify-between px-6 py-3">
            <a href="{{ url('/') }}" class="text-xl font-extrabold text-indigo-700 tracking-tight">{{ config('app.name', 'Laravel') }}</a>
            <div>
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="ml-4 text-gray-700 hover:text-indigo-600 font-semibold">{{ __('Login') }}</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-gray-700 hover:text-indigo-600 font-semibold">{{ __('Register') }}</a>
                    @endif
                @else
                    <div class="relative inline-block text-left">
                        <button type="button" class="inline-flex items-center px-4 py-2 text-gray-700 font-semibold hover:text-indigo-600 focus:outline-none" id="user-menu" aria-haspopup="true" aria-expanded="true">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                @endguest
            </div>
        </nav>
        <main class="py-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
