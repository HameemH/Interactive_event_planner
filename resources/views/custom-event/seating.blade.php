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

  /* Glass Effect */
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

  /* Gradient Badge */
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
      <a href="{{ route('custom-event.venue') }}" 
         class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
        <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
          Select Seating Options
        </span>
      </h1>
      <p class="text-purple-900 text-center mb-6">Choose seating preferences for your event</p>

      <!-- Progress Bar -->
      <div class="w-full mb-8">
          <div class="flex items-center justify-between text-sm font-medium text-blue-900 mb-2">
              <span>Step 1: Venue</span>
              <span>Step 2: Seating</span>
              <span>Step 3: Decoration</span>
              <span>Step 4: Review</span>
          </div>
          <div class="w-full bg-white/30 rounded-full h-2 overflow-hidden">
              <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: 50%;"></div>
          </div>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('custom-event.stage') }}" class="space-y-6">
          @csrf

          <!-- Number of Attendees -->
          <div>
              <label for="attendees" class="block font-semibold text-black mb-2">Number of Attendees</label>
              <input type="number" name="attendees" id="attendees" placeholder="Enter number of people" 
                     class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
              <span id="max-attendees-info" class="text-xs text-gray-500"></span>
          </div>

          <!-- Chair Type -->
          <div>
              <label for="chair_type" class="block font-semibold text-black mb-2">Choose Chair Type</label>
              <select name="chair_type" id="chair_type" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="basic">Basic</option>
                  <option value="premium">Premium</option>
                  <option value="luxury">Luxury</option>
              </select>
          </div>

          <!-- Table Type -->
          <div>
              <label for="table_type" class="block font-semibold text-black mb-2">Choose Table Type</label>
              <select name="table_type" id="table_type" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="circular">Circular</option>
                  <option value="square">Square</option>
              </select>
          </div>

          <!-- Seat Cover -->
          <div>
              <label for="seat_cover" class="block font-semibold text-black mb-2">Seat Covering</label>
              <select name="seat_cover" id="seat_cover" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="no">No</option>
                  <option value="yes">Yes</option>
              </select>
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
              <button type="submit" 
                      class="w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg">
                  Next: Select Stage →
              </button>
          </div>
      </form>

      <!-- Cost Indicators (Bottom Right) -->
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attendeesInput = document.getElementById('attendees');
        const chairTypeSelect = document.getElementById('chair_type');
        const tableTypeSelect = document.getElementById('table_type');
        const seatCoverSelect = document.getElementById('seat_cover');
        const estimatedCostElement = document.getElementById('estimated-cost');
        const totalEstimatedCostElement = document.getElementById('total-estimated-cost');
        const maxAttendeesInfo = document.getElementById('max-attendees-info');

        function saveSeatingInfo(attendees, chairType, tableType, seatCover, cost) {
            const seatingData = { attendees, chairType, tableType, seatCover, cost };
            localStorage.setItem('event_seating', JSON.stringify(seatingData));
            updateTotalEstimatedCost();
        }

        function updateTotalEstimatedCost() {
            let total = 0;
            const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
            if (venue.cost) total += venue.cost;
            const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
            if (seating.cost) total += seating.cost;
            const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
            if (stage.cost) total += stage.cost;
            const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
            if (catering.cost) total += catering.cost;
            const photography = JSON.parse(localStorage.getItem('event_photography') || '{}');
            if (photography.cost) total += photography.cost;
            const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');
            if (extra.cost) total += extra.cost;
            totalEstimatedCostElement.innerText = `Total Estimated Price: $${total}`;
        }

        function getMaxAttendees() {
            const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
            return venue.size ? Math.floor(venue.size / 2) : null;
        }

        attendeesInput.addEventListener('input', calculateCost);
        chairTypeSelect.addEventListener('change', calculateCost);
        tableTypeSelect.addEventListener('change', calculateCost);
        seatCoverSelect.addEventListener('change', calculateCost);

        function calculateCost() {
            let attendees = parseInt(attendeesInput.value) || 0;
            const maxAttendees = getMaxAttendees();
            if (maxAttendees !== null) {
                maxAttendeesInfo.innerText = `Maximum allowed by venue: ${maxAttendees}`;
                if (attendees > maxAttendees) {
                    attendeesInput.value = maxAttendees;
                    attendees = maxAttendees;

    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: $0</span>
            </div>
            <!-- Total Estimated Price Section -->
            <div class="absolute top-16 right-4 bg-indigo-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="total-estimated-cost">Total Estimated Price: $0</span>
            </div>

            <!-- Back Button (Top Left) -->
            <a href="{{ route('custom-event.venue') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
                &#8592; Go Back
            </a>

            <!-- Title of the Card -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Seating Options</h1>

            <form method="POST" action="{{ route('custom-event.stage') }}">
                @csrf

                <!-- Number of Attendees -->
                <div class="mb-4">
                    <label for="attendees" class="block text-left mb-2">Number of Attendees</label>
                    <input type="number" name="attendees" id="attendees" placeholder="Enter number of people" class="w-full bg-transparent outline-none text-base">
                    <span id="max-attendees-info" class="text-xs text-gray-500"></span>
                </div>

                <!-- Chair Type Selection -->
                <div class="mb-4">
                    <label for="chair_type" class="block text-left mb-2">Choose Chair Type</label>
                    <select name="chair_type" id="chair_type" class="w-full bg-transparent outline-none text-base">
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="luxury">Luxury</option>
                    </select>
                </div>

                <!-- Table Type Selection -->
                <div class="mb-4">
                    <label for="table_type" class="block text-left mb-2">Choose Table Type</label>
                    <select name="table_type" id="table_type" class="w-full bg-transparent outline-none text-base">
                        <option value="circular">Circular</option>
                        <option value="square">Square</option>
                    </select>
                </div>

                <!-- Seat Covering Option -->
                <div class="mb-4">
                    <label for="seat_cover" class="block text-left mb-2">Seat Covering</label>
                    <select name="seat_cover" id="seat_cover" class="w-full bg-transparent outline-none text-base">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                    Next: Select Stage
                </button>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const attendeesInput = document.getElementById('attendees');
                const chairTypeSelect = document.getElementById('chair_type');
                const tableTypeSelect = document.getElementById('table_type');
                const seatCoverSelect = document.getElementById('seat_cover');
                const estimatedCostElement = document.getElementById('estimated-cost');
                const totalEstimatedCostElement = document.getElementById('total-estimated-cost');
                const maxAttendeesInfo = document.getElementById('max-attendees-info');

                // Helper: Save seating info to localStorage
                function saveSeatingInfo(attendees, chairType, tableType, seatCover, cost) {
                    const seatingData = {
                        attendees: attendees,
                        chairType: chairType,
                        tableType: tableType,
                        seatCover: seatCover === 'yes' ? 'yes' : 'no',
                        cost: cost
                    };
                    localStorage.setItem('event_seating', JSON.stringify(seatingData));
                    updateTotalEstimatedCost();
                }
            } else {
                maxAttendeesInfo.innerText = '';
            }
            const chairType = chairTypeSelect.value;
            const tableType = tableTypeSelect.value;
            const seatCover = seatCoverSelect.value;

            const chairCost = chairType === 'premium' ? 10 : (chairType === 'luxury' ? 20 : 5);
            const tableCost = tableType === 'square' ? 15 : 10;
            const seatCoverCost = seatCover === 'yes' ? 5 : 0;

            const totalCost = attendees * (chairCost + tableCost + seatCoverCost);
            estimatedCostElement.innerText = `Estimated Cost: $${totalCost}`;
            saveSeatingInfo(attendees, chairType, tableType, seatCover, totalCost);
        }

        (function restoreSeatingInfo() {
            const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
            if (seating.attendees) attendeesInput.value = seating.attendees;
            if (seating.chairType) chairTypeSelect.value = seating.chairType;
            if (seating.tableType) tableTypeSelect.value = seating.tableType;
            if (seating.seatCover) seatCoverSelect.value = seating.seatCover;
            calculateCost();
            updateTotalEstimatedCost();
        })();
    });
</script>
@endsection
@endsection
