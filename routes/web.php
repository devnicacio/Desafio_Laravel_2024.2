<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('web')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user-dashboard');
    Route::get('/user-show-edit-profile', [UserController::class, 'ShowEditProfile'])->name('user-show-edit-profile');
    Route::get('/user-show-withdraw', [UserController::class, 'ShowEditProfile'])->name('user-show-edit-profile');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'dashboardAdmin'])->name('admin-dashboard');
    Route::get('/admin-show-edit-profile', [AdminController::class, 'showEditProfile'])->name('admin-show-edit-profile');
    Route::get('/admin-show-user-list', [AdminController::class, 'showUserList'])->name('admin-show-user-list');
    Route::get('/admin-show-create-user', [AdminController::class, 'showCreateUser'])->name('admin-show-create-user');
    Route::get('/admin-show-user/{user}', [AdminController::class, 'showUser'])->name('admin-show-user');
    Route::get('/admin-show-edit-user/{user}', [AdminController::class, 'showEditUser'])->name('admin-show-edit-user');
    Route::get('/admin-show-manager-list', [AdminController::class, 'showManagerList'])->name('admin-show-manager-list');
    Route::get('/admin-show-manager/{user}', [AdminController::class, 'showManager'])->name('admin-show-manager');
    Route::get('/admin-show-edit-manager/{user}', [AdminController::class, 'showEditManager'])->name('admin-show-edit-manager');
    Route::get('/admin-show-create-manager', [AdminController::class, 'showCreateManager'])->name('admin-show-create-manager');
    Route::get('/admin-show-admin-list', [AdminController::class, 'showAdminList'])->name('admin-show-admin-list');
    Route::get('/admin-show-admin/{user}', [AdminController::class, 'showAdmin'])->name('admin-show-admin');
    Route::get('/admin-show-edit-admin/{user}', [AdminController::class, 'showEditAdmin'])->name('admin-show-edit-admin');
    Route::get('/admin-show-create-admin', [AdminController::class, 'showCreateAdmin'])->name('admin-show-create-admin');
    Route::get('/admin-show-pendencies', [AdminController::class, 'showPendencies'])->name('admin-show-pendencies');
    Route::get('/admin-show-loans', [AdminController::class, 'showLoans'])->name('admin-show-loans');

    Route::post('/admin-create-user', [AdminController::class, 'createUser'])->name('admin-create-user');
    Route::post('/admin-create-manager', [AdminController::class, 'createManager'])->name('admin-create-manager');
    Route::post('/admin-create-admin', [AdminController::class, 'createAdmin'])->name('admin-create-admin');
    Route::post('/admin-accept-loan/{loan}', [AdminController::class, 'acceptLoan'])->name('admin-accept-loan');
    
    Route::put('/admin-update-profile', [AdminController::class, 'profileUpdate'])->name('admin-update-profile');
    Route::put('/admin-update-user/{user}', [AdminController::class, 'updateUser'])->name('admin-update-user');
    Route::put('/admin-update-manager/{user}', [AdminController::class, 'updateManager'])->name('admin-update-manager');
    Route::put('/admin-update-admin/{user}', [AdminController::class, 'updateAdmin'])->name('admin-update-admin');
    

    Route::delete('/admin-delete-profile', [AdminController::class, 'deleteProfile'])->name('admin-delete-profile');
    Route::delete('/admin-delete-profile', [AdminController::class, 'deleteProfile'])->name('admin-delete-profile');
    Route::delete('/admin-delete-user/{user}', [AdminController::class, 'deleteUser'])->name('admin-delete-user');
    Route::delete('/admin-delete-manager/{user}', [AdminController::class, 'deleteManager'])->name('admin-delete-manager');
    Route::delete('/admin-delete-admin/{user}', [AdminController::class, 'deleteAdmin'])->name('admin-delete-admin');
    Route::delete('/admin-accept-pendencie/{transferPendencie}', [AdminController::class, 'acceptPendencie'])->name('admin-accept-pendencie');
    Route::delete('/admin-deny-pendencie/{transferPendencie}', [AdminController::class, 'denyPendencie'])->name('admin-deny-pendencie');
    Route::delete('/admin-deny-loan/{loan}', [AdminController::class, 'denyLoan'])->name('admin-deny-loan');
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
    Route::post('/generatepdf', [ManagerController::class, 'generatePdf'])->name('generatepdf');

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
