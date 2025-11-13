<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Patient\DiagnosticCenterController;
use App\Http\Controllers\Patient\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::get('patient/profile', [ProfileController::class, 'edit'])->name('patient.profile.edit');
    Route::put('patient/profile', [ProfileController::class, 'update'])->name('patient.profile.update');
});

Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::view('dashboard', 'patient.dashboard')->name('dashboard');
    Route::get('patient/diagnostic-centers', [DiagnosticCenterController::class, 'index'])
        ->name('patient.diagnostic-centers.index');
    Route::post('patient/diagnostic-centers/select', [DiagnosticCenterController::class, 'select'])
        ->name('patient.diagnostic-centers.select');
    Route::view('patient/symptoms', 'patient.enter-symptoms')
        ->name('patient.symptoms.create');
});
