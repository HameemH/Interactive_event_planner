<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Momento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('scripts')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">

    <style>
        /* Gradient Animation */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-text {
            background: linear-gradient(270deg, #6366f1, #ec4899, #8b5cf6);
            background-size: 600% 600%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 6s ease infinite;
        }

        /* Glassy 3D Navbar */
        .glass-navbar {
            backdrop-filter: blur(25px) saturate(180%);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .glass-navbar:hover {
            transform: translateY(-3px) perspective(1000px) rotateX(2deg);
            box-shadow: 0 12px 40px rgba(0,0,0,0.35);
            background: rgba(255,255,255,0.2);
        }

        /* Buttons */
        .tech-button {
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.5);
            backdrop-filter: blur(15px);
            background: rgba(255, 214, 255, 0.2);
            color: #400369f3;
        
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .tech-button:hover {
            background: rgba(255,255,255,0.3);
            box-shadow: 0 6px 25px rgba(0,0,0,0.35);
            transform: translateY(-2px);
        }

        .logo-text {
            font-family: 'Lilita One', cursive;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-50 min-h-screen">
<div id="app">
    <nav class="glass-navbar fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 shadow-lg">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-4">
            <img src="{{ asset('images/momento.png') }}" alt="Momento Logo" class="h-14 w-14 object-contain">
            <span class="text-3xl font-extrabold logo-text animate-gradient-text">Momento</span>
        </a>

        <!-- Navigation & Auth Links -->
        <div class="flex items-center space-x-4">
            <!-- Customize Event Button - Conditional based on auth status -->
            @auth
                <a href="{{ route('custom-event.index') }}" class="tech-button">
                    <i class="fas fa-paint-brush mr-2"></i>
                    Customize Event
                </a>
            @else
                <a href="{{ route('customize.event') }}" class="tech-button">
                    <i class="fas fa-paint-brush mr-2"></i>
                    Customize Event
                </a>
            @endauth
            
            @guest
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="tech-button">Login</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="tech-button">Register</a>
                @endif
            @else
                @if(Auth::user()->isOrganizer())
                    <a href="{{ route('admin.dashboard') }}" class="tech-button">Admin Panel</a>
                @endif
                <a href="{{ route('profile.show', Auth::id()) }}" class="tech-button">My Profile</a>
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button type="button" class="inline-flex items-center px-4 py-2 text-white font-semibold tech-button focus:outline-none" @click="open = !open">
                        {{ Auth::user()->name }}
                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                         style="display: none;">
                        <a href="{{ route('profile.show', Auth::id()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </nav>

    <main class="pt-24 pb-8">
        @yield('content')
    </main>
</div>
</body>
</html>
