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

    <!-- User Role Badge -->
    <div class="mb-4 text-center">
      <span class="px-4 py-2 rounded-full text-sm font-semibold {{ Auth::user()->isOrganizer() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
        {{ Auth::user()->isOrganizer() ? 'Organizer View' : 'Guest View' }}
      </span>
    </div>

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
    <div class="mt-8 flex justify-between items-center">
      @if(Auth::user()->isOrganizer())
        <!-- Organizer Actions -->
        <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-red-500/70 text-white rounded-full font-semibold hover:bg-red-600/80 transition">
          🔧 Admin Panel
        </a>
      @else
        <!-- Guest Actions -->
        <a href="{{ route('custom-event.index') }}" class="px-6 py-3 bg-gray-300/70 rounded-full font-semibold hover:bg-gray-400/80 transition">
          ⬅ Start Over
        </a>
      @endif
      
      <button id="download-receipt" class="px-6 py-3 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition">
        📄 Download Receipt
      </button>
      
      @if(Auth::user()->isGuest())
        <button id="request-approval-btn" class="px-6 py-3 bg-gradient-to-r from-green-500 via-blue-500 to-purple-500 text-white rounded-full font-bold shadow-lg hover:scale-105 hover:shadow-xl transition transform duration-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          � Request Approval
        </button>
      @else
        <button id="approve-btn" class="px-6 py-3 bg-green-600 text-white rounded-full font-bold shadow-lg hover:scale-105 hover:shadow-xl transition transform duration-200 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          ✅ Approve Event
        </button>
      @endif
    </div>

    <!-- Ready to Submit Section -->
    <div class="mt-6 p-4 bg-white/20 backdrop-blur-lg rounded-xl">
      <h3 class="text-lg font-semibold mb-2">Event Planning Complete</h3>
      <p class="text-sm text-gray-600">All event details have been configured. Ready to submit your request!</p>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  console.log('Dashboard script loaded'); // Debug line
  
  // Check if user came from public customization flow
  const fromPublicCustomization = localStorage.getItem('from_public_customization');
  if (fromPublicCustomization === 'true') {
    // Clear the flag
    localStorage.removeItem('from_public_customization');
    // Show welcome message
    showSuccessPopup('Welcome Back!', 'Your customizations have been preserved. You can now submit your event request.');
  }
  
  // Fetch data from localStorage with default cost values
  function getData(key, defaults) {
    let data;
    try {
      data = JSON.parse(localStorage.getItem(key)) || {};
      console.log(`Retrieved ${key}:`, data); // Debug line
    } catch (e) {
      console.error(`Error parsing ${key}:`, e); // Debug line
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

  console.log('All localStorage data:', { venue, seating, stage, catering, photography, extra }); // Debug line

  let total = 0;

  // Venue
  console.log('Processing venue data:', venue); // Debug line
  if (venue.size || venue.predefined || venue.type) {
    const venueInfo = `${venue.type === 'predefined' ? (venue.predefined || 'Venue') : 'Custom Venue'} | Size: ${venue.size || 'N/A'} sqm | Address: ${venue.address || 'N/A'} | Cost: ৳${venue.cost || 0}`;
    document.getElementById('venue-info').innerText = venueInfo;
    total += Number(venue.cost) || 0;
    console.log('Venue info set:', venueInfo); // Debug line
  } else {
    document.getElementById('venue-info').innerText = 'No venue selected. Please complete the venue selection step.';
    console.log('No venue data found'); // Debug line
  }

  // Seating
  console.log('Processing seating data:', seating); // Debug line
  if (seating.attendees || seating.chairType) {
    const seatingInfo = `${seating.attendees || 0} guests | Chair: ${seating.chairType || 'Not selected'} | Table: ${seating.tableType || 'Not selected'} | Seat Cover: ${seating.seatCover ? 'Yes' : 'No'} | Cost: ৳${seating.cost || 0}`;
    document.getElementById('seating-info').innerText = seatingInfo;
    total += Number(seating.cost) || 0;
    console.log('Seating info set:', seatingInfo); // Debug line
  } else {
    document.getElementById('seating-info').innerText = 'No seating arrangement selected. Please complete the seating step.';
    console.log('No seating data found'); // Debug line
  }

  // Stage
  console.log('Processing stage data:', stage); // Debug line
  if (stage.type || stage.stage_type) {
    const stageType = stage.type || stage.stage_type || 'Basic';
    const stageInfo = `${stageType} stage ${stage.decoration ? '+ Decoration' : ''} | Cost: ৳${stage.cost || 0}`;
    document.getElementById('stage-info').innerText = stageInfo;
    if (stage.stage_image || stage.image) {
      const img = document.getElementById('stage-image');
      img.src = stage.stage_image || stage.image;
      img.classList.remove('hidden');
    }
    total += Number(stage.cost) || 0;
    console.log('Stage info set:', stageInfo); // Debug line
  } else {
    document.getElementById('stage-info').innerText = 'No stage setup selected. Please complete the stage step.';
    console.log('No stage data found'); // Debug line
  }

  // Catering
  console.log('Processing catering data:', catering); // Debug line
  if (catering.catering_required || catering.package || catering.total_catering_cost || catering.per_person_cost) {
    let cateringText = '';
    if (catering.package) {
      cateringText = `Package: ${catering.package} | Guests: ${catering.total_guests || catering.guests || 0} | Cost: ৳${catering.cost || catering.total_catering_cost || 0}`;
    } else if (catering.total_catering_cost) {
      const cateringTotal = catering.total_catering_cost;
      cateringText = `Catering Required | Guests: ${catering.total_guests || 0} | Per Person: ৳${catering.per_person_cost || 0} | Total: ৳${cateringTotal}`;
    } else {
      cateringText = `Catering Required | Cost: ৳${catering.cost || 0}`;
    }
    document.getElementById('catering-info').innerText = cateringText;
    total += Number(catering.cost || catering.total_catering_cost) || 0;
    console.log('Catering info set:', cateringText); // Debug line
  } else {
    document.getElementById('catering-info').innerText = 'No catering selected. Please complete the catering step.';
    console.log('No catering data found'); // Debug line
  }

  // Photography
  console.log('Processing photography data:', photography); // Debug line
  if (photography.photography_required || photography.package || photography.cost || photography.package_type) {
    let photoText = '';
    if (photography.package || photography.package_type) {
      photoText = `Package: ${photography.package || photography.package_type} | Hours: ${photography.num_hours || photography.hours || 'N/A'} | Cost: ৳${photography.cost || photography.photography_cost || 0}`;
    } else {
      photoText = `Photography Required | Cost: ৳${photography.cost || photography.photography_cost || 0}`;
    }
    document.getElementById('photography-info').innerText = photoText;
    total += Number(photography.cost || photography.photography_cost) || 0;
    console.log('Photography info set:', photoText); // Debug line
  } else {
    document.getElementById('photography-info').innerText = 'No photography selected. Please complete the photography step.';
    console.log('No photography data found'); // Debug line
  }

  // Extra Options
  console.log('Processing extra options data:', extra); // Debug line
  if (extra.selected && extra.selected.length > 0) {
    const extraText = `${extra.selected.join(', ')} | Cost: ৳${extra.cost || 0}`;
    document.getElementById('extra-info').innerText = extraText;
    total += Number(extra.cost) || 0;
    console.log('Extra options info set:', extraText); // Debug line
  } else {
    document.getElementById('extra-info').innerText = 'No extra options selected. Please complete the extra options step.';
    console.log('No extra options data found'); // Debug line
  }

  // Show total
  console.log('Final calculated total:', total); // Debug line
  document.getElementById('total-estimated-cost').innerText = `Total Estimated Price: ৳${total}`;
  console.log('Dashboard data loading completed'); // Debug line

  // Add test data button for debugging (remove in production)
  if (total === 0) {
    console.log('No data found, you can test by going through the customization steps first');
  }

  // Download receipt button
  document.getElementById('download-receipt').addEventListener('click', function () {
    // Get fresh data from localStorage to ensure we have the latest
    const currentVenue = JSON.parse(localStorage.getItem('event_venue') || '{}');
    const currentSeating = JSON.parse(localStorage.getItem('event_seating') || '{}');
    const currentStage = JSON.parse(localStorage.getItem('event_stage') || '{}');
    const currentCatering = JSON.parse(localStorage.getItem('event_catering') || '{}');
    const currentPhotography = JSON.parse(localStorage.getItem('event_photography') || '{}');
    const currentExtra = JSON.parse(localStorage.getItem('event_extra') || '{}');
    
    // Calculate total for receipt
    let receiptTotal = 0;
    receiptTotal += Number(currentVenue.cost) || 0;
    receiptTotal += Number(currentSeating.cost) || 0;
    receiptTotal += Number(currentStage.cost) || 0;
    receiptTotal += Number(currentCatering.cost || currentCatering.total_catering_cost) || 0;
    receiptTotal += Number(currentPhotography.cost || currentPhotography.photography_cost) || 0;
    receiptTotal += Number(currentExtra.cost) || 0;
    
    const eventData = { 
      venue: currentVenue, 
      seating: currentSeating, 
      stage: currentStage, 
      catering: currentCatering, 
      photography: currentPhotography, 
      extra: currentExtra, 
      total: receiptTotal 
    };
    
    console.log('Download receipt clicked, event data:', eventData); // Debug line
    window.location.href = `/download-receipt?event_data=${encodeURIComponent(JSON.stringify(eventData))}`;
  });

  // Guest Request Approval button
  const requestBtn = document.getElementById('request-approval-btn');
  if (requestBtn) {
    requestBtn.addEventListener('click', function () {
      showRequestApprovalForm();
    });
  }

  // Organizer Approve button
  const approveBtn = document.getElementById('approve-btn');
  if (approveBtn) {
    approveBtn.addEventListener('click', function () {
      showSuccessPopup('Event Approved!', 'This event has been approved and the client will be notified.');
    });
  }
});

