<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Event Planner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-indigo-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
                        <p class="text-gray-600">User ID: #{{ $user->id }}</p>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Member since</p>
                    <p class="text-lg font-semibold text-gray-700">{{ $user->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                    My Events
                </h2>
                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $events->count() }} {{ $events->count() == 1 ? 'Event' : 'Events' }}
                </span>
            </div>

            @if($events->count() > 0)
                <div class="space-y-4">
                    @foreach($events as $event)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            {{ $event->event_name ?? ucfirst($event->category) . ' Event' }}
                                        </h3>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $event->status_badge_color }}">
                                            {{ $event->formatted_status }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                        <div>
                                            <i class="fas fa-tag text-indigo-500 mr-1"></i>
                                            <span class="font-medium">Category:</span> {{ ucfirst($event->category) }}
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar text-indigo-500 mr-1"></i>
                                            <span class="font-medium">Date:</span> 
                                            {{ $event->event_date ? $event->event_date->format('M d, Y') : 'Not set' }}
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill-wave text-indigo-500 mr-1"></i>
                                            <span class="font-medium">Total Cost:</span> ৳{{ number_format($event->total_cost, 2) }}
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        Submitted on {{ $event->created_at->format('M d, Y \a\t h:i A') }}
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-2 ml-4">
                                    <a href="{{ route('profile.event.details', $event->id) }}" 
                                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View Details
                                    </a>
                                    @if($event->status === 'approved')
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-xs font-medium text-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Approved
                                        </span>
                                    @elseif($event->status === 'rejected')
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-lg text-xs font-medium text-center">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Rejected
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-xs font-medium text-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No Events Yet</h3>
                    <p class="text-gray-500 mb-4">You haven't submitted any events yet.</p>
                    <a href="{{ route('home') }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Create Your First Event
                    </a>
                </div>
            @endif
        </div>

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </a>
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