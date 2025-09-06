<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Existing index method
    public function index()
    {
        $event = [
            'id' => 1, // example
            'name' => 'Wedding Ceremony',
            'date' => '2025-10-15',
            'venue' => 'Grand Palace Convention Center',
            'seating' => 'Round Table - 200 guests',
            'catering' => 'Buffet - Premium',
            'photography' => 'Full Coverage + Album',
            'payment_status' => 'Paid',
            'total' => '$2500'
        ];

        return view('dashboard.index', compact('event'));
    }

    // Add this method for chat
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Store in session (demo)
        $messages = session('messages', []);
        $messages[] = [
            'from' => 'user',
            'text' => $request->message
        ];

        // Optional automated support reply
        $messages[] = [
            'from' => 'support',
            'text' => 'Thanks for your message! Our team will get back to you shortly.'
        ];

        session(['messages' => $messages]);

        return back();
    }
    public function downloadReceipt($id)
{
    $event = Event::where('id', $id)
                  ->where('user_id', auth()->id()) // make sure the user owns the event
                  ->firstOrFail();

    // Generate PDF using DomPDF
    $pdf = \PDF::loadView('dashboard.receipt', compact('event'));

    return $pdf->download('receipt-'.$event->id.'.pdf');
}


}

