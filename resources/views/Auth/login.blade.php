@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden 
            bg-gradient-to-br from-indigo-200 via-white to-purple-200">

  <!-- Abstract Gradient Blobs -->
  <div class="absolute -top-24 -left-24 w-72 h-72 bg-indigo-400/30 rounded-full blur-3xl"></div>
  <div class="absolute bottom-[-80px] right-[-60px] w-80 h-80 bg-purple-400/20 rounded-full blur-3xl"></div>
  <div class="absolute top-1/2 left-1/2 w-60 h-60 bg-pink-300/20 rounded-full blur-2xl -translate-x-1/2 -translate-y-1/2"></div>

  <!-- Glass Card -->
  <div class="relative z-10 glass-card p-8 pt-6 rounded-3xl w-[380px] 
              text-center backdrop-blur-xl bg-white/30 shadow-2xl border border-white/20">
    <!-- Logo & Title -->
    <div class="mb-6 flex flex-col items-center">
      <div class="w-16 h-16 rounded-full flex items-center justify-center 
                  bg-indigo-100 shadow-md">
        <!-- Vector Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" 
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M12 8c1.657 0 3-.843 3-2s-1.343-2-3-2-3 .843-3 2 1.343 2 3 2zM5.5 22h13a2.5 2.5 0 002.5-2.5v-.379c0-1.34-.895-2.555-2.197-2.89A11.956 11.956 0 0012 14c-2.273 0-4.379.635-6.803 2.231C3.895 16.566 3 17.781 3 19.121V19.5A2.5 2.5 0 005.5 22z" />
        </svg>
      </div>
      <h1 class="mt-3 text-2xl font-extrabold text-gray-800">Event Planner</h1>
      <p class="text-xs text-gray-600">Login to manage your events</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 text-left">
            @foreach ($errors->all() as $error)
                <p class="text-red-500 text-xs">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <!-- Email Field -->
      <div class="flex items-center px-4 py-3 rounded-full glass-input bg-white/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
               class="bg-transparent w-full outline-none text-base placeholder-gray-500" required />
      </div>
      <!-- Password Field -->
      <div class="flex items-center px-4 py-3 rounded-full glass-input bg-white/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="password" name="password" placeholder="Enter your password"
               class="bg-transparent w-full outline-none text-base placeholder-gray-500" required />
      </div>

      <!-- Role Selector -->
      <div class="px-4 py-3 rounded-full glass-input bg-white/50 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" viewBox="0 0 24 24"
             fill="none" stroke="currentColor">
          <path d="M20 6L9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <select name="role" required
                class="w-full bg-transparent outline-none text-base appearance-none text-gray-700">
          <option value="" disabled selected>Select Role</option>
          <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
          <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest</option>
        </select>
      </div>

      <!-- Login Button -->
      <button type="submit"
              class="w-full py-2 rounded-full bg-indigo-500/90 text-white font-semibold 
                     hover:bg-indigo-600 hover:scale-105 transition transform duration-200 shadow-lg">
        Login
      </button>

      @if (Route::has('password.request'))
        <a class="block mt-3 text-sm text-indigo-700 hover:text-indigo-900" href="{{ route('password.request') }}">
          Forgot Your Password?
        </a>
      @endif
    </form>
    <!-- Footer -->
    <p class="text-[11px] text-gray-500 mt-6">© 2025 Event Planner Software</p>
  </div>
</div>
@endsection
