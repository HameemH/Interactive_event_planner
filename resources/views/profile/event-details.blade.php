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
    
    /* Hide Stripe billing details fields but keep payment form */
    #payment-element .p-BillingDetails,
    #payment-element .p-BillingDetailsForm,
    #payment-element [data-testid="billingDetails"],
    #payment-element .BillingDetails,
    #payment-element .OptionalField,
    #payment-element .p-BillingDetailsCollectionContainer,
    #payment-element .p-BillingDetailsSectionContainer,
    #payment-element [data-elements-stable-field-name="billingDetails"],
    #payment-element .p-Input--billingDetails,
    #payment-element .p-BillingDetailsCollectionForm {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
    }
    
    /* Ensure payment method fields remain visible */
    #payment-element .p-PaymentMethodMessagesContainer,
    #payment-element .p-PaymentMethodSelector,
    #payment-element .p-Input--paymentMethod,
    #payment-element .p-CardNumberInput,
    #payment-element .p-CardExpiryInput,
    #payment-element .p-CardCvcInput {
        display: block !important;
        visibility: visible !important;
    }
    
    /* Payment Modal Scrolling */
    #paymentModal {
        scrollbar-width: thin;
        scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
    }
    
    #paymentModal::-webkit-scrollbar {
        width: 6px;
    }
    
    #paymentModal::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #paymentModal::-webkit-scrollbar-thumb {
        background-color: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }
    
    #paymentModal::-webkit-scrollbar-thumb:hover {
        background-color: rgba(156, 163, 175, 0.8);
    }
    
    /* Ensure modal content doesn't get cut off */
    #paymentModal .bg-white {
        min-height: fit-content;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-height: calc(100vh - 2rem);
    }
    
    /* Mobile responsiveness for payment modal */
    @media (max-height: 600px) {
        #paymentModal .bg-white {
            max-height: calc(100vh - 1rem);
            padding: 1rem;
        }
        
        #paymentModal .text-center.mb-6 {
            margin-bottom: 1rem;
        }
        
        #paymentModal .text-3xl {
            font-size: 1.5rem;
        }
        
        #paymentModal .w-16.h-16 {
            width: 3rem;
            height: 3rem;
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
                        @if($hasSuccessfulPayment)
                            <div class="alert-message w-full bg-green-100 border-2 border-green-300 text-green-800 py-3 px-4 rounded-lg font-medium">
                                <i class="fas fa-check-circle mr-2"></i>
                                Payment Completed Successfully
                            </div>
                            <div class="text-xs text-green-600 text-center">
                                <p><i class="fas fa-shield-alt mr-1"></i>Your payment of ৳{{ number_format($event->total_cost, 2) }} has been processed</p>
                            </div>
                        @elseif($event->isApproved())
                            <button onclick="openPaymentModal('full_event', {{ $event->total_cost }})" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                                <i class="fas fa-credit-card mr-2"></i>
                                Pay Full Amount (৳{{ number_format($event->total_cost, 2) }})
                            </button>
                            <div class="text-xs text-gray-500 text-center">
                                <p><i class="fas fa-shield-alt mr-1"></i>Secure payment powered by Stripe</p>
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
        <div class="alert-message fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-message fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg z-50">
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
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-lg p-4 sm:p-6 w-full max-w-lg mx-auto my-4 sm:my-8 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Secure Payment</h3>
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

            <!-- Payment Form -->
            <div class="max-h-96 overflow-y-auto pr-2">
                <form id="payment-form" class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                        <p class="text-sm text-blue-800">Secured by Stripe - Your payment information is encrypted and secure</p>
                    </div>
                </div>

                <!-- Stripe Elements will be mounted here -->
                <div id="payment-element" class="mb-4">
                    <!-- Stripe Elements creates form fields here -->
                </div>

                <!-- Loading state -->
                <div id="payment-loading" class="hidden text-center py-4">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing payment...
                    </div>
                </div>

                <!-- Error messages -->
                <div id="payment-error" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>
                        <p class="text-sm text-red-800" id="payment-error-message"></p>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex space-x-2 pt-4">
                    <button type="submit" id="submit-payment" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <i class="fas fa-credit-card mr-2"></i>
                        <span id="payment-button-text">Pay Now</span>
                    </button>
                    <button type="button" onclick="closePaymentModal()"
                            class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </form>
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

        // Stripe Configuration
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        let elements;
        let paymentElement;
        let currentEventId = {{ $event->id }};
        let currentAmount = 0;

        // Payment Modal Functions
        window.openPaymentModal = async function(module, amount) {
            // Check if payment is already in progress
            if (document.getElementById('submit-payment').disabled) {
                return;
            }
            
            // Debug authentication
            console.log('User authenticated:', {{ auth()->check() ? 'true' : 'false' }});
            console.log('Event ID:', currentEventId);
            console.log('Current URL:', window.location.href);
            
            currentAmount = amount;
            document.getElementById('paymentModuleDisplay').textContent = moduleNames[module];
            document.getElementById('paymentAmount').textContent = new Intl.NumberFormat().format(amount);
            document.getElementById('paymentModal').classList.remove('hidden');
            
            // Initialize Stripe payment form
            await initializePaymentForm(amount);
        };

        window.closePaymentModal = function() {
            document.getElementById('paymentModal').classList.add('hidden');
            resetPaymentForm();
        };

        // Initialize Stripe Payment Form
        async function initializePaymentForm(amount) {
            try {
                showLoadingState(true);
                
                // Create payment intent
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    throw new Error('CSRF token not found. Please refresh the page.');
                }
                
                console.log('Making request to:', `/payment/create-intent/${currentEventId}`);
                console.log('CSRF token found:', csrfToken.content.substring(0, 10) + '...');
                
                const response = await fetch(`/payment/create-intent/${currentEventId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ amount: amount })
                });

                console.log('Response status:', response.status);
                
                // Handle different response types
                if (response.status === 419) {
                    throw new Error('Session expired. Please refresh the page and try again.');
                }
                
                // Check if response is actually JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const textResponse = await response.text();
                    console.error('Expected JSON but got:', textResponse.substring(0, 200));
                    
                    if (response.status === 419) {
                        throw new Error('Session expired. Please refresh the page and try again.');
                    } else if (response.status === 403) {
                        throw new Error('Access denied. Please log in and try again.');
                    } else if (response.status === 404) {
                        throw new Error('Payment service not found. Please contact support.');
                    } else {
                        throw new Error(`Server error (${response.status}). Please try again.`);
                    }
                }

                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error || `Payment initialization failed (${response.status})`);
                }

                // Create Stripe elements with minimal fields (no personal info)
                elements = stripe.elements({ 
                    clientSecret: data.client_secret,
                    appearance: {
                        theme: 'stripe'
                    }
                });
                
                paymentElement = elements.create('payment', {
                    layout: {
                        type: 'tabs',
                        defaultCollapsed: false
                    },
                    wallets: {
                        applePay: 'never',
                        googlePay: 'never'
                    }
                });
                paymentElement.mount('#payment-element');

                // Hide billing details after mounting
                setTimeout(() => {
                    hideBillingDetails();
                }, 500);

                // Setup form submission
                setupPaymentForm();
                
                showLoadingState(false);
            } catch (error) {
                console.error('Payment initialization error:', error);
                showPaymentError(error.message);
                showLoadingState(false);
            }
        }

        // Setup Payment Form Submission
        function setupPaymentForm() {
            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                
                if (!stripe || !elements) {
                    return;
                }

                setPaymentButtonState(true, 'Processing...');
                hidePaymentError();

                try {
                    // Use the exact current URL origin to ensure consistency
                    const returnUrl = `${window.location.protocol}//${window.location.host}/payment/confirm/${currentEventId}`;
                    console.log('Using return URL:', returnUrl);
                    
                    const { error } = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: returnUrl,
                        },
                    });

                    if (error) {
                        if (error.type === "card_error" || error.type === "validation_error") {
                            showPaymentError(error.message);
                        } else {
                            showPaymentError("An unexpected error occurred.");
                        }
                        setPaymentButtonState(false, 'Pay Now');
                    }
                } catch (error) {
                    console.error('Payment confirmation error:', error);
                    showPaymentError('Payment failed. Please try again.');
                    setPaymentButtonState(false, 'Pay Now');
                }
            });
        }

        // Helper Functions
        function showLoadingState(show) {
            const loading = document.getElementById('payment-loading');
            const paymentElement = document.getElementById('payment-element');
            const submitButton = document.getElementById('submit-payment');
            
            if (show) {
                loading.classList.remove('hidden');
                paymentElement.style.display = 'none';
                submitButton.disabled = true;
            } else {
                loading.classList.add('hidden');
                paymentElement.style.display = 'block';
                submitButton.disabled = false;
            }
        }

        function showPaymentError(message) {
            const errorDiv = document.getElementById('payment-error');
            const errorMessage = document.getElementById('payment-error-message');
            errorMessage.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        function hidePaymentError() {
            document.getElementById('payment-error').classList.add('hidden');
        }

        function setPaymentButtonState(loading, text) {
            const button = document.getElementById('submit-payment');
            const buttonText = document.getElementById('payment-button-text');
            button.disabled = loading;
            buttonText.textContent = text;
        }

        function resetPaymentForm() {
            if (paymentElement) {
                paymentElement.unmount();
                paymentElement = null;
            }
            elements = null;
            hidePaymentError();
            setPaymentButtonState(false, 'Pay Now');
        }

        function hideBillingDetails() {
            // Additional JavaScript to hide billing fields that might appear
            const billingSelectors = [
                '[data-testid="billingDetails"]',
                '.p-BillingDetails',
                '.p-BillingDetailsForm',
                '.BillingDetails',
                '.p-BillingDetailsCollectionContainer',
                '.p-BillingDetailsSectionContainer',
                '[data-elements-stable-field-name="billingDetails"]'
            ];
            
            billingSelectors.forEach(selector => {
                const elements = document.querySelectorAll(`#payment-element ${selector}`);
                elements.forEach(element => {
                    element.style.display = 'none';
                    element.style.visibility = 'hidden';
                    element.style.height = '0px';
                    element.style.overflow = 'hidden';
                });
            });
        }

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

        // Auto-hide success/error messages after 3 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-message');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 3000);
    }); // Close DOMContentLoaded
</script>
@endpush