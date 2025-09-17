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

  /* Heading gradient pill */
  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }
  .animate-gradient {
    animation: gradientMove 6s ease infinite;
    background-size: 200% 200%;
  }

  /* Button ripple effect */
  button, a {
    position: relative;
    overflow: hidden;
  }
  button::after, a::after {
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
  button:active::after, a:active::after {
    width: 200%;
    height: 200%;
    opacity: 1;
    transition: width 0.4s ease, height 0.4s ease, opacity 1s ease;
  }
</style>

<div class="min-h-screen flex items-center justify-center p-6 relative">
  <!-- Background Image with Animated Gradient Overlay -->
  <div class="fixed inset-0 w-full h-full">
    <img src="{{ asset('images/event-bg.jpg') }}" 
         alt="Event background" 
         class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-animated"></div>
  </div>

  <!-- Glass Card -->
  <div class="relative z-10 glass-card p-10 rounded-3xl w-[420px] text-center
              backdrop-blur-xl bg-white/20 shadow-2xl
              transition duration-500 hover:shadow-[0_0_40px_rgba(99,102,241,0.5)]
              animate-fade-in-up">
    
    <!-- Heading with gradient pill -->
    <h1 class="text-2xl font-extrabold mb-2">
      <span class="px-4 py-2 rounded-full text-white shadow-lg 
                   bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 
                   animate-gradient">
        Customize Your Event
      </span>
    </h1>
    <p class="text-sm text-purple-900 mb-6">Please select your event details below</p>

    <!-- Start Customizing Button -->
    <a href="{{ route('custom-event.venue') }}" 
   class="w-64 py-3 px-8 rounded-full bg-white/40 text-gray-800 font-semibold 
          hover:scale-105 transition transform">
  Start Customizing
</a>

  </div>
</div>
@endsection
