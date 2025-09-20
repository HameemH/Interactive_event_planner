@extends('layouts.app')

@section('title', 'Event Details - ' . ($event->event_name ?? ucfirst($event->category) . ' Event'))

<!-- ========== CUSTOM STYLES FOR EVENT DETAILS ========== -->
@push('styles')
<style>
    /* Event Details Custom Styles */
    .event-status-badge {
        transition: all 0.3s ease;
    }
    
    .module-section {
        transition: all 0.3s ease;
    }
    
    .module-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .payment-button {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        transition: all 0.3s ease;
    }
    
    .payment-button:hover {
        background: linear-gradient(135deg, #3730a3 0%, #5b21b6 100%);
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
    }
    
    .message-form {
        animation: slideInUp 0.3s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- ========== EVENT HEADER SECTION ========== -->
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

        <!-- ========== MAIN CONTENT GRID ========== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- ========== EVENT DETAILS SECTION ========== -->
            <div class="lg:col-span-2 space-y-6">
                <!-- ========== VENUE MODULE ========== -->
                @if($event->venue)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>
                            Venue Details
                        </h2>
                        <button onclick="openMessageModal('venue')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Venue Name</p>
                            <p class="font-semibold">{{ $event->venue->venue_name ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Address</p>
                            <p class="font-semibold">{{ $event->venue->venue_address ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Size (sq. meters)</p>
                            <p class="font-semibold">{{ $event->venue->venue_size ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->venue->venue_cost ?? 0, 2) }}</p>
                        </div>
                        @if($userMessages && $userMessages->venue_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->venue_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ========== SEATING MODULE ========== -->
                @if($event->seating)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-chair text-indigo-600 mr-2"></i>
                            Seating Arrangement
                        </h2>
                        <button onclick="openMessageModal('seating')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Number of Attendees</p>
                            <p class="font-semibold">{{ $event->seating->attendees ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Chair Type</p>
                            <p class="font-semibold">{{ ucfirst($event->seating->chair_type ?? 'Not specified') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Table Type</p>
                            <p class="font-semibold">{{ ucfirst($event->seating->table_type ?? 'Not specified') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Seat Cover</p>
                            <p class="font-semibold">{{ $event->seating->seat_cover ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->seating->seating_cost ?? 0, 2) }}</p>
                        </div>
                        @if($userMessages && $userMessages->seating_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->seating_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ========== STAGE MODULE ========== -->
                @if($event->stage)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-theater-masks text-indigo-600 mr-2"></i>
                            Stage Setup
                        </h2>
                        <button onclick="openMessageModal('stage')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Stage Type</p>
                            <p class="font-semibold">{{ ucfirst($event->stage->stage_type ?? 'Not specified') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Surrounding Decoration</p>
                            <p class="font-semibold">{{ $event->stage->surrounding_decoration ? 'Yes' : 'No' }}</p>
                        </div>
                        @if($event->stage->stage_image_link)
                        <div>
                            <p class="text-sm text-gray-600">Stage Image</p>
                            <img src="{{ $event->stage->stage_image_link }}" alt="Stage Design" class="w-32 h-24 object-cover rounded-lg">
                        </div>
                        @endif
                        @if($event->stage->decoration_image_link)
                        <div>
                            <p class="text-sm text-gray-600">Decoration Image</p>
                            <img src="{{ $event->stage->decoration_image_link }}" alt="Decoration Design" class="w-32 h-24 object-cover rounded-lg">
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600">Stage Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->stage->stage_cost ?? 0, 2) }}</p>
                        </div>
                        @if($event->stage->total_decoration_cost)
                        <div>
                            <p class="text-sm text-gray-600">Total Decoration Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->stage->total_decoration_cost, 2) }}</p>
                        </div>
                        @endif
                        @if($userMessages && $userMessages->stage_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->stage_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ========== CATERING MODULE ========== -->
                @if($event->catering)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-utensils text-indigo-600 mr-2"></i>
                            Catering
                        </h2>
                        <button onclick="openMessageModal('catering')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Catering Required</p>
                            <p class="font-semibold">{{ $event->catering->catering_required ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Guests</p>
                            <p class="font-semibold">{{ $event->catering->total_guests ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Per Person Cost</p>
                            <p class="font-semibold">৳{{ number_format($event->catering->per_person_cost ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Catering Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->catering->total_catering_cost ?? 0, 2) }}</p>
                        </div>
                        @if($userMessages && $userMessages->catering_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->catering_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ========== PHOTOGRAPHY MODULE ========== -->
                @if($event->photography)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-camera text-indigo-600 mr-2"></i>
                            Photography
                        </h2>
                        <button onclick="openMessageModal('photography')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Photography Required</p>
                            <p class="font-semibold">{{ $event->photography->photography_required ? 'Yes' : 'No' }}</p>
                        </div>
                        @if($event->photography->package_type)
                        <div>
                            <p class="text-sm text-gray-600">Package Type</p>
                            <p class="font-semibold">{{ ucfirst($event->photography->package_type) }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600">Customizable</p>
                            <p class="font-semibold">{{ $event->photography->customizable ? 'Yes' : 'No' }}</p>
                        </div>
                        @if($event->photography->num_photographers)
                        <div>
                            <p class="text-sm text-gray-600">Number of Photographers</p>
                            <p class="font-semibold">{{ $event->photography->num_photographers }}</p>
                        </div>
                        @endif
                        @if($event->photography->num_hours)
                        <div>
                            <p class="text-sm text-gray-600">Number of Hours</p>
                            <p class="font-semibold">{{ $event->photography->num_hours }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600">Indoor</p>
                            <p class="font-semibold">{{ $event->photography->indoor ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Outdoor</p>
                            <p class="font-semibold">{{ $event->photography->outdoor ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Cinematography</p>
                            <p class="font-semibold">{{ $event->photography->cinematography ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Photography Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->photography->photography_cost ?? 0, 2) }}</p>
                        </div>
                        @if($userMessages && $userMessages->photography_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->photography_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- ========== EXTRA OPTIONS MODULE ========== -->
                @if($event->extraOptions)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                            Extra Options
                        </h2>
                        <button onclick="openMessageModal('extra_options')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-comment mr-1"></i>Message
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Photo Booth</p>
                            <p class="font-semibold">{{ $event->extraOptions->photo_booth ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Coffee Booth</p>
                            <p class="font-semibold">{{ $event->extraOptions->coffee_booth ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mehendi Booth</p>
                            <p class="font-semibold">{{ $event->extraOptions->mehendi_booth ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Paan Booth</p>
                            <p class="font-semibold">{{ $event->extraOptions->paan_booth ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fuchka Stall</p>
                            <p class="font-semibold">{{ $event->extraOptions->fuchka_stall ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Sketch Booth</p>
                            <p class="font-semibold">{{ $event->extraOptions->sketch_booth ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Extra Options Cost</p>
                            <p class="font-semibold text-green-600">৳{{ number_format($event->extraOptions->extra_options_cost ?? 0, 2) }}</p>
                        </div>
                        @if($userMessages && $userMessages->extra_options_message)
                        <div class="md:col-span-2 bg-blue-50 p-3 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Your Message:</p>
                            <p class="text-sm font-medium">{{ $userMessages->extra_options_message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- ========== SIDEBAR SECTION ========== -->
            <div class="space-y-6">
                <!-- ========== QUICK INFO CARD ========== -->
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

                <!-- ========== PAYMENT SECTION ========== -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-bolt text-indigo-600 mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        @if($event->isApproved())
                            <button onclick="openPaymentModal('full_event', {{ $event->total_cost }})" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-credit-card mr-2"></i>
                                Pay Full Amount (৳{{ number_format($event->total_cost, 2) }})
                            </button>
                            <div class="text-xs text-gray-500 text-center">
                                <p>Payment integration coming soon</p>
                            </div>
                        @else
                            <div class="w-full bg-gray-300 text-gray-600 py-3 px-4 rounded-lg font-medium cursor-not-allowed">
                                <i class="fas fa-lock mr-2"></i>
                                Payment Locked - Event Pending Approval
                            </div>
                            <div class="text-xs text-red-500 text-center">
                                <p><i class="fas fa-info-circle mr-1"></i>Payment will be available once your event is approved by an admin</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ========== NAVIGATION SECTION ========== -->
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

    <!-- ========== MESSAGE MODAL ========== -->
    <div id="messageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Send Message</h3>
                <button onclick="closeMessageModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('profile.event.message', $event->id) }}" method="POST">
                @csrf
                <input type="hidden" id="messageModule" name="module" value="">
                <div class="mb-4">
                    <label for="messageText" class="block text-sm font-medium text-gray-700 mb-2">
                        Message about <span id="moduleNameDisplay"></span>:
                    </label>
                    <textarea 
                        id="messageText" 
                        name="message" 
                        rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Enter your message..."
                        required></textarea>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Message
                    </button>
                    <button type="button" onclick="closeMessageModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== PAYMENT MODAL ========== -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Payment</h3>
                <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-credit-card text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-800 mb-2">Payment for <span id="paymentModuleDisplay"></span></h4>
                <p class="text-3xl font-bold text-green-600">৳<span id="paymentAmount"></span></p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-yellow-600 mr-2"></i>
                    <p class="text-sm text-yellow-800">Payment system integration coming soon!</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <button disabled
                        class="flex-1 bg-gray-400 text-white py-2 px-4 rounded-lg font-medium cursor-not-allowed">
                    <i class="fas fa-credit-card mr-2"></i>
                    Pay Now (Coming Soon)
                </button>
                <button type="button" onclick="closePaymentModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>

@endsection

<!-- ========== CUSTOM JAVASCRIPT FOR EVENT DETAILS ========== -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Module name mappings for display
        const moduleNames = {
            'venue': 'Venue',
            'seating': 'Seating',
            'stage': 'Stage',
            'catering': 'Catering',
            'photography': 'Photography',
            'extra_options': 'Extra Options',
            'full_event': 'Full Event'
        };

        // Make functions globally available
        window.openMessageModal = function(module) {
            document.getElementById('messageModule').value = module;
            document.getElementById('moduleNameDisplay').textContent = moduleNames[module];
            document.getElementById('messageModal').classList.remove('hidden');
        };

        window.closeMessageModal = function() {
            document.getElementById('messageModal').classList.add('hidden');
            document.getElementById('messageText').value = '';
        };

        // Payment Modal Functions
        window.openPaymentModal = function(module, amount) {
            document.getElementById('paymentModuleDisplay').textContent = moduleNames[module];
            document.getElementById('paymentAmount').textContent = new Intl.NumberFormat().format(amount);
            document.getElementById('paymentModal').classList.remove('hidden');
        };

        window.closePaymentModal = function() {
            document.getElementById('paymentModal').classList.add('hidden');
        };

    // Close modals when clicking outside
    document.getElementById('messageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMessageModal();
        }
    });

    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });

        // Auto-hide success/error messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    }); // Close DOMContentLoaded
</script>
@endpush