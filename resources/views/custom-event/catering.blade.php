@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative mt-16">
    <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] max-h-[80vh] overflow-y-auto flex flex-col justify-between shadow-lg">
        <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
            <span id="estimated-cost">Estimated Cost: $0</span>
        </div>
        <!-- Total Estimated Price Section -->
        <div class="absolute top-16 right-4 bg-indigo-800 text-white px-4 py-2 rounded-full text-sm">
            <span id="total-estimated-cost">Total Estimated Price: $0</span>
        </div>
        <a href="{{ route('custom-event.stage') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
            &#8592; Go Back
        </a>
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Catering</h1>
        <form method="POST" action="{{ route('custom-event.photography') }}">
            @csrf
            <!-- Catering Option -->
            <div class="mb-4">
                <label for="catering_required" class="block text-left mb-2">Add Catering</label>
                <input type="checkbox" name="catering_required" id="catering_required" class="form-checkbox">
            </div>
            <!-- Set Menu Dropdown (hidden by default) -->
            <div class="mb-4" id="set-menu-section" style="display:none;">
                <label for="set_menu" class="block text-left mb-2">Select Set Menu</label>
                <select name="set_menu" id="set_menu" class="w-full bg-transparent outline-none text-base">
                    <option value="" data-price="0">-- Choose a Set Menu --</option>
                    <option value="Standard" data-price="300">Standard (৳300)</option>
                    <option value="Premium" data-price="500">Premium (৳500)</option>
                    <option value="Vegetarian" data-price="250">Vegetarian (৳250)</option>
                </select>
                <!-- Dynamic Set Menu Items -->
                <div id="set-menu-items" class="mt-2 text-left text-sm text-gray-700" style="display:none;"></div>
            </div>
            <!-- Extra Dishes (hidden by default) -->
            <div class="mb-4" id="extra-dishes-section" style="display:none;">
                <label for="dishes" class="block text-left mb-2">Select Extra Dishes</label>
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
    const setMenuSection = document.getElementById('set-menu-section');
    const setMenuSelect = document.getElementById('set_menu');
    const setMenuItemsDiv = document.getElementById('set-menu-items');
    const extraDishesSection = document.getElementById('extra-dishes-section');
    const dishCheckboxes = document.querySelectorAll('.dish-checkbox');
    const foodCostInput = document.getElementById('food_cost');
    const estimatedCostElement = document.getElementById('estimated-cost');
    const totalEstimatedCostElement = document.getElementById('total-estimated-cost');

    // Get attendee count from seating info
    function getAttendees() {
        const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
        return seating.attendees || 100;
    }

    // Helper: Save event_catering info to localStorage (matches migration)
    function saveEventCateringInfo(required, perPersonCost, totalGuests, totalCost) {
        const cateringData = {
            catering_required: required,
            per_person_cost: perPersonCost,
            total_guests: totalGuests,
            total_catering_cost: totalCost
        };
        localStorage.setItem('event_catering', JSON.stringify(cateringData));
        updateTotalEstimatedCost();
    }

    // Helper: Save catering_selections info to localStorage (matches migration)
    function saveCateringSelectionsInfo(setMenu, extraItems) {
        const selectionsData = {
            set_menu: setMenu,
            extra_items: extraItems
        };
        localStorage.setItem('catering_selections', JSON.stringify(selectionsData));
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
        totalEstimatedCostElement.innerText = `Total Estimated Price: ৳${total}`;
    }

    // Set menu items
    const setMenus = {
        'Standard': [
            'Biryani',
            'Chicken Curry',
            'Mixed Vegetable',
            'Raita',
            'Salad',
            'Gulab Jamun'
        ],
        'Premium': [
            'Mutton Biryani',
            'Butter Chicken',
            'Paneer Masala',
            'Fish Fry',
            'Naan/Roti',
            'Shahi Tukda',
            'Fruit Custard'
        ],
        'Vegetarian': [
            'Vegetable Pulao',
            'Dal Makhani',
            'Paneer Butter Masala',
            'Mixed Veg Curry',
            'Cucumber Salad',
            'Rasgulla'
        ]
    };

    function showSetMenuItems() {
        const selectedMenu = setMenuSelect.value;
        if (selectedMenu && setMenus[selectedMenu]) {
            setMenuItemsDiv.style.display = '';
            setMenuItemsDiv.innerHTML = `<strong>Menu Items:</strong><ul class='list-disc ml-4'>` +
                setMenus[selectedMenu].map(item => `<li>${item}</li>`).join('') + '</ul>';
        } else {
            setMenuItemsDiv.style.display = 'none';
            setMenuItemsDiv.innerHTML = '';
        }
    }

    function calculateFoodCost() {
        let setMenuPrice = 0;
        let extraDishesPrice = 0;
        let selectedDishes = [];

        // Get set menu price
        if (setMenuSelect.value) {
            setMenuPrice = parseFloat(setMenuSelect.options[setMenuSelect.selectedIndex].getAttribute('data-price')) || 0;
        }

        // Get extra dishes price
        dishCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                extraDishesPrice += parseFloat(checkbox.getAttribute('data-price')) || 0;
                selectedDishes.push(checkbox.value);
            }
        });

        // Total per person
        const totalPerPerson = setMenuPrice + extraDishesPrice;
        foodCostInput.value = totalPerPerson;

        // Total for all attendees
        const attendees = getAttendees();
        const totalCost = totalPerPerson * attendees;
        estimatedCostElement.innerText = `Estimated Cost: ৳${totalCost}`;

        // Save event_catering info
        saveEventCateringInfo(cateringRequiredCheckbox.checked, totalPerPerson, attendees, totalCost);
        // Save catering_selections info
        saveCateringSelectionsInfo(setMenuSelect.value, selectedDishes);
    }

    // Show/hide sections based on catering checkbox
    cateringRequiredCheckbox.addEventListener('change', function() {
        if (this.checked) {
            setMenuSection.style.display = '';
            extraDishesSection.style.display = '';
            showSetMenuItems();
            calculateFoodCost();
        } else {
            setMenuSection.style.display = 'none';
            extraDishesSection.style.display = 'none';
            setMenuItemsDiv.style.display = 'none';
            setMenuItemsDiv.innerHTML = '';
            foodCostInput.value = 0;
            estimatedCostElement.innerText = `Estimated Cost: ৳0`;
            saveCateringInfo(false, '', [], 0);
        }
    });

    // Recalculate and show menu items on set menu change
    setMenuSelect.addEventListener('change', function() {
        showSetMenuItems();
        calculateFoodCost();
    });

    // Recalculate on extra dish change
    dishCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', calculateFoodCost);
    });

    // On page load, restore catering info and total price
    (function restoreCateringInfo() {
        // Restore event_catering info
        const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
        if (catering.catering_required) {
            cateringRequiredCheckbox.checked = true;
            setMenuSection.style.display = '';
            extraDishesSection.style.display = '';
        } else {
            cateringRequiredCheckbox.checked = false;
            setMenuSection.style.display = 'none';
            extraDishesSection.style.display = 'none';
        }
        // Restore catering_selections info
        const selections = JSON.parse(localStorage.getItem('catering_selections') || '{}');
        if (selections.set_menu) setMenuSelect.value = selections.set_menu;
        if (selections.extra_items && Array.isArray(selections.extra_items)) {
            dishCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selections.extra_items.includes(checkbox.value);
            });
        }
        calculateFoodCost();
        updateTotalEstimatedCost();
    })();
});
</script>
@endsection