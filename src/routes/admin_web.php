<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\LoginPageController;
use App\Http\Controllers\Admin\Auth\LogoutPageController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordPageController;
use App\Http\Controllers\Admin\Auth\ProfilePageController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Academic\SchoolClassController;
use App\Http\Controllers\Admin\Academic\ClassController;
use App\Http\Controllers\Admin\Academic\SchoolController;
use App\Http\Controllers\Admin\Academic\SectionController;
use App\Http\Controllers\Admin\Dashboard\OrderController;
use App\Http\Controllers\Admin\Dashboard\BannerController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\UnitController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\ProductImageController;
use App\Http\Controllers\Admin\Product\ProductSpecificationController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\User\ParentUserController;
use App\Http\Controllers\Admin\User\SchoolUserController;

Route::middleware(['guest_admin'])->group(function () {
    Route::get('/sign-in', [LoginPageController::class, 'index', 'as' => 'login.index'])->name('signin');
    Route::post('/sign-in', [LoginPageController::class, 'authenticate', 'as' => 'login.authenticate'])->name('signin_authenticate');
    Route::get('/forgot-password', [ForgotPasswordPageController::class, 'index', 'as' => 'forgot_password.index'])->name('forgot_password');
    Route::post('/forgot-password', [ForgotPasswordPageController::class, 'requestForgotPassword', 'as' => 'forgot_password.requestForgotPassword'])->name('forgot_password_request');
});

