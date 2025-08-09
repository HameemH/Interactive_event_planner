<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Wedding Packages - Citizen Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(145deg, #d3d8ff, #eef1ff);
    }
    .neumorphic {
      background: #e8ebff;
      box-shadow: 8px 8px 16px #c2c5d6, -8px -8px 16px #ffffff;
    }
    .modal {
      backdrop-filter: blur(6px);
      background: rgba(0, 0, 0, 0.5);
    }
  </style>
</head>
<body class="min-h-screen p-10 font-sans text-gray-800">

  <h1 class="text-4xl font-extrabold text-center mb-12">Wedding Packages</h1>

  <!-- Package List -->
  <div class="neumorphic p-6 rounded-[30px] space-y-6">

    <!-- Classic -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('classic')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/1.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Classic Package</h2>
          <p class="text-sm text-gray-600 mt-1">Standard decor, 100 guests, veg menu, basic photography.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">79,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Order Now</button>
    </div>

    <!-- Elegant -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('elegant')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/2.webp')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Elegant Package</h2>
          <p class="text-sm text-gray-600 mt-1">Themed decor, 150 guests, buffet, HD photography, DJ.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">89,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Order Now</button>
    </div>

    <!-- Luxury -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('luxury')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/3.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Luxury Package</h2>
          <p class="text-sm text-gray-600 mt-1">Designer decor, 200 guests, makeup, cinematic video.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,49,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Order Now</button>
    </div>

    <!-- Royal -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('royal')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/4.jpeg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Royal Palace Package</h2>
          <p class="text-sm text-gray-600 mt-1">Palace venue, floral dome, 500 guests, drone film.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">2,99,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Order Now</button>
    </div>

    <!-- Customize Your Own (HIGHLIGHTED) -->
    <div class="flex justify-between items-center p-6 bg-gradient-to-r from-indigo-100 to-blue-200 rounded-[20px] shadow-xl border border-indigo-300 hover:scale-[1.01] transition">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/5.jpeg')}}" class="w-72 h-44 object-cover rounded-xl border border-indigo-400" />
        <div>
          <h2 class="text-xl font-extrabold text-indigo-700">Customize Your Own Package</h2>
          <p class="text-sm text-gray-700 mt-1">Mix & match venue, services, catering and create your dream wedding experience.</p>
          <a href="customize-wedding.html" class="mt-2 inline-block text-sm font-semibold text-blue-700 hover:underline">Start Customizing →</a>
        </div>
      </div>
      <a href="customize-wedding.html" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-full shadow">Customize</a>
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
