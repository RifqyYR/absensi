<?php

use App\Http\Controllers\Api\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/login', [ApiController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/logout', [ApiController::class, 'logout']);

    // General
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/absensi-anak-hari-ini', [ApiController::class, 'getChildTodayAbsence']);
        Route::get('/anak', [ApiController::class, 'getChildren']);
        Route::get('/riwayat-absensi-anak/{id}', [ApiController::class, 'getChildAbsenceHistoryDetail']);
        Route::get('/riwayat-pelanggaran-anak', [ApiController::class, 'getViolationHistory']);
        Route::get('/get-user', [ApiController::class, 'getUser']);
        Route::post('/ubah-password', [ApiController::class, 'changePassword']);
    });
});
