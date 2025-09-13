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

            <!-- Title of the Card -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Your Venue</h1>

            <!-- Back Button -->
            <a href="{{ route('custom-event.index') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
                &#8592; Go Back
            </a>

            <form method="POST" action="{{ route('custom-event.seating') }}">
                @csrf

                <!-- Venue Selection -->
                <div class="mb-4">
                    <label for="venue" class="block text-left mb-2">Choose Venue Type</label>
                    <select name="venue_type" id="venue_type" class="w-full bg-transparent outline-none text-base">
                        <option value="predefined">Predefined Venue</option>
                        <option value="custom">Custom Venue</option>
                    </select>
                </div>

                <!-- Date Picker (DaisyUI) -->
                <div class="mb-4">
                    <label for="event_date" class="block text-left mb-2">Select Event Date</label>
                    <input type="date" name="event_date" id="event_date" class="input input-bordered w-full" />

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('event_date');
        const venueSelect = document.getElementById('predefined_venue');

        // Only trigger AJAX when date is changed by user
        dateInput.addEventListener('change', function() {
            let selectedDate = this.value;
            // Ensure date is in YYYY-MM-DD format
            if (selectedDate) {
                const dateObj = new Date(selectedDate);
                const yyyy = dateObj.getFullYear();
                const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
                const dd = String(dateObj.getDate()).padStart(2, '0');
                selectedDate = `${yyyy}-${mm}-${dd}`;
            }
            fetch(`/api/available-venues?date=${selectedDate}`)
                .then(response => response.json())
                .then(venues => {
                    window.availableVenues = venues; // Store globally for later lookup
                    // Make sure the dropdown is visible
                    const predefinedVenueList = document.getElementById('predefined-venue-list');
                    if (predefinedVenueList) {
                        predefinedVenueList.classList.remove('hidden');
                    }
                    venueSelect.innerHTML = '<option value="" disabled selected>Select a venue</option>';
                    venues.forEach(venue => {
                        venueSelect.innerHTML += `<option value="${venue.id}">${venue.name} (${venue.size} sq meters)</option>`;
                    });
                });
        });
    });
    </script>
                </div>

                <!-- Predefined Venue List (hidden by default) -->
                <div id="predefined-venue-list" class="mb-4 hidden">
                    <label for="predefined_venue" class="block text-left mb-2">Select Predefined Venue</label>
                    <select name="predefined_venue" id="predefined_venue" class="w-full bg-transparent outline-none text-base">
                        <option value="" disabled selected>Select a venue</option>
                    </select>
                </div>

                <!-- Venue size/address input always shown, but readonly for predefined -->
                <div id="custom-venue-fields" class="mb-4">
                    <div id="venue-capacity-message" class="mb-2 text-sm text-indigo-700 font-semibold"></div>
                    <!-- Max Guests (hidden, used for JS only) -->
                    <input type="number" id="max_guests" class="hidden">
                    <div class="mb-4">
                        <label for="venue_size" class="block text-left mb-2">Venue Size (sq meters)</label>
                        <input type="number" name="venue_size" id="venue_size" placeholder="Enter venue size" class="w-full bg-transparent outline-none text-base">
                    </div>

                    <div class="mb-4">
                        <label for="venue_address" class="block text-left mb-2">Venue Address</label>
                        <input type="text" name="venue_address" id="venue_address" placeholder="Enter address" class="w-full bg-transparent outline-none text-base">
                    </div>
                    
                </div>

                <!-- "Next" Button -->
                <button type="submit" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                    Next: Select Seating
                </button>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dateInput = document.getElementById('event_date');
                const today = new Date();
                today.setDate(today.getDate() + 7); // Add 7 days
                const minDate = today.toISOString().split('T')[0];
                dateInput.setAttribute('min', minDate);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const venueTypeSelect = document.getElementById('venue_type');
                const predefinedVenueList = document.getElementById('predefined-venue-list');
                const customVenueFields = document.getElementById('custom-venue-fields');
                const predefinedVenueSelect = document.getElementById('predefined_venue');
                const venueSizeInput = document.getElementById('venue_size');
                const venueAddressInput = document.getElementById('venue_address');
                const estimatedCostElement = document.getElementById('estimated-cost');
                const totalEstimatedCostElement = document.getElementById('total-estimated-cost');
                const maxGuestsInput = document.getElementById('max_guests');

                // Helper: Save venue info to localStorage (include type and predefined name)
                function saveVenueInfo(type, predefined, size, address, cost) {
                    const dateInput = document.getElementById('event_date');
                    const selectedDate = dateInput ? dateInput.value : '';
                    const venueData = {
                        type: type,
                        predefined: predefined,
                        size: size,
                        address: address,
                        cost: cost,
                        date: selectedDate
                    };
                    localStorage.setItem('event_venue', JSON.stringify(venueData));
                    updateTotalEstimatedCost();
                }

                // Helper: Calculate max guests by venue size (assume 2 sq meters per guest)
                function calculateMaxGuests(size) {
                    return Math.floor(size / 2);
                }

                // Helper: Update total estimated cost from all steps
                function updateTotalEstimatedCost() {
                    let total = 0;
                    // Venue
                    const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
                    if (venue.cost) total += venue.cost;
                    // Seating
                    const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
                    if (seating.cost) total += seating.cost;
                    // Stage
                    const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
                    if (stage.cost) total += stage.cost;
                    // Catering
                    const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
                    if (catering.cost) total += catering.cost;
                    // Photography
                    const photography = JSON.parse(localStorage.getItem('event_photography') || '{}');
                    if (photography.cost) total += photography.cost;
                    // Extra Options
                    const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');
                    if (extra.cost) total += extra.cost;
                    totalEstimatedCostElement.innerText = `Total Estimated Price: $${total}`;
                }

                // Toggle between predefined and custom venue forms
                function updateVenueTypeUI() {
                    if (venueTypeSelect.value === 'predefined') {
                        predefinedVenueList.classList.remove('hidden');
                        customVenueFields.classList.remove('hidden');
                        venueSizeInput.readOnly = true;
                        venueAddressInput.readOnly = true;
                    } else {
                        predefinedVenueList.classList.add('hidden');
                        customVenueFields.classList.remove('hidden');
                        venueSizeInput.readOnly = false;
                        venueAddressInput.readOnly = false;
                    }
                }
                venueTypeSelect.addEventListener('change', function() {
                    updateVenueTypeUI();
                    if (venueTypeSelect.value === 'predefined') {
                        // If a predefined venue is already selected, trigger its change event
                        if (predefinedVenueSelect.value && predefinedVenueSelect.value !== "") {
                            predefinedVenueSelect.dispatchEvent(new Event('change'));
                        } else {
                            // No venue selected, clear fields and localStorage
                            venueSizeInput.value = "";
                            venueAddressInput.value = "";
                            maxGuestsInput.value = "";
                            estimatedCostElement.innerText = `Estimated Cost: $0`;
                            saveVenueInfo('predefined', '', 0, '', 0);
                        }
                    } else if (venueTypeSelect.value === 'custom') {
                        const size = parseInt(venueSizeInput.value) || 0;
                        updateEstimatedCost(size);
                    }
                });

                // Replace hardcoded venue autofill logic with dynamic lookup
                predefinedVenueSelect.addEventListener('change', function() {
                    const selectedVenueId = this.value;
                    const selectedVenueObj = window.availableVenues?.find(v => v.id == selectedVenueId);
                    if (selectedVenueObj) {
                        // Fill the input boxes with the selected venue's data
                        document.getElementById('venue_size').value = selectedVenueObj.size;
                        document.getElementById('venue_address').value = selectedVenueObj.address;
                        if (maxGuestsInput) maxGuestsInput.value = calculateMaxGuests(selectedVenueObj.size);
                        estimatedCostElement.innerText = `Estimated Cost: $${selectedVenueObj.size * 10}`;
                        // Show capacity message
                        const capacityMsg = document.getElementById('venue-capacity-message');
                        if (capacityMsg) {
                            capacityMsg.innerText = `Capacity: ${calculateMaxGuests(selectedVenueObj.size)} guests`;
                        }
                        saveVenueInfo('predefined', selectedVenueObj.name, selectedVenueObj.size, selectedVenueObj.address, selectedVenueObj.size * 10);
                    } else {
                        document.getElementById('venue_size').value = '';
                        document.getElementById('venue_address').value = '';
                        if (maxGuestsInput) maxGuestsInput.value = '';
                        estimatedCostElement.innerText = `Estimated Cost: $0`;
                        const capacityMsg = document.getElementById('venue-capacity-message');
                        if (capacityMsg) {
                            capacityMsg.innerText = '';
                        }
                        saveVenueInfo('predefined', '', 0, '', 0);
                    }
                });

                // Update max guests and cost on venue size change (only if custom)
                venueSizeInput.addEventListener('input', function() {
                    if (venueTypeSelect.value === 'custom') {
                        const size = parseInt(venueSizeInput.value) || 0;
                        maxGuestsInput.value = calculateMaxGuests(size);
                        updateEstimatedCost(size);
                    }
                });

                // Function to update the estimated cost
                function updateEstimatedCost(size) {
                    const costPerSquareMeter = 10; // Example cost
                    const estimatedCost = size * costPerSquareMeter;
                    estimatedCostElement.innerText = `Estimated Cost: $${estimatedCost}`;
                    // Save venue info for custom or predefined
                    if (venueTypeSelect.value === 'predefined') {
                        saveVenueInfo('predefined', predefinedVenueSelect.value, size, venueAddressInput.value, estimatedCost);
                    } else {
                        saveVenueInfo('custom', '', size, venueAddressInput.value, estimatedCost);
                    }
                }

                // On page load, restore venue info and total price
                (function restoreVenueInfo() {
                    const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
                    // Restore the selected date in the date picker
                    if (venue.date) {
                        document.getElementById('event_date').value = venue.date;
                    }
                    if (venue.type === 'predefined') {
                        venueTypeSelect.value = 'predefined';
                        updateVenueTypeUI();
                        // Populate predefined venue fields directly from localStorage
                        predefinedVenueSelect.value = venue.predefined || '';
                        venueSizeInput.value = venue.size || '';
                        venueAddressInput.value = venue.address || '';
                        if (venue.size) maxGuestsInput.value = calculateMaxGuests(venue.size);
                        if (venue.size) estimatedCostElement.innerText = `Estimated Cost: $${venue.size * 10}`;
                        const capacityMsg = document.getElementById('venue-capacity-message');
                        if (capacityMsg && venue.size) {
                            capacityMsg.innerText = `Capacity: ${calculateMaxGuests(venue.size)} guests`;
                        } else if (capacityMsg) {
                            capacityMsg.innerText = '';
                        }
                        updateTotalEstimatedCost();
                    } else {
                        venueTypeSelect.value = 'custom';
                        updateVenueTypeUI();
                        venueSizeInput.value = venue.size || '';
                        venueAddressInput.value = venue.address || '';
                        if (venue.size) maxGuestsInput.value = calculateMaxGuests(venue.size);
                        if (venue.cost) estimatedCostElement.innerText = `Estimated Cost: $${venue.cost}`;
                        const capacityMsg = document.getElementById('venue-capacity-message');
                        if (capacityMsg) {
                            capacityMsg.innerText = '';
                        }
                        updateTotalEstimatedCost();
                    }
                })();
            });
        </script>
    @endsection

@endsection
