@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Select Seating Options</h1>

        <form method="POST" action="{{ route('custom-event.stage') }}">
            @csrf
            <div class="mb-4">
                <label for="attendees" class="block text-left mb-2">Number of Attendees</label>
                <input type="number" name="attendees" placeholder="Enter number of people" class="w-full bg-transparent outline-none text-base">
            </div>

            <div class="mb-4">
                <label for="chair_type" class="block text-left mb-2">Choose Chair Type</label>
                <select name="chair_type" class="w-full bg-transparent outline-none text-base">
                    <option value="basic">Basic</option>
                    <option value="premium">Premium</option>
                    <option value="luxury">Luxury</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="table_type" class="block text-left mb-2">Choose Table Type</label>
                <select name="table_type" class="w-full bg-transparent outline-none text-base">
                    <option value="circular">Circular</option>
                    <option value="square">Square</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Next: Select Stage
            </button>
        </form>
    </div>
@endsection
