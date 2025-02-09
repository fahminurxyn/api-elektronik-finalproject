<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/pelanggan', PelangganController::class);
Route::apiResource('/penyewaan', PenyewaanController::class);
