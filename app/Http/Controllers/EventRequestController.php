<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventVenue;
use App\Models\EventSeating;
use App\Models\EventStage;
use App\Models\EventCatering;
use App\Models\EventPhotography;
use App\Models\EventExtraOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRequestController extends Controller
{
    /**
     * Store a new event request from localStorage data
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|in:wedding,seminar,religious,corporate',
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'total_cost' => 'required|numeric|min:0',
            // All localStorage event component data
            'event_venue' => 'nullable|array',
            'event_seating' => 'nullable|array',
            'event_stage' => 'nullable|array',
            'event_catering' => 'nullable|array',
            'event_photography' => 'nullable|array',
            'event_extra' => 'nullable|array',
        ]);

        try {
            // Create main event record
            $event = Event::create([
                'user_id' => Auth::id(),
                'category' => $request->category,
                'event_name' => $request->event_name,
                'event_date' => $request->event_date,
                'total_cost' => $request->total_cost,
                'status' => Event::STATUS_PENDING,
            ]);

            // Save venue data if present
            if ($request->has('event_venue') && !empty($request->event_venue)) {
                $venueData = $request->event_venue;
                $event->venue()->create([
                    'venue_name' => $venueData['predefined'] ?? 'Custom Venue',
                    'venue_address' => $venueData['address'] ?? null,
                    'venue_size' => $venueData['size'] ?? null,
                    'venue_cost' => $venueData['cost'] ?? 0,
                ]);
            }

            // Save seating data if present
            if ($request->has('event_seating') && !empty($request->event_seating)) {
                $seatingData = $request->event_seating;
                $event->seating()->create([
                    'attendees' => $seatingData['attendees'] ?? 0,
                    'chair_type' => $seatingData['chairType'] ?? 'basic',
                    'table_type' => $seatingData['tableType'] ?? 'circular',
                    'seat_cover' => filter_var($seatingData['seatCover'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'seating_cost' => $seatingData['cost'] ?? 0,
                ]);
            }

            // Save stage data if present
            if ($request->has('event_stage') && !empty($request->event_stage)) {
                $stageData = $request->event_stage;
                $event->stage()->create([
                    'stage_type' => $stageData['type'] ?? 'basic',
                    'stage_image_link' => $stageData['stage_image'] ?? null,
                    'surrounding_decoration' => filter_var($stageData['decoration'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'decoration_image_link' => $stageData['decoration_image'] ?? null,
                    'stage_cost' => $stageData['cost'] ?? 0,
                ]);
            }

            // Save catering data if present
            if ($request->has('event_catering') && !empty($request->event_catering)) {
                $cateringData = $request->event_catering;
                $event->catering()->create([
                    'catering_required' => filter_var($cateringData['catering_required'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'per_person_cost' => $cateringData['per_person_cost'] ?? 0,
                    'total_guests' => $cateringData['total_guests'] ?? 0,
                    'total_catering_cost' => $cateringData['total_catering_cost'] ?? 0,
                ]);
            }

            // Save photography data if present
            if ($request->has('event_photography') && !empty($request->event_photography)) {
                $photoData = $request->event_photography;
                $event->photography()->create([
                    'photography_required' => filter_var($photoData['photography_required'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'package_type' => $photoData['package_type'] ?? null,
                    'customizable' => filter_var($photoData['customizable'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'num_photographers' => $photoData['num_photographers'] ?? null,
                    'num_hours' => $photoData['num_hours'] ?? null,
                    'indoor' => filter_var($photoData['indoor'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'outdoor' => filter_var($photoData['outdoor'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'cinematography' => filter_var($photoData['cinematography'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'photography_cost' => $photoData['cost'] ?? 0,
                ]);
            }

            // Save extra options data if present
            if ($request->has('event_extra') && !empty($request->event_extra)) {
                $extraData = $request->event_extra;
                $selectedOptions = $extraData['selected'] ?? [];
                
                $event->extraOptions()->create([
                    'photo_booth' => in_array('photo_booth', $selectedOptions),
                    'coffee_booth' => in_array('coffee_booth', $selectedOptions),
                    'mehendi_booth' => in_array('mehendi_booth', $selectedOptions),
                    'paan_booth' => in_array('paan_booth', $selectedOptions),
                    'fuchka_stall' => in_array('fuchka_stall', $selectedOptions),
                    'sketch_booth' => in_array('sketch_booth', $selectedOptions),
                    'extra_options_cost' => $extraData['cost'] ?? 0,
                ]);
            }

            // Store user ID in session for profile redirect
            session(['current_user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Event request submitted successfully with all details! You will be notified once it\'s reviewed.',
                'event_id' => $event->id,
                'status' => $event->status,
                'redirect_url' => route('profile.show', Auth::id())
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit event request. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's event requests
     */
    public function getUserEvents()
    {
        $events = Auth::user()->events()->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'events' => $events
        ]);
    }

    /**
     * Get specific event details with all components
     */
    public function show(Event $event)
    {
        // Check if user owns this event or is an organizer
        if ($event->user_id !== Auth::id() && !Auth::user()->isOrganizer()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Load all event components
        $event->load(['venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions']);

        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    /**
     * Get comprehensive event data for display/debugging
     */
    public function getEventDetails($eventId)
    {
        try {
            $event = Event::with(['venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions'])
                          ->findOrFail($eventId);
            
            // Check authorization
            if ($event->user_id !== Auth::id() && !Auth::user()->isOrganizer()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'event' => [
                    'basic_info' => [
                        'id' => $event->id,
                        'event_name' => $event->event_name,
                        'category' => $event->category,
                        'event_date' => $event->event_date,
                        'total_cost' => $event->total_cost,
                        'status' => $event->status,
                        'created_at' => $event->created_at
                    ],
                    'venue_details' => $event->venue ? [
                        'venue_name' => $event->venue->venue_name,
                        'venue_address' => $event->venue->venue_address,
                        'venue_size' => $event->venue->venue_size,
                        'venue_cost' => $event->venue->venue_cost
                    ] : null,
                    'seating_details' => $event->seating ? [
                        'attendees' => $event->seating->attendees,
                        'chair_type' => $event->seating->chair_type,
                        'table_type' => $event->seating->table_type,
                        'seat_cover' => $event->seating->seat_cover,
                        'seating_cost' => $event->seating->seating_cost
                    ] : null,
                    'stage_details' => $event->stage ? [
                        'stage_type' => $event->stage->stage_type,
                        'stage_image_link' => $event->stage->stage_image_link,
                        'surrounding_decoration' => $event->stage->surrounding_decoration,
                        'decoration_image_link' => $event->stage->decoration_image_link,
                        'stage_cost' => $event->stage->stage_cost
                    ] : null,
                    'catering_details' => $event->catering ? [
                        'catering_required' => $event->catering->catering_required,
                        'per_person_cost' => $event->catering->per_person_cost,
                        'total_guests' => $event->catering->total_guests,
                        'total_catering_cost' => $event->catering->total_catering_cost
                    ] : null,
                    'photography_details' => $event->photography ? [
                        'photography_required' => $event->photography->photography_required,
                        'package_type' => $event->photography->package_type,
                        'customizable' => $event->photography->customizable,
                        'num_photographers' => $event->photography->num_photographers,
                        'num_hours' => $event->photography->num_hours,
                        'indoor' => $event->photography->indoor,
                        'outdoor' => $event->photography->outdoor,
                        'cinematography' => $event->photography->cinematography,
                        'photography_cost' => $event->photography->photography_cost
                    ] : null,
                    'extra_options' => $event->extraOptions ? [
                        'photo_booth' => $event->extraOptions->photo_booth,
                        'coffee_booth' => $event->extraOptions->coffee_booth,
                        'mehendi_booth' => $event->extraOptions->mehendi_booth,
                        'paan_booth' => $event->extraOptions->paan_booth,
                        'fuchka_stall' => $event->extraOptions->fuchka_stall,
                        'sketch_booth' => $event->extraOptions->sketch_booth,
                        'extra_options_cost' => $event->extraOptions->extra_options_cost
                    ] : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found or error occurred',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}