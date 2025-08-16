@extends('layouts.app')

@section('content')
    <div class="glass-card p-8 pt-6 rounded-3xl w-[360px] text-center">
        <h1 class="text-xl font-extrabold text-gray-800">Select Stage & Decoration</h1>

        <form method="POST" action="{{ route('custom-event.catering') }}">
            @csrf
            <!-- Stage selection -->
            <div class="mb-4">
                <label for="stage_type" class="block text-left mb-2">Choose Stage Type</label>
                <select name="stage_type" class="w-full bg-transparent outline-none text-base">
                    <option value="basic">Basic</option>
                    <option value="premium">Premium</option>
                    <option value="luxury">Luxury</option>
                </select>
            </div>

            <!-- Decoration options -->
            <div class="mb-4">
                <label for="surrounding_decoration" class="block text-left mb-2">Add Surrounding Decoration</label>
                <input type="checkbox" name="surrounding_decoration" class="form-checkbox">
            </div>

            <button type="submit" class="w-full py-2 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
                Next: Select Catering
            </button>
        </form>
    </div>
@endsection
