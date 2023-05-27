<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Main\Auth\LoginPageController;
use App\Http\Controllers\Main\Auth\LogoutPageController;
use App\Http\Controllers\Main\Auth\RegisterPageController;
use App\Http\Controllers\Main\Auth\ForgotPasswordPageController;
use App\Http\Controllers\Main\Auth\ResetPasswordPageController;
use App\Http\Controllers\Main\Auth\ProfilePageController;
use App\Http\Controllers\Main\Auth\VerifyRegisteredUserController;
use App\Http\Controllers\Main\Dashboard\ClientController;
use App\Http\Controllers\Main\Dashboard\DashboardController;
use App\Http\Controllers\Main\Dashboard\ProjectController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('signin');
    Route::post('/sign-in', [LoginPageController::class, 'authenticate', 'as' => 'login.authenticate'])->name('signin_authenticate');
    Route::get('/sign-up', [RegisterPageController::class, 'index', 'as' => 'register.index'])->name('signup');
    Route::post('/sign-up', [RegisterPageController::class, 'store', 'as' => 'register.store'])->name('signup_store');
    Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('forgot_password');
    Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('forgot_password_request');
    Route::get('/reset-password/{token}', [ResetPasswordPageController::class, 'index', 'as' => 'reset_password.index'])->name('reset_password')->middleware('signed');
    Route::post('/reset-password/{token}', [ResetPasswordPageController::class, 'requestResetPassword', 'as' => 'reset_password.requestResetPassword'])->name('reset_password_request')->middleware('signed');
});

Route::prefix('/email/verify')->middleware(['auth'])->group(function () {
    Route::get('/', [VerifyRegisteredUserController::class, 'index', 'as' => 'index'])->name('verification.notice');
    Route::post('/resend-notification', [VerifyRegisteredUserController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['throttle:6,1'])->name('verification.send');
    Route::get('/{id}/{hash}', [VerifyRegisteredUserController::class, 'verify_email', 'as' => 'verify_email'])->middleware(['signed'])->name('verification.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfilePageController::class, 'index', 'as' => 'admin.profile'])->name('profile');
        Route::post('/update', [ProfilePageController::class, 'update', 'as' => 'admin.profile_update'])->name('profile_update');
        Route::post('/profile-password-update', [ProfilePageController::class, 'change_profile_password', 'as' => 'admin.change_profile_password'])->name('profile_password_update');
    });

    Route::prefix('/client')->group(function () {
        Route::get('/', [ClientController::class, 'index', 'as' => 'admin.client.view'])->name('client.paginate.get');
        Route::get('/create', [ClientController::class, 'create', 'as' => 'admin.client.create'])->name('client.create.get');
        Route::post('/create', [ClientController::class, 'store', 'as' => 'admin.client.store'])->name('client.create.post');
        Route::get('/excel', [ClientController::class, 'excel', 'as' => 'admin.client.excel'])->name('client.excel.get');
        Route::get('/edit/{id}', [ClientController::class, 'edit', 'as' => 'admin.client.edit'])->name('client.update.get');
        Route::post('/edit/{id}', [ClientController::class, 'update', 'as' => 'admin.client.update'])->name('client.update.post');
        Route::get('/delete/{id}', [ClientController::class, 'delete', 'as' => 'admin.client.delete'])->name('client.delete.get');
    });

    Route::prefix('/project')->group(function () {
        Route::get('/', [ProjectController::class, 'index', 'as' => 'admin.project.view'])->name('project.paginate.get');
        Route::get('/create', [ProjectController::class, 'create', 'as' => 'admin.project.create'])->name('project.create.get');
        Route::post('/create', [ProjectController::class, 'store', 'as' => 'admin.project.store'])->name('project.create.post');
        Route::get('/excel', [ProjectController::class, 'excel', 'as' => 'admin.project.excel'])->name('project.excel.get');
        Route::get('/edit/{id}', [ProjectController::class, 'edit', 'as' => 'admin.project.edit'])->name('project.update.get');
        Route::post('/edit/{id}', [ProjectController::class, 'update', 'as' => 'admin.project.update'])->name('project.update.post');
        Route::get('/delete/{id}', [ProjectController::class, 'delete', 'as' => 'admin.project.delete'])->name('project.delete.get');
    });

});

Route::get('/sign-out', [LogoutPageController::class, 'logout', 'as' => 'logout.index'])->middleware(['auth'])->name('signout');
