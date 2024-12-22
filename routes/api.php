<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{
    LoginController,
    LogoutController,
    MeController,
    PasswordResetController,
    ProfileController,
    RegisterController,
    SendResetCodeController,
    VerifyResetCodeController,
};

use App\Http\Controllers\Tenant\{
    CategoryController,
    CustomerController,
    OrderController,
    ProductController,
    ResourceController,
    RoleController,
    UserController,
};
use App\Http\Middleware\CheckUserPersmissions;


/** 
 * Auth Routes 
 * */
Route::prefix('auth')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::post('/register', RegisterController::class)->name('register');
        Route::post('/login', LoginController::class)->name('login');
        Route::post('/password/code', SendResetCodeController::class)->name('sendResetCode');
        Route::post('/password/verify', VerifyResetCodeController::class)->name('verifyResetCode');
        Route::post('/password/reset', PasswordResetController::class)->name('reset');
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/me', MeController::class)->name('me');
        Route::put('/profile', ProfileController::class)->name('profile');
        Route::post('/logout', LogoutController::class)->name('logout');
    });
});

/** 
 * Tenant Routes 
 * */
Route::middleware(['auth:sanctum', CheckUserPersmissions::class])->group(function () {
    Route::apiResource('/orders', OrderController::class);
    Route::apiResource('/customers', CustomerController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::get('/resources', [ResourceController::class, 'index'])->name('roles.permissions');
    Route::apiResource('/users', UserController::class);
});
