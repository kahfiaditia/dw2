<?php

use App\Http\Controllers\LoginController;
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

Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.proses');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
        Route::get('/register', [LoginController::class, 'register'])->name('login.register');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
        Route::get('/success', [LoginController::class, 'success'])->name('login.success');
        Route::get('/verifikasi/{id}', [LoginController::class, 'verifikasi'])->name('login.verifikasi');
        Route::post('/confirmasi', [LoginController::class, 'confirmasi'])->name('login.confirmasi');
        Route::get('/recovery', [LoginController::class, 'recovery'])->name('login.recovery');
    }
);
