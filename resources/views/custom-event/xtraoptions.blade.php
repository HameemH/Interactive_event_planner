@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
    <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[400px] flex flex-col justify-between shadow-lg">
        <a href="{{ route('custom-event.photography') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
            &#8592; Go Back
        </a>
        <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
            <span id="extra-estimated-cost">Estimated Cost: ৳0</span>
        </div>
        <!-- Total Estimated Price Section -->
        <div class="absolute top-16 right-4 bg-indigo-800 text-white px-4 py-2 rounded-full text-sm">
            <span id="total-estimated-cost">Total Estimated Price: ৳0</span>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Extra Options</h1>
        <form method="POST" action="{{ route('custom-event.finalize') }}">
            @csrf
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" name="photo_booth" id="photo_booth" data-price="3000" class="mr-2 extra-option">
                    <label for="photo_booth">Photo Booth (+৳3000)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="coffee_booth" id="coffee_booth" data-price="2500" class="mr-2 extra-option">
                    <label for="coffee_booth">Coffee Booth (+৳2500)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="mehendi_booth" id="mehendi_booth" data-price="2000" class="mr-2 extra-option">
                    <label for="mehendi_booth">Mehendi Booth (+৳2000)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="paan_booth" id="paan_booth" data-price="1500" class="mr-2 extra-option">
                    <label for="paan_booth">Paan Booth (+৳1500)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="fuchka_stall" id="fuchka_stall" data-price="1800" class="mr-2 extra-option">
                    <label for="fuchka_stall">Fuchka Stall (+৳1800)</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="sketch_booth" id="sketch_booth" data-price="2200" class="mr-2 extra-option">
                    <label for="sketch_booth">Sketch Booth (+৳2200)</label>
                </div>
            </div>
            <div class="mt-4 mb-4">
                <label>Estimated Cost</label>
                <input type="text" id="extra_cost" readonly value="৳0" class="w-full bg-transparent outline-none text-base">
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
    const extraOptions = document.querySelectorAll('.extra-option');
    const extraCostInput = document.getElementById('extra_cost');
    const extraEstimatedCost = document.getElementById('extra-estimated-cost');
    const totalEstimatedCostElement = document.getElementById('total-estimated-cost');

    // Helper: Save extra options info to localStorage
    function saveExtraInfo(selected, cost) {
        const extraData = {
            selected: selected,
            cost: cost
        };
        localStorage.setItem('event_extra', JSON.stringify(extraData));
        updateTotalEstimatedCost();
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

    function updateExtraCost() {
        let cost = 0;
        let selected = [];
        extraOptions.forEach(function(opt) {
            if (opt.checked) {
                cost += parseInt(opt.getAttribute('data-price')) || 0;
                selected.push(opt.id);
            }
        });
        extraCostInput.value = `৳${cost}`;
        extraEstimatedCost.innerText = `Estimated Cost: ৳${cost}`;
        saveExtraInfo(selected, cost);
    }
    extraOptions.forEach(function(opt) {
        opt.addEventListener('change', updateExtraCost);
    });
    // On page load, restore extra info and total price
    (function restoreExtraInfo() {
        const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');
        if (extra.selected && Array.isArray(extra.selected)) {
            extraOptions.forEach(function(opt) {
                opt.checked = extra.selected.includes(opt.id);
            });
        }
        updateExtraCost();
        updateTotalEstimatedCost();
    })();
});
</script>
@endsection
@endsection
