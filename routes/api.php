<?php

use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiManagerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/managers', [ApiManagerController::class, 'index']);
Route::get('/admins', [ApiAdminController::class, 'index']);

