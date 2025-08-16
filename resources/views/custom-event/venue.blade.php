@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: $0</span>
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
                <div id="predefined-venue-list" class="hidden mb-4">
                    <label for="predefined_venue" class="block text-left mb-2">Select Predefined Venue</label>
                    <select name="predefined_venue" id="predefined_venue" class="w-full bg-transparent outline-none text-base">
                        <option value="" disabled selected>Select a venue</option>
                        <option value="Venue A">Venue A (100 sq meters)</option>
                        <option value="Venue B">Venue B (200 sq meters)</option>
                        <option value="Venue C">Venue C (300 sq meters)</option>
                    </select>
                </div>

                <!-- Venue size input if custom venue is selected -->
                <div id="custom-venue-fields" >
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

                // Toggle between predefined and custom venue forms
                venueTypeSelect.addEventListener('change', function() {
                    if (this.value === 'predefined') {
                        predefinedVenueList.classList.remove('hidden');
                    } else {
                        predefinedVenueList.classList.add('hidden');
                    }
                });

                // Autofill custom fields based on selected predefined venue
                predefinedVenueSelect.addEventListener('change', function() {
                    const selectedVenue = this.value;
                    if (selectedVenue === 'Venue A') {
                        venueSizeInput.value = 100;
                        venueAddressInput.value = '123 Venue A Address';
                        updateEstimatedCost(100);
                    } else if (selectedVenue === 'Venue B') {
                        venueSizeInput.value = 200;
                        venueAddressInput.value = '456 Venue B Address';
                        updateEstimatedCost(200);
                    } else if (selectedVenue === 'Venue C') {
                        venueSizeInput.value = 300;
                        venueAddressInput.value = '789 Venue C Address';
                        updateEstimatedCost(300);
                    }
                });

                // Function to update the estimated cost
                function updateEstimatedCost(size) {
                    const costPerSquareMeter = 10; // Example cost
                    const estimatedCost = size * costPerSquareMeter;
                    estimatedCostElement.innerText = `Estimated Cost: $${estimatedCost}`;
                }
            });
        </script>
    @endsection
@endsection
