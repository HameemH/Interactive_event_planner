<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Wedding Packages - Event Planner</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Animated Gradient Overlay */
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      color: #333;
      overflow-x: hidden;
      position: relative;
      background: url('images/wedbg.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .bg-animated {
      position: fixed;
      inset: 0;
      z-index: -1;
      background: linear-gradient(270deg, rgba(255,192,203,0.3), rgba(255,182,193,0.3), rgba(255,228,225,0.3));
      background-size: 600% 600%;
      animation: gradientShift 20s ease infinite;
    }

    /* Glass Card Style */
    .glass-card {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
    }

    /* Modal Overlay */
    .modal {
      backdrop-filter: blur(6px);
      background: rgba(0, 0, 0, 0.6);
    }

    /* Fade-in-up animation */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
      animation: fadeInUp 0.8s ease forwards;
    }

    /* Scrollbar for modal gallery */
    #galleryImages::-webkit-scrollbar {
      height: 8px;
    }
    #galleryImages::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 4px;
    }
  </style>
</head>
<body class="p-6 md:p-10">

  <!-- Animated Gradient Overlay -->
  <div class="bg-animated"></div>

  <h1 class="text-4xl md:text-5xl font-extrabold text-center mb-10 text-white drop-shadow-lg animate-fade-in-up">
     Wedding Packages 
  </h1>

  <!-- Package List -->
  <div class="glass-card p-4 md:p-6 rounded-[30px] space-y-6 max-w-6xl mx-auto animate-fade-in-up">

    <!-- Classic -->
    <div class="flex flex-col md:flex-row justify-between items-center p-4 glass-card rounded-[20px] cursor-pointer" onclick="openGallery('classic')">
      <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
        <img src="images/1.jpg" class="w-full md:w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold text-gray-800">Classic Package</h2>
          <p class="text-sm text-gray-700 mt-1">Standard decor, 100 guests, veg menu, basic photography.</p>
          <p class="text-sm font-semibold text-yellow-600 mt-2">79,999 BDT</p>
        </div>
      </div>
      <button class="mt-4 md:mt-0 px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-800">Order Now</button>
    </div>

    <!-- Elegant -->
    <div class="flex flex-col md:flex-row justify-between items-center p-4 glass-card rounded-[20px] cursor-pointer" onclick="openGallery('elegant')">
      <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
        <img src="images/2.webp" class="w-full md:w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold text-gray-800">Elegant Package</h2>
          <p class="text-sm text-gray-700 mt-1">Themed decor, 150 guests, buffet, HD photography, DJ.</p>
          <p class="text-sm font-semibold text-yellow-600 mt-2">89,999 BDT</p>
        </div>
      </div>
      <button class="mt-4 md:mt-0 px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-800">Order Now</button>
    </div>

    <!-- Luxury -->
    <div class="flex flex-col md:flex-row justify-between items-center p-4 glass-card rounded-[20px] cursor-pointer" onclick="openGallery('luxury')">
      <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
        <img src="images/3.jpg" class="w-full md:w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold text-gray-800">Luxury Package</h2>
          <p class="text-sm text-gray-700 mt-1">Designer decor, 200 guests, makeup, cinematic video.</p>
          <p class="text-sm font-semibold text-yellow-600 mt-2">1,49,999 BDT</p>
        </div>
      </div>
      <button class="mt-4 md:mt-0 px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-800">Order Now</button>
    </div>

    <!-- Royal -->
    <div class="flex flex-col md:flex-row justify-between items-center p-4 glass-card rounded-[20px] cursor-pointer" onclick="openGallery('royal')">
      <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
        <img src="images/4.jpeg" class="w-full md:w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold text-gray-800">Royal Palace Package</h2>
          <p class="text-sm text-gray-700 mt-1">Palace venue, floral dome, 500 guests, drone film.</p>
          <p class="text-sm font-semibold text-yellow-600 mt-2">2,99,999 BDT</p>
        </div>
      </div>
      <button class="mt-4 md:mt-0 px-4 py-2 glass-card rounded-full text-sm font-semibold text-gray-800">Order Now</button>
    </div>

    <!-- Customize -->
    <div class="flex flex-col md:flex-row justify-between items-center p-6 glass-card rounded-[20px] border border-yellow-400">
      <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
        <img src="images/5.jpeg" class="w-full md:w-72 h-44 object-cover rounded-xl border border-yellow-500" />
        <div>
          <h2 class="text-xl font-extrabold text-yellow-700">Customize Your Own Package</h2>
          <p class="text-sm text-gray-700 mt-1">Mix & match venue, services, catering and create your dream wedding experience.</p>
          <a href="customize-wedding.html" class="mt-2 inline-block text-sm font-semibold text-yellow-800 hover:underline">Start Customizing →</a>
        </div>
      </div>
      <a href="customize-wedding.html" class="mt-4 md:mt-0 px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-full shadow">Customize</a>
    </div>

  </div>

  <!-- MODAL VIEWER -->
  <div id="galleryModal" class="fixed inset-0 z-50 hidden modal flex items-center justify-center">
    <div class="glass-card max-w-4xl w-full rounded-2xl p-4 relative">
      <button onclick="closeGallery()" class="absolute top-3 right-4 text-lg font-bold text-gray-800 hover:text-red-500">✕</button>
      <div class="flex overflow-x-auto gap-4 p-4" id="galleryImages"></div>
    </div>
  </div>

  <!-- FOOTER -->
  <p class="mt-12 text-[11px] text-center text-white drop-shadow-lg">© 2025 Event Management Software</p>

  <!-- JS: Gallery Modal -->
  <script>
    const galleryModal = document.getElementById("galleryModal");
    const galleryImages = document.getElementById("galleryImages");
    const galleries = {
      classic: ['wedding1.jpg', 'wedding1b.jpg', 'wedding1c.jpg'],
      elegant: ['wedding2.jpg', 'wedding2b.jpg', 'wedding2c.jpg'],
      luxury:  ['wedding3.jpg', 'wedding3b.jpg', 'wedding3c.jpg'],
      royal:   ['wedding4.jpg', 'wedding4b.jpg', 'wedding4c.jpg'],
    };
    function openGallery(type) {
      galleryImages.innerHTML = '';
      galleries[type].forEach(img => {
        const image = document.createElement('img');
        image.src = 'images/' + img;
        image.className = "w-80 h-52 object-cover rounded-xl glass-card flex-shrink-0";
        galleryImages.appendChild(image);
      });
      galleryModal.classList.remove('hidden');
    }
    function closeGallery() {
      galleryModal.classList.add('hidden');
    }
    galleryModal.addEventListener('click', e => {
      if (e.target === galleryModal) closeGallery();
    });
  </script>

</body>
</html>
