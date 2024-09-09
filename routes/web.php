<?php

use App\Http\Controllers\AdminController;
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
    Route::get('/admin-dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin-dashboard');
});

Route::middleware('manager')->group(function () {
    Route::get('/manager-dashboard', [ManagerController::class, 'index'])->name('manager-dashboard');
    Route::get('/manager-user-list', [ManagerController::class, 'userlist'])->name('manager-user-list');
    Route::get('/manager-show-user/{user}', [ManagerController::class, 'showUser'])->name('manager-show-user');
    Route::get('/manager-show-edit-user/{user}', [ManagerController::class, 'showEditUser'])->name('manager-show-edit');
    Route::get('/manager-show-create-user', [ManagerController::class, 'showCreateUser'])->name('manager-show-create-user');
    Route::get('/manager-show-edit-manager', [ManagerController::class, 'showEditManager'])->name('manager-show-edit-manager');
    Route::get('/manager-show-withdraw', [ManagerController::class, 'showWithdraw'])->name('manager-show-withdraw');
    Route::get('/manager-show-deposit', [ManagerController::class, 'showDeposit'])->name('manager-show-deposit');
    Route::get('/manager-show-transfer', [ManagerController::class, 'showTransfer'])->name('manager-show-transfer');
    Route::get('/manager-show-loan', [ManagerController::class, 'showLoan'])->name('manager-show-loan');
    Route::get('/manager-show-pendencies', [ManagerController::class, 'showPendencies'])->name('manager-show-pendencies');
    Route::get('/manager-show-loans', [ManagerController::class, 'showLoans'])->name('manager-show-loans');
    Route::get('/manager-show-statement', [ManagerController::class, 'showstatement'])->name('manager-show-statement');

    Route::post('/manager-store-user', [ManagerController::class, 'storeUser'])->name('manager-store-user');
    Route::post('/manager-store-user', [ManagerController::class, 'storeUser'])->name('manager-store-user');
    Route::post('/manager-store-withdraw', [ManagerController::class, 'storeWithdraw'])->name('manager-store-withdraw');
    Route::post('/manager-store-deposit', [ManagerController::class, 'storeDeposit'])->name('manager-store-deposit');
    Route::post('/manager-store-transfer', [ManagerController::class, 'storeTransfer'])->name('manager-store-transfer');
    Route::post('/manager-store-loan', [ManagerController::class, 'storeLoan'])->name('manager-store-loan');
    Route::post('/manager-pay-loan', [ManagerController::class, 'payLoan'])->name('manager-pay-loan');
    Route::post('/manager-accept-loan/{loan}', [ManagerController::class, 'acceptLoan'])->name('manager-accept-loan');

    Route::put('/manager-update-manager', [ManagerController::class, 'updateManager'])->name('manager-update-manager');
    Route::put('/manager-update-user/{user}', [ManagerController::class, 'updateUser'])->name('manager-update-user');

    Route::delete('/manager-delete-user/{user}', [ManagerController::class, 'deleteUser'])->name('manager-delete-user');
    Route::delete('/manager-accept-pendencie/{transferPendencie}', [ManagerController::class, 'acceptPendencie'])->name('manager-accept-pendencie');
    Route::delete('/manager-deny-pendencie/{transferPendencie}', [ManagerController::class, 'denyPendencie'])->name('manager-deny-pendencie');
    Route::delete('/manager-deny-loan/{loan}', [ManagerController::class, 'denyLoan'])->name('manager-deny-loan');
    Route::delete('/manager-delete-manager', [ManagerController::class, 'deleteManager'])->name('manager-delete-manager');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
