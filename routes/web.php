<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Parent
Route::group(['prefix' => 'data-orang-tua'], function () {
    Route::get('/', [App\Http\Controllers\StudentParentController::class, 'index'])->name('parent-data');
    Route::get('/tambah', [App\Http\Controllers\StudentParentController::class, 'create'])->name('parent-data.create');
    Route::post('/tambah', [App\Http\Controllers\StudentParentController::class, 'store'])->name('parent-data.store');
    Route::get('/edit/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'edit'])->name('parent-data.edit');
    Route::post('/edit/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'editProcess'])->name('parent-data.edit-process');
    Route::get('/hapus/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'delete'])->name('parent-data.delete');
});
