@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)]">
        <!-- min-h subtracts nav height (adjust 64px if your nav height differs) -->
        <div class="glass-card p-10 rounded-3xl w-[420px] text-center shadow-lg">
            <h1 class="text-2xl font-extrabold text-gray-800 mb-2">Customize Your Event</h1>
            <p class="text-sm text-gray-600 mb-6">Please select your event details below</p>

            <a href="{{ route('custom-event.venue') }}" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Start Customizing
            </a>
        </div>
    </div>
@endsection
