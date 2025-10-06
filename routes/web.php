<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MccClassifierController;
use App\Http\Controllers\HypothesisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('/for-business', 'pages.for-business')->name('pages.for-business');
Route::view('/for-government', 'pages.for-government')->name('pages.for-government');
Route::view('/for-banks', 'pages.for-banks')->name('pages.for-banks');
Route::view('/for-all', 'pages.for-all')->name('pages.for-all');

Route::get('/classifier', [MccClassifierController::class, 'show'])->name('classifier.show');
Route::post('/classifier', [MccClassifierController::class, 'classify'])->name('classifier.classify');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::view('/hypothesis', 'hypothesis.create')->name('hypothesis.create');
    Route::post('/hypothesis', [HypothesisController::class, 'store'])->name('hypothesis.store');
    Route::post('/hypothesis/classify', [MccClassifierController::class, 'classifyAsync'])->name('hypothesis.classify');
});

