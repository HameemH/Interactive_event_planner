@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: $0</span>
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

                // Add event listeners to inputs to calculate estimated cost dynamically
                attendeesInput.addEventListener('input', calculateCost);
                chairTypeSelect.addEventListener('change', calculateCost);
                tableTypeSelect.addEventListener('change', calculateCost);
                seatCoverSelect.addEventListener('change', calculateCost);

                function calculateCost() {
                    const attendees = parseInt(attendeesInput.value) || 0;
                    const chairType = chairTypeSelect.value;
                    const tableType = tableTypeSelect.value;
                    const seatCover = seatCoverSelect.value;

                    // Define cost for chair and table types
                    const chairCost = chairType === 'premium' ? 10 : (chairType === 'luxury' ? 20 : 5);
                    const tableCost = tableType === 'square' ? 15 : 10;
                    const seatCoverCost = seatCover === 'yes' ? 5 : 0;

                    // Total cost calculation
                    const totalCost = attendees * (chairCost + tableCost + seatCoverCost);
                    estimatedCostElement.innerText = `Estimated Cost: $${totalCost}`;
                }
            });
        </script>
    @endsection
@endsection
