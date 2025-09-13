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
    <img src="{{ asset('images/event-bg.jpg') }}" alt="Event background" class="w-full h-full object-cover">
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

    <!-- Total Estimated Price -->
    <div class="mb-6 text-right">
      <span id="total-estimated-cost" class="px-6 py-3 bg-indigo-800 text-white rounded-full text-lg">
        Total Estimated Price: ৳0
      </span>
    </div>

    <!-- Dashboard Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Venue -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Venue</h2>
        <p id="venue-info" class="text-gray-700 text-sm">Loading...</p>
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Venue')">Message</button>
      </div>

      <!-- Seating -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Seating</h2>
        <p id="seating-info" class="text-gray-700 text-sm">Loading...</p>
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Seating')">Message</button>
      </div>

      <!-- Stage -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Stage & Decoration</h2>
        <p id="stage-info" class="text-gray-700 text-sm">Loading...</p>
        <img id="stage-image" src="" alt="" class="mt-2 rounded-lg hidden w-40 h-28 object-cover">
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Stage & Decoration')">Message</button>
      </div>

      <!-- Catering -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Catering</h2>
        <p id="catering-info" class="text-gray-700 text-sm">Loading...</p>
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Catering')">Message</button>
      </div>

      <!-- Photography -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Photography</h2>
        <p id="photography-info" class="text-gray-700 text-sm">Loading...</p>
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Photography')">Message</button>
      </div>

      <!-- Extra Options -->
      <div class="p-4 bg-white/30 backdrop-blur-lg rounded-xl shadow-md relative">
        <h2 class="text-lg font-bold mb-2">Extra Options</h2>
        <p id="extra-info" class="text-gray-700 text-sm">Loading...</p>
        <button class="absolute top-4 right-4 bg-indigo-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md" onclick="openMessagePopup('Extra Options')">Message</button>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-between items-center">
      <a href="{{ route('custom-event.index') }}" class="px-6 py-3 bg-gray-300/70 rounded-full font-semibold hover:bg-gray-400/80 transition">
        ⬅ Start Over
      </a>
      <button id="download-receipt" class="px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition">
        Download Receipt
      </button>
      <button id="pay-btn" class="px-6 py-3 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 text-white rounded-full font-bold shadow-lg hover:scale-105 hover:shadow-xl transition transform duration-200 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Pay Now
      </button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Fetch data from localStorage with default cost values
  function getData(key, defaults) {
    let data;
    try {
      data = JSON.parse(localStorage.getItem(key)) || {};
    } catch (e) {
      data = {};
    }
    return { ...defaults, ...data };
  }

  const venue = getData('event_venue', { cost: 0 });
  const seating = getData('event_seating', { cost: 0 });
  const stage = getData('event_stage', { cost: 0 });
  const catering = getData('event_catering', { cost: 0 });
  const photography = getData('event_photography', { cost: 0 });
  const extra = getData('event_extra', { cost: 0, selected: [] });

  let total = 0;

  // Venue
  if (venue.size) {
    document.getElementById('venue-info').innerText =
      `${venue.type === 'predefined' ? venue.predefined : 'Custom'} | Size: ${venue.size} sqm | Address: ${venue.address || ''} | Cost: ৳${venue.cost}`;
    total += Number(venue.cost) || 0;
  } else {
    document.getElementById('venue-info').innerText = 'No venue selected.';
  }

  // Seating
  if (seating.attendees) {
    document.getElementById('seating-info').innerText =
      `${seating.attendees} guests | Chair: ${seating.chairType || ''} | Table: ${seating.tableType || ''} | Seat Cover: ${seating.seatCover || ''} | Cost: ৳${seating.cost}`;
    total += Number(seating.cost) || 0;
  } else {
    document.getElementById('seating-info').innerText = 'No seating selected.';
  }

  // Stage
  if (stage.type) {
    document.getElementById('stage-info').innerText =
      `${stage.type} stage ${stage.decoration ? '+ Decoration' : ''} | Cost: ৳${stage.cost}`;
    if (stage.image) {
      const img = document.getElementById('stage-image');
      img.src = stage.image;
      img.classList.remove('hidden');
    }
    total += Number(stage.cost) || 0;
  } else {
    document.getElementById('stage-info').innerText = 'No stage selected.';
  }

  // Catering
  if (catering.package || catering.total_catering_cost) {
    let cateringText = '';
    if (catering.package) {
      cateringText = `Package: ${catering.package} | Guests: ${catering.guests || ''} | Cost: ৳${catering.cost}`;
      total += Number(catering.cost) || 0;
    } else if (catering.total_catering_cost) {
      cateringText = `Total Catering Cost: ৳${catering.total_catering_cost}`;
      total += Number(catering.total_catering_cost) || 0;
    }
    document.getElementById('catering-info').innerText = cateringText;
  } else {
    document.getElementById('catering-info').innerText = 'No catering selected.';
  }

  // Photography
  if (photography.package) {
    document.getElementById('photography-info').innerText =
      `Package: ${photography.package} | Hours: ${photography.hours || ''} | Cost: ৳${photography.cost}`;
    total += Number(photography.cost) || 0;
  } else {
    document.getElementById('photography-info').innerText = 'No photography selected.';
  }

  // Extra
  if (extra.selected && extra.selected.length > 0) {
    document.getElementById('extra-info').innerText =
      `${extra.selected.join(', ')} | Cost: ৳${extra.cost}`;
    total += Number(extra.cost) || 0;
  } else {
    document.getElementById('extra-info').innerText = 'No extra options selected.';
  }

  // Show total
  document.getElementById('total-estimated-cost').innerText = `Total Estimated Price: ৳${total}`;

  // Download receipt button
  document.getElementById('download-receipt').addEventListener('click', function () {
    const eventData = { venue, seating, stage, catering, photography, extra, total };
    window.location.href = `/download-receipt?event_data=${encodeURIComponent(JSON.stringify(eventData))}`;
  });

  document.getElementById('pay-btn').addEventListener('click', function () {
    const popup = document.createElement('div');
    popup.style.position = 'fixed';
    popup.style.top = '0';
    popup.style.left = '0';
    popup.style.width = '100vw';
    popup.style.height = '100vh';
    popup.style.background = 'rgba(0,0,0,0.3)';
    popup.style.display = 'flex';
    popup.style.alignItems = 'center';
    popup.style.justifyContent = 'center';
    popup.style.zIndex = '9999';
    popup.innerHTML = `
      <div style="background:rgba(255,255,255,0.97);backdrop-filter:blur(8px);padding:40px 32px;border-radius:18px;min-width:320px;max-width:90vw;box-shadow:0 8px 32px rgba(99,102,241,0.15);text-align:center;">
        <h2 style='font-size:2rem;font-weight:700;color:#4f46e5;margin-bottom:16px;'>Congratulations!</h2>
        <p style='font-size:1.1rem;color:#374151;margin-bottom:18px;'>Your payment was successful.<br>Thank you for booking your event with us!</p>
        <button onclick="document.body.removeChild(this.closest('.popup-bg'))" style="background:#4f46e5;color:#fff;padding:10px 28px;border-radius:10px;font-weight:600;border:none;font-size:1rem;">Close</button>
      </div>
    `;
    popup.className = 'popup-bg';
    document.body.appendChild(popup);
  });
});

