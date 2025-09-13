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

  /* Glass Card Effect */
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

  /* Gradient Badge for Heading */
  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .animate-gradient {
    animation: gradientMove 6s ease infinite;
    background-size: 200% 200%;
  }

  /* Slider Images */
  .slider-img {
    cursor: pointer;
    border: 2px solid transparent;
    transition: transform 0.2s, border-color 0.2s;
  }
  .slider-img:hover { transform: scale(1.05); }
  .slider-img.selected { border-color: #8b5cf6; }
</style>
<br><br><br><br>
<div class="min-h-screen flex items-center justify-center p-4 relative">
  <!-- Background Image + Gradient Overlay -->
  <div class="fixed inset-0 w-full h-full">
    <img src="{{ asset('images/event-bg.jpg') }}" alt="Event background" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-animated"></div>
  </div>

  <!-- Glass Card Container -->
  <div class="glass-card p-10 pt-8 rounded-3xl w-[650px] min-h-[600px] flex flex-col shadow-xl relative z-10">

      <!-- Back Button -->
      <a href="{{ route('custom-event.seating') }}" class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
        <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
          Select Stage & Decoration
        </span>
      </h1>
      <p class="text-purple-900 text-center mb-6">Choose your stage type and surrounding decoration</p>
<!-- Progress Bar -->
    <div class="w-full mb-8">
    <div class="flex items-center justify-between text-sm font-medium text-blue-900 mb-2">
        <span>Step 1: Venue</span>
        <span>Step 2: Seating</span>
        <span class="font-bold text-purple-600">Step 3: Stage</span>
        <span>Step 4: Catering</span>
        <span>Step 5: Photography</span>
    </div>
    <div class="w-full bg-white/30 rounded-full h-2 overflow-hidden">
        <!-- Step 3 = 60% -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: 60%;"></div>
    </div>
</div>


      <!-- Form -->
      <form method="POST" action="{{ route('custom-event.catering') }}" class="space-y-6">
        @csrf

        <!-- Stage Type -->
        <div>
          <label for="stage_type" class="block font-semibold text-black mb-2">Choose Stage Type</label>
          <select name="stage_type" id="stage_type" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white/60 shadow-sm">
              <option value="basic">Basic</option>
              <option value="premium">Premium</option>
              <option value="luxury">Luxury</option>
          </select>
        </div>

        <!-- Stage Image -->
        <div>
          <input type="hidden" name="stage_image" id="stage_image">
          <button type="button" id="open-stage-slider" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform">
            Choose Stage Image
          </button>
          <div id="selected-stage-image" class="mt-2"></div>
        </div>

        <!-- Surrounding Decoration -->
        <div>
          <label class="flex items-center space-x-2 mb-2">
            <input type="checkbox" id="surrounding_decoration">
            <span class="font-semibold text-black">Add Surrounding Decoration</span>
          </label>
          <button type="button" id="open-decoration-slider" class="w-full py-3 rounded-full bg-white/40 text-gray-800 font-semibold hover:scale-105 transition transform hidden">
            Choose Decoration Image
          </button>
          <input type="hidden" name="decoration_image" id="decoration_image">
          <div id="selected-decoration-image" class="mt-2"></div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg">
            Next: Select Catering →
          </button>
        </div>
      </form>

      <!-- Cost Indicators -->
      <div class="mt-6 flex flex-col gap-2 items-end">
          <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="estimated-cost">Estimated Cost: $0</span>
          </div>
          <div class="bg-indigo-800 text-white px-4 py-2 rounded-full text-sm shadow">
              <span id="total-estimated-cost">Total Estimated Price: $0</span>
          </div>
      </div>
  </div>
</div>

<!-- Stage Slider Popup -->
<div id="stage-slider" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg w-[80%] md:w-[60%]">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">Select Stage Image</h3>
      <div id="stage-slider-images" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
      <button id="close-stage-slider" class="mt-4 py-2 px-4 bg-indigo-600 text-white rounded-lg">Close</button>
  </div>
</div>

<!-- Decoration Slider Popup -->
<div id="decoration-slider" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded-lg w-[80%] md:w-[60%]">
      <h3 class="text-xl font-semibold text-gray-800 mb-4">Select Decoration Image</h3>
      <div id="decoration-slider-images" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
      <button id="close-decoration-slider" class="mt-4 py-2 px-4 bg-indigo-600 text-white rounded-lg">Close</button>
  </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stage Elements
    const stageTypeSelect = document.getElementById('stage_type');
    const stageImageInput = document.getElementById('stage_image');
    const openStageSliderBtn = document.getElementById('open-stage-slider');
    const stageSlider = document.getElementById('stage-slider');
    const stageSliderImages = document.getElementById('stage-slider-images');
    const closeStageSliderBtn = document.getElementById('close-stage-slider');
    const selectedStageDiv = document.getElementById('selected-stage-image');

    // Decoration Elements
    const surroundingCheckbox = document.getElementById('surrounding_decoration');
    const openDecorationSliderBtn = document.getElementById('open-decoration-slider');
    const decorationSlider = document.getElementById('decoration-slider');
    const decorationSliderImages = document.getElementById('decoration-slider-images');
    const closeDecorationSliderBtn = document.getElementById('close-decoration-slider');
    const decorationImageInput = document.getElementById('decoration_image');
    const selectedDecorationDiv = document.getElementById('selected-decoration-image');

    // Cost Elements
    const estimatedCostEl = document.getElementById('estimated-cost');
    const totalEstimatedCostEl = document.getElementById('total-estimated-cost');

    // Sample Images
    const stageImages = {
        basic: ['https://via.placeholder.com/150?text=Basic+1','https://via.placeholder.com/150?text=Basic+2','https://via.placeholder.com/150?text=Basic+3'],
        premium: ['https://via.placeholder.com/150?text=Premium+1','https://via.placeholder.com/150?text=Premium+2','https://via.placeholder.com/150?text=Premium+3'],
        luxury: ['https://via.placeholder.com/150?text=Luxury+1','https://via.placeholder.com/150?text=Luxury+2','https://via.placeholder.com/150?text=Luxury+3']
    };
    const stageCosts = { basic: 20, premium: 50, luxury: 100 };
    const decorationImagesArr = ['https://via.placeholder.com/150?text=Deco+1','https://via.placeholder.com/150?text=Deco+2','https://via.placeholder.com/150?text=Deco+3'];

    function renderStageSlider() {
        stageSliderImages.innerHTML = '';
        stageImages[stageTypeSelect.value].forEach(img => {
            const imageEl = document.createElement('img');
            imageEl.src = img;
            imageEl.classList.add('slider-img');
            imageEl.addEventListener('click', () => {
                stageImageInput.value = img;
                selectedStageDiv.innerHTML = `<img src="${img}" class="rounded-lg mt-2 h-24 w-auto">`;
                stageSlider.classList.add('hidden');
                updateCost();
            });
            stageSliderImages.appendChild(imageEl);
        });
    }

    function renderDecorationSlider() {
        decorationSliderImages.innerHTML = '';
        decorationImagesArr.forEach(img => {
            const imageEl = document.createElement('img');
            imageEl.src = img;
            imageEl.classList.add('slider-img');
            imageEl.addEventListener('click', () => {
                decorationImageInput.value = img;
                selectedDecorationDiv.innerHTML = `<img src="${img}" class="rounded-lg mt-2 h-24 w-auto">`;
                decorationSlider.classList.add('hidden');
                updateCost();
            });
            decorationSliderImages.appendChild(imageEl);
        });
    }

    function updateCost() {
        const stageCost = stageCosts[stageTypeSelect.value] || 0;
        const decorationCost = surroundingCheckbox.checked && decorationImageInput.value ? 30 : 0;
        const totalCost = stageCost + decorationCost;
        estimatedCostEl.innerText = `Estimated Cost: $${totalCost}`;
        totalEstimatedCostEl.innerText = `Total Estimated Price: $${totalCost}`;
    }

    // Event Listeners
    openStageSliderBtn.addEventListener('click', () => { stageSlider.classList.remove('hidden'); renderStageSlider(); });
    closeStageSliderBtn.addEventListener('click', () => { stageSlider.classList.add('hidden'); });

    surroundingCheckbox.addEventListener('change', () => {
        openDecorationSliderBtn.classList.toggle('hidden', !surroundingCheckbox.checked);
        updateCost();
    });
    openDecorationSliderBtn.addEventListener('click', () => { decorationSlider.classList.remove('hidden'); renderDecorationSlider(); });
    closeDecorationSliderBtn.addEventListener('click', () => { decorationSlider.classList.add('hidden'); });

    stageTypeSelect.addEventListener('change', updateCost);

    // Restore previous selection if stored in localStorage
    const saved = JSON.parse(localStorage.getItem('event_stage') || '{}');
    if (saved.type) stageTypeSelect.value = saved.type;
    if (saved.stage_image) { stageImageInput.value = saved.stage_image; selectedStageDiv.innerHTML = `<img src="${saved.stage_image}" class="rounded-lg mt-2 h-24 w-auto">`; }
    if (saved.decoration) { surroundingCheckbox.checked = saved.decoration; openDecorationSliderBtn.classList.remove('hidden'); }
    if (saved.decoration_image) { decorationImageInput.value = saved.decoration_image; selectedDecorationDiv.innerHTML = `<img src="${saved.decoration_image}" class="rounded-lg mt-2 h-24 w-auto">`; }

    updateCost();
});
</script>
@endsection
