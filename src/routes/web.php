<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\ResetPasswordPageController;
use App\Http\Controllers\Admin\Auth\VerifyRegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function () {
    Route::get('/reset-password/{token}', [ResetPasswordPageController::class, 'index', 'as' => 'reset_password.index'])->name('reset_password')->middleware('signed');
    Route::post('/reset-password/{token}', [ResetPasswordPageController::class, 'requestResetPassword', 'as' => 'reset_password.requestResetPassword'])->name('reset_password_request')->middleware('signed');
});

Route::prefix('/email/verify')->middleware(['auth'])->group(function () {
    Route::get('/', [VerifyRegisteredUserController::class, 'index', 'as' => 'index'])->name('verification.notice');
    Route::post('/resend-notification', [VerifyRegisteredUserController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::get('/{id}/{hash}', [VerifyRegisteredUserController::class, 'verify_email', 'as' => 'verify_email'])->middleware(['signed'])->name('verification.verify');
});
