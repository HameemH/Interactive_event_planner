@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
        <!-- Card Container with Estimated Cost Counter -->
        <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
            <!-- Estimated Cost Counter in Top Right -->
            <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
                <span id="estimated-cost">Estimated Cost: $0</span>
            </div>

            <!-- Go Back Button (Top Left) -->
            <a href="{{ route('custom-event.index') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
                &#8592; Go Back
            </a>

            <!-- Title of the Card -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Catering</h1>

            <form method="POST" action="{{ route('custom-event.photography') }}">
                @csrf

                <!-- Catering Option -->
                <div class="mb-4">
                    <label for="catering_required" class="block text-left mb-2">Add Catering</label>
                    <input type="checkbox" name="catering_required" id="catering_required" class="form-checkbox">
                </div>

                <!-- Dish Selection -->
                <div class="mb-4">
                    <label for="dishes" class="block text-left mb-2">Select Dishes</label>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $dishes = [
                                'Biryani' => 150,
                                'Pulao' => 100,
                                'Korma' => 200,
                                'Roshogolla' => 80,
                                'Macher Jhol' => 120,
                                'Samosa' => 50,
                                'Fried Chicken' => 180,
                                'Shorshe Ilish' => 250,
                                'Beguni' => 70,
                                'Kachaudi' => 40
                            ];
                        @endphp

                        @foreach($dishes as $dish => $price)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="selected_dishes[]" value="{{ $dish }}" data-price="{{ $price }}" class="dish-checkbox">
                                <label for="{{ $dish }}" class="text-left text-sm">{{ $dish }} (৳{{ $price }})</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price per Person -->
                <div class="mb-4">
                    <label for="food_cost" class="block text-left mb-2">Food Cost per Person</label>
                    <input type="number" name="food_cost" id="food_cost" readonly class="w-full bg-transparent outline-none text-base" placeholder="Calculated cost per person" value="0">
                </div>

                <button type="submit" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                    Next: Select Photography
                </button>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cateringRequiredCheckbox = document.getElementById('catering_required');
                const dishCheckboxes = document.querySelectorAll('.dish-checkbox');
                const foodCostInput = document.getElementById('food_cost');
                const estimatedCostElement = document.getElementById('estimated-cost');
                const attendees = 100; // This should be dynamically pulled from the previous page or session

                // Function to calculate food cost per person
                function calculateFoodCost() {
                    let totalCost = 0;

                    // Loop through all selected dishes and calculate total cost
                    dishCheckboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            const price = parseFloat(checkbox.getAttribute('data-price'));
                            totalCost += price;
                        }
                    });

                    // Update the food cost input field
                    foodCostInput.value = totalCost;

                    // Calculate the total cost with attendees
                    const totalFoodCost = totalCost * attendees;
                    estimatedCostElement.innerText = `Estimated Cost: ৳${totalFoodCost}`;
                }

                // Event listener for checking/unchecking dishes
                dishCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', calculateFoodCost);
                });

                // Toggle the catering options and re-calculate cost
                cateringRequiredCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        calculateFoodCost(); // Recalculate cost when catering is selected
                    } else {
                        foodCostInput.value = 0; // Reset food cost if catering is not required
                        estimatedCostElement.innerText = `Estimated Cost: ৳0`;
                    }
                });
            });
        </script>
    @endsection
@endsection
