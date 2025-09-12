@extends('layouts.app')

@section('content')
<style>
  /* Animated Gradient Overlay */
  @keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .bg-animated {
    background: linear-gradient(270deg, rgba(99,102,241,0.4), rgba(236,72,153,0.4), rgba(139,92,246,0.4));
    background-size: 600% 600%;
    animation: gradientShift 15s ease infinite;
  }

  /* Card Glass Effect */
  .glass-card {
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .glass-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
  }

  /* Heading Gradient Badge */
  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .animate-gradient {
    animation: gradientMove 6s ease infinite;
    background-size: 200% 200%;
  }
</style>

<div class="min-h-screen flex items-center justify-center p-4 relative">
  <!-- Background Image with Animated Gradient Overlay -->
 <div class="fixed inset-0 w-full h-full">
  <img src="{{ asset('images/event-bg.jpg') }}" 
       alt="Event background" 
       class="w-full h-full object-cover">
  <div class="absolute inset-0 bg-animated"></div>
</div>
  <!-- Card -->
  <div class="glass-card p-10 pt-8 rounded-3xl w-[650px] min-h-[550px] flex flex-col shadow-xl relative z-10">
      
      <!-- Back Button -->
      <a href="{{ route('custom-event.index') }}" 
         class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
        <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
          Select Your Venue
        </span>
      </h1>
      <p class="text-purple-900 text-center mb-6">Fill in the details to customize your event venue</p>

      <!-- Progress Bar -->
      <div class="w-full mb-8">
          <div class="flex items-center justify-between text-sm font-medium text-blue-900 mb-2">
              <span>Step 1: Venue</span>
              <span>Step 2: Seating</span>
              <span>Step 3: Decoration</span>
              <span>Step 4: Review</span>
          </div>
          <div class="w-full bg-white/30 rounded-full h-2 overflow-hidden">
              <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: 25%;"></div>
          </div>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('custom-event.seating') }}" class="space-y-6">
          @csrf

          <!-- Venue Type -->
          <div>
              <label for="venue_type" class="block font-semibold text-black mb-2">Choose Venue Type</label>
              <select name="venue_type" id="venue_type" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="predefined">Predefined Venue</option>
                  <option value="custom">Custom Venue</option>
              </select>
          </div>

          <!-- Date Picker -->
          <div>
              <label for="event_date" class="block font-semibold text-black mb-2">Select Event Date</label>
              <input type="date" name="event_date" id="event_date" 
                     class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm"/>
          </div>

          <!-- Predefined Venue List -->
          <div id="predefined-venue-list" class="hidden">
              <label for="predefined_venue" class="block font-semibold text-black mb-2">Select Predefined Venue</label>
              <select name="predefined_venue" id="predefined_venue" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="" disabled selected>Select a venue</option>
              </select>
          </div>

          <!-- Custom Venue Fields -->
          <div id="custom-venue-fields" class="space-y-6">
              <input type="number" id="max_guests" class="hidden">

              <div>
                  <label for="venue_size" class="block font-semibold text-black mb-2">Venue Size (sq meters)</label>
                  <input type="number" name="venue_size" id="venue_size" placeholder="Enter venue size" 
                         class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm"/>
              </div>

              <div>
                  <label for="venue_address" class="block font-semibold text-black mb-2">Venue Address</label>
                  <input type="text" name="venue_address" id="venue_address" placeholder="Enter address" 
                         class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm"/>
              </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
              <button type="submit" 
                      class="w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg">
                  Next: Select Seating →
              </button>
          </div>
      </form>

      <!-- Cost Indicators moved to bottom -->
      <div class="mt-8 flex flex-col gap-2 items-end">
          <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="estimated-cost">Estimated Cost: $0</span>
          </div>
          <div class="bg-indigo-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="total-estimated-cost">Total Estimated Price: $0</span>
          </div>
      </div>
  </div>
</div>
@endsection
