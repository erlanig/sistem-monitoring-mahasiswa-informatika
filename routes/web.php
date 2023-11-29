<?php

use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
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
    // Mahasiswa
    Route::middleware(['userAkses:mahasiswa'])->group(function () {
        Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
        Route::get('/mahasiswa/edit/{id_mhs}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/mahasiswa/update/{id_mhs}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::get('/mahasiswa/entryirs/{id_mhs}', [MahasiswaController::class, 'entryirs'])->name('mahasiswa.irs');
        Route::post('/mahasiswa/updateirs/{id_mhs}', [MahasiswaController::class, 'updateirs'])->name('mahasiswa.updateirs');
        Route::post('/mahasiswa/createirs/{id_mhs}', [MahasiswaController::class, 'createirs'])->name('mahasiswa.createirs');

        Route::get('/mahasiswa/entrykhs/{id_mhs}', [MahasiswaController::class, 'entrykhs'])->name('mahasiswa.khs');;
        Route::post('/mahasiswa/updatekhs/{id_mhs}', [MahasiswaController::class, 'updatekhs'])->name('mahasiswa.updatekhs');
        Route::post('/mahasiswa/createkhs/{id_mhs}', [MahasiswaController::class, 'createkhs'])->name('mahasiswa.createkhs');

        Route::get('/mahasiswa/entrypkl/{id_mhs}', [MahasiswaController::class, 'entrypkl'])->name('mahasiswa.pkl');;
        Route::post('/mahasiswa/createpkl/{id_mhs}', [MahasiswaController::class, 'createpkl'])->name('mahasiswa.createpkl');

        Route::get('/mahasiswa/entryskripsi/{id_mhs}', [MahasiswaController::class, 'entryskripsi'])->name('mahasiswa.skripsi');;
        Route::post('/mahasiswa/createskripsi/{id_mhs}', [MahasiswaController::class, 'createskripsi'])->name('mahasiswa.createskripsi');
    });

    // Operator
    Route::middleware(['userAkses:operator'])->group(function () {
        Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');
        Route::get('/operator/manajemen', [OperatorController::class, 'manajemenakun'])->name('operator.manajemen');
        Route::get('/operator/generateAkun', [OperatorController::class, 'generate'])->name('operator.generate');
        Route::get('/operator/generateAkunPerorangan', [OperatorController::class, 'create'])->name('operator.create');
        Route::match(['get','post'], '/operator/simpanGenerateAkunPerorangan', [OperatorController::class, 'store'])->name('operator.store');
        Route::get('/operator/export', [OperatorController::class, 'export'])->name('operator.export');
        Route::post('/operator/import', [OperatorController::class, 'import'])->name('operator.import');

        Route::get('/operator/rekap-pkl', [OperatorController::class, 'rekappkl'])->name('operator.rekappkl');
        Route::get('/operator/sudah-pkl/{tahun}', [OperatorController::class, 'dataSudahPKL'])->name('operator.sudahpkl');
        Route::get('/operator/belum-pkl/{tahun}', [OperatorController::class, 'dataBlmPKL'])->name('operator.belumpkl');
        Route::get('/operator/cetak-rekap-pkl', [OperatorController::class, 'cetakPKL'])->name('operator.cetakrekappkl');
        Route::get('/operator/cetak-sudah-pkl/{tahun}', [OperatorController::class, 'cetakSudahPKL'])->name('operator.cetaksudahpkl');
        Route::get('/operator/cetak-belum-pkl/{tahun}', [OperatorController::class, 'cetakBelumPKL'])->name('operator.cetakbelumpkl');

        Route::get('/operator/rekap-skripsi', [OperatorController::class, 'rekapSkripsi'])->name('operator.rekapskripsi');
        Route::get('/operator/sudah-skripsi/{tahun}', [OperatorController::class, 'dataSudahSkripsi'])->name('operator.sudahskripsi');
        Route::get('/operator/belum-skripsi/{tahun}', [OperatorController::class, 'dataBlmSkripsi'])->name('operator.belumskripsi');
        Route::get('/operator/cetak-rekap-skripsi', [OperatorController::class, 'cetakSkripsi'])->name('operator.cetakrekapskripsi');
        Route::get('/operator/cetak-sudah-skripsi/{tahun}', [OperatorController::class, 'cetakSudahSkripsi'])->name('operator.cetaksudahskripsi');
        Route::get('/operator/cetak-belum-skripsi/{tahun}', [OperatorController::class, 'cetakBelumSkripsi'])->name('operator.cetakbelumskripsi');

        Route::get('/operator/rekap-status', [OperatorController::class, 'rekapStatus'])->name('operator.rekapstatus');
        Route::get('/operator/mahasiswa-aktif/{tahun}', [OperatorController::class, 'dataMhsAktif'])->name('operator.mhsaktif');
        Route::get('/operator/mahasiswa-tidak-aktif/{tahun}/{status}', [OperatorController::class, 'dataMhsTdkAktif'])->name('operator.mhstdkaktif');
        Route::get('/operator/cetak-rekap-status', [OperatorController::class, 'cetakStatus'])->name('operator.cetakrekapstatus');
        Route::get('/operator/cetak-mahasiswa-aktif/{tahun}', [OperatorController::class, 'cetakMhsAktif'])->name('operator.cetakmhsaktif');
        Route::get('/operator/cetak-mahasiswa-tidak-aktif/{tahun}/{status}', [OperatorController::class, 'cetakMhsTdkAktif'])->name('operator.cetakmhstdkaktif');
    });

    // Dosen
    Route::middleware(['userAkses:dosen'])->group(function(){
        Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');
        Route::get('/dosen/irsMahasiswa', [DosenController::class, 'showIRS'])->name('dosen.irs');
        Route::patch('/dosen/irsMahasiswa/{nim}', [DosenController::class, 'verifikasiIRS'])->name('dosen.verifikasiIRS');
        Route::get('/dosen/khsMahasiswa', [DosenController::class, 'showKHS'])->name('dosen.khs');
        Route::patch('/dosen/khsMahasiswa/{nim}', [DosenController::class, 'verifikasiKHS'])->name('dosen.verifikasiKHS');
        Route::get('/dosen/pklMahasiswa', [DosenController::class, 'showPKL'])->name('dosen.pkl');
        Route::patch('/dosen/pklMahasiswa/{nim}', [DosenController::class, 'verifikasiPKL'])->name('dosen.verifikasiPKL');
        Route::get('/dosen/skripsiMahasiswa', [DosenController::class, 'showSkripsi'])->name('dosen.skripsi');
        Route::patch('/dosen/skripsiMahasiswa/{nim}', [DosenController::class, 'verifikasiSkripsi'])->name('dosen.verifikasiSkripsi');
        Route::get('/dosen/daftar-mahasiswa', [DosenController::class, 'daftarMahasiswa'])->name('doswal.daftarmahasiswa');
        Route::get('/dosen/perwalian/{nim}', [DosenController::class, 'perwalian'])->name('doswal.perwalian');

        Route::get('/dosen/rekap-pkl', [dosenController::class, 'rekappkl'])->name('dosen.rekappkl');
        Route::get('/dosen/sudah-pkl/{tahun}', [DosenController::class, 'dataSudahPKL'])->name('dosen.sudahpkl');
        Route::get('/dosen/belum-pkl/{tahun}', [DosenController::class, 'dataBlmPKL'])->name('dosen.belumpkl');
        Route::get('/dosen/cetak-rekap-pkl', [DosenController::class, 'cetakPKL'])->name('dosen.cetakrekappkl');
        Route::get('/dosen/cetak-sudah-pkl/{tahun}', [DosenController::class, 'cetakSudahPKL'])->name('dosen.cetaksudahpkl');
        Route::get('/dosen/cetak-belum-pkl/{tahun}', [DosenController::class, 'cetakBelumPKL'])->name('dosen.cetakbelumpkl');

        Route::get('/dosen/rekap-skripsi', [DosenController::class, 'rekapSkripsi'])->name('dosen.rekapskripsi');
        Route::get('/dosen/sudah-skripsi/{tahun}', [DosenController::class, 'dataSudahSkripsi'])->name('dosen.sudahskripsi');
        Route::get('/dosen/belum-skripsi/{tahun}', [DosenController::class, 'dataBlmSkripsi'])->name('dosen.belumskripsi');
        Route::get('/dosen/cetak-rekap-skripsi', [DosenController::class, 'cetakSkripsi'])->name('dosen.cetakrekapskripsi');
        Route::get('/dosen/cetak-sudah-skripsi/{tahun}', [DosenController::class, 'cetakSudahSkripsi'])->name('dosen.cetaksudahskripsi');
        Route::get('/dosen/cetak-belum-skripsi/{tahun}', [DosenController::class, 'cetakBelumSkripsi'])->name('dosen.cetakbelumskripsi');

        Route::get('/dosen/rekap-status', [DosenController::class, 'rekapStatus'])->name('dosen.rekapstatus');
        Route::get('/dosen/mahasiswa-aktif/{tahun}', [DosenController::class, 'dataMhsAktif'])->name('dosen.mhsaktif');
        Route::get('/dosen/mahasiswa-tidak-aktif/{tahun}', [DosenController::class, 'dataMhsTdkAktif'])->name('dosen.mhstdkaktif');
        Route::get('/dosen/cetak-rekap-status', [DosenController::class, 'cetakStatus'])->name('dosen.cetakrekapstatus');
        Route::get('/dosen/cetak-mahasiswa-aktif/{tahun}', [DosenController::class, 'cetakMhsAktif'])->name('dosen.cetakmhsaktif');
        Route::get('/dosen/cetak-mahasiswa-tidak-aktif/{tahun}', [DosenController::class, 'cetakMhsTdkAktif'])->name('dosen.cetakmhstdkaktif');


    });
    Route::middleware(['userAkses:departemen'])->group(function(){
        Route::get('/departemen/dashboard', [DepartemenController::class, 'index'])->name('departemen.dashboard');
        Route::get('/departemen/sudah-irs/{tahun}', [DepartemenController::class, 'dataSudahIRS'])->name('departemen.sudahirs');
        Route::get('/departemen/belum-irs/{tahun}', [DepartemenController::class, 'dataBlmIRS'])->name('departemen.belumirs');
        Route::get('/departemen/khs', [DepartemenController::class, 'datakhs'])->name('departemen.khs');

        Route::get('/departemen/rekap-pkl', [DepartemenController::class, 'rekappkl'])->name('departemen.rekappkl');
        Route::get('/departemen/sudah-pkl/{tahun}', [DepartemenController::class, 'dataSudahPKL'])->name('departemen.sudahpkl');
        Route::get('/departemen/belum-pkl/{tahun}', [DepartemenController::class, 'dataBlmPKL'])->name('departemen.belumpkl');
        Route::get('/departemen/cetak-rekap-pkl', [DepartemenController::class, 'cetakPKL'])->name('departemen.cetakrekappkl');
        Route::get('/departemen/cetak-sudah-pkl/{tahun}', [DepartemenController::class, 'cetakSudahPKL'])->name('departemen.cetaksudahpkl');
        Route::get('/departemen/cetak-belum-pkl/{tahun}', [DepartemenController::class, 'cetakBelumPKL'])->name('departemen.cetakbelumpkl');


        // Route::get('/departemen/skripsi', [DepartemenController::class, 'dataskripsi'])->name('departemen.skripsi');
        Route::get('/departemen/rekap-irs', [DepartemenController::class, 'rekapirs'])->name('departemen.rekapirs');

        Route::get('/departemen/rekap-skripsi', [DepartemenController::class, 'rekapSkripsi'])->name('departemen.rekapskripsi');
        Route::get('/departemen/sudah-skripsi/{tahun}', [DepartemenController::class, 'dataSudahSkripsi'])->name('departemen.sudahskripsi');
        Route::get('/departemen/belum-skripsi/{tahun}', [DepartemenController::class, 'dataBlmSkripsi'])->name('departemen.belumskripsi');
        Route::get('/departemen/cetak-rekap-skripsi', [DepartemenController::class, 'cetakSkripsi'])->name('departemen.cetakrekapskripsi');
        Route::get('/departemen/cetak-sudah-skripsi/{tahun}', [DepartemenController::class, 'cetakSudahSkripsi'])->name('departemen.cetaksudahskripsi');
        Route::get('/departemen/cetak-belum-skripsi/{tahun}', [DepartemenController::class, 'cetakBelumSkripsi'])->name('departemen.cetakbelumskripsi');

        Route::get('/departemen/rekap-status', [DepartemenController::class, 'rekapStatus'])->name('departemen.rekapstatus');
        Route::get('/departemen/mahasiswa-aktif/{tahun}', [DepartemenController::class, 'dataMhsAktif'])->name('departemen.mhsaktif');
        //Route::get('/departemen/asiswamah-tidak-aktif/{tahun}', [DepartemenController::class, 'dataMhsTdkAktif'])->name('departemen.mhstdkaktif');
        Route::get('/departemen/mahasiswa-tidak-aktif/{tahun}/{status}', [DepartemenController::class, 'dataMhsTdkAktif'])->name('departemen.mhstdkaktif');
        Route::get('/departemen/cetak-rekap-status', [DepartemenController::class, 'cetakStatus'])->name('departemen.cetakrekapstatus');
        Route::get('/departemen/cetak-mahasiswa-aktif/{tahun}', [DepartemenController::class, 'cetakMhsAktif'])->name('departemen.cetakmhsaktif');
        Route::get('/departemen/cetak-mahasiswa-tidak-aktif/{tahun}/{status}', [DepartemenController::class, 'cetakMhsTdkAktif'])->name('departemen.cetakmhstdkaktif');

    });

    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');
});


