@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(145deg, #d3d8ff, #eef1ff);">
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <!-- Logo & Title -->
        <div class="mb-6 flex flex-col items-center">
            <!-- Logo Placeholder -->
            <div class="w-14 h-14 rounded-full glass-input flex items-center justify-center text-2xl font-bold text-indigo-600">
                �
            </div>
            <!-- App Name -->
            <h1 class="mt-3 text-xl font-extrabold text-gray-800">Event Planner</h1>
            <p class="text-xs text-gray-600">Create your account</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4">
                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-xs">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Signup Form -->
        <form method="POST" action="{{ route('register') }}">
        @csrf
            <!-- Full Name -->
            <div class="flex items-center mb-4 px-4 py-3 rounded-full glass-input">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M5 12h14M12 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="text" name="name" placeholder="Full name"
                       class="bg-transparent w-full outline-none text-gray-700 placeholder-gray-400 text-sm" required />
            </div>
            <!-- Email -->
            <div class="flex items-center mb-4 px-4 py-3 rounded-full glass-input">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                       class="bg-transparent w-full outline-none text-base" required />
            </div>
            <!-- Password -->
            <div class="flex items-center mb-4 px-4 py-3 rounded-full glass-input">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="password" name="password" placeholder="Enter your password"
                       class="bg-transparent w-full outline-none text-base" required />
            </div>
            <!-- Confirm Password -->
            <div class="flex items-center mb-6 px-4 py-3 rounded-full glass-input">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <input type="password" name="password_confirmation" placeholder="Confirm your password"
                       class="bg-transparent w-full outline-none text-base" required />
            </div>
            <!-- Signup Button -->
            <button type="submit"
                    class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Register
            </button>
        </form>
        <!-- Link to Login -->
        <p class="text-[11px] text-gray-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">Login</a>
        </p>
    </div>
</div>
@endsection
