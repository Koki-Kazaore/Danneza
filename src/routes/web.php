<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleFitController;

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
    return view('welcome');
});

// OAuth
Route::get('login/google', [GoogleFitController::class, 'redirectToProvider'])->name('login.google');
Route::get('callback/google', [GoogleFitController::class, 'handleProviderCallback']);

// 歩数取得
Route::get('steps', [GoogleFitController::class, 'showSteps'])->name('show.steps');