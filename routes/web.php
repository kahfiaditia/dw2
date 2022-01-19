<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KodeposController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/notifikasi', [LoginController::class, 'notifikasi'])->name('notifikasi');
Route::get('/verifikasi/{id}', [LoginController::class, 'verifikasi'])->name('verifikasi');
Route::get('/recovery', [LoginController::class, 'recovery'])->name('recovery');
Route::get('/reverify', [LoginController::class, 'reverify'])->name('reverify');
Route::get('/reset/{id}', [LoginController::class, 'reset'])->name('reset');

Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/proses', [LoginController::class, 'authenticate'])->name('login.proses');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
        Route::post('/confirmasi', [LoginController::class, 'confirmasi'])->name('login.confirmasi');
        Route::post('/reverifycode', [LoginController::class, 'reverifycode'])->name('login.reverifycode');
        Route::post('/resetcode', [LoginController::class, 'resetcode'])->name('login.resetcode');
        Route::post('/newpassword', [LoginController::class, 'newpassword'])->name('login.newpassword');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
    }
);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::group(
    [
        'prefix' => 'employee',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::get('/show', [EmployeeController::class, 'show'])->name('employee.show');
        Route::post('/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/destroy', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    }
);

Route::group(
    [
        'prefix'     => 'kodepos',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [KodeposController::class, 'index'])->name('kodepos');
        Route::get('/create', [KodeposController::class, 'create'])->name('kodepos.create');
        Route::post('/store', [KodeposController::class, 'store'])->name('kodepos.store');
        Route::get('/edit/{id}', [KodeposController::class, 'edit'])->name('kodepos.edit');
        Route::post('/update', [KodeposController::class, 'update'])->name('kodepos.update');
        Route::get('/destroy', [KodeposController::class, 'destroy'])->name('kodepos.destroy');
        Route::post('/dropdown', [KodeposController::class, 'dropdown'])->name('kodepos.dropdown');
        Route::post('/provinsi', [KodeposController::class, 'provinsi'])->name('kodepos.dropdown.provinsi');
        Route::post('/kota', [KodeposController::class, 'kota'])->name('kodepos.dropdown.kota');
        Route::post('/kecamatan', [KodeposController::class, 'kecamatan'])->name('kodepos.dropdown.kecamatan');
        Route::post('/kelurahan', [KodeposController::class, 'kelurahan'])->name('kodepos.dropdown.kelurahan');
        Route::get('/data_ajax', [KodeposController::class, 'data_ajax'])->name('kodepos.data_ajax');
    }
);

Route::group(
    [
        'prefix'     => 'agama',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [AgamaController::class, 'index'])->name('agama');
        Route::get('/create', [AgamaController::class, 'create'])->name('agama.create');
        Route::post('/store', [AgamaController::class, 'store'])->name('agama.store');
        Route::get('/edit/{id}', [AgamaController::class, 'edit'])->name('agama.edit');
        Route::post('/update', [AgamaController::class, 'update'])->name('agama.update');
        Route::delete('/destroy', [AgamaController::class, 'destroy'])->name('agama.destroy');
        Route::post('/dropdown', [AgamaController::class, 'dropdown'])->name('agama.dropdown');
    }
);

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::resource('/siswa', SiswaController::class);
    }
);
