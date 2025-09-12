@extends('layouts.app')

@section('content')
<style>
  /* Animated Gradient Background */
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

  /* Fade-in-up animation */
  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease forwards;
  }

  /* Ripple effect for button */
  button {
    position: relative;
    overflow: hidden;
  }
  button::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.4);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
  }
  button:active::after {
    width: 200%;
    height: 200%;
    opacity: 1;
    transition: width 0.4s ease, height 0.4s ease, opacity 1s ease;
  }
</style>

<div class="min-h-screen flex items-center justify-center p-6 relative">
  <!-- Background Image with Animated Gradient Overlay -->
  <div class="fixed inset-0 w-full h-full">
  <img src="{{ asset('images/event-bg.jpg') }}" 
       alt="Event background" 
       class="w-full h-full object-cover">
  <div class="absolute inset-0 bg-animated"></div>
</div>
  <!-- Glass Card -->
  <div class="relative z-10 glass-card p-10 rounded-3xl w-[900px] min-h-[500px] 
              backdrop-blur-xl bg-white/20 shadow-2xl
              transition duration-500 hover:shadow-[0_0_40px_rgba(99,102,241,0.5)]
              animate-fade-in-up">
    <h1 class="text-4xl font-bold text-center mb-6 font-[Poppins]">
  <span class="px-6 py-2 rounded-full text-white shadow-lg 
               bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
               animate-gradient bg-[length:200%_200%]">
     Event Dashboard
  </span>
</h1>


</br>
    <!-- Total Estimated Price -->
    <div class="mb-6 text-right">
      <span id="total-estimated-cost" class="px-6 py-3 bg-indigo-800 text-white rounded-full text-lg">
        Total Estimated Price: ৳0
      </span>
    </div>

    <!-- Dashboard Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Venue -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Venue</h2>
        <p id="venue-info" class="text-gray-700 text-sm">Loading...</p>
      </div>

      <!-- Seating -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Seating</h2>
        <p id="seating-info" class="text-gray-700 text-sm">Loading...</p>
      </div>

      <!-- Stage -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Stage & Decoration</h2>
        <p id="stage-info" class="text-gray-700 text-sm">Loading...</p>
        <img id="stage-image" src="" alt="" class="mt-2 rounded-lg hidden w-40 h-28 object-cover">
      </div>

      <!-- Catering -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Catering</h2>
        <p id="catering-info" class="text-gray-700 text-sm">Loading...</p>
      </div>

      <!-- Photography -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Photography</h2>
        <p id="photography-info" class="text-gray-700 text-sm">Loading...</p>
      </div>

      <!-- Extra Options -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md">
        <h2 class="text-lg font-bold mb-2">Extra Options</h2>
        <p id="extra-info" class="text-gray-700 text-sm">Loading...</p>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-between">
      <a href="{{ route('custom-event.index') }}" 
         class="px-6 py-3 bg-gray-300/70 rounded-full font-semibold hover:bg-gray-400/80 transition">
        ⬅ Start Over
      </a>
      <button id="download-receipt" 
              class="px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition">
        Download Receipt
      </button>
    </div>
  </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const venue = JSON.parse(localStorage.getItem('event_venue') || '{}');
  const seating = JSON.parse(localStorage.getItem('event_seating') || '{}');
  const stage = JSON.parse(localStorage.getItem('event_stage') || '{}');
  const catering = JSON.parse(localStorage.getItem('event_catering') || '{}');
  const photography = JSON.parse(localStorage.getItem('event_photography') || '{}');
  const extra = JSON.parse(localStorage.getItem('event_extra') || '{}');

  let total = 0;

  if (venue.size) {
    document.getElementById('venue-info').innerText =
      `${venue.type === 'predefined' ? venue.predefined : 'Custom'} | Size: ${venue.size} sqm | Address: ${venue.address} | Cost: ৳${venue.cost}`;
    total += venue.cost || 0;
  }
  if (seating.attendees) {
    document.getElementById('seating-info').innerText =
      `${seating.attendees} guests | Chair: ${seating.chairType} | Table: ${seating.tableType} | Seat Cover: ${seating.seatCover} | Cost: ৳${seating.cost}`;
    total += seating.cost || 0;
  }
  if (stage.type) {
    document.getElementById('stage-info').innerText =
      `${stage.type} stage ${stage.decoration ? '+ Decoration' : ''} | Cost: ৳${stage.cost}`;
    if (stage.image) {
      const img = document.getElementById('stage-image');
      img.src = stage.image;
      img.classList.remove('hidden');
    }
    total += stage.cost || 0;
  }
  if (catering.package) {
    document.getElementById('catering-info').innerText =
      `Package: ${catering.package} | Guests: ${catering.guests} | Cost: ৳${catering.cost}`;
    total += catering.cost || 0;
  }
  if (photography.package) {
    document.getElementById('photography-info').innerText =
      `Package: ${photography.package} | Hours: ${photography.hours} | Cost: ৳${photography.cost}`;
    total += photography.cost || 0;
  }
  if (extra.selected && extra.selected.length > 0) {
    document.getElementById('extra-info').innerText =
      `${extra.selected.join(', ')} | Cost: ৳${extra.cost}`;
    total += extra.cost || 0;
  }

  document.getElementById('total-estimated-cost').innerText = `Total Estimated Price: ৳${total}`;

  document.getElementById('download-receipt').addEventListener('click', function () {
    const eventData = { venue, seating, stage, catering, photography, extra, total };
    const query = new URLSearchParams({ event_data: JSON.stringify(eventData) });
    window.location.href = `/download-receipt?${query.toString()}`;
  });
});
</script>

@endsection
@endsection
