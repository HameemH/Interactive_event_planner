<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EventCustomizationController;
use App\Http\Controllers\VenueController;

use App\Http\Controllers\ReceiptController;
use App\Models\Event;

Route::get('/db', function () {
    try {
        DB::connection()->getPdo();
        return " Database connected successfully.";
    } catch (\Exception $e) {
        return " Could not connect to the database. Error: " . $e->getMessage();
    }
});


Route::get('/', function () {
    return view('BasePages.publicHome');
});
Route::get('/seminar', function () {
    return view('BasePages.seminar');
});
Route::get('/wedding', function () {
    return view('BasePages.wedding');
});
Route::get('/religious', function () {
    return view('BasePages.religious');
});
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Auth::routes();
Route::post('/dashboard/message', [DashboardController::class, 'message'])->name('dashboard.message')->middleware('auth');
use App\Http\Controllers\DashboardController;

Route::get('/dashboard/receipt/{id}', [DashboardController::class, 'downloadReceipt'])
    ->name('download.receipt')
    ->middleware('auth'); // ensures only logged-in users can access

Route::post('/dashboard/message', [DashboardController::class, 'message'])
    ->name('dashboard.message')
    ->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/customize-event', [EventCustomizationController::class, 'index'])->name('custom-event.index');
Route::get('/customize-event/venue', [EventCustomizationController::class, 'venueForm'])->name('custom-event.venue');
Route::get('/customize-event/seating', [EventCustomizationController::class, 'seatingForm'])->name('custom-event.seating'); // GET for navigation
Route::post('/customize-event/seating', [EventCustomizationController::class, 'seatingForm']); // POST for form submission
Route::get('/customize-event/stage', [EventCustomizationController::class, 'stageForm'])->name('custom-event.stage'); // GET for navigation
Route::post('/customize-event/stage', [EventCustomizationController::class, 'stageForm']); // POST for form submission
Route::get('/customize-event/catering', [EventCustomizationController::class, 'cateringForm'])->name('custom-event.catering'); // GET for navigation
Route::post('/customize-event/catering', [EventCustomizationController::class, 'cateringForm']); // POST for form submission
Route::get('/customize-event/photography', [EventCustomizationController::class, 'photographyForm'])->name('custom-event.photography'); // GET for navigation
Route::post('/customize-event/photography', [EventCustomizationController::class, 'photographyForm']); // POST for form submission
Route::get('/customize-event/xtraoptions', [EventCustomizationController::class, 'xtraOptionsForm'])->name('custom-event.xtraoptions'); // GET for navigation
Route::post('/customize-event/xtraoptions', [EventCustomizationController::class, 'xtraOptionsForm']); // POST for form submission
Route::post('/customize-event/finalize', function() {
    return redirect()->route('dashboard');
})->name('custom-event.finalize');


Route::get('/download-receipt', [ReceiptController::class, 'download'])->name('receipt.download');
Route::get('/api/available-venues', [VenueController::class, 'availableVenues']);