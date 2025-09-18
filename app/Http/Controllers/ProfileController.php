<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

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
        $event = Event::with(['venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions', 'user'])
                     ->findOrFail($eventId);

        return view('profile.event-details', compact('event'));
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
     * Send message about event (placeholder for future implementation)
     */
    public function sendMessage(Request $request, $eventId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // For now, just return success - can be extended to save messages to database
        return back()->with('success', 'Message sent successfully');
    }
}
