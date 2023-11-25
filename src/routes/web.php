<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleFitController;
use App\Http\Controllers\Auth\LoginController;

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

// welcome画面
Route::get('/', function () {
    return view('welcome');
});

// OAuthログイン
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('callback/google', [LoginController::class, 'handleGoogleCallback']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {    
    // 歩数取得
    Route::get('steps', [GoogleFitController::class, 'showSteps'])->name('show.steps');
});
