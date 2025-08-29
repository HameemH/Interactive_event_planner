@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-64px)] relative">
    <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col justify-between shadow-lg">
        <div class="absolute top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-full text-sm">
            <span id="estimated-cost">Estimated Cost: ৳0</span>
        </div>
        <a href="{{ route('custom-event.index') }}" class="absolute top-4 left-4 text-gray-700 hover:text-indigo-600 font-semibold">
            &#8592; Go Back
        </a>
        <h1 class="text-2xl font-extrabold text-gray-800 mb-4">Select Photography</h1>
        <form method="POST" action="{{ route('custom-event.finalize') }}">
            @csrf
            <div class="mb-4">
                <label for="photographer_needed" class="block text-left mb-2">Do you want a photographer?</label>
                <input type="checkbox" name="photographer_needed" id="photographer_needed" class="form-checkbox">
            </div>
            <div id="photography-options" style="display:none;">
                <div class="mb-4">
                    <label for="photo_type" class="block text-left mb-2">Choose Photography Option</label>
                    <select id="photo_type" name="photo_type" class="w-full bg-transparent outline-none text-base">
                        <option value="">-- Select --</option>
                        <option value="package">Package</option>
                        <option value="custom">Customizable</option>
                    </select>
                </div>
                <!-- Package Dropdown -->
                <div id="package-section" style="display:none;" class="mb-4">
                    <label for="package" class="block text-left mb-2">Select Package</label>
                    <select id="package" name="package" class="w-full bg-transparent outline-none text-base">
                        <option value="">-- Choose Package --</option>
                        <option value="standard" data-price="10000">Standard (৳10,000)</option>
                        <option value="premium" data-price="18000">Premium (৳18,000)</option>
                        <option value="deluxe" data-price="25000">Deluxe (৳25,000)</option>
                    </select>
                    <div id="package-details" class="mt-2 text-sm text-gray-700"></div>
                </div>
                <!-- Customizable Section -->
                <div id="custom-section" style="display:none;" class="mb-4">
                    <label>Number of Photographers</label>
                    <input type="number" name="num_photographers" id="num_photographers" min="1" value="1" class="w-full bg-transparent outline-none text-base mb-2">
                    <label>Number of Hours</label>
                    <input type="number" name="num_hours" id="num_hours" min="1" value="1" class="w-full bg-transparent outline-none text-base mb-2">
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="photography" id="photography" checked class="mr-2" disabled>
                        <label for="photography">Photography (default)</label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="indoor" id="indoor" checked class="mr-2" disabled>
                        <label for="indoor">Indoor Photography (default)</label>
                    </div>
                    <div class="flex items-center mb-2" id="outdoor-section">
                        <input type="checkbox" name="outdoor" id="outdoor" class="mr-2">
                        <label for="outdoor">Outdoor Photography (+৳2000)</label>
                    </div>
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="cinematography" id="cinematography" class="mr-2">
                        <label for="cinematography">Cinematography</label>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-4">
                <label>Estimated Cost</label>
                <input type="text" id="estimated_cost" readonly value="৳0" class="w-full bg-transparent outline-none text-base">
            </div>
            <button type="submit" formaction="{{ route('custom-event.xtraoptions') }}" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform mt-auto">
                Next: Extra Options
            </button>
        </form>
    </div>
</div>
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photographerNeeded = document.getElementById('photographer_needed');
    const photographyOptions = document.getElementById('photography-options');
    const photoType = document.getElementById('photo_type');
    const packageSection = document.getElementById('package-section');
    const customSection = document.getElementById('custom-section');
    const packageSelect = document.getElementById('package');
    const packageDetails = document.getElementById('package-details');
    const numPhotographers = document.getElementById('num_photographers');
    const numHours = document.getElementById('num_hours');
    const photography = document.getElementById('photography');
    const cinematography = document.getElementById('cinematography');
    const outdoor = document.getElementById('outdoor');
    const indoor = document.getElementById('indoor');
    const estimatedCost = document.getElementById('estimated_cost');
    const estimatedCostElement = document.getElementById('estimated-cost');

    const packages = {
        standard: {
            price: 10000,
            details: '1 photographer, 4 hours, photography only, indoor only'
        },
        premium: {
            price: 18000,
            details: '2 photographers, 6 hours, photography + cinematography, indoor + outdoor included'
        },
        deluxe: {
            price: 25000,
            details: '3 photographers, 8 hours, photography + cinematography + drone, indoor + outdoor included'
        }
    };

    function updateSections() {
        if (photoType.value === 'package') {
            packageSection.style.display = '';
            customSection.style.display = 'none';
            updatePackageDetails();
            updateEstimatedCost();
        } else if (photoType.value === 'custom') {
            packageSection.style.display = 'none';
            customSection.style.display = '';
            updateEstimatedCost();
        } else {
            packageSection.style.display = 'none';
            customSection.style.display = 'none';
            estimatedCost.value = '৳0';
            estimatedCostElement.innerText = 'Estimated Cost: ৳0';
        }
    }

    function updatePackageDetails() {
        const selected = packageSelect.value;
        if (selected && packages[selected]) {
            packageDetails.innerHTML = `<strong>Details:</strong> ${packages[selected].details}`;
        } else {
            packageDetails.innerHTML = '';
        }
    }

    function updateEstimatedCost() {
        let cost = 0;
        if (photographerNeeded.checked) {
            if (photoType.value === 'package') {
                const selected = packageSelect.value;
                if (selected && packages[selected]) {
                    cost = packages[selected].price;
                }
            } else if (photoType.value === 'custom') {
                const photographerRate = 2000; // per hour per photographer
                const cinematographyRate = 3000; // per hour
                let numP = parseInt(numPhotographers.value) || 1;
                let numH = parseInt(numHours.value) || 1;
                let photoCost = photographerRate * numP * numH; // photography always checked
                let cinemaCost = cinematography.checked ? cinematographyRate * numH : 0;
                cost = photoCost + cinemaCost;
                if (outdoor.checked) {
                    cost += 2000;
                }
            }
        }
        estimatedCost.value = `৳${cost}`;
        estimatedCostElement.innerText = `Estimated Cost: ৳${cost}`;
    }

    photographerNeeded.addEventListener('change', function() {
        if (this.checked) {
            photographyOptions.style.display = '';
            updateEstimatedCost();
        } else {
            photographyOptions.style.display = 'none';
            estimatedCost.value = '৳0';
            estimatedCostElement.innerText = 'Estimated Cost: ৳0';
        }
    });
    photoType.addEventListener('change', updateSections);
    packageSelect.addEventListener('change', function() {
        updatePackageDetails();
        updateEstimatedCost();
    });
    [numPhotographers, numHours, cinematography, outdoor].forEach(el => {
        el.addEventListener('change', updateEstimatedCost);
    });
    // Initial state
    photographyOptions.style.display = 'none';
    updateSections();
});
</script>
@endsection
@endsection
