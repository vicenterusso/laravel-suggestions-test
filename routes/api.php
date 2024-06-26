<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/suggestions',[\App\Http\Controllers\SuggestionController::class, 'index']);
    Route::post('/suggestion',[\App\Http\Controllers\SuggestionController::class, 'create']);
    Route::post('/suggestion/vote/{id}',[\App\Http\Controllers\SuggestionController::class, 'vote']);


});
