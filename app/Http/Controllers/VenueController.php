<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function availableVenues(Request $request)
    {
        $date = $request->query('date');
        $venues = Venue::whereRaw("JSON_SEARCH(booked_dates, 'one', ? ) IS NULL", [$date])->get();
        return response()->json($venues);
    }
}
