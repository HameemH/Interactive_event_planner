<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EventCustomizationController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/customize-event', [EventCustomizationController::class, 'index'])->name('custom-event.index');
Route::get('/customize-event/venue', [EventCustomizationController::class, 'venueForm'])->name('custom-event.venue');
Route::post('/customize-event/seating', [EventCustomizationController::class, 'seatingForm'])->name('custom-event.seating'); // POST for form submission
Route::post('/customize-event/stage', [EventCustomizationController::class, 'stageForm'])->name('custom-event.stage'); // POST for form submission
Route::post('/customize-event/catering', [EventCustomizationController::class, 'cateringForm'])->name('custom-event.catering'); // POST for form submission
Route::post('/customize-event/photography', [EventCustomizationController::class, 'photographyForm'])->name('custom-event.photography'); // POST for form submission
Route::post('/customize-event/store', [EventCustomizationController::class, 'store'])->name('custom-event.finalize');
