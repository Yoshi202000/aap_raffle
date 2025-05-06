<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\AapRaffleController;


Route::get('/raffles/index', function (){
    return view('index');
});

Route::get('/raffles/create', function () {
    return view('raffles.create');
});

// Simple Raffle Routes - try these first
Route::get('/raffles', [RaffleController::class, 'index']);
Route::get('/raffles/create', [RaffleController::class, 'create']);
Route::post('/raffles', [RaffleController::class, 'store']);

// The most important route - make sure this is above the PUT route
Route::get('/raffles/{raffle_id}', [RaffleController::class, 'show']);

// Other raffle routes
Route::get('/raffles/{raffle_id}/edit', [RaffleController::class, 'edit']);
Route::put('/raffles/{raffle_id}', [RaffleController::class, 'update']);
Route::delete('/raffles/{raffle_id}', [RaffleController::class, 'destroy']);

Route::resource('prizes', PrizeController::class)->except(['index', 'create', 'show']);
Route::post('/prizes', [PrizeController::class, 'store']);
Route::get('/raffles/{raffle_id}/prizes', [PrizeController::class, 'showByRaffle'])->name('prizes.show');
Route::post('/prizes-debug', [PrizeController::class, 'debug'])->name('prizes.debug');

//aap_raffle
Route::get('/aap_raffles/edit', [AapRaffleController::class, 'customEdit'])->name('aap_raffles.custom_edit');

Route::resource('aap_raffles', AapRaffleController::class);
Route::post('/aap_raffles/update-order', [AapRaffleController::class, 'updateOrder'])->name('aap_raffles.updateOrder');

// Routes for inline editing
Route::post('/aap_raffles/update-field/{id}', [AapRaffleController::class, 'updateField'])->name('aap_raffles.updateField');
Route::post('/aap_raffles/update-image/{id}', [AapRaffleController::class, 'updateImage'])->name('aap_raffles.updateImage');