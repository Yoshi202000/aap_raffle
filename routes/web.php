<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\AapRaffleController;

// Homepage routes
Route::get('/', function(){
    return view('aap_raffle.index');
});

// Raffle routes
Route::get('/raffles/index', function (){
    return view('index');
});
Route::get('/raffles/create', function () {
    return view('raffles.create');
});
Route::get('/raffles', [RaffleController::class, 'index']);
Route::get('/raffles/create', [RaffleController::class, 'create']);
Route::post('/raffles', [RaffleController::class, 'store']);
Route::get('/raffles/{raffle_id}', [RaffleController::class, 'show']);
Route::get('/raffles/{raffle_id}/edit', [RaffleController::class, 'edit']);
Route::put('/raffles/{raffle_id}', [RaffleController::class, 'update']);
Route::delete('/raffles/{raffle_id}', [RaffleController::class, 'destroy']);

// Prize routes
Route::resource('prizes', PrizeController::class)->except(['index', 'create', 'show']);
Route::post('/prizes', [PrizeController::class, 'store']);
Route::get('/raffles/{raffle_id}/prizes', [PrizeController::class, 'showByRaffle'])->name('prizes.show');
Route::post('/prizes-debug', [PrizeController::class, 'debug'])->name('prizes.debug');

// AAP Raffle routes - using resource for standard CRUD
Route::resource('aap_raffles', AapRaffleController::class);

// Additional AAP Raffle routes
Route::post('/aap_raffles/update-order', [AapRaffleController::class, 'updateOrder'])->name('aap_raffles.updateOrder');
Route::get('/aap_raffle/attendees', [AapRaffleController::class, 'createAttendees'])->name('aap_raffles.attendees');
Route::get('/aap_raffle/members', [AapRaffleController::class, 'createMembers'])->name('aap_raffles.members');
Route::post('/aap_raffles/update-image/{id}', [AapRaffleController::class, 'updateImage'])->name('aap_raffles.updateImage');

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