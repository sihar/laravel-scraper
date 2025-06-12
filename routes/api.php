<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\TalentProfileController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/scrape', [ScrapeController::class, 'scrape']);

Route::get('/talent-profiles', [TalentProfileController::class, 'index']);
Route::get('/talent-profiles/{username}', [TalentProfileController::class, 'show']);
Route::put('/talent-profiles/{id}', [TalentProfileController::class, 'update']);
Route::delete('/talent-profiles/{id}', [TalentProfileController::class, 'destroy']);
