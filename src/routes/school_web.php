<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\School\Auth\LoginPageController;
use App\Http\Controllers\School\Auth\LogoutPageController;
use App\Http\Controllers\School\Auth\ForgotPasswordPageController;
use App\Http\Controllers\School\Auth\ProfilePageController;
use App\Http\Controllers\School\Auth\RegisterPageController;
use App\Http\Controllers\School\Dashboard\AddressController;
use App\Http\Controllers\School\Dashboard\CartController;
use App\Http\Controllers\School\Dashboard\DashboardController;
use App\Http\Controllers\School\Dashboard\KidController;
use App\Http\Controllers\School\Dashboard\OrderController;
use App\Http\Controllers\School\Dashboard\ProductController;

Route::middleware(['guest_school'])->group(function () {
    Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('school_signin');
    Route::post('/sign-in', [LoginPageController::class, 'authenticate', 'as' => 'login.authenticate'])->name('school_signin_authenticate');
    Route::get('/sign-up', [RegisterPageController::class, 'index', 'as' => 'register.index'])->name('school_register');
    Route::post('/sign-up', [RegisterPageController::class, 'post', 'as' => 'register.post'])->name('school_register_post');
    Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('school_forgot_password');
    Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('school_forgot_password_request');
});

Route::middleware(['auth_school', 'verified', 'school'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'school.dashboard'])->name('school_dashboard');
    Route::get('/product/{id}', [ProductController::class, 'index', 'as' => 'school.product_detail'])->name('school_product_detail');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfilePageController::class, 'index', 'as' => 'school.profile'])->name('school_profile');
        Route::post('/update', [ProfilePageController::class, 'update', 'as' => 'school.profile_update'])->name('school_profile_update');
        Route::post('/profile-password-update', [ProfilePageController::class, 'change_profile_password', 'as' => 'school.change_profile_password'])->name('school_profile_password_update');
    });

    Route::prefix('/cart')->group(function () {
        Route::post('/save', [CartController::class, 'save_cart', 'as' => 'school.save_cart'])->name('school_save_cart');
        Route::get('/checkout', [CartController::class, 'checkout', 'as' => 'school.checkout_cart'])->name('school_checkout_cart');
        Route::get('/delete/{id}', [CartController::class, 'delete_cart', 'as' => 'school.delete_cart'])->name('school_delete_cart');
        Route::get('/edit/{id}', [CartController::class, 'edit_cart', 'as' => 'school.edit_cart'])->name('school_edit_cart');
        Route::post('/update/{id}', [CartController::class, 'update_cart', 'as' => 'school.update_cart'])->name('school_update_cart');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index', 'as' => 'school.order.view'])->name('school_order.paginate.get');
        Route::get('/detail/{id}', [OrderController::class, 'detail', 'as' => 'school.order.detail'])->name('school_order.detail.get');
        Route::get('/make-payment/{id}', [OrderController::class, 'make_payment', 'as' => 'school.order.make_payment'])->name('school_order.make_payment.get');
        Route::post('/verify-payment/{id}', [OrderController::class, 'verify_payment', 'as' => 'school.order.verify_payment'])->name('school_order.verify_payment.get');
        Route::get('/cancel-order/{id}', [OrderController::class, 'cancel_order', 'as' => 'school.order.cancel_order'])->name('school_order.cancel.get');
        Route::get('/edit-item-size/{id}', [OrderController::class, 'edit_order', 'as' => 'school.edit_order'])->name('school_edit_order');
        Route::post('/update-item-size/{id}', [OrderController::class, 'update_order', 'as' => 'school.update_order'])->name('school_update_order');
        Route::post('/place', [OrderController::class, 'place_order', 'as' => 'school.place_order'])->name('school_place_order');
    });

    Route::prefix('/address')->group(function () {
        Route::get('/', [AddressController::class, 'index', 'as' => 'school.address.view'])->name('school_address.paginate.get');
        Route::get('/create', [AddressController::class, 'create', 'as' => 'school.address.create'])->name('school_address.create.get');
        Route::post('/create', [AddressController::class, 'store', 'as' => 'school.address.store'])->name('school_address.create.post');
        Route::get('/edit/{id}', [AddressController::class, 'edit', 'as' => 'school.address.edit'])->name('school_address.update.get');
        Route::post('/edit/{id}', [AddressController::class, 'update', 'as' => 'school.address.update'])->name('school_address.update.post');
        Route::get('/delete/{id}', [AddressController::class, 'delete', 'as' => 'school.address.delete'])->name('school_address.delete.get');
    });

    Route::prefix('/kid')->group(function () {
        Route::get('/', [KidController::class, 'index', 'as' => 'school.kid.view'])->name('school_kid.paginate.get');
        Route::get('/create', [KidController::class, 'create', 'as' => 'school.kid.create'])->name('school_kid.create.get');
        Route::post('/create', [KidController::class, 'store', 'as' => 'school.kid.store'])->name('school_kid.create.post');
        Route::get('/edit/{id}', [KidController::class, 'edit', 'as' => 'school.kid.edit'])->name('school_kid.update.get');
        Route::post('/edit/{id}', [KidController::class, 'update', 'as' => 'school.kid.update'])->name('school_kid.update.post');
        Route::get('/delete/{id}', [KidController::class, 'delete', 'as' => 'school.kid.delete'])->name('school_kid.delete.get');
    });

});

Route::get('/sign-out', [LogoutPageController::class, 'logout', 'as' => 'logout.index'])->middleware(['auth'])->name('school_signout');
