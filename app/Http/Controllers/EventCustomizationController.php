<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventCustomizationController extends Controller
{
    public function index()
    {
        return view('custom-event.index');
    }

    public function venueForm(Request $request)
    {
        // Handle venue form submission (e.g., store selected venue, calculate cost)
        // Save the selected venue information in session
        Session::put('venue', $request->all()); 

        return view('custom-event.venue');
    }

    public function seatingForm(Request $request)
    {
        // Handle seating form submission (e.g., store seating choices)
        Session::put('seating', $request->all());

        return view('custom-event.seating');
    }

    public function stageForm(Request $request)
    {
        // Handle stage form submission (e.g., store stage and decoration options)
        Session::put('stage', $request->all());

        return view('custom-event.stage');
    }

    public function cateringForm(Request $request)
    {
        // Handle catering form submission (e.g., store catering details)
        Session::put('catering', $request->all());

        return view('custom-event.catering');
    }

    public function photographyForm(Request $request)
    {
        // Handle photography form submission
        Session::put('photography', $request->all());

        return view('custom-event.photography');
    }

    public function xtraOptionsForm()
    {
        return view('custom-event.xtraoptions');
    }

    // Public methods for guest users (no authentication required)
    public function publicIndex()
    {
        return view('custom-event.public-index');
    }

    public function publicVenueForm(Request $request)
    {
        // Handle venue form for guests - store in session without authentication
        if ($request->isMethod('post')) {
            Session::put('guest_venue', $request->all());
        }
        return view('custom-event.public-venue');
    }

    public function publicSeatingForm(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::put('guest_seating', $request->all());
        }
        return view('custom-event.public-seating');
    }

    public function publicStageForm(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::put('guest_stage', $request->all());
        }
        return view('custom-event.public-stage');
    }

    public function publicCateringForm(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::put('guest_catering', $request->all());
        }
        return view('custom-event.public-catering');
    }

    public function publicPhotographyForm(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::put('guest_photography', $request->all());
        }
        return view('custom-event.public-photography');
    }

    public function publicXtraOptionsForm(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::put('guest_xtraoptions', $request->all());
        }
        return view('custom-event.public-xtraoptions');
    }

    public function publicDashboard()
    {
        // Public dashboard that shows localStorage-based customizations
        // Only requires login for final event submission
        return view('events.public-dashboard');
    }

    public function finalizeEvent(Request $request)
    {
        // This method requires authentication - user must be logged in to finalize
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please log in to finalize your event request.');
        }

        // Get all guest session data and convert to authenticated user data
        $guestData = [];
        $guestKeys = ['guest_venue', 'guest_seating', 'guest_stage', 'guest_catering', 'guest_photography', 'guest_xtraoptions'];
        
        foreach ($guestKeys as $key) {
            if (Session::has($key)) {
                $guestData[$key] = Session::get($key);
            }
        }

        // Store event data to database logic goes here
        $event = new Event();
        $event->user_id = Auth::id();
        $event->category = $request->input('category', 'custom');
        $event->total_cost = $request->input('total_cost', 0);
        $event->event_data = json_encode($guestData); // Store customization data as JSON
        $event->save();

        // Clear guest session data
        foreach ($guestKeys as $key) {
            Session::forget($key);
        }

        return redirect()->route('profile.show', Auth::id())->with('success', 'Your event request has been submitted successfully!');
    }

    public function store(Request $request)
    {

        // Store the final event data into the database
        $eventData = Session::all();  // Get all session data

        // Save event data to database logic goes here

        // Clear session after storing data
        Session::flush();

        return redirect()->route('events.dashboard');

        $event = new Event();
        $event->user_id = Auth::id(); // make sure user is logged in
        $event->category = $request->input('category');
        $event->total_cost = $request->input('total_cost');
        $event->save();

        // Save catering details
        if ($request->has('event_catering')) {
            $catering = $request->input('event_catering');
            // Example: Save catering info in session or another table/model as needed
            // Session::put('event_catering', $catering);
            // Or, if you have a Catering model/table:
            // Catering::create([
            //     'event_id' => $event->id,
            //     'catering_required' => $catering['catering_required'],
            //     'per_person_cost' => $catering['per_person_cost'],
            //     'total_catering_cost' => $catering['total_catering_cost'],
            //     'total_guests' => $catering['total_guests'],
            // ]);
        }

        // 2. Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
