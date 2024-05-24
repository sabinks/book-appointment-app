<?php

use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home', ['name' => 'Sabin KS'])->name('home');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/contact', 'Contact')->name('contact');



Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('guest')->group(function () {
    Route::inertia('/login', 'Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::inertia('/register', 'Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
