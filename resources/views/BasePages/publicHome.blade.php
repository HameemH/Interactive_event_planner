<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events - Citizen Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: linear-gradient(145deg, #d3d8ff, #eef1ff);
    }
    .neumorphic {
      background: #e8ebff;
      box-shadow: 8px 8px 16px #c2c5d6, -8px -8px 16px #ffffff;
      transition: all 0.4s ease;
    }
    .neumorphic:hover {
      transform: scale(1.04) rotateY(4deg);
    }
    .neumorphic-inner {
      background: #e8ebff;
      box-shadow: inset 5px 5px 10px #c2c5d6, inset -5px -5px 10px #ffffff;
    }
  </style>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">

</head>
<body class="min-h-screen flex flex-col items-center justify-center p-10 font-sans">

  <h1 class="text-3xl font-extrabold text-gray-800 mb-12">Event Categories</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl w-full">

    <!-- Wedding Card -->
    <div class="glass-card neumorphic p-6 rounded-[30px] text-center">
      <div class="mb-4 flex justify-center">
  <img src="{{asset('images/wedding.png')}}" alt="Wedding Icon" class="w-14 h-14 rounded-full shadow-md object-cover" />
</div>
      <h2 class="text-xl font-bold text-gray-800 mb-2">Wedding</h2>
      <p class="text-gray-600 text-sm mb-4">Elegant planning for your dream wedding.</p>
      <a href="#" class="inline-block px-5 py-2 neumorphic-inner text-sm font-semibold text-gray-800 rounded-full">Explore</a>
    </div>

    <!-- Seminars Card -->
    <div class="glass-card neumorphic p-6 rounded-[30px] text-center">
      <div class="mb-4 flex justify-center">
  <img src="{{asset('images/seminar.png')}}" alt="Seminar Icon" class="w-14 h-14 rounded-full shadow-md object-cover" />
</div>

      <h2 class="text-xl font-bold text-gray-800 mb-2">Seminars</h2>
      <p class="text-gray-600 text-sm mb-4">Host professional knowledge-sharing sessions.</p>
      <a href="#" class="inline-block px-5 py-2 neumorphic-inner text-sm font-semibold text-gray-800 rounded-full">Explore</a>
    </div>

    <!-- Religious Events Card -->
    <div class="glass-card  neumorphic p-6 rounded-[30px] text-center">
      <div class="mb-4 flex justify-center">
 <img src="{{asset('images/religious.png')}}" alt="Religious Icon" class="w-14 h-14 rounded-full shadow-md object-cover" />
</div>

      <h2 class="text-xl font-bold text-gray-800 mb-2">Religious Events</h2>
      <p class="text-gray-600 text-sm mb-4">Celebrate with spiritual grace and community.</p>
      <a href="#" class="inline-block px-5 py-2 neumorphic-inner text-sm font-semibold text-gray-800 rounded-full">Explore</a>
    </div>

  </div>

  <p class="mt-12 text-[11px] text-gray-500">© 2025 Event Management Software</p>

</body>
</html>
