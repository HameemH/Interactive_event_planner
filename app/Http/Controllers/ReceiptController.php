<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function download(Request $request)
    {
        // Get data from localStorage (sent via query or API)
        $data = json_decode($request->input('event_data'), true);

        $pdf = Pdf::loadView('receipts.invoice', compact('data'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('event-receipt.pdf');
    }
}
