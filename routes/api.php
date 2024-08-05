<?php

use App\Http\Controllers\Api\v1\VendaChaveTrocaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('/', [VendaChaveTrocaController::class,'index'])->name('/');
Route::post('/game', [VendaChaveTrocaController::class,'store'])->name('store'); // CREATE
Route::get('/games', [VendaChaveTrocaController::class,'index'])->name('index'); // READ all games
Route::put('/game/{id}', [VendaChaveTrocaController::class,'update'])->name('update'); // UPDATE
Route::delete('/game/{id}', [VendaChaveTrocaController::class,'destroy'])->name('destroy'); // DELETE