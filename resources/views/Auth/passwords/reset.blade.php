@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(145deg, #d3d8ff, #eef1ff);">
  <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
    <div class="mb-6 flex flex-col items-center">
      <div class="w-14 h-14 rounded-full glass-input flex items-center justify-center text-2xl font-bold text-indigo-600">
        🔑
      </div>
      <h1 class="mt-3 text-xl font-extrabold text-gray-800">Reset Password</h1>
      <p class="text-xs text-gray-600">Set a new password for your account.</p>
    </div>
    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="flex items-center mb-5 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input id="email" type="email" name="email" placeholder="Enter your email" value="{{ $email ?? old('email') }}" class="bg-transparent w-full outline-none text-base" required autofocus />
      </div>
      @error('email')
        <div class="text-red-600 text-xs mb-2">{{ $message }}</div>
      @enderror
      <div class="flex items-center mb-5 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M17 11V7a5 5 0 00-10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 11c-1.657 0-3 .895-3 2v1h6v-1c0-1.105-1.343-2-3-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input id="password" type="password" name="password" placeholder="New password" class="bg-transparent w-full outline-none text-base" required />
      </div>
      @error('password')
        <div class="text-red-600 text-xs mb-2">{{ $message }}</div>
      @enderror
      <div class="flex items-center mb-6 px-4 py-3 rounded-full glass-input">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path d="M2 8l10 6 10-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm new password" class="bg-transparent w-full outline-none text-base" required />
      </div>
      <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
        {{ __('Reset Password') }}
      </button>
    </form>
  </div>
</div>
@endsection
