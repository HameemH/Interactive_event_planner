@extends('layouts.app')

@section('content')
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

                <!-- Predefined Venue List (hidden by default) -->
                <div id="predefined-venue-list" class="mb-4 hidden">
                    <label for="predefined_venue" class="block text-left mb-2">Select Predefined Venue</label>
                    <select name="predefined_venue" id="predefined_venue" class="w-full bg-transparent outline-none text-base">
                        <option value="" disabled selected>Select a venue</option>
                        <option value="Venue A">Venue A (100 sq meters)</option>
                        <option value="Venue B">Venue B (200 sq meters)</option>
                        <option value="Venue C">Venue C (300 sq meters)</option>
                    </select>
                </div>

                <!-- Venue size/address input always shown, but readonly for predefined -->
                <div id="custom-venue-fields" class="mb-4">
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
                    const venueData = {
                        type: type,
                        predefined: predefined,
                        size: size,
                        address: address,
                        cost: cost
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

                // Autofill custom fields based on selected predefined venue
                predefinedVenueSelect.addEventListener('change', function() {
                    const selectedVenue = this.value;
                    let size = 0;
                    let address = '';
                    if (selectedVenue === 'Venue A') {
                        size = 100;
                        address = '123 Venue A Address';
                    } else if (selectedVenue === 'Venue B') {
                        size = 200;
                        address = '456 Venue B Address';
                    } else if (selectedVenue === 'Venue C') {
                        size = 300;
                        address = '789 Venue C Address';
                    }
                    venueSizeInput.value = size;
                    venueAddressInput.value = address;
                        if (maxGuestsInput) maxGuestsInput.value = calculateMaxGuests(size);
                    // Always update price and save info to localStorage
                    estimatedCostElement.innerText = `Estimated Cost: $${size * 10}`;
                    saveVenueInfo('predefined', selectedVenue, size, address, size * 10);
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
                    if (venue.type === 'predefined') {
                        venueTypeSelect.value = 'predefined';
                        updateVenueTypeUI();
                        if (venue.predefined) predefinedVenueSelect.value = venue.predefined;
                        predefinedVenueSelect.dispatchEvent(new Event('change'));
                    } else {
                        venueTypeSelect.value = 'custom';
                        updateVenueTypeUI();
                        if (venue.size) venueSizeInput.value = venue.size;
                        if (venue.address) venueAddressInput.value = venue.address;
                        if (venue.size) maxGuestsInput.value = calculateMaxGuests(venue.size);
                        if (venue.cost) estimatedCostElement.innerText = `Estimated Cost: $${venue.cost}`;
                    }
                    updateTotalEstimatedCost();
                })();
            });
        </script>
    @endsection
@endsection