function showSuccessPopup(title, message) {
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
      <h2 style='font-size:2rem;font-weight:700;color:#4f46e5;margin-bottom:16px;'>${title}</h2>
      <p style='font-size:1.1rem;color:#374151;margin-bottom:18px;'>${message}</p>
      <button onclick="document.body.removeChild(this.closest('.popup-bg'))" style="background:#4f46e5;color:#fff;padding:10px 28px;border-radius:10px;font-weight:600;border:none;font-size:1rem;">Close</button>
    </div>
  `;
  popup.className = 'popup-bg';
  document.body.appendChild(popup);
  
  // Auto-hide after 3 seconds
  setTimeout(() => {
    if (document.body.contains(popup)) {
      popup.style.transition = 'opacity 0.5s ease-out';
      popup.style.opacity = '0';
      setTimeout(() => {
        if (document.body.contains(popup)) {
          document.body.removeChild(popup);
        }
      }, 500);
    }
  }, 3000);
}

function showRequestApprovalForm() {
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
  
  // Get event date and calculate total from localStorage
  const eventVenue = JSON.parse(localStorage.getItem('event_venue') || '{}');
  const eventSeating = JSON.parse(localStorage.getItem('event_seating') || '{}');
  const eventStage = JSON.parse(localStorage.getItem('event_stage') || '{}');
  const eventCatering = JSON.parse(localStorage.getItem('event_catering') || '{}');
  const eventPhotography = JSON.parse(localStorage.getItem('event_photography') || '{}');
  const eventExtra = JSON.parse(localStorage.getItem('event_extra') || '{}');
  
  const storedEventDate = eventVenue.date || '';
  
  // Calculate total cost
  let popupTotal = 0;
  popupTotal += Number(eventVenue.cost) || 0;
  popupTotal += Number(eventSeating.cost) || 0;
  popupTotal += Number(eventStage.cost) || 0;
  popupTotal += Number(eventCatering.cost || eventCatering.total_catering_cost) || 0;
  popupTotal += Number(eventPhotography.cost || eventPhotography.photography_cost) || 0;
  popupTotal += Number(eventExtra.cost) || 0;
  
  popup.innerHTML = `
    <div style="background:rgba(255,255,255,0.97);backdrop-filter:blur(8px);padding:32px;border-radius:18px;min-width:400px;max-width:90vw;box-shadow:0 8px 32px rgba(99,102,241,0.15);">
      <h2 style='font-size:1.5rem;font-weight:700;color:#4f46e5;margin-bottom:24px;text-align:center;'>Submit Event Request</h2>
      
      <form id="request-form">
        <div style="margin-bottom:20px;">
          <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Event Name</label>
          <input type="text" id="event-name" required placeholder="Enter your event name" style="width:100%;padding:12px;border:2px solid #e5e7eb;border-radius:8px;font-size:16px;">
        </div>
        
        <div style="margin-bottom:20px;">
          <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Event Category</label>
          <select id="event-category" required style="width:100%;padding:12px;border:2px solid #e5e7eb;border-radius:8px;font-size:16px;">
            <option value="">Select Category</option>
            <option value="wedding">Wedding</option>
            <option value="seminar">Seminar</option>
            <option value="religious">Religious</option>
            <option value="corporate">Corporate</option>
          </select>
        </div>
        
        <div style="margin-bottom:20px;padding:16px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb;">
          <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
            <span style="font-weight:600;color:#374151;">Event Date:</span>
            <span style="color:#6b7280;">${storedEventDate || 'Not selected'}</span>
          </div>
          <div style="display:flex;justify-content:space-between;">
            <span style="font-weight:600;color:#374151;">Total Cost:</span>
            <span style="color:#059669;font-weight:600;">৳<span id="form-total-cost">${popupTotal}</span></span>
          </div>
        </div>
        
        <div style="display:flex;justify-content:flex-end;gap:12px;">
          <button type="button" onclick="document.body.removeChild(this.closest('.popup-bg'))" style="background:#e5e7eb;color:#374151;padding:12px 24px;border-radius:8px;font-weight:500;border:none;cursor:pointer;">Cancel</button>
          <button type="submit" style="background:#4f46e5;color:#fff;padding:12px 24px;border-radius:8px;font-weight:500;border:none;cursor:pointer;">Submit Request</button>
        </div>
      </form>
      
      <div id="form-status" style="margin-top:16px;text-align:center;"></div>
    </div>
  `;
  
  popup.className = 'popup-bg';
  document.body.appendChild(popup);
  
  // Handle form submission
  document.getElementById('request-form').addEventListener('submit', function(e) {
    e.preventDefault();
    submitEventRequest();
  });
}

function submitEventRequest() {
  const eventName = document.getElementById('event-name').value;
  const eventCategory = document.getElementById('event-category').value;
  const statusDiv = document.getElementById('form-status');
  
  // Get event date from localStorage (saved from venue selection)
  const eventVenue = JSON.parse(localStorage.getItem('event_venue') || '{}');
  const eventDate = eventVenue.date;
  
  if (!eventName || !eventCategory) {
    statusDiv.innerHTML = '<p style="color:#dc2626;">Please fill in all required fields.</p>';
    return;
  }
  
  if (!eventDate) {
    statusDiv.innerHTML = '<p style="color:#dc2626;">Event date not found. Please complete venue selection first.</p>';
    return;
  }
  
  statusDiv.innerHTML = '<p style="color:#3b82f6;">Submitting request...</p>';
  
  // Collect all localStorage data for comprehensive event details
  // Note: eventVenue already declared above, reuse it
  const eventSeating = JSON.parse(localStorage.getItem('event_seating') || 'null');
  const eventStage = JSON.parse(localStorage.getItem('event_stage') || 'null');
  const eventCatering = JSON.parse(localStorage.getItem('event_catering') || 'null');
  const eventPhotography = JSON.parse(localStorage.getItem('event_photography') || 'null');
  const eventExtra = JSON.parse(localStorage.getItem('event_extra') || 'null');
  
  // Calculate total cost from localStorage data
  let submitTotal = 0;
  if (eventVenue) submitTotal += Number(eventVenue.cost) || 0;
  if (eventSeating) submitTotal += Number(eventSeating.cost) || 0;
  if (eventStage) submitTotal += Number(eventStage.cost) || 0;
  if (eventCatering) submitTotal += Number(eventCatering.cost || eventCatering.total_catering_cost) || 0;
  if (eventPhotography) submitTotal += Number(eventPhotography.cost || eventPhotography.photography_cost) || 0;
  if (eventExtra) submitTotal += Number(eventExtra.cost) || 0;
  
  // Submit to backend with all event component data
  fetch('{{ route("event.request.store") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      event_name: eventName,
      event_date: eventDate,
      category: eventCategory,
      total_cost: submitTotal,
      // Include all localStorage event component data
      event_venue: eventVenue,
      event_seating: eventSeating,
      event_stage: eventStage,
      event_catering: eventCatering,
      event_photography: eventPhotography,
      event_extra: eventExtra
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      statusDiv.innerHTML = '<p style="color:#16a34a;">✅ ' + data.message + '</p>';
      setTimeout(() => {
        document.body.removeChild(document.querySelector('.popup-bg'));
        // Clear localStorage after successful submission
        localStorage.removeItem('event_venue');
        localStorage.removeItem('event_seating');
        localStorage.removeItem('event_stage');
        localStorage.removeItem('event_catering');
        localStorage.removeItem('event_photography');
        localStorage.removeItem('event_extra');
        // Redirect to user profile
        if (data.redirect_url) {
          window.location.href = data.redirect_url;
        } else {
          window.location.href = '{{ route("dashboard") }}';
        }
      }, 2000);
    } else {
      statusDiv.innerHTML = '<p style="color:#dc2626;">❌ ' + data.message + '</p>';
    }
  })
  .catch(error => {
    console.error('Error:', error);
    statusDiv.innerHTML = '<p style="color:#dc2626;">❌ Network error. Please try again.</p>';
  });
}
</script>
@endsection