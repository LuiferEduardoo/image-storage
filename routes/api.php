<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerImageStorage;
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/images', [ControllerImageStorage::class, 'GetImages']);
    Route::post('/images/create', [ControllerImageStorage::class, 'createImage']);
    Route::delete('/images', [ControllerImageStorage::class, 'DeleteImage']);
    Route::patch('/images/{id}', [ControllerImageStorage::class, 'PatchImage']);
});