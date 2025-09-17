@extends('layouts.app')

@section('content')
<style>
  /* Animated Gradient Background */
  @keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .bg-animated {
    background: linear-gradient(270deg, rgba(99,102,241,0.4), rgba(236,72,153,0.4), rgba(139,92,246,0.4));
    background-size: 600% 600%;
    animation: gradientShift 15s ease infinite;
  }

  /* Input focus effect */
  .glass-input input:focus {
    transform: scale(1.02);
    transition: transform 0.2s ease;
  }

  /* Fade-in-up animation */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease forwards;
  }

  /* Ripple effect for button */
  button {
    position: relative;
    overflow: hidden;
  }
  button::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.4);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
  }
  button:active::after {
    width: 200%;
    height: 200%;
    opacity: 1;
    transition: width 0.4s ease, height 0.4s ease, opacity 1s ease;
  }
</style>

<div class="min-h-screen flex items-center justify-center p-4 relative">
  <!-- Background Image with Animated Gradient Overlay -->
 <div class="fixed inset-0 w-full h-full">
  <img src="{{ asset('images/event-bg.jpg') }}" 
       alt="Event background" 
       class="w-full h-full object-cover">
  <div class="absolute inset-0 bg-animated"></div>
</div>

  <!-- Glass Card -->
  <div class="relative z-10 glass-card p-8 pt-6 rounded-3xl w-[380px] 
              text-center backdrop-blur-xl bg-white/20 shadow-2xl
              transition duration-500 hover:shadow-[0_0_40px_rgba(99,102,241,0.5)]
              animate-fade-in-up">
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
        <div class="mb-4 p-3 bg-red-100/80 border border-red-300 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="h-4 w-4 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 8.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <span class="font-semibold text-red-700 text-sm">Login Error</span>
            </div>
            @foreach ($errors->all() as $error)
                <p class="text-red-600 text-sm mb-1">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <!-- Email Field -->
      <div class="flex items-center px-4 py-3 rounded-full glass-input bg-white/40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
               class="bg-transparent w-full outline-none text-base placeholder-gray-500" required />
      </div>
      <!-- Password Field -->
      <div class="flex items-center px-4 py-3 rounded-full glass-input bg-white/40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="password" name="password" placeholder="Enter your password"
               class="bg-transparent w-full outline-none text-base placeholder-gray-500" required />
      </div>

      <!-- Role Selector -->
      <div class="px-4 py-3 rounded-full glass-input bg-white/40 flex items-center border-2 border-indigo-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" viewBox="0 0 24 24"
             fill="none" stroke="currentColor">
          <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <select name="role" required
                class="w-full bg-transparent outline-none text-base appearance-none text-gray-700">
          <option value="" disabled selected>Select Your Role</option>
          <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer (Admin)</option>
          <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest (User)</option>
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
