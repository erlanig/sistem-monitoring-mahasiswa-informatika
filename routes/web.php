<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\SesiController;
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

Route::get('/', [SesiController::class, 'index'])->name('login');
Route::post('/', [SesiController::class, 'login']);


Route::get('/home', function(){
    return redirect('/login');
});

Route::middleware(['auth'])->group(function(){
    Route::middleware(['userAkses:mahasiswa'])->group(function () {
        Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/mahasiswa/edit/{id_mhs}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/update/{id_mhs}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    });
    Route::middleware(['userAkses:operator'])->group(function () {
        Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
        Route::get('/operator/manajemen', [OperatorController::class, 'manajemenakun'])->name('operator.manajemen');
    });
    Route::get('/dosen/dashboard', [DosenController::class, 'index'])->middleware('userAkses:dosen')->name('dosen.dashboard');
    Route::get('/departemen/dashboard', [DepartemenController::class, 'index'])->middleware('userAkses:departemen')->name('departemen.dashboard');
    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');
});
