<?php

use App\Http\Controllers\Api\v1\VendaChaveTrocaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/', [VendaChaveTrocaController::class,'index'])->name('/');
Route::post('/game', [VendaChaveTrocaController::class,'store'])->name('store');
Route::put('/game/{id}', [VendaChaveTrocaController::class,'update'])->name('update');