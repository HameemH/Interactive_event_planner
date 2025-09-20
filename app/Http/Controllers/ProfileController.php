<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\UserMessage;
use App\Models\Payment;

class ProfileController extends Controller
{
    /**
     * Show user profile with their events
     */
    public function show(Request $request, $userId = null)
    {
        // If no userId provided, try to get from session
        if (!$userId) {
            $userId = session('current_user_id');
            if (!$userId) {
                return redirect()->route('home')->with('error', 'User not found');
            }
        }

        // Get user information
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found');
        }

        // Get user's events with all related data
        $events = Event::with(['venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions'])
                      ->where('user_id', $userId)
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('profile.show', compact('user', 'events'));
    }

    /**
     * Show specific event details from database
     */
    public function showEvent($eventId)
    {
        $event = Event::with(['venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions', 'user', 'payments'])
                     ->findOrFail($eventId);

        // Get user messages for this user
        $userMessages = UserMessage::where('user_id', $event->user_id)->first();

        // Check if payment has been completed for this event
        // Check both payment_status field and actual successful payments
        $hasSuccessfulPayment = $event->isPaid() || $event->payments()->where('status', 'succeeded')->exists();

        return view('profile.event-details', compact('event', 'userMessages', 'hasSuccessfulPayment'));
    }

    /**
     * Update event status (for admin use)
     */
    public function updateEventStatus(Request $request, $eventId)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $event = Event::findOrFail($eventId);
        $event->status = $request->status;
        $event->save();

        return back()->with('success', 'Event status updated successfully');
    }

    /**
     * Send module-specific message about event
     */
    public function sendMessage(Request $request, $eventId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'module' => 'required|string|in:venue,seating,stage,catering,photography,extra_options'
        ]);

        $event = Event::findOrFail($eventId);
        
        // Check if user owns this event
        if ($event->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized access');
        }

        // Find or create user message record
        $userMessage = UserMessage::firstOrCreate(['user_id' => auth()->id()]);
        
        // Update the specific module message
        $moduleField = $request->module . '_message';
        $userMessage->$moduleField = $request->message;
        $userMessage->save();

        $moduleNames = [
            'venue' => 'Venue',
            'seating' => 'Seating',
            'stage' => 'Stage',
            'catering' => 'Catering',
            'photography' => 'Photography',
            'extra_options' => 'Extra Options'
        ];

        return back()->with('success', $moduleNames[$request->module] . ' message sent successfully');
    }
}
