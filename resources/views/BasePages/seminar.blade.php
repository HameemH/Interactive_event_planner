<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Seminar Packages - Event Planner</title>
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

  <h1 class="text-4xl font-extrabold text-center mb-12">Seminar Packages</h1>

  <!-- Package List -->
  <div class="neumorphic p-6 rounded-[30px] space-y-6">

    <!-- Basic Package -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('basic')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/a.jpeg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Basic Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 50 attendees, basic setup, projector, water, stationary.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">29,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Book Now</button>
    </div>

    <!-- Professional Package -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('professional')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/b.jpg')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Professional Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 100 attendees, branded backdrop, lunch box, high-quality audio.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">49,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Book Now</button>
    </div>

    <!-- Premium Package -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('premium')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/c.webp')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Premium Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Up to 200 attendees, live stream, recording, buffet, gift bags.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">79,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Book Now</button>
    </div>

    <!-- Executive Seminar -->
    <div class="flex justify-between items-center p-4 bg-[#e8ebff] rounded-[20px] shadow-md hover:scale-[1.01] transition cursor-pointer" onclick="openGallery('executive')">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/d.webp')}}" class="w-72 h-44 object-cover rounded-xl" />
        <div>
          <h2 class="text-xl font-bold">Executive Seminar</h2>
          <p class="text-sm text-gray-600 mt-1">Premium venue, panel hosting, 300+ attendees, press coverage, networking lounge.</p>
          <p class="text-sm font-semibold text-indigo-600 mt-2">1,29,999 BDT</p>
        </div>
      </div>
      <button class="px-4 py-2 neumorphic rounded-full text-sm font-semibold text-gray-700 hover:bg-indigo-50">Book Now</button>
    </div>

    <!-- Custom Seminar -->
    <div class="flex justify-between items-center p-6 bg-gradient-to-r from-indigo-100 to-blue-200 rounded-[20px] shadow-xl border border-indigo-300 hover:scale-[1.01] transition">
      <div class="flex items-center gap-6">
        <img src="{{asset('images/seminar.png')}}" class="w-72 h-44 object-cover rounded-xl border border-indigo-400" />
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
      basic: ['seminar1a.jpg', 'seminar1b.jpg', 'seminar1c.jpg'],
      professional: ['seminar2a.jpg', 'seminar2b.jpg', 'seminar2c.jpg'],
      premium: ['seminar3a.jpg', 'seminar3b.jpg', 'seminar3c.jpg'],
      executive: ['seminar4a.jpg', 'seminar4b.jpg', 'seminar4c.jpg'],
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
