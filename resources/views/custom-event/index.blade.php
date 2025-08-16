@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Customize Your Event</h1>
        <p class="text-xs text-gray-600">Please select your event details below</p>

        <a href="{{ route('custom-event.venue') }}" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
            Start Customizing
        </a>
    </div>
@endsection