Route::middleware(['auth_admin', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index', 'as' => 'admin.dashboard'])->name('dashboard');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfilePageController::class, 'index', 'as' => 'admin.profile'])->name('profile');
        Route::post('/update', [ProfilePageController::class, 'update', 'as' => 'admin.profile_update'])->name('profile_update');
        Route::post('/profile-password-update', [ProfilePageController::class, 'change_profile_password', 'as' => 'admin.change_profile_password'])->name('profile_password_update');
    });

    Route::prefix('/class')->group(function () {
        Route::get('/', [ClassController::class, 'index', 'as' => 'admin.class.view'])->name('class.paginate.get');
        Route::get('/create', [ClassController::class, 'create', 'as' => 'admin.class.create'])->name('class.create.get');
        Route::post('/create', [ClassController::class, 'store', 'as' => 'admin.class.store'])->name('class.create.post');
        Route::get('/excel', [ClassController::class, 'excel', 'as' => 'admin.class.excel'])->name('class.excel.get');
        Route::get('/edit/{id}', [ClassController::class, 'edit', 'as' => 'admin.class.edit'])->name('class.update.get');
        Route::post('/edit/{id}', [ClassController::class, 'update', 'as' => 'admin.class.update'])->name('class.update.post');
        Route::get('/delete/{id}', [ClassController::class, 'delete', 'as' => 'admin.class.delete'])->name('class.delete.get');
    });

    Route::prefix('/section')->group(function () {
        Route::get('/', [SectionController::class, 'index', 'as' => 'admin.section.view'])->name('section.paginate.get');
        Route::get('/create', [SectionController::class, 'create', 'as' => 'admin.section.create'])->name('section.create.get');
        Route::post('/create', [SectionController::class, 'store', 'as' => 'admin.section.store'])->name('section.create.post');
        Route::get('/excel', [SectionController::class, 'excel', 'as' => 'admin.section.excel'])->name('section.excel.get');
        Route::get('/edit/{id}', [SectionController::class, 'edit', 'as' => 'admin.section.edit'])->name('section.update.get');
        Route::post('/edit/{id}', [SectionController::class, 'update', 'as' => 'admin.section.update'])->name('section.update.post');
        Route::get('/delete/{id}', [SectionController::class, 'delete', 'as' => 'admin.section.delete'])->name('section.delete.get');
    });

    Route::prefix('/user')->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/', [AdminUserController::class, 'view', 'as' => 'user.admin.view'])->name('user.admin.paginate.get');
            Route::get('/create', [AdminUserController::class, 'create', 'as' => 'user.admin.create'])->name('user.admin.create.get');
            Route::post('/create', [AdminUserController::class, 'store', 'as' => 'user.admin.store'])->name('user.admin.create.post');
            Route::get('/edit/{id}', [AdminUserController::class, 'edit', 'as' => 'user.admin.edit'])->name('user.admin.update.get');
            Route::post('/edit/{id}', [AdminUserController::class, 'update', 'as' => 'user.admin.update'])->name('user.admin.update.post');
            Route::get('/delete/{id}', [AdminUserController::class, 'delete', 'as' => 'user.admin.delete'])->name('user.admin.delete.get');
        });
        Route::prefix('/parent')->group(function () {
            Route::get('/', [ParentUserController::class, 'view', 'as' => 'user.parent.view'])->name('user.parent.paginate.get');
            Route::get('/create', [ParentUserController::class, 'create', 'as' => 'user.parent.create'])->name('user.parent.create.get');
            Route::post('/create', [ParentUserController::class, 'store', 'as' => 'user.parent.store'])->name('user.parent.create.post');
            Route::get('/edit/{id}', [ParentUserController::class, 'edit', 'as' => 'user.parent.edit'])->name('user.parent.update.get');
            Route::post('/edit/{id}', [ParentUserController::class, 'update', 'as' => 'user.parent.update'])->name('user.parent.update.post');
            Route::get('/delete/{id}', [ParentUserController::class, 'delete', 'as' => 'user.parent.delete'])->name('user.parent.delete.get');
        });
        Route::prefix('/school')->group(function () {
            Route::get('/', [SchoolUserController::class, 'view', 'as' => 'user.school.view'])->name('user.school.paginate.get');
            Route::get('/create', [SchoolUserController::class, 'create', 'as' => 'user.school.create'])->name('user.school.create.get');
            Route::post('/create', [SchoolUserController::class, 'store', 'as' => 'user.school.store'])->name('user.school.create.post');
            Route::get('/edit/{id}', [SchoolUserController::class, 'edit', 'as' => 'user.school.edit'])->name('user.school.update.get');
            Route::post('/edit/{id}', [SchoolUserController::class, 'update', 'as' => 'user.school.update'])->name('user.school.update.post');
            Route::get('/delete/{id}', [SchoolUserController::class, 'delete', 'as' => 'user.school.delete'])->name('user.school.delete.get');
        });
    });

    Route::prefix('/school')->group(function () {
        Route::get('/', [SchoolController::class, 'index', 'as' => 'admin.school.view'])->name('school.paginate.get');
        Route::get('/create', [SchoolController::class, 'create', 'as' => 'admin.school.create'])->name('school.create.get');
        Route::post('/create', [SchoolController::class, 'store', 'as' => 'admin.school.store'])->name('school.create.post');
        Route::get('/excel', [SchoolController::class, 'excel', 'as' => 'admin.school.excel'])->name('school.excel.get');
        Route::get('/edit/{id}', [SchoolController::class, 'edit', 'as' => 'admin.school.edit'])->name('school.update.get');
        Route::post('/edit/{id}', [SchoolController::class, 'update', 'as' => 'admin.school.update'])->name('school.update.post');
        Route::get('/delete/{id}', [SchoolController::class, 'delete', 'as' => 'admin.school.delete'])->name('school.delete.get');
        Route::prefix('/{school_id}/class-section')->group(function () {
            Route::get('/', [SchoolClassController::class, 'index', 'as' => 'admin.school_class.view'])->name('school_class.paginate.get');
            Route::get('/create', [SchoolClassController::class, 'create', 'as' => 'admin.school_class.create'])->name('school_class.create.get');
            Route::post('/create', [SchoolClassController::class, 'store', 'as' => 'admin.school_class.store'])->name('school_class.create.post');
            Route::get('/excel', [SchoolClassController::class, 'excel', 'as' => 'admin.school_class.excel'])->name('school_class.excel.get');
            Route::get('/edit/{id}', [SchoolClassController::class, 'edit', 'as' => 'admin.school_class.edit'])->name('school_class.update.get');
            Route::post('/edit/{id}', [SchoolClassController::class, 'update', 'as' => 'admin.school_class.update'])->name('school_class.update.post');
            Route::get('/delete/{id}', [SchoolClassController::class, 'delete', 'as' => 'admin.school_class.delete'])->name('school_class.delete.get');
        });
    });

    Route::prefix('/product')->group(function () {
        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryController::class, 'index', 'as' => 'admin.category.view'])->name('category.paginate.get');
            Route::get('/create', [CategoryController::class, 'create', 'as' => 'admin.category.create'])->name('category.create.get');
            Route::post('/create', [CategoryController::class, 'store', 'as' => 'admin.category.store'])->name('category.create.post');
            Route::get('/excel', [CategoryController::class, 'excel', 'as' => 'admin.category.excel'])->name('category.excel.get');
            Route::get('/edit/{id}', [CategoryController::class, 'edit', 'as' => 'admin.category.edit'])->name('category.update.get');
            Route::post('/edit/{id}', [CategoryController::class, 'update', 'as' => 'admin.category.update'])->name('category.update.post');
            Route::get('/delete/{id}', [CategoryController::class, 'delete', 'as' => 'admin.category.delete'])->name('category.delete.get');
        });
        Route::prefix('/unit')->group(function () {
            Route::get('/', [UnitController::class, 'index', 'as' => 'admin.unit.view'])->name('unit.paginate.get');
            Route::get('/create', [UnitController::class, 'create', 'as' => 'admin.unit.create'])->name('unit.create.get');
            Route::post('/create', [UnitController::class, 'store', 'as' => 'admin.unit.store'])->name('unit.create.post');
            Route::get('/excel', [UnitController::class, 'excel', 'as' => 'admin.unit.excel'])->name('unit.excel.get');
            Route::get('/edit/{id}', [UnitController::class, 'edit', 'as' => 'admin.unit.edit'])->name('unit.update.get');
            Route::post('/edit/{id}', [UnitController::class, 'update', 'as' => 'admin.unit.update'])->name('unit.update.post');
            Route::get('/delete/{id}', [UnitController::class, 'delete', 'as' => 'admin.unit.delete'])->name('unit.delete.get');
        });
        Route::prefix('/item')->group(function () {
            Route::get('/', [ProductController::class, 'index', 'as' => 'admin.product.view'])->name('product.paginate.get');
            Route::get('/create', [ProductController::class, 'create', 'as' => 'admin.product.create'])->name('product.create.get');
            Route::post('/create', [ProductController::class, 'store', 'as' => 'admin.product.store'])->name('product.create.post');
            Route::get('/excel', [ProductController::class, 'excel', 'as' => 'admin.product.excel'])->name('product.excel.get');
            Route::get('/edit/{id}', [ProductController::class, 'edit', 'as' => 'admin.product.edit'])->name('product.update.get');
            Route::post('/edit/{id}', [ProductController::class, 'update', 'as' => 'admin.product.update'])->name('product.update.post');
            Route::get('/delete/{id}', [ProductController::class, 'delete', 'as' => 'admin.product.delete'])->name('product.delete.get');
        });
        Route::prefix('/{product_id}/images')->group(function () {
            Route::get('/', [ProductImageController::class, 'index', 'as' => 'admin.product_image.view'])->name('product_image.paginate.get');
            Route::post('/create', [ProductImageController::class, 'store', 'as' => 'admin.product_image.store'])->name('product_image.create.post');
            Route::get('/delete/{id}', [ProductImageController::class, 'delete', 'as' => 'admin.product_image.delete'])->name('product_image.delete.get');
        });
        Route::prefix('/{product_id}/specification')->group(function () {
            Route::get('/', [ProductSpecificationController::class, 'index', 'as' => 'admin.product_specification.view'])->name('product_specification.paginate.get');
            Route::get('/create', [ProductSpecificationController::class, 'create', 'as' => 'admin.product_specification.create'])->name('product_specification.create.get');
            Route::post('/create', [ProductSpecificationController::class, 'store', 'as' => 'admin.product_specification.store'])->name('product_specification.create.post');
            Route::get('/excel', [ProductSpecificationController::class, 'excel', 'as' => 'admin.product_specification.excel'])->name('product_specification.excel.get');
            Route::get('/edit/{id}', [ProductSpecificationController::class, 'edit', 'as' => 'admin.product_specification.edit'])->name('product_specification.update.get');
            Route::post('/edit/{id}', [ProductSpecificationController::class, 'update', 'as' => 'admin.product_specification.update'])->name('product_specification.update.post');
            Route::get('/delete/{id}', [ProductSpecificationController::class, 'delete', 'as' => 'admin.product_specification.delete'])->name('product_specification.delete.get');
        });
    });

    Route::prefix('/banner-images')->group(function () {
        Route::get('/', [BannerController::class, 'index', 'as' => 'admin.banner.view'])->name('banner.paginate.get');
        Route::post('/create', [BannerController::class, 'store', 'as' => 'admin.banner.store'])->name('banner.create.post');
        Route::get('/delete/{id}', [BannerController::class, 'delete', 'as' => 'admin.banner.delete'])->name('banner.delete.get');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index', 'as' => 'admin.order.view'])->name('admin_order.paginate.get');
        Route::get('/detail/{id}', [OrderController::class, 'detail', 'as' => 'admin.order.detail'])->name('admin_order.detail.get');
        Route::get('/cancel-order/{id}', [OrderController::class, 'cancel_order', 'as' => 'admin.order.cancel_order'])->name('admin_order.cancel.get');
        Route::get('/update-order-status/{id}', [OrderController::class, 'update_order_status', 'as' => 'admin.order.update_order_status'])->name('admin_order.update_order_status.get');
    });

});

Route::get('/sign-out', [LogoutPageController::class, 'logout', 'as' => 'logout.index'])->middleware(['auth_admin', 'admin'])->name('signout');
