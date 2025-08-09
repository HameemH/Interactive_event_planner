@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(145deg, #d3d8ff, #eef1ff);">
  <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
    <div class="mb-6 flex flex-col items-center">
      <div class="w-14 h-14 rounded-full glass-input flex items-center justify-center text-2xl font-bold text-indigo-600">
        ✉️
      </div>
      <h1 class="mt-3 text-xl font-extrabold text-gray-800">Verify Your Email Address</h1>
      <p class="text-xs text-gray-600">A verification link has been sent to your email.</p>
    </div>
    <div class="mb-4">
      @if (session('resent'))
        <div class="rounded-lg bg-green-100 text-green-800 px-4 py-2 mb-2 text-sm">
          {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
      @endif
      <p class="text-gray-700 text-sm mb-2">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
      <p class="text-gray-700 text-sm mb-4">{{ __('If you did not receive the email') }},</p>
      <form class="inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="text-indigo-600 underline hover:text-indigo-800 text-sm">{{ __('click here to request another') }}</button>.
      </form>
    </div>
  </div>
</div>
@endsection
