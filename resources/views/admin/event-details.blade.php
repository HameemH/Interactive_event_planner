@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Event Details</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.events') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Events
                </a>
                @if($event->isPending())
                    <form method="POST" action="{{ route('admin.events.status', $event) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            <i class="fas fa-check mr-2"></i>Approve Event
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.events.status', $event) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Are you sure you want to reject this event?')">
                            <i class="fas fa-times mr-2"></i>Reject Event
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Event Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Event Information</h3>
                <div class="space-y-2">
                    <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                    <p><strong>Category:</strong> {{ ucfirst($event->category) }}</p>
                    <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->status_badge_color }}">
                            {{ $event->formatted_status }}
                        </span>
                    </p>
                    <p><strong>Total Cost:</strong> <span class="text-xl font-bold text-green-600">৳{{ number_format($event->total_cost, 2) }}</span></p>
                </div>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                <div class="space-y-2">
                    <p><strong>Name:</strong> {{ $event->user->name }}</p>
                    <p><strong>Email:</strong> {{ $event->user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($event->user->role) }}</p>
                    <p><strong>Requested on:</strong> {{ $event->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Pricing Management Form -->
        <div class="bg-blue-50 p-6 rounded-lg mb-8">
            <h3 class="text-lg font-semibold mb-4">
                <i class="fas fa-dollar-sign mr-2"></i>
                Update Event Pricing
            </h3>
            <form method="POST" action="{{ route('admin.events.pricing', $event) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($event->venue)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Venue Cost (৳)</label>
                            <input type="number" name="venue_cost" step="0.01" min="0" 
                                   value="{{ $event->venue->venue_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                    
                    @if($event->seating)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Seating Cost (৳)</label>
                            <input type="number" name="seating_cost" step="0.01" min="0" 
                                   value="{{ $event->seating->seating_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                    
                    @if($event->stage)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stage Cost (৳)</label>
                            <input type="number" name="stage_cost" step="0.01" min="0" 
                                   value="{{ $event->stage->stage_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                    
                    @if($event->catering)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catering Cost (৳)</label>
                            <input type="number" name="catering_cost" step="0.01" min="0" 
                                   value="{{ $event->catering->total_catering_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                    
                    @if($event->photography)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Photography Cost (৳)</label>
                            <input type="number" name="photography_cost" step="0.01" min="0" 
                                   value="{{ $event->photography->photography_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                    
                    @if($event->extraOptions)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Extra Options Cost (৳)</label>
                            <input type="number" name="extra_cost" step="0.01" min="0" 
                                   value="{{ $event->extraOptions->extra_options_cost ?? 0 }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    @endif
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i>Update Pricing
                    </button>
                </div>
            </form>
        </div>

        <!-- Event Components Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Venue Details -->
            @if($event->venue)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-building text-indigo-600 mr-2"></i>Venue Details
                    </h4>
                    <div class="space-y-1 text-sm">
                        <p><strong>Venue:</strong> {{ $event->venue->venue_name }}</p>
                        <p><strong>Size:</strong> {{ $event->venue->venue_size ?? 'N/A' }} sqm</p>
                        <p><strong>Address:</strong> {{ $event->venue->venue_address ?? 'N/A' }}</p>
                        <p><strong>Cost:</strong> ৳{{ number_format($event->venue->venue_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif

            <!-- Seating Details -->
            @if($event->seating)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-chair text-green-600 mr-2"></i>Seating Details
                    </h4>
                    <div class="space-y-1 text-sm">
                        <p><strong>Attendees:</strong> {{ $event->seating->attendees ?? 'N/A' }}</p>
                        <p><strong>Chair Type:</strong> {{ $event->seating->chair_type ?? 'N/A' }}</p>
                        <p><strong>Table Type:</strong> {{ $event->seating->table_type ?? 'N/A' }}</p>
                        <p><strong>Cost:</strong> ৳{{ number_format($event->seating->seating_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif

            <!-- Stage Details -->
            @if($event->stage)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-theater-masks text-purple-600 mr-2"></i>Stage Details
                    </h4>
                    <div class="space-y-1 text-sm">
                        <p><strong>Stage Type:</strong> {{ $event->stage->stage_type ?? 'N/A' }}</p>
                        <p><strong>Decoration:</strong> {{ $event->stage->surrounding_decoration ? 'Yes' : 'No' }}</p>
                        <p><strong>Cost:</strong> ৳{{ number_format($event->stage->stage_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif

            <!-- Catering Details -->
            @if($event->catering)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-utensils text-orange-600 mr-2"></i>Catering Details
                    </h4>
                    <div class="space-y-1 text-sm">
                        <p><strong>Catering Required:</strong> {{ $event->catering->catering_required ? 'Yes' : 'No' }}</p>
                        <p><strong>Guests:</strong> {{ $event->catering->total_guests ?? 'N/A' }}</p>
                        <p><strong>Per Person:</strong> ৳{{ number_format($event->catering->per_person_cost ?? 0, 2) }}</p>
                        <p><strong>Total Cost:</strong> ৳{{ number_format($event->catering->total_catering_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif

            <!-- Photography Details -->
            @if($event->photography)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-camera text-pink-600 mr-2"></i>Photography Details
                    </h4>
                    <div class="space-y-1 text-sm">
                        <p><strong>Package:</strong> {{ $event->photography->package_type ?? 'Custom' }}</p>
                        <p><strong>Photographers:</strong> {{ $event->photography->num_photographers ?? 'N/A' }}</p>
                        <p><strong>Hours:</strong> {{ $event->photography->num_hours ?? 'N/A' }}</p>
                        <p><strong>Cost:</strong> ৳{{ number_format($event->photography->photography_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif

            <!-- Extra Options Details -->
            @if($event->extraOptions)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        <i class="fas fa-plus-circle text-red-600 mr-2"></i>Extra Options
                    </h4>
                    <div class="space-y-1 text-sm">
                        @php
                            $selectedOptions = [];
                            if($event->extraOptions->photo_booth) $selectedOptions[] = 'Photo Booth';
                            if($event->extraOptions->coffee_booth) $selectedOptions[] = 'Coffee Booth';
                            if($event->extraOptions->mehendi_booth) $selectedOptions[] = 'Mehendi Booth';
                            if($event->extraOptions->paan_booth) $selectedOptions[] = 'Paan Booth';
                            if($event->extraOptions->fuchka_stall) $selectedOptions[] = 'Fuchka Stall';
                            if($event->extraOptions->sketch_booth) $selectedOptions[] = 'Sketch Booth';
                        @endphp
                        @if(count($selectedOptions) > 0)
                            <p><strong>Selected:</strong> {{ implode(', ', $selectedOptions) }}</p>
                        @else
                            <p>No extra options selected</p>
                        @endif
                        <p><strong>Cost:</strong> ৳{{ number_format($event->extraOptions->extra_options_cost ?? 0, 2) }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection