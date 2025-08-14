<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [EventController::class, 'index'])->name('home');
Route::resource('events', EventController::class);

Route::middleware('auth')->group(function () {
    Route::post('events/{event}/rsvp', [RsvpController::class, 'store'])->name('events.rsvp');
    Route::delete('events/{event}/rsvp', [RsvpController::class, 'destroy'])->name('events.rsvp.cancel');
});