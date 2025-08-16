<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function store(Request $request)
    {
        // Store the final event data into the database
        $eventData = Session::all();  // Get all session data

        // Save event data to database logic goes here

        // Clear session after storing data
        Session::flush();

        return redirect()->route('events.dashboard');
    }
}
