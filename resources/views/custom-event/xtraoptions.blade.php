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
  <!-- Background Image with Animated Gradient -->
  <div class="fixed inset-0 w-full h-full">
      <img src="{{ asset('images/event-bg.jpg') }}" alt="Event background" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-animated"></div>
  </div>

  <!-- Glass Card -->
  <div class="glass-card p-10 pt-8 rounded-3xl w-[600px] min-h-[400px] flex flex-col shadow-xl relative z-10">

      <!-- Go Back -->
      <a href="{{ route('custom-event.photography') }}" class="absolute top-4 left-4 text-purple-900 hover:text-indigo-400 font-semibold transition">
          &#8592; Go Back
      </a>

      <!-- Title -->
      <h1 class="text-3xl font-extrabold mb-4 text-center">
          <span class="px-6 py-2 rounded-full text-white shadow-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 animate-gradient">
              Extra Options
          </span>
      </h1>

      <!-- Extra Options Form -->
      <form method="POST" action="{{ route('custom-event.finalize') }}" class="flex flex-col flex-grow space-y-6">
          @csrf

          <div class="grid grid-cols-2 gap-4">
              @php
                  $extras = [
                      'photo_booth' => 3000,
                      'coffee_booth' => 2500,
                      'mehendi_booth' => 2000,
                      'paan_booth' => 1500,
                      'fuchka_stall' => 1800,
                      'sketch_booth' => 2200,
                  ];
              @endphp
              @foreach($extras as $id => $price)
                  <div class="flex items-center">
                      <input type="checkbox" name="{{ $id }}" id="{{ $id }}" data-price="{{ $price }}" class="mr-2 extra-option">
                      <label for="{{ $id }}">{{ ucwords(str_replace('_',' ',$id)) }} (+৳{{ $price }})</label>
                  </div>
              @endforeach
          </div>

          <!-- Estimated Cost -->
          <div class="mt-auto flex flex-col gap-2 items-end">
              <div class="bg-gray-800 text-white px-4 py-2 rounded-full text-sm shadow">
                  <span id="extra-estimated-cost">Estimated Cost: ৳0</span>
              </div>
              <div class="bg-indigo-800 text-white px-4 py-2 rounded-full text-sm shadow">
                  <span id="total-estimated-cost">Total Estimated Price: ৳0</span>
              </div>
          </div>

          <button type="submit" class="w-full py-3 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold hover:scale-105 transition transform shadow-lg">
              Finalize Event
          </button>
      </form>
  </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const extraOptions = document.querySelectorAll('.extra-option');
    const extraEstimatedCost = document.getElementById('extra-estimated-cost');
    const totalEstimatedCostElement = document.getElementById('total-estimated-cost');

    function saveExtraInfo(selected, cost) {
        const extraData = { selected, cost };
        localStorage.setItem('event_extra', JSON.stringify(extraData));
        updateTotalEstimatedCost();
    }

    function updateTotalEstimatedCost() {
        let total = 0;
        ['event_venue','event_seating','event_stage','event_catering','event_photography','event_extra'].forEach(k => {
            const d = JSON.parse(localStorage.getItem(k) || '{}');
            if(d.cost) total += d.cost;
        });
        totalEstimatedCostElement.innerText = `Total Estimated Price: ৳${total}`;
    }

    function updateExtraCost() {
        let cost = 0, selected = [];
        extraOptions.forEach(opt => {
            if(opt.checked){
                cost += parseInt(opt.dataset.price) || 0;
                selected.push(opt.id);
            }
        });
        extraEstimatedCost.innerText = `Estimated Cost: ৳${cost}`;
        saveExtraInfo(selected, cost);
    }

    extraOptions.forEach(opt => opt.addEventListener('change', updateExtraCost));

    // Restore extra info
    (function restoreExtraInfo(){
        const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');
        if(extra.selected && Array.isArray(extra.selected)){
            extraOptions.forEach(opt => { opt.checked = extra.selected.includes(opt.id); });
        }
        updateExtraCost();
    })();
});
</script>
@endsection
@endsection
