<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Dashboard\CapresController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\HasilSuaraController;
use App\Http\Controllers\Dashboard\KecamatanController;
use App\Http\Controllers\Dashboard\KeluarahanController;
use App\Http\Controllers\Dashboard\SaksiController;
use App\Http\Controllers\Dashboard\SuaraMasukController;
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

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});
Route::prefix('/dashboard')->middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });
    Route::prefix('saksi')->group(function () {
        Route::controller(SaksiController::class)->group(function () {
            Route::get('/', 'index')->name('saksi');
            Route::get('/tambah_saksi', 'create')->name('saksi.create');
            Route::get('/edit_saksi/{saksi_id}', 'edit')->name('saksi.edit');
            Route::post('/simpan_saksi', 'store')->name('saksi.simpan');
            Route::post('/update_saksi', 'update')->name('saksi.update');
            Route::get('/delete_saksi/{saksi_id}', 'destroy')->name('saksi.delete');
        });
    });
    Route::prefix('capres')->group(function () {
        Route::controller(CapresController::class)->group(function () {
            Route::get('/', 'index')->name('capres');
            Route::get('/tambah_capres', 'create')->name('capres.create');
            Route::get('/edit_capres/{id}', 'edit')->name('capres.edit');
            Route::post('/simpan_capres', 'store')->name('capres.simpan');
            Route::post('/update_capres', 'update')->name('capres.update');
            Route::get('/delete_capres/{id}', 'destroy')->name('capres.delete');
        });
    });
    Route::prefix('hasil_suara')->group(function () {
        Route::controller(HasilSuaraController::class)->group(function () {
            Route::get('/', 'index')->name('suara');
        });
    });
    Route::prefix('suara_masuk')->group(function () {
        Route::controller(SuaraMasukController::class)->group(function () {
            Route::get('/', 'index')->name('suara_masuk');
        });
    });
    Route::prefix('kecamatan')->group(function () {
        Route::controller(KecamatanController::class)->group(function () {
            Route::get('/', 'index')->name('kecamatan');
            Route::get('/tambah_kecamatan', 'create')->name('kecamatan.create');
            Route::post('/simpan_kecamatan', 'store')->name('kecamatan.simpan');
            Route::get('/edit_kecamatan/{id}', 'edit')->name('kecamatan.edit');
            Route::post('/update_kecamatan', 'update')->name('kecamatan.update');
            Route::get('/delete_kecamatan/{id}', 'destroy')->name('kecamatan.delete');
        });
    });
    Route::prefix('kelurahan')->group(function () {
        Route::controller(KeluarahanController::class)->group(function () {
            Route::get('/', 'index')->name('kelurahan');
            Route::get('/tambah_kecamatan', 'create')->name('kelurahan.create');
            Route::post('/simpan_kecamatan', 'store')->name('kelurahan.simpan');
            Route::get('/edit_kecamatan/{id}', 'edit')->name('kelurahan.edit');
            Route::post('/update_kecamatan', 'update')->name('kelurahan.update');
            Route::get('/delete_kecamatan/{id}', 'destroy')->name('kelurahan.delete');
        });
    });
});
