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

Auth::routes(['reset' => false, 'register' => false]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/data-absensi', [App\Http\Controllers\AbsenceController::class, 'getAbsencesByDate'])->name('home.absences');

    // Parent
    Route::group(['prefix' => 'data-orang-tua'], function () {
        Route::get('/', [App\Http\Controllers\StudentParentController::class, 'index'])->name('parent-data');
        Route::get('/tambah', [App\Http\Controllers\StudentParentController::class, 'create'])->name('parent-data.create');
        Route::post('/tambah', [App\Http\Controllers\StudentParentController::class, 'store'])->name('parent-data.store');
        Route::get('/edit/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'edit'])->name('parent-data.edit');
        Route::post('/edit/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'editProcess'])->name('parent-data.edit-process');
        Route::get('/hapus/{uuid}', [\App\Http\Controllers\StudentParentController::class, 'delete'])->name('parent-data.delete');
    });

    // Student
    Route::group(['prefix' => 'data-siswa'], function () {
        Route::get('/', [App\Http\Controllers\StudentController::class, 'index'])->name('student-data');
        Route::post('/id-card-siswa', [App\Http\Controllers\StudentController::class, 'printAllIdCard'])->name('student-data.print-id-cards');
        Route::get('/detail/{uuid}', [App\Http\Controllers\StudentController::class, 'detail'])->name('student-data.detail');
        Route::get('/detail/riwayat-pelanggaran/{uuid}', [App\Http\Controllers\StudentController::class, 'violationHistory'])->name('student-data.violation-history');
        Route::get('/detail/riwayat-pelanggaran/hapus/{uuid}', [App\Http\Controllers\StudentController::class, 'deleteViolationHistory'])->name('student-data.violation-history.delete');
        Route::get('/tambah', [App\Http\Controllers\StudentController::class, 'create'])->name('student-data.create');
        Route::post('/tambah', [App\Http\Controllers\StudentController::class, 'store'])->name('student-data.store');
        Route::get('/edit/{uuid}', [App\Http\Controllers\StudentController::class, 'edit'])->name('student-data.edit');
        Route::post('/edit/{uuid}', [App\Http\Controllers\StudentController::class, 'editProcess'])->name('student-data.edit-process');
        Route::get('/hapus/{uuid}', [App\Http\Controllers\StudentController::class, 'delete'])->name('student-data.delete');

    });

    // Absence
    Route::group(['prefix' => 'absensi'], function () {
        // Masuk
        Route::get('/masuk', [App\Http\Controllers\AbsenceController::class, 'indexIn'])->name('absence.in');
        Route::post('/masuk', [App\Http\Controllers\AbsenceController::class, 'absenceIn'])->name('absence.in.process');

        // Pulang
        Route::get('/pulang', [App\Http\Controllers\AbsenceController::class, 'indexOut'])->name('absence.out');
        Route::post('/pulang', [App\Http\Controllers\AbsenceController::class, 'absenceOut'])->name('absence.out.process');
    });

    // Absence History
    Route::group(['prefix' => 'riwayat-absensi'], function () {
        Route::get('/', [App\Http\Controllers\AbsenceController::class, 'history'])->name('absence-history');
        Route::get('/{date}', [App\Http\Controllers\AbsenceController::class, 'detailHistory'])->name('absence-history.detail');
        Route::post('/update', [App\Http\Controllers\AbsenceController::class, 'updateStatus'])->name('absence-history.update');
        Route::get('/hapus/{uuid}', [App\Http\Controllers\AbsenceController::class, 'deleteHistory'])->name('absence-history.delete');
    });

    // Student Violation Points
    Route::group(['prefix' => 'pelanggaran-siswa'], function () {
        Route::post('/', [App\Http\Controllers\StudentController::class, 'violation'])->name('student-violation');
    });

    // Import Excel
    Route::post('/import', [App\Http\Controllers\HomeController::class, 'importExcel'])->name('import');

    // User Management
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user');
        Route::get('/tambah', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        Route::post('/tambah', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::post('/edit/{id}', [App\Http\Controllers\UserController::class, 'editProcess'])->name('user.edit-process');
        Route::get('/hapus/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
        Route::get('/ubah-password', [App\Http\Controllers\UserController::class, 'changePasswordShowPage'])->name('user.change-password-page');
        Route::post('/ubah-password', [App\Http\Controllers\UserController::class, 'changePassword'])->name('user.change-password');
    });
});
