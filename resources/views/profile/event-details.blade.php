<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - {{ $event->event_name ?? ucfirst($event->category) . ' Event' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        {{ $event->event_name ?? ucfirst($event->category) . ' Event' }}
                    </h1>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $event->status_badge_color }}">
                            <i class="fas fa-circle text-xs mr-1"></i>
                            {{ $event->formatted_status }}
                        </span>
                        <span class="text-gray-600">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $event->event_date ? $event->event_date->format('M d, Y') : 'Date not set' }}
                        </span>
                        <span class="text-gray-600">
                            <i class="fas fa-user mr-1"></i>
                            {{ $event->user->name }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-indigo-600">৳{{ number_format($event->total_cost, 2) }}</p>
                    <p class="text-sm text-gray-500">Total Cost</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Event Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Venue Details -->
                @if($event->venue)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                        Venue Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Venue Type</p>
                            <p class="font-semibold">{{ $event->venue->venue_type ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Location</p>
                            <p class="font-semibold">{{ $event->venue->location ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->venue->cost ?? 0, 2) }}</p>
                        </div>
                        @if($event->venue->special_requirements)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Special Requirements</p>
                            <p class="font-semibold">{{ $event->venue->special_requirements }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Seating Arrangement -->
                @if($event->seating)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-chair text-indigo-600 mr-2"></i>
                        Seating Arrangement
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Seating Type</p>
                            <p class="font-semibold">{{ $event->seating->seating_type ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Number of Guests</p>
                            <p class="font-semibold">{{ $event->seating->number_of_guests ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->seating->cost ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Stage Setup -->
                @if($event->stage)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-theater-masks text-indigo-600 mr-2"></i>
                        Stage Setup
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Stage Required</p>
                            <p class="font-semibold">{{ $event->stage->stage_required ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Stage Type</p>
                            <p class="font-semibold">{{ $event->stage->stage_type ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->stage->cost ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Catering -->
                @if($event->catering)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-utensils text-indigo-600 mr-2"></i>
                        Catering
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Catering Required</p>
                            <p class="font-semibold">{{ $event->catering->catering_required ? 'Yes' : 'No' }}</p>
                        </div>
                        @if($event->catering->package)
                        <div>
                            <p class="text-sm text-gray-600">Package</p>
                            <p class="font-semibold">{{ $event->catering->package }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600">Total Guests</p>
                            <p class="font-semibold">{{ $event->catering->total_guests ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Per Person Cost</p>
                            <p class="font-semibold">৳{{ number_format($event->catering->per_person_cost ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->catering->cost ?? $event->catering->total_catering_cost ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Photography -->
                @if($event->photography)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-camera text-indigo-600 mr-2"></i>
                        Photography
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Photography Required</p>
                            <p class="font-semibold">{{ $event->photography->photography_required ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Photography Type</p>
                            <p class="font-semibold">{{ $event->photography->photography_type ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->photography->cost ?? $event->photography->photography_cost ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Extra Options -->
                @if($event->extraOptions)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                        Extra Options
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Decoration</p>
                            <p class="font-semibold">{{ $event->extraOptions->decoration ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Sound System</p>
                            <p class="font-semibold">{{ $event->extraOptions->sound_system ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->extraOptions->cost ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Info</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Event ID:</span>
                            <span class="font-semibold">#{{ $event->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Category:</span>
                            <span class="font-semibold">{{ ucfirst($event->category) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Submitted:</span>
                            <span class="font-semibold">{{ $event->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Client:</span>
                            <span class="font-semibold">{{ $event->user->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Message Section -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-envelope text-indigo-600 mr-2"></i>
                        Send Message
                    </h3>
                    <form action="{{ route('profile.event.message', $event->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message about this event:
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Enter your message about this event..."
                                required></textarea>
                        </div>
                        <button type="submit" 
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Navigation -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('profile.show', $event->user_id) }}" 
                           class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200 block text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Profile
                        </a>
                        <a href="{{ route('home') }}" 
                           class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200 block text-center">
                            <i class="fas fa-home mr-2"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif
</body>
</html>