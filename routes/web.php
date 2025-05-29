<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\AapRaffleController;
use App\Http\Controllers\WinnerController;
use App\Http\Controllers\ImageController;

// Homepage routes
Route::redirect('/', '/aap_raffles');

// AAP Raffle routes - using resource for standard CRUD
Route::resource('aap_raffles', AapRaffleController::class);

// Additional AAP Raffle routes
Route::post('/aap_raffles/update-order', [AapRaffleController::class, 'updateOrder'])->name('aap_raffles.updateOrder');
Route::get('/aap_raffle/attendees', [AapRaffleController::class, 'createAttendees'])->name('aap_raffles.attendees');
Route::get('/aap_raffle/members', [AapRaffleController::class, 'createMembers'])->name('aap_raffles.members');
Route::post('/aap_raffles/update-image/{id}', [AapRaffleController::class, 'updateImage'])->name('aap_raffles.updateImage');
Route::post('/aap-raffles/decrease-prize', [AapRaffleController::class, 'decreasePrize'])->name('aap_raffles.decrease_prize');

// Get edit modal content - make sure this route is used in your JavaScript
Route::get('/get-edit-modal-content', function() {
    return view('aap_raffle.edit_modal_content');
});
Route::get('/raffle-showcase/{aap_raffle}', function(App\Models\AapRaffle $aap_raffle) {
    return view('aap_raffle.raffle_showcase', compact('aap_raffle'));
})->name('aap_raffles.showcase');

Route::get('/aap-raffle-show/{id}', function($id) {
    $aap_raffle = \App\Models\AapRaffle::findOrFail($id);
    return view('aap_raffle.raffle_show', compact('aap_raffle'));
})->name('aap_raffle.raffle_show');

Route::get('/raffle-showcase/{aap_raffle}', function(App\Models\AapRaffle $aap_raffle) {
    return view('aap_raffle.raffle_showcase', compact('aap_raffle'));
})->name('aap_raffles.showcase');

Route::get('/aap-raffles-carousel', [AapRaffleController::class, 'carouselAll'])
    ->name('aap_raffles.carousel_all');

Route::get('/aap-raffles-attendees', [AapRaffleController::class, 'attendeesCarousel'])
    ->name('aap_raffles.attendees');

// show winner coupon, first name, last name 
Route::get('/winner', [WinnerController::class, 'random']);
Route::get('/raffle/random-winner', [RaffleController::class, 'randomApi']);

// image bg controller
Route::post('/upload-image', [ImageController::class, 'upload'])->name('image.upload');
Route::delete('/delete-image/{filename}', [ImageController::class, 'delete'])->name('image.delete');
Route::post('/upload-background', [ImageController::class, 'uploadBackground'])->name('background.upload');

