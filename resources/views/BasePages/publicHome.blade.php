<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events - Citizen Management</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

  <style>
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
      background: url('{{ asset('images/event-bg.jpg') }}') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: linear-gradient(270deg, rgba(99,102,241,0.3), rgba(236,72,153,0.3), rgba(139,92,246,0.3));
      background-size: 600% 600%;
      animation: gradientShift 15s ease infinite;
      z-index: 0;
    }

    .glass-card {
      position: relative;
      z-index: 10;
      backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 2rem;
      padding: 2rem;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 40px rgba(0,0,0,0.25);
    }

    .glass-card img {
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0,0,0,0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card img:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0,0,0,0.35);
    }

    .btn-gradient {
      display: inline-block;
      padding: 0.5rem 1.5rem;
      border-radius: 9999px;
      font-weight: 600;
      color: white;
      background: linear-gradient(to right, #6366f1, #8b5cf6, #ec4899);
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .btn-gradient:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 25px rgba(0,0,0,0.3);
    }

   

     #carousel img {
  -webkit-backdrop-filter: none !important;
  backdrop-filter: none !important;
  filter: none !important;
}



  </style>
</head>

<body>

<h1 class="text-5xl font-extrabold mb-12 text-blue" style="font-family: 'Playfair Display', serif; z-index:10;">
  Event Management
</h1>  



<!-- Carousel Section  -->
<div class="relative w-full max-w-6xl mx-auto mb-12 overflow-hidden z-10 rounded-2xl shadow-2xl">
  <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
    @foreach (['bdhome.jpg','weddinghome.jpg','confhome.jpg','seminarhome.jpg'] as $img)
      <div class="relative w-full h-[450px] flex-shrink-0 group">
        <!-- image (kept sharp) -->
        <img src="{{ asset('images/' . $img) }}"
             class="w-full h-full object-cover rounded-2xl transform group-hover:scale-105 transition duration-700 ease-in-out shadow-lg"
             alt="carousel slide" />
        <!-- soft gradient overlay -->
        <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-black/35 via-transparent to-black/20 pointer-events-none"></div>
      </div>
    @endforeach
  </div>
</div>


<!-- Branding Section -->
<div class="glass-card mb-12 max-w-4xl">
  <h2 class="text-4xl font-extrabold mb-4 text-black" style="font-family: 'Playfair Display', serif;">WHO WE ARE</h2>
  <p class="text-gray-900 text-lg">We are Citizen Management, dedicated to planning flawless events that leave lasting memories. Our expert team ensures that every detail of your event is taken care of, from venues to decorations and photography.</p>
</div>

<h2 class="text-4xl font-bold text-black mb-8 z-10" style="font-family: 'Playfair Display', serif;">
  Explore Our Event Categories
</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl w-full z-10">
  <!-- Wedding Card -->
  <div class="glass-card">
<div class="mb-4 flex justify-center">
      <img src="{{ asset('images/wedding.png') }}" alt="Wedding Icon" class="w-16 h-16 ring-2 ring-indigo-300 hover:ring-pink-400 transition"/>
    </div>
    <h2 class="text-xl font-bold text-black mb-2">Wedding</h2>
    <p class="text-gray-700 text-sm mb-4">Elegant planning for your dream wedding.</p>
    <a href="#" class="btn-gradient">Explore</a>
  </div>

  <!-- Seminars Card -->
  <div class="glass-card">
    <div class="mb-4 flex justify-center">
      <img src="{{ asset('images/seminar.png') }}" alt="Seminar Icon" class="w-16 h-16 ring-2 ring-indigo-300 hover:ring-pink-400 transition"/>
    </div>
    <h2 class="text-xl font-bold text-black mb-2">Seminars</h2>
    <p class="text-gray-900 text-sm mb-4">Host professional knowledge-sharing sessions.</p>
    <a href="#" class="btn-gradient">Explore</a>
  </div>

  <!-- Religious Events Card -->
  <div class="glass-card">
    <div class="mb-4 flex justify-center">
      <img src="{{ asset('images/religious.png') }}" alt="Religious Icon" class="w-16 h-16 ring-2 ring-indigo-300 hover:ring-pink-400 transition"/>
    </div>
    <h2 class="text-xl font-bold text-black mb-2">Religious Events</h2>
    <p class="text-gray-900 text-sm mb-4">Celebrate with spiritual grace and community.</p>
    <a href="#" class="btn-gradient">Explore</a>
  </div>
</div>

<!-- Our Recent Events Section -->
<h2 class="text-4xl font-bold text-black mt-16 mb-8 z-10" style="font-family: 'Playfair Display', serif;">Our Recent Events</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full z-10 mb-16">
  <div class="glass-card">
    <img src="{{ asset('images/recent1.jpg') }}" class="w-full h-48 object-cover mb-4 rounded-xl"/>
    <h3 class="text-xl font-semibold text-black mb-2">Wedding Gala</h3>
    <p class="text-gray-900 text-sm">A beautiful wedding celebration with over 300 guests.</p>
  </div>
  <div class="glass-card">
    <img src="{{ asset('images/recent2.jpg') }}" class="w-full h-48 object-cover mb-4 rounded-xl"/>
    <h3 class="text-xl font-semibold text-black mb-2">Corporate Seminar</h3>
    <p class="text-gray-900 text-sm">Professional event with keynote speakers and networking sessions.</p>
  </div>
  <div class="glass-card">
    <img src="{{ asset('images/recent3.jpg') }}" class="w-full h-48 object-cover mb-4 rounded-xl"/>
    <h3 class="text-xl font-semibold text-black mb-2">Charity Event</h3>
    <p class="text-gray-900 text-sm">A heartwarming charity event raising funds for local communities.</p>
  </div>
</div>

<!-- Why Choose Us Section -->
<div class="glass-card max-w-4xl mb-12">
  <h2 class="text-4xl font-extrabold mb-4 text-black" style="font-family: 'Playfair Display', serif;">Why Choose Us for Your Event?</h2>
  <p class="text-gray-900 text-lg">Our team combines creativity, precision, and passion to deliver seamless event experiences. We manage every aspect – from planning to execution – ensuring your event is unforgettable.</p>
</div>

<p class="mt-12 text-[11px] text-black z-10">©️ 2025 Event Management Software</p>


<!-- Carousel Script -->
<script>
  const carousel = document.getElementById('carousel');
  let index = 0;
  const totalSlides = carousel.children.length;

  function autoSlide() {
    index = (index + 1) % totalSlides;
    carousel.style.transform = `translateX(-${index * 100}%)`;
  }

  // start auto sliding
  setInterval(autoSlide, 3000);
</script>

</body>
</html>