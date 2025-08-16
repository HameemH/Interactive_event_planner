@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Select Photography</h1>

        <form method="POST" action="{{ route('custom-event.finalize') }}">
            @csrf
            <!-- Photography team -->
            <div class="mb-4">
                <label for="photographers_count" class="block text-left mb-2">Number of Photographers</label>
                <input type="number" name="photographers_count" placeholder="Enter number of photographers" class="w-full bg-transparent outline-none text-base">
            </div>

            <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Finalize Event
            </button>
        </form>
    </div>
@endsection
