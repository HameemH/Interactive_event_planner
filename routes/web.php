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
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

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

// Public Event Customization Routes (no auth required for browsing)
Route::get('/customize', [EventCustomizationController::class, 'publicIndex'])->name('customize.event');
Route::get('/customize/venue', [EventCustomizationController::class, 'publicVenueForm'])->name('customize.venue');
Route::post('/customize/venue', [EventCustomizationController::class, 'publicVenueForm']);
Route::get('/customize/seating', [EventCustomizationController::class, 'publicSeatingForm'])->name('customize.seating');
Route::post('/customize/seating', [EventCustomizationController::class, 'publicSeatingForm']);
Route::get('/customize/stage', [EventCustomizationController::class, 'publicStageForm'])->name('customize.stage');
Route::post('/customize/stage', [EventCustomizationController::class, 'publicStageForm']);
Route::get('/customize/catering', [EventCustomizationController::class, 'publicCateringForm'])->name('customize.catering');
Route::post('/customize/catering', [EventCustomizationController::class, 'publicCateringForm']);
Route::get('/customize/photography', [EventCustomizationController::class, 'publicPhotographyForm'])->name('customize.photography');
Route::post('/customize/photography', [EventCustomizationController::class, 'publicPhotographyForm']);
Route::get('/customize/xtraoptions', [EventCustomizationController::class, 'publicXtraOptionsForm'])->name('customize.xtraoptions');
Route::post('/customize/xtraoptions', [EventCustomizationController::class, 'publicXtraOptionsForm']);
Route::get('/customize/dashboard', [EventCustomizationController::class, 'publicDashboard'])->name('customize.dashboard');
Route::get('/public-receipt', [ReceiptController::class, 'download'])->name('public.receipt.download');

// Finalization requires authentication
Route::post('/customize/finalize', [EventCustomizationController::class, 'finalizeEvent'])->name('customize.finalize')->middleware('auth');

// Access denied route
Route::get('/access-denied', function () {
    return view('errors.access-denied');
})->name('access.denied')->middleware('auth');

// Routes accessible by both organizers and guests (logged in users)
Route::middleware(['auth'])->group(function () {
    Route::get('/customize-event', [EventCustomizationController::class, 'index'])->name('custom-event.index');
    Route::get('/customize-event/venue', [EventCustomizationController::class, 'venueForm'])->name('custom-event.venue');
    Route::get('/customize-event/seating', [EventCustomizationController::class, 'seatingForm'])->name('custom-event.seating');
    Route::post('/customize-event/seating', [EventCustomizationController::class, 'seatingForm']);
    Route::get('/customize-event/stage', [EventCustomizationController::class, 'stageForm'])->name('custom-event.stage');
    Route::post('/customize-event/stage', [EventCustomizationController::class, 'stageForm']);
    Route::get('/customize-event/catering', [EventCustomizationController::class, 'cateringForm'])->name('custom-event.catering');
    Route::post('/customize-event/catering', [EventCustomizationController::class, 'cateringForm']);
    Route::get('/customize-event/photography', [EventCustomizationController::class, 'photographyForm'])->name('custom-event.photography');
    Route::post('/customize-event/photography', [EventCustomizationController::class, 'photographyForm']);
    Route::get('/customize-event/xtraoptions', [EventCustomizationController::class, 'xtraOptionsForm'])->name('custom-event.xtraoptions');
    Route::post('/customize-event/xtraoptions', [EventCustomizationController::class, 'xtraOptionsForm']);
    Route::post('/customize-event/finalize', function() {
        return redirect()->route('event.dashboard');
    })->name('custom-event.finalize');
    
    // Shared Event Dashboard (accessible by both organizers and guests)
    Route::get('/event/dashboard', function() {
        return view('events.dashboard');
    })->name('event.dashboard');
    
    // Event Request Routes
    Route::post('/event/request', [App\Http\Controllers\EventRequestController::class, 'store'])->name('event.request.store');
    Route::get('/event/my-events', [App\Http\Controllers\EventRequestController::class, 'getUserEvents'])->name('event.my-events');
    Route::get('/event/{event}', [App\Http\Controllers\EventRequestController::class, 'show'])->name('event.show');
    Route::get('/event/{eventId}/details', [App\Http\Controllers\EventRequestController::class, 'getEventDetails'])->name('event.details');
});

// Routes accessible only by organizers (admins)
Route::middleware(['auth', 'role:organizer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/promote', [App\Http\Controllers\Admin\AdminController::class, 'promoteUser'])->name('users.promote');
    Route::post('/users/{user}/demote', [App\Http\Controllers\Admin\AdminController::class, 'demoteUser'])->name('users.demote');
    
    // Event management routes
    Route::get('/events', [App\Http\Controllers\Admin\AdminController::class, 'events'])->name('events');
    Route::get('/events/{event}', [App\Http\Controllers\Admin\AdminController::class, 'showEvent'])->name('events.show');
    Route::post('/events/{event}/status', [App\Http\Controllers\Admin\AdminController::class, 'updateEventStatus'])->name('events.status');
    Route::post('/events/{event}/pricing', [App\Http\Controllers\Admin\AdminController::class, 'updateEventPricing'])->name('events.pricing');
});


Route::get('/download-receipt', [ReceiptController::class, 'download'])->name('receipt.download')->middleware('auth');
Route::get('/api/available-venues', [VenueController::class, 'availableVenues']);

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{userId?}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/event/{eventId}/details', [App\Http\Controllers\ProfileController::class, 'showEvent'])->name('profile.event.details');
    Route::post('/event/{eventId}/message', [App\Http\Controllers\ProfileController::class, 'sendMessage'])->name('profile.event.message');
    Route::post('/event/{eventId}/status', [App\Http\Controllers\ProfileController::class, 'updateEventStatus'])->name('profile.event.status');
});