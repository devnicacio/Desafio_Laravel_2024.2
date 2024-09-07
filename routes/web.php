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
    Route::get('/manager-show-edit-user/{user}', [ManagerController::class, 'showEditUser'])->name('manager-show-edit');
    Route::get('/manager-show-create-user', [ManagerController::class, 'showCreateUser'])->name('manager-show-create-user');
    Route::get('/manager-show-edit-manager', [ManagerController::class, 'showEditManager'])->name('manager-show-edit-manager');
    Route::get('/manager-show-withdraw', [ManagerController::class, 'showWithdraw'])->name('manager-show-withdraw');

    Route::put('/manager-update-manager', [ManagerController::class, 'updateManager'])->name('manager-update-manager');
    Route::put('/manager-update-user/{user}', [ManagerController::class, 'updateUser'])->name('manager-update-user');
    Route::delete('/manager-delete-user/{user}', [ManagerController::class, 'deleteUser'])->name('manager-delete-user');
    Route::post('/manager-store-user', [ManagerController::class, 'storeUser'])->name('manager-store-user');
    Route::post('/manager-store-user', [ManagerController::class, 'storeUser'])->name('manager-store-user');
    Route::post('/manager-store-withdraw', [ManagerController::class, 'storeWithdraw'])->name('manager-store-withdraw');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
