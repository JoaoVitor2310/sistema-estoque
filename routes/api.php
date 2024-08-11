<?php

use App\Http\Controllers\Api\v1\VendaChaveTrocaController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Autenticação
Route::get('/prepare-to-login', [AuthController::class,'prepare_to_login'])->name('prepare.login');
Route::get('/callback', [AuthController::class,'callback'])->name('callback');

Route::post('/game', [VendaChaveTrocaController::class,'store'])->name('store'); // CREATE
Route::get('/games', [VendaChaveTrocaController::class,'index'])->name('index'); // READ all games
Route::put('/game/{id}', [VendaChaveTrocaController::class,'update'])->name('update'); // UPDATE
Route::delete('/game/{id}', [VendaChaveTrocaController::class,'destroy'])->name('destroy'); // DELETE