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

  <!-- Glass Card -->
  <div class="glass-card p-10 pt-8 rounded-3xl w-[650px] min-h-[600px] flex flex-col shadow-xl relative z-10">
      
      <!-- Back Button -->
      <a href="{{ route('customize.stage') }}" 
         class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
        <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
          Select Catering
        </span>
      </h1>
      <p class="text-purple-900 text-center mb-6">Choose your catering options for the event</p>
<div class="w-full mb-8">
    <div class="flex items-center justify-between text-sm font-medium text-blue-900 mb-2">
        <span>Step 1: Venue</span>
        <span>Step 2: Seating</span>
        <span>Step 3: Stage</span>
        <span class="font-bold text-purple-600">Step 4: Catering</span>
        <span>Step 5: Photography</span>
    </div>
    <div class="w-full bg-white/30 rounded-full h-2 overflow-hidden">
        <!-- Step 4 = 80% -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: 80%;"></div>
    </div>
</div>


      <!-- Form -->
      <div class="space-y-6">

          <!-- Add Catering -->
          <div>
              <label class="block font-semibold text-black mb-2">Add Catering?</label>
              <input type="checkbox" id="catering_required" class="form-checkbox">
          </div>

          <!-- Set Menu -->
          <div id="set-menu-section" class="space-y-2 hidden">
              <label for="set_menu" class="block font-semibold text-black mb-2">Select Set Menu</label>
              <select name="set_menu" id="set_menu" 
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
                  <option value="" data-price="0">-- Choose a Set Menu --</option>
                  <option value="Standard" data-price="300">Standard (৳300)</option>
                  <option value="Premium" data-price="500">Premium (৳500)</option>
                  <option value="Vegetarian" data-price="250">Vegetarian (৳250)</option>
              </select>
              <div id="set-menu-items" class="mt-2 text-left text-sm text-gray-700 hidden"></div>
          </div>

          <!-- Extra Dishes -->
          <div id="extra-dishes-section" class="space-y-2 hidden">
              <label class="block font-semibold text-black mb-2">Select Extra Dishes</label>
              <div class="grid grid-cols-2 gap-4">
                  @php
                      $dishes = [
                          'Biryani' => 150, 'Pulao' => 100, 'Korma' => 200, 'Roshogolla' => 80,
                          'Macher Jhol' => 120, 'Samosa' => 50, 'Fried Chicken' => 180,
                          'Shorshe Ilish' => 250, 'Beguni' => 70, 'Kachaudi' => 40
                      ];
                  @endphp
                  @foreach($dishes as $dish => $price)
                      <div class="flex items-center space-x-2">
                          <input type="checkbox" name="selected_dishes[]" value="{{ $dish }}" data-price="{{ $price }}" class="dish-checkbox">
                          <label class="text-left text-sm">{{ $dish }} (৳{{ $price }})</label>
                      </div>
                  @endforeach
              </div>
          </div>

          <!-- Food Cost per Person -->
          <div>
              <label for="food_cost" class="block font-semibold text-black mb-2">Food Cost per Person</label>
              <input type="number" name="food_cost" id="food_cost" readonly 
                     class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm" value="0">
          </div>

          <!-- Submit Button -->
          <div class="pt-4">
              <a href="{{ route('customize.photography') }}" 
                      class="block w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg text-center">
                  Next: Select Photography →
              </a>
          </div>
      </div>

      <!-- Cost Indicators -->
      <div class="mt-8 flex flex-col gap-2 items-end">
          <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="estimated-cost">Estimated Cost: ৳0</span>
          </div>
          <div class="bg-indigo-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="total-estimated-cost">Total Estimated Price: ৳0</span>
          </div>
      </div>
  </div>
</div>
@endsection

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

    function getAttendees() {
        const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
        return seating.attendees || 100;
    }

    function saveEventCateringInfo(required, perPersonCost, totalGuests, totalCost) {
        const cateringData = {
            catering_required: required,
            per_person_cost: perPersonCost,
            total_guests: totalGuests,
            total_catering_cost: totalCost,
            cost: totalCost
        };
        localStorage.setItem('event_catering', JSON.stringify(cateringData));
        updateTotalEstimatedCost();
    }

    function saveCateringSelectionsInfo(setMenu, extraItems) {
        const selectionsData = { set_menu: setMenu, extra_items: extraItems };
        localStorage.setItem('catering_selections', JSON.stringify(selectionsData));
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
        totalEstimatedCostElement.innerText = `Total Estimated Price: ৳${total}`;
    }

    const setMenus = {
        'Standard': ['Biryani','Chicken Curry','Mixed Vegetable','Raita','Salad','Gulab Jamun'],
        'Premium': ['Mutton Biryani','Butter Chicken','Paneer Masala','Fish Fry','Naan/Roti','Shahi Tukda','Fruit Custard'],
        'Vegetarian': ['Vegetable Pulao','Dal Makhani','Paneer Butter Masala','Mixed Veg Curry','Cucumber Salad','Rasgulla']
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
        let setMenuPrice = 0, extraDishesPrice = 0, selectedDishes = [];
        if (setMenuSelect.value) {
            setMenuPrice = parseFloat(setMenuSelect.options[setMenuSelect.selectedIndex].getAttribute('data-price')) || 0;
        }
        dishCheckboxes.forEach(cb => {
            if(cb.checked) { extraDishesPrice += parseFloat(cb.getAttribute('data-price')) || 0; selectedDishes.push(cb.value); }
        });
        const totalPerPerson = setMenuPrice + extraDishesPrice;
        foodCostInput.value = totalPerPerson;
        const totalCost = totalPerPerson * getAttendees();
        estimatedCostElement.innerText = `Estimated Cost: ৳${totalCost}`;
        saveEventCateringInfo(cateringRequiredCheckbox.checked, totalPerPerson, getAttendees(), totalCost);
        saveCateringSelectionsInfo(setMenuSelect.value, selectedDishes);
    }

    cateringRequiredCheckbox.addEventListener('change', function() {
        if(this.checked) { setMenuSection.classList.remove('hidden'); extraDishesSection.classList.remove('hidden'); showSetMenuItems(); calculateFoodCost(); }
        else { setMenuSection.classList.add('hidden'); extraDishesSection.classList.add('hidden'); setMenuItemsDiv.classList.add('hidden'); setMenuItemsDiv.innerHTML = ''; foodCostInput.value = 0; estimatedCostElement.innerText = `Estimated Cost: ৳0`; saveEventCateringInfo(false,0,getAttendees(),0); }
    });

    setMenuSelect.addEventListener('change', function(){ showSetMenuItems(); calculateFoodCost(); });
    dishCheckboxes.forEach(cb => cb.addEventListener('change', calculateFoodCost));

    // Restore saved info
    (function restoreCateringInfo() {
        const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
        if(catering.catering_required) { cateringRequiredCheckbox.checked=true; setMenuSection.classList.remove('hidden'); extraDishesSection.classList.remove('hidden'); }
        const selections = JSON.parse(localStorage.getItem('catering_selections') || '{}');
        if(selections.set_menu) setMenuSelect.value=selections.set_menu;
        if(selections.extra_items && Array.isArray(selections.extra_items)) { dishCheckboxes.forEach(cb => { cb.checked = selections.extra_items.includes(cb.value); }); }
        calculateFoodCost();
        updateTotalEstimatedCost();
    })();
});
</script>
@endsection