function openMessagePopup(feature) {
  const popup = document.createElement('div');
  popup.style.position = 'fixed';
  popup.style.top = '0';
  popup.style.left = '0';
  popup.style.width = '100vw';
  popup.style.height = '100vh';
  popup.style.background = 'rgba(0,0,0,0.3)';
  popup.style.display = 'flex';
  popup.style.alignItems = 'center';
  popup.style.justifyContent = 'center';
  popup.style.zIndex = '9999';
  popup.innerHTML = `
    <div style="background:rgba(255,255,255,0.95);backdrop-filter:blur(8px);padding:32px 24px;border-radius:16px;min-width:320px;max-width:90vw;box-shadow:0 8px 32px rgba(99,102,241,0.15);">
      <h3 style="font-size:1.25rem;font-weight:600;color:#4f46e5;margin-bottom:12px;">Message about <span style='color:#ec4899;'>${feature}</span></h3>
      <textarea id="popup-message" rows="4" style="width:100%;padding:8px;border-radius:8px;border:1px solid #ddd;margin-bottom:12px;"></textarea>
      <div style="display:flex;justify-content:flex-end;gap:8px;">
        <button onclick="document.body.removeChild(this.closest('.popup-bg'))" style="background:#e5e7eb;color:#374151;padding:6px 16px;border-radius:8px;font-weight:500;border:none;">Cancel</button>
        <button onclick="sendFeatureMessage('${feature}')" style="background:#4f46e5;color:#fff;padding:6px 16px;border-radius:8px;font-weight:500;border:none;">Send</button>
      </div>
      <div id="popup-status" style="margin-top:8px;color:#16a34a;"></div>
    </div>
  `;
  popup.className = 'popup-bg';
  document.body.appendChild(popup);
}

function sendFeatureMessage(feature) {
  const message = document.getElementById('popup-message').value.trim();
  if (!message) return;
  const statusDiv = document.getElementById('popup-status');
  statusDiv.textContent = 'Sending...';
  // Replace with your AJAX logic to send message to backend
  setTimeout(function() {
    statusDiv.textContent = 'Message sent!';
  }, 800);
}
</script>
@endsection
