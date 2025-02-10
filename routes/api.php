<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganDataController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaanDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('/pelanggan', PelangganController::class);
    Route::apiResource('/penyewaan', PenyewaanController::class);
    Route::apiResource('/kategori', KategoriController::class);
    Route::apiResource('/alat', AlatController::class);
    Route::apiResource('/penyewaan_detail', PenyewaanDetailController::class);
    Route::apiResource('/pelanggan_data', PelangganDataController::class);
    Route::apiResource('/admin', AdminController::class);
});
