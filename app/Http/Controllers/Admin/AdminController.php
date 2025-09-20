<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Double-check permissions
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied. Only organizers can access the admin panel.');
        }

        $users = User::all();
        $events = Event::with(['user', 'venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        $eventStats = [
            'total' => $events->count(),
            'pending' => $events->where('status', Event::STATUS_PENDING)->count(),
            'approved' => $events->where('status', Event::STATUS_APPROVED)->count(),
            'rejected' => $events->where('status', Event::STATUS_REJECTED)->count(),
        ];

        return view('admin.dashboard', compact('users', 'events', 'eventStats'));
    }

    /**
     * Show user management page
     */
    public function users()
    {
        // Double-check permissions
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied. Only organizers can manage users.');
        }

        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Promote a user to organizer
     */
    public function promoteUser(Request $request, User $user)
    {
        // Additional permission check
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied. Only organizers can promote users.');
        }

        if ($user->promoteToAdmin()) {
            return back()->with('success', 'User promoted to organizer successfully.');
        }
        
        return back()->with('error', 'Failed to promote user.');
    }

    /**
     * Demote a user to guest
     */
    public function demoteUser(Request $request, User $user)
    {
        // Additional permission check
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied. Only organizers can manage users.');
        }

        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot demote yourself.');
        }

        // Prevent demoting the last organizer
        $organizerCount = User::where('role', User::ROLE_ORGANIZER)->count();
        if ($organizerCount <= 1 && $user->isOrganizer()) {
            return back()->with('error', 'Cannot demote the last organizer. At least one organizer must remain.');
        }

        if ($user->demoteToGuest()) {
            return back()->with('success', 'User demoted to guest successfully.');
        }
        
        return back()->with('error', 'Failed to demote user.');
    }

    /**
     * Show all events for management
     */
    public function events()
    {
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied.');
        }

        $events = Event::with(['user', 'venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('admin.events', compact('events'));
    }

    /**
     * Show event details for editing
     */
    public function showEvent(Event $event)
    {
        if (!auth()->user()->isOrganizer()) {
            return redirect()->route('access.denied')->with('error', 'Access denied.');
        }

        $event->load(['user.userMessages', 'venue', 'seating', 'stage', 'catering', 'photography', 'extraOptions']);
        return view('admin.event-details', compact('event'));
    }

    /**
     * Update event status (approve/reject)
     */
    public function updateEventStatus(Request $request, Event $event)
    {
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $event->status = $request->status;
        $event->save();

        return back()->with('success', 'Event status updated successfully.');
    }

    /**
     * Update event module pricing
     */
    public function updateEventPricing(Request $request, Event $event)
    {
        if (!auth()->user()->isOrganizer()) {
            return back()->with('error', 'Access denied.');
        }

        $request->validate([
            'venue_cost' => 'nullable|numeric|min:0',
            'seating_cost' => 'nullable|numeric|min:0',
            'stage_cost' => 'nullable|numeric|min:0',
            'catering_cost' => 'nullable|numeric|min:0',
            'photography_cost' => 'nullable|numeric|min:0',
            'extra_cost' => 'nullable|numeric|min:0',
        ]);

        $totalCost = 0;

        // Update venue cost
        if ($event->venue && $request->has('venue_cost')) {
            $event->venue->update(['venue_cost' => $request->venue_cost]);
            $totalCost += $request->venue_cost;
        }

        // Update seating cost
        if ($event->seating && $request->has('seating_cost')) {
            $event->seating->update(['seating_cost' => $request->seating_cost]);
            $totalCost += $request->seating_cost;
        }

        // Update stage cost
        if ($event->stage && $request->has('stage_cost')) {
            $event->stage->update(['stage_cost' => $request->stage_cost]);
            $totalCost += $request->stage_cost;
        }

        // Update catering cost
        if ($event->catering && $request->has('catering_cost')) {
            $event->catering->update(['total_catering_cost' => $request->catering_cost]);
            $totalCost += $request->catering_cost;
        }

        // Update photography cost
        if ($event->photography && $request->has('photography_cost')) {
            $event->photography->update(['photography_cost' => $request->photography_cost]);
            $totalCost += $request->photography_cost;
        }

        // Update extra options cost
        if ($event->extraOptions && $request->has('extra_cost')) {
            $event->extraOptions->update(['extra_options_cost' => $request->extra_cost]);
            $totalCost += $request->extra_cost;
        }

        // Update total event cost
        $event->update(['total_cost' => $totalCost]);

        return back()->with('success', 'Event pricing updated successfully.');
    }
}