<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.dashboard', ['title' => 'Dashboard']);
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('layouts.profiledashboard.profile', ['title' => 'Profile']);
    })->name('profile');

    // Update Profile
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Update Password
    Route::put('/profile/password', [PasswordController::class, 'update'])->name('profile.password.update');

    //Projects
    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects');
    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->name('projects.update');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy');
});

require __DIR__ . '/auth.php';
