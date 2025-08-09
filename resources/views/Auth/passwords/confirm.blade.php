@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(145deg, #d3d8ff, #eef1ff);">
  <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
    <div class="mb-6 flex flex-col items-center">
      <div class="w-14 h-14 rounded-full glass-input flex items-center justify-center text-2xl font-bold text-indigo-600">
        🔒
      </div>
      <h1 class="mt-3 text-xl font-extrabold text-gray-800">Confirm Password</h1>
      <p class="text-xs text-gray-600">Please confirm your password before continuing.</p>
    </div>
    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf
      <div class="flex items-center mb-6 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input id="password" type="password" name="password" placeholder="Enter your password" class="bg-transparent w-full outline-none text-base" required />
      </div>
      @error('password')
        <div class="text-red-600 text-xs mb-2">{{ $message }}</div>
      @enderror
      <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
        {{ __('Confirm Password') }}
      </button>
      @if (Route::has('password.request'))
        <div class="mt-4">
          <a class="text-indigo-600 underline hover:text-indigo-800 text-sm" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
          </a>
        </div>
      @endif
    </form>
  </div>
</div>
@endsection
