<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

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
