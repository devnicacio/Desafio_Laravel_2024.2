<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('web')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('admin')->group(function () {
    Route::get('/dashboardAdmin', function () {
        echo Auth::guard('admin')->user()->name;
    })->name('dashboardAdmin');
});

Route::middleware('manager')->group(function () {
    Route::get('/manager-dashboard', [ManagerController::class, 'index'])->name('manager-dashboard');
    Route::get('/manager-user-list', [ManagerController::class, 'userlist'])->name('manager-user-list');
    Route::get('/manager-show-user/{user}', [ManagerController::class, 'showUser'])->name('manager-show-user');
    Route::get('/manager-show-edit/{user}', [ManagerController::class, 'showEdit'])->name('manager-show-edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
