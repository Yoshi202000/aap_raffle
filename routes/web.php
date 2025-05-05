<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaffleController;
use App\Http\Controllers\PrizeController;


Route::get('/', function () {
    return redirect('/raffles');
});

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
