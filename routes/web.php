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
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/notifikasi', [LoginController::class, 'notifikasi'])->name('notifikasi');
Route::get('/verifikasi/{id}', [LoginController::class, 'verifikasi'])->name('verifikasi');
Route::get('/recovery', [LoginController::class, 'recovery'])->name('recovery');
Route::get('/verify', [LoginController::class, 'verify'])->name('verify');

Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.proses');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
        Route::post('/confirmasi', [LoginController::class, 'confirmasi'])->name('login.confirmasi');
    }
);
