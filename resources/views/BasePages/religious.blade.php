<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Religious Event Packages - Event Planner</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(145deg, #d3d8ff, #eef1ff);
    }
    /* Glassmorphism Card Style */
    .glass-card {
      background: rgba(255, 255, 255, 0.15);
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
  </style>
</head>
<body class="min-h-screen p-10 font-sans text-gray-800">

  <h1 class="text-4xl font-extrabold text-center mb-12">Religious Event Packages</h1>

  <!-- Package List -->
  <div class="glass-card p-6 rounded-[30px] space-y-6">

    <!-- Basic Prayer -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('basic')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/bb.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Basic Prayer Setup</h2>
          <p class="text-sm text-gray-600 mt-1">Prayer mats, sound system, small community hall, water arrangements.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">60,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-700">Book Now</button>
    </div>

    <!-- Puja -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('spiritual')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/cc.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Puja</h2>
          <p class="text-sm text-gray-600 mt-1">Gita recitation, stage, lighting, separate prayer areas.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,89,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-700">Book Now</button>
    </div>

    <!-- Grand Milad -->
    <div class="flex justify-between items-center p-4 glass-card rounded-[20px] hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('grand')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/dd.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Grand Milad Event</h2>
          <p class="text-sm text-gray-600 mt-1">Quran recitation, Stage decor, media coverage, Islamic scholars, 500+ guests, gift distribution.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,99,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-700">Book Now</button>
    </div>

    <!-- Custom Religious Event -->
    <div class="flex justify-between items-center p-6 glass-card rounded-[20px] hover:scale-[1.01] transition border border-indigo-300">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/Religious.png')}}" class="w-72 h-44 object-cover rounded-xl border border-indigo-400" />
        <div>
          <h2 class="text-xl font-extrabold text-indigo-700">Plan a Custom Religious Event</h2>
          <p class="text-sm text-gray-700 mt-1">Choose your services, scholars, audience size, and prayer settings.</p>
          <a href="customize-religious.html" class="mt-2 inline-block text-sm font-semibold text-blue-700 hover:underline">Start Planning →</a>
        </div>
      </div>
      <a href="customize-religious.html" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Customize</a>
    </div>

  </div>

  <!-- MODAL VIEWER -->
  <div id="galleryModal" class="fixed inset-0 z-50 hidden modal flex items-center justify-center">
    <div class="bg-white max-w-4xl w-full rounded-2xl p-4 relative">
      <button onclick="closeGallery()" class="absolute top-3 right-4 text-lg font-bold text-gray-700 hover:text-red-600">✕</button>
      <div class="flex overflow-x-auto gap-4 p-4" id="galleryImages">
        <!-- Dynamic images will go here -->
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <p class="mt-12 text-[11px] text-center text-gray-500">© 2025 Event Management Software</p>

  <!-- JS: Gallery Modal -->
  <script>
    const galleryModal = document.getElementById("galleryModal");
    const galleryImages = document.getElementById("galleryImages");

    const galleries = {
      basic: ['re1a.jpg', 're1b.jpg', 're1c.jpg'],
      spiritual: ['re2a.jpg', 're2b.jpg', 're2c.jpg'],
      faithful: ['re3a.jpg', 're3b.jpg', 're3c.jpg'],
      grand: ['re4a.jpg', 're4b.jpg', 're4c.jpg'],
    };

    function openGallery(type) {
      galleryImages.innerHTML = '';
      galleries[type].forEach(img => {
        const image = document.createElement('img');
        image.src = 'images/' + img;
        image.className = "w-80 h-52 object-cover rounded-xl flex-shrink-0";
        galleryImages.appendChild(image);
      });
      galleryModal.classList.remove('hidden');
    }

    function closeGallery() {
      galleryModal.classList.add('hidden');
    }
  </script>

</body>
</html>
