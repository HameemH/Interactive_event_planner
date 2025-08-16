@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Select Your Venue</h1>

        <form method="POST" action="{{ route('custom-event.seating') }}">
            @csrf
            <!-- Venue Selection -->
            <div class="mb-4">
                <label for="venue" class="block text-left mb-2">Choose Venue Type</label>
                <select name="venue_type" class="w-full bg-transparent outline-none text-base">
                    <option value="predefined">Predefined Venue</option>
                    <option value="custom">Custom Venue</option>
                </select>
            </div>

            <!-- Venue size input if custom venue is selected -->
            <div class="mb-4">
                <label for="venue_size" class="block text-left mb-2">Venue Size (sq meters)</label>
                <input type="number" name="venue_size" placeholder="Enter venue size" class="w-full bg-transparent outline-none text-base">
            </div>

            <!-- Address input for custom venue -->
            <div class="mb-4">
                <label for="venue_address" class="block text-left mb-2">Venue Address</label>
                <input type="text" name="venue_address" placeholder="Enter address" class="w-full bg-transparent outline-none text-base">
            </div>

            <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Next: Select Seating
            </button>
        </form>
    </div>
@endsection
