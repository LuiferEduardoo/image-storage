<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerImageStorage;
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create/{folder}', [ControllerImageStorage::class, 'createImage']);
});