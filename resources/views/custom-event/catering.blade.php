@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Select Catering</h1>

        <form method="POST" action="{{ route('custom-event.photography') }}">
            @csrf
            <!-- Catering options -->
            <div class="mb-4">
                <label for="catering_required" class="block text-left mb-2">Add Catering</label>
                <input type="checkbox" name="catering_required" class="form-checkbox">
            </div>

            <!-- Pricing per person -->
            <div class="mb-4">
                <label for="food_cost" class="block text-left mb-2">Food Cost per Person</label>
                <input type="number" name="food_cost" placeholder="Enter cost per person" class="w-full bg-transparent outline-none text-base">
            </div>

            <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Next: Select Photography
            </button>
        </form>
    </div>
@endsection
