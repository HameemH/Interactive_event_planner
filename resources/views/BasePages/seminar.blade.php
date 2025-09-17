<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Seminar Packages - Event Planner</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Animated Gradient Background */
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    body {
      min-height: 100vh;
      margin: 0;
      font-family: sans-serif;
      position: relative;
      overflow-x: hidden;
    }
    .bg-animated {
      position: fixed;
      inset: 0;
      z-index: -1;
      background: linear-gradient(270deg, rgba(99,102,241,0.4), rgba(236,72,153,0.4), rgba(139,92,246,0.4));
      background-size: 600% 600%;
      animation: gradientShift 15s ease infinite;
    }

    /* Glassmorphism Card Style */
    .glass-card {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.4s ease;
    }
    .glass-card:hover {
      transform: scale(1.02);
    }

    .modal {
      backdrop-filter: blur(6px);
      background: rgba(0, 0, 0, 0.5);
    }

    /* Fade-in animation */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
      animation: fadeInUp 0.8s ease forwards;
    }

    /* Button ripple effect */
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
      background: rgba(255,255,255,0.4);
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
</head>
<body class="p-10 text-gray-800">

  <!-- Animated Background -->
  <div class="bg-animated"></div>

  <h1 class="text-4xl font-extrabold text-center mb-12 animate-fade-in-up">Seminar Packages</h1>

  <!-- Package List -->
  <div class="glass-card p-6 rounded-[30px] space-y-6 animate-fade-in-up">

    <!-- Basic Package -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('basic')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/a.jpeg')}}" alt="Basic Seminar" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Basic Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 50 attendees, basic setup, projector, water, stationary.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">29,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Book Now</button>
    </div>

    <!-- Professional Package -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('professional')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/b.jpg')}}" alt="Professional Seminar" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Professional Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 100 attendees, branded backdrop, lunch box, high-quality audio.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">49,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Book Now</button>
    </div>

    <!-- Premium Package -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('premium')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/c.webp')}}" alt="Premium Seminar" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Premium Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 200 attendees, live stream, recording, buffet, gift bags.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">79,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Book Now</button>
    </div>

    <!-- Executive Seminar -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('executive')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/d.webp')}}" alt="Executive Seminar" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Executive Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Premium venue, panel hosting, 300+ attendees, press coverage, networking lounge.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,29,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Book Now</button>
    </div>

    <!-- Custom Seminar -->
    <div class="flex justify-between items-center p-6 glass-card rounded-[20px] hover:scale-[1.01] transition border border-indigo-300">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/seminar.png')}}" alt="Custom Seminar" class="w-72 h-44 object-cover rounded-xl border border-indigo-400" />
        <div>
          <h2 class="text-xl font-extrabold text-indigo-700">Create Your Own Seminar Plan</h2>
          <p class="text-sm text-gray-700 mt-1">Pick your venue, schedule, equipment, speakers, audience and more.</p>
          <a href="customize-seminar.html" class="mt-2 inline-block text-sm font-semibold text-blue-700 hover:underline">Start Planning →</a>
        </div>
      </div>
      <a href="customize-seminar.html" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Customize</a>
    </div>

  </div>

  <!-- MODAL VIEWER -->
  <div id="galleryModal" class="fixed inset-0 z-50 hidden modal flex items-center justify-center">
    <div class="glass-card max-w-4xl w-full rounded-2xl p-4 relative">
      <button onclick="closeGallery()" class="absolute top-3 right-4 text-lg font-bold text-gray-700 hover:text-red-600">✕</button>
      <div class="flex overflow-x-auto gap-4 p-4" id="galleryImages"></div>
    </div>
  </div>

  <!-- FOOTER -->
  <p class="mt-12 text-[11px] text-center text-gray-500">© 2025 Event Management Software</p>

  <!-- JS: Gallery Modal -->
  <script>
    const galleryModal = document.getElementById("galleryModal");
    const galleryImages = document.getElementById("galleryImages");

    const galleries = {
      basic: ['seminar1a.jpg', 'seminar1b.jpg', 'seminar1c.jpg'],
      professional: ['seminar2a.jpg', 'seminar2b.jpg', 'seminar2c.jpg'],
      premium: ['seminar3a.jpg', 'seminar3b.jpg', 'seminar3c.jpg'],
      executive: ['seminar4a.jpg', 'seminar4b.jpg', 'seminar4c.jpg'],
    };

    function openGallery(type) {
      galleryImages.innerHTML = '';
      galleries[type].forEach(img => {
        const image = document.createElement('img');
        image.src = "{{ asset('images') }}/" + img;
        image.alt = type + " seminar image";
        image.className = "w-80 h-52 object-cover rounded-xl glass-card flex-shrink-0";
        galleryImages.appendChild(image);
      });
      galleryModal.classList.remove('hidden');
    }

    function closeGallery() {
      galleryModal.classList.add('hidden');
    }

    // Close modal on overlay click
    galleryModal.addEventListener("click", function(e) {
      if (e.target === galleryModal) closeGallery();
    });
  </script>

</body>
</html>
