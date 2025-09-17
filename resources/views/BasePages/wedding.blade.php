<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Wedding Packages - Citizen Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
   /* Background with animated gradient */
  
body {
  background: linear-gradient(270deg, #ddd3f5ff, #fbc2eb, #fad0c4, #a18cd1);
  background-size: 800% 800%;
  animation: bgMove 20s ease infinite;
}

@keyframes bgMove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
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

  <h1 class="text-5xl font-extrabold text-center mb-12 bg-gradient-to-r from-pink-500 to-indigo-600 bg-clip-text text-transparent animate-pulse">
  Wedding Packages
</h1>


  <!-- Package List -->
  <div class="neumorphic p-6 rounded-[30px] space-y-6">

    <!-- Classic -->
     <div class="flex justify-between items-center p-6 bg-gradient-to-br from-indigo-200 via-pink-100 to-yellow-100 
            rounded-[25px] shadow-2xl hover:scale-105 hover:shadow-purple-500/50 transition duration-300 cursor-pointer
            backdrop-blur-sm border border-indigo-300" onclick="openGallery('classic')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/1.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Classic Package</h2>
          <p class="text-sm text-gray-600 mt-1">Standard decor, 100 guests, veg menu, basic photography.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">79,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-pink-500 shadow-lg hover:shadow-pink-500/50 hover:scale-105 transition">Order Now</button>
    </div>

    <!-- Elegant -->
<div class="flex justify-between items-center p-6 bg-gradient-to-br from-indigo-200 via-pink-100 to-yellow-100 
            rounded-[25px] shadow-2xl hover:scale-105 hover:shadow-purple-500/50 transition duration-300 cursor-pointer
            backdrop-blur-sm border border-indigo-300" onclick="openGallery('elegant')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/2.webp')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Elegant Package</h2>
          <p class="text-sm text-gray-600 mt-1">Themed decor, 150 guests, buffet, HD photography, DJ.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">89,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-pink-500 shadow-lg hover:shadow-pink-500/50 hover:scale-105 transition">Order Now</button>
    </div>

    <!-- Luxury -->
   <div class="flex justify-between items-center p-6 bg-gradient-to-br from-indigo-200 via-pink-100 to-yellow-100 
            rounded-[25px] shadow-2xl hover:scale-105 hover:shadow-purple-500/50 transition duration-300 cursor-pointer
            backdrop-blur-sm border border-indigo-300" onclick="openGallery('luxury')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/3.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Luxury Package</h2>
          <p class="text-sm text-gray-600 mt-1">Designer decor, 200 guests, makeup, cinematic video.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,49,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-pink-500 shadow-lg hover:shadow-pink-500/50 hover:scale-105 transition">Order Now</button>
    </div>

    <!-- Royal -->
    <div class="flex justify-between items-center p-6 bg-gradient-to-br from-indigo-200 via-pink-100 to-yellow-100 
            rounded-[25px] shadow-2xl hover:scale-105 hover:shadow-purple-500/50 transition duration-300 cursor-pointer
            backdrop-blur-sm border border-indigo-300" onclick="openGallery('royal')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/4.jpeg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Royal Palace Package</h2>
          <p class="text-sm text-gray-600 mt-1">Palace venue, floral dome, 500 guests, drone film.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">2,99,999 BDT</p>
        </div>
      </div>
      <button class="px-5 py-2 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-pink-500 shadow-lg hover:shadow-pink-500/50 hover:scale-105 transition">Order Now</button>
    </div>

    <!-- Customize Your Own (HIGHLIGHTED) -->
    <div class="flex flex-col md:flex-row justify-between items-center p-6 bg-gradient-to-br from-purple-200 via-pink-100 to-yellow-100
            rounded-[25px] shadow-2xl hover:scale-105 hover:shadow-pink-400/50 transition duration-300 cursor-pointer
            backdrop-blur-sm border border-purple-300">
  
  <div class="flex items-center gap-6 mb-4 md:mb-0">
    <img src="{{asset('images/5.jpeg')}}" class="w-72 h-48 object-cover rounded-xl shadow-lg hover:shadow-pink-300/50 transition duration-300" />
    <div>
      <h2 class="text-2xl font-extrabold text-purple-900 mb-2">Customize Your Own Package</h2>
      <p class="text-gray-700 text-sm mb-4">Mix & match venue, services, catering and create your dream wedding experience.</p>
      <a href="customize-wedding.html" class="inline-block px-6 py-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-pink-400/60 transition">
        Start Customizing →
      </a>
    </div>
  </div>

</div>



  </div>

  <!-- MODAL VIEWER -->
  <div id="galleryModal" class="fixed inset-0 z-50 hidden modal flex items-center justify-center">
    <div class="bg-white/90 backdrop-blur-lg max-w-5xl w-full rounded-2xl p-6 relative shadow-2xl">

      <button onclick="closeGallery()" class="absolute top-3 right-4 text-lg font-bold text-gray-700 hover:text-red-600">✕</button>
      <div class="flex overflow-x-auto gap-4 p-4" id="galleryImages">
        <!-- Dynamic images will go here -->
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <p class="mt-12 text-sm text-center bg-gradient-to-r from-indigo-500 to-pink-500 bg-clip-text text-transparent font-semibold">
  © 2025 Event Management Software | All Rights Reserved
</p>


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
