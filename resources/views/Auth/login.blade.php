@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(145deg, #d3d8ff, #eef1ff);">
  <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
    <!-- Logo & Title -->
    <div class="mb-6 flex flex-col items-center">
      <div class="w-14 h-14 rounded-full glass-input flex items-center justify-center text-2xl font-bold text-indigo-600">
        🎉
      </div>
      <h1 class="mt-3 text-xl font-extrabold text-gray-800">Event Planner</h1>
      <p class="text-xs text-gray-600">Login to manage your events</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4">
            @foreach ($errors->all() as $error)
                <p class="text-red-500 text-xs">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <!-- Email Field -->
      <div class="flex items-center mb-5 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
               class="bg-transparent w-full outline-none text-base" required />
      </div>
      <!-- Password Field -->
      <div class="flex items-center mb-4 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="password" name="password" placeholder="Enter your password"
               class="bg-transparent w-full outline-none text-base" required />
      </div>

      <!-- Role Selector -->
      <div class="mb-6 px-4 py-3 rounded-full glass-input flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" viewBox="0 0 24 24"
             fill="none" stroke="currentColor">
          <path d="M20 6L9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <select name="role" required
                class="w-full bg-transparent outline-none text-base appearance-none">
          <option value="" disabled selected>Select Role</option>
          <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
          <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest</option>
        </select>
      </div>

      <!-- Login Button -->
      <button type="submit"
              class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
        Login
      </button>

      @if (Route::has('password.request'))
        <a class="block mt-4 text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
          Forgot Your Password?
        </a>
      @endif
    </form>
    <!-- Footer -->
    <p class="text-[11px] text-gray-500 mt-6">© 2025 Event Planner Software</p>
  </div>
</div>
@endsection
