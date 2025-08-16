@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: ৳0</span>
            </div>

            <!-- Go Back Button (Top Left) -->
            <a href="{{ route('custom-event.index') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
                &#8592; Go Back
            </a>

            <!-- Title of the Card -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Photography</h1>

            <form method="POST" action="{{ route('custom-event.finalize') }}">
                @csrf

                <!-- Photographer Needed Checkbox -->
                <div class="mb-4">
                    <label for="photographer_needed" class="block text-left mb-2">Do you need a photographer?</label>
                    <input type="checkbox" name="photographer_needed" id="photographer_needed" class="form-checkbox">
                </div>

                <!-- Photographer Count (Visible only if photographer_needed is checked) -->
                <div id="photographer-fields" class="hidden">
                    <div class="mb-4">
                        <label for="photographers_count" class="block text-left mb-2">Number of Photographers</label>
                        <input type="number" name="photographers_count" id="photographers_count" value="1" min="1" class="w-full bg-transparent outline-none text-base">
                    </div>

                    <!-- Shoot Type Selection -->
                    <div class="mb-4">
                        <label for="shoot_type" class="block text-left mb-2">Select Shoot Type</label>
                        <select name="shoot_type" id="shoot_type" class="w-full bg-transparent outline-none text-base">
                            <option value="basic">Basic</option>
                            <option value="premium">Premium</option>
                            <option value="luxury">Luxury</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                    Finalize Event
                </button>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const photographerNeededCheckbox = document.getElementById('photographer_needed');
                const photographerFields = document.getElementById('photographer-fields');
                const photographersCountInput = document.getElementById('photographers_count');
                const shootTypeSelect = document.getElementById('shoot_type');
                const estimatedCostElement = document.getElementById('estimated-cost');

                const photographerRates = {
                    basic: 100,   // Basic shoot cost per photographer
                    premium: 200, // Premium shoot cost per photographer
                    luxury: 300   // Luxury shoot cost per photographer
                };

                // Function to calculate the total estimated cost
                function calculateEstimatedCost() {
                    const photographersCount = parseInt(photographersCountInput.value) || 1; // Default to 1 photographer
                    const shootType = shootTypeSelect.value;
                    const shootRate = photographerRates[shootType];

                    const totalCost = photographersCount * shootRate;
                    estimatedCostElement.innerText = `Estimated Cost: ৳${totalCost}`;
                }

                // Toggle the photographer fields based on the checkbox
                photographerNeededCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        photographerFields.classList.remove('hidden');
                        calculateEstimatedCost(); // Recalculate the cost when photographer is selected
                    } else {
                        photographerFields.classList.add('hidden');
                        estimatedCostElement.innerText = `Estimated Cost: ৳0`; // Reset cost if no photographer is needed
                    }
                });

                // Recalculate the cost when the photographer count or shoot type changes
                photographersCountInput.addEventListener('input', calculateEstimatedCost);
                shootTypeSelect.addEventListener('change', calculateEstimatedCost);

                // Initial calculation
                calculateEstimatedCost();
            });
        </script>
    @endsection
@endsection
