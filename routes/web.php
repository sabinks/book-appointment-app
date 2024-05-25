<?php

use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookAppointmentController;
use App\Http\Controllers\Front\BookAppointmentController as FrontBookAppointmentController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home', ['name' => 'Sabin KS'])->name('home');
Route::inertia('/about', 'About')->name('about');
Route::inertia('/contact', 'Contact')->name('contact');
Route::get('/book-appointment', [FrontBookAppointmentController::class, 'index'])->name('book-appointment');
Route::post('book-appointment', [FrontBookAppointmentController::class, 'store']);
Route::inertia('/forgot-password', 'ForgotPassword');
Route::inertia('/reset-password', 'ResetPassword');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset_password');

Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('appointments', BookAppointmentController::class);
});
Route::middleware('guest')->group(function () {
    Route::inertia('/login', 'Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::inertia('/register', 'Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
