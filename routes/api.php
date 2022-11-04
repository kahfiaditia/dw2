<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/show/{id}', [ChatController::class, 'show']);
Route::get('/show_description/{id}', [ChatController::class, 'show_description']);
Route::get('/contact/{userOne}', [ChatController::class, 'contact']);
Route::get('/converstation/{id}', [ChatController::class, 'converstation']);
Route::get('/message_converstation/{id_converstation}/{me}', [ChatController::class, 'message_converstation']);
Route::post('/store/{id_converstation}/{me}', [ChatController::class, 'store']);
Route::get('/add_converstation/{userTwo}/{me}', [ChatController::class, 'add_converstation']);
Route::delete('/destroy_message/{id}', [ChatController::class, 'destroy_message']);
Route::get('/search/{name}', [ChatController::class, 'name']);
