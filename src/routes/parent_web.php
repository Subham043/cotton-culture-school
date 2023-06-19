<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Parent\Auth\LoginPageController;
use App\Http\Controllers\Parent\Auth\LogoutPageController;
use App\Http\Controllers\Parent\Auth\ForgotPasswordPageController;
use App\Http\Controllers\Parent\Auth\ProfilePageController;
use App\Http\Controllers\Parent\Auth\RegisterPageController;
use App\Http\Controllers\Parent\Dashboard\AddressController;
use App\Http\Controllers\Parent\Dashboard\CartController;
use App\Http\Controllers\Parent\Dashboard\DashboardController;
use App\Http\Controllers\Parent\Dashboard\KidController;
use App\Http\Controllers\Parent\Dashboard\OrderController;
use App\Http\Controllers\Parent\Dashboard\ProductController;

Route::middleware(['guest'])->group(function () {
    Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('parent_signin');
    Route::post('/sign-in', [LoginPageController::class, 'authenticate', 'as' => 'login.authenticate'])->name('parent_signin_authenticate');
    Route::get('/sign-up', [RegisterPageController::class, 'index', 'as' => 'register.index'])->name('parent_register');
    Route::post('/sign-up', [RegisterPageController::class, 'post', 'as' => 'register.post'])->name('parent_register_post');
    Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('parent_forgot_password');
    Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('parent_forgot_password_request');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'parent.dashboard'])->name('parent_dashboard');
    Route::get('/product/{id}', [ProductController::class, 'index', 'as' => 'parent.product_detail'])->name('parent_product_detail');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfilePageController::class, 'index', 'as' => 'parent.profile'])->name('parent_profile');
        Route::post('/update', [ProfilePageController::class, 'update', 'as' => 'parent.profile_update'])->name('parent_profile_update');
        Route::post('/profile-password-update', [ProfilePageController::class, 'change_profile_password', 'as' => 'parent.change_profile_password'])->name('parent_profile_password_update');
    });

    Route::prefix('/cart')->group(function () {
        Route::post('/save', [CartController::class, 'save_cart', 'as' => 'parent.save_cart'])->name('parent_save_cart');
        Route::get('/checkout', [CartController::class, 'checkout', 'as' => 'parent.checkout_cart'])->name('checkout_cart');
        Route::get('/delete/{id}', [CartController::class, 'delete_cart', 'as' => 'parent.delete_cart'])->name('parent_delete_cart');
        Route::get('/edit/{id}', [CartController::class, 'edit_cart', 'as' => 'parent.edit_cart'])->name('parent_edit_cart');
        Route::post('/update/{id}', [CartController::class, 'update_cart', 'as' => 'parent.update_cart'])->name('parent_update_cart');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index', 'as' => 'parent.order.view'])->name('order.paginate.get');
        Route::get('/detail/{id}', [OrderController::class, 'detail', 'as' => 'parent.order.detail'])->name('order.detail.get');
        Route::get('/make-payment/{id}', [OrderController::class, 'make_payment', 'as' => 'parent.order.make_payment'])->name('order.make_payment.get');
        Route::post('/verify-payment/{id}', [OrderController::class, 'verify_payment', 'as' => 'parent.order.verify_payment'])->name('order.verify_payment.get');
        Route::get('/cancel-order/{id}', [OrderController::class, 'cancel_order', 'as' => 'parent.order.cancel_order'])->name('order.cancel.get');
        Route::get('/edit-item-size/{id}', [OrderController::class, 'edit_order', 'as' => 'parent.edit_order'])->name('parent_edit_order');
        Route::post('/update-item-size/{id}', [OrderController::class, 'update_order', 'as' => 'parent.update_order'])->name('parent_update_order');
        Route::post('/place', [OrderController::class, 'place_order', 'as' => 'parent.place_order'])->name('parent_place_order');
    });

    Route::prefix('/address')->group(function () {
        Route::get('/', [AddressController::class, 'index', 'as' => 'parent.address.view'])->name('address.paginate.get');
        Route::get('/create', [AddressController::class, 'create', 'as' => 'parent.address.create'])->name('address.create.get');
        Route::post('/create', [AddressController::class, 'store', 'as' => 'parent.address.store'])->name('address.create.post');
        Route::get('/edit/{id}', [AddressController::class, 'edit', 'as' => 'parent.address.edit'])->name('address.update.get');
        Route::post('/edit/{id}', [AddressController::class, 'update', 'as' => 'parent.address.update'])->name('address.update.post');
        Route::get('/delete/{id}', [AddressController::class, 'delete', 'as' => 'parent.address.delete'])->name('address.delete.get');
    });

    Route::prefix('/kid')->group(function () {
        Route::get('/', [KidController::class, 'index', 'as' => 'parent.kid.view'])->name('kid.paginate.get');
        Route::get('/create', [KidController::class, 'create', 'as' => 'parent.kid.create'])->name('kid.create.get');
        Route::post('/create', [KidController::class, 'store', 'as' => 'parent.kid.store'])->name('kid.create.post');
        Route::get('/edit/{id}', [KidController::class, 'edit', 'as' => 'parent.kid.edit'])->name('kid.update.get');
        Route::post('/edit/{id}', [KidController::class, 'update', 'as' => 'parent.kid.update'])->name('kid.update.post');
        Route::get('/delete/{id}', [KidController::class, 'delete', 'as' => 'parent.kid.delete'])->name('kid.delete.get');
    });

});

Route::get('/sign-out', [LogoutPageController::class, 'logout', 'as' => 'logout.index'])->middleware(['auth'])->name('parent_signout');
