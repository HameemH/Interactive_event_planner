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

  /* Glass Effect */
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

  /* Gradient Badge */
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
  <!-- Background Image + Overlay -->
  <div class="fixed inset-0 w-full h-full">
      <img src="{{ asset('images/event-bg.jpg') }}" alt="Event background" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-animated"></div>
  </div>

  <!-- Glass Card -->
  <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[500px] flex flex-col shadow-xl relative z-10">

      <!-- Go Back -->
      <a href="{{ route('customize.catering') }}" 
         class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
          <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
              Select Photography
          </span>
      </h1>
      <p class="text-purple-900 text-center mb-6">Customize your photography options</p>
<div class="w-full mb-8">
    <div class="flex items-center justify-between text-sm font-medium text-blue-900 mb-2">
        <span>Step 1: Venue</span>
        <span>Step 2: Seating</span>
        <span>Step 3: Stage</span>
        <span>Step 4: Catering</span>
        <span class="font-bold text-purple-600">Step 5: Photography</span>
    </div>
    <div class="w-full bg-white/30 rounded-full h-2 overflow-hidden">
        <!-- Step 5 = 100% -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: 100%;"></div>
    </div>
</div>

      <!-- Form -->
      <div class="space-y-6 flex flex-col flex-grow">
          <!-- Photographer Checkbox -->
          <div>
              <label for="photographer_needed" class="block font-semibold text-black mb-2">
                  Do you want a photographer?
              </label>
              <input type="checkbox" name="photographer_needed" id="photographer_needed" class="form-checkbox">
          </div>

          <!-- Photography Options -->
          <div id="photography-options" style="display:none;">
              <div>
                  <label for="photo_type" class="block font-semibold text-black mb-2">Choose Photography Option</label>
                  <select id="photo_type" name="photo_type" 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/60 shadow-sm focus:ring-2 focus:ring-indigo-500">
                      <option value="">-- Select --</option>
                      <option value="package">Package</option>
                      <option value="custom">Customizable</option>
                  </select>
              </div>

              <!-- Package Dropdown -->
              <div id="package-section" style="display:none;" class="mt-4">
                  <label for="package" class="block font-semibold text-black mb-2">Select Package</label>
                  <select id="package" name="package" 
                          class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/60 shadow-sm focus:ring-2 focus:ring-indigo-500">
                      <option value="">-- Choose Package --</option>
                      <option value="standard" data-price="10000">Standard (৳10,000)</option>
                      <option value="premium" data-price="18000">Premium (৳18,000)</option>
                      <option value="deluxe" data-price="25000">Deluxe (৳25,000)</option>
                  </select>
                  <div id="package-details" class="mt-2 text-sm text-gray-700"></div>
              </div>

              <!-- Customizable Section -->
              <div id="custom-section" style="display:none;" class="mt-4 space-y-2">
                  <label class="block font-semibold text-black mb-2">Number of Photographers</label>
                  <input type="number" name="num_photographers" id="num_photographers" min="1" value="1" 
                         class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/60 shadow-sm">
                  <label class="block font-semibold text-black mb-2">Number of Hours</label>
                  <input type="number" name="num_hours" id="num_hours" min="1" value="1" 
                         class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white/60 shadow-sm">
                  
                  <div class="flex items-center mb-2">
                      <input type="checkbox" name="photography" id="photography" checked class="mr-2" disabled>
                      <label for="photography">Photography (default)</label>
                  </div>
                  <div class="flex items-center mb-2">
                      <input type="checkbox" name="indoor" id="indoor" checked class="mr-2" disabled>
                      <label for="indoor">Indoor Photography (default)</label>
                  </div>
                  <div class="flex items-center mb-2">
                      <input type="checkbox" name="outdoor" id="outdoor" class="mr-2">
                      <label for="outdoor">Outdoor Photography (+৳2000)</label>
                  </div>
                  <div class="flex items-center mb-2">
                      <input type="checkbox" name="cinematography" id="cinematography" class="mr-2">
                      <label for="cinematography">Cinematography</label>
                  </div>
              </div>
          </div>

          <!-- Submit Button -->
          <a href="{{ route('customize.xtraoptions') }}" 
                  class="block w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg mt-2 text-center">
              Next: Extra Options →
          </a>

          <!-- Estimated Cost at Bottom -->
          <div class="mt-6 flex flex-col gap-2 items-end">
              <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow">
                  <span id="estimated-cost">Estimated Cost: ৳0</span>
              </div>
              <div class="bg-indigo-800 text-white px-4 py-2 rounded-full text-sm shadow">
                  <span id="total-estimated-cost">Total Estimated Price: ৳0</span>
              </div>
          </div>
      </div>
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
    const cinematography = document.getElementById('cinematography');
    const outdoor = document.getElementById('outdoor');
    const estimatedCost = document.getElementById('estimated-cost');
    const totalEstimatedCost = document.getElementById('total-estimated-cost');

    const packages = {
        standard: { price: 10000, details: '1 photographer, 4 hours, photography only, indoor only' },
        premium: { price: 18000, details: '2 photographers, 6 hours, photography + cinematography, indoor + outdoor included' },
        deluxe: { price: 25000, details: '3 photographers, 8 hours, photography + cinematography + drone, indoor + outdoor included' }
    };

    function updateSections() {
        if(photoType.value==='package'){ 
            packageSection.style.display=''; 
            customSection.style.display='none'; 
            updatePackageDetails(); 
        } else if(photoType.value==='custom'){ 
            packageSection.style.display='none'; 
            customSection.style.display=''; 
        } else { 
            packageSection.style.display='none'; 
            customSection.style.display='none'; 
        }
        updateEstimatedCost();
    }

    function updatePackageDetails() {
        const selected = packageSelect.value;
        packageDetails.innerHTML = selected && packages[selected]?`<strong>Details:</strong> ${packages[selected].details}`:'';
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
        totalEstimatedCost.innerText = `Total Estimated Price: ৳${total}`;
    }

    function updateEstimatedCost() {
        let cost = 0;
        if(photographerNeeded.checked){
            if(photoType.value==='package'){ 
                cost = packages[packageSelect.value]?.price || 0; 
            } else if(photoType.value==='custom'){ 
                cost = 2000*(parseInt(numPhotographers.value)||1)*(parseInt(numHours.value)||1);
                if(cinematography.checked) cost += 3000*(parseInt(numHours.value)||1);
                if(outdoor.checked) cost += 2000;
            }
        }
        estimatedCost.innerText = `Estimated Cost: ৳${cost}`;
        
        // Save to localStorage
        const photographyData = {
            photographer_needed: photographerNeeded.checked,
            photo_type: photoType.value,
            package: packageSelect.value,
            num_photographers: numPhotographers.value,
            num_hours: numHours.value,
            cinematography: cinematography.checked,
            outdoor: outdoor.checked,
            cost: cost
        };
        localStorage.setItem('event_photography', JSON.stringify(photographyData));
        updateTotalEstimatedCost();
    }

    photographerNeeded.addEventListener('change', function() {
        photographyOptions.style.display = this.checked ? '' : 'none';
        updateEstimatedCost();
    });
    photoType.addEventListener('change', updateSections);
    packageSelect.addEventListener('change', function(){ updatePackageDetails(); updateEstimatedCost(); });
    [numPhotographers,numHours,cinematography,outdoor].forEach(el=>el.addEventListener('change', updateEstimatedCost));

    // Restore saved data
    const saved = JSON.parse(localStorage.getItem('event_photography') || '{}');
    if (saved.photographer_needed) photographerNeeded.checked = true;
    if (saved.photo_type) photoType.value = saved.photo_type;
    if (saved.package) packageSelect.value = saved.package;
    if (saved.num_photographers) numPhotographers.value = saved.num_photographers;
    if (saved.num_hours) numHours.value = saved.num_hours;
    if (saved.cinematography) cinematography.checked = saved.cinematography;
    if (saved.outdoor) outdoor.checked = saved.outdoor;
    
    if (photographerNeeded.checked) {
        photographyOptions.style.display = '';
        updateSections();
    }
    updateEstimatedCost();
});
</script>
@endsection
@endsection