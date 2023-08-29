<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->as('api::v1::')->group(function (): void {
    Route::prefix('/admin')->as('admin::')->group(function (): void {
        Route::post('/login', \App\Http\Controllers\Api\v1\Admin\LoginController::class)
            ->name('login');

        Route::middleware('auth.jwt')->group(function (): void {
            Route::get('/logout', \App\Http\Controllers\Api\v1\Admin\LogoutController::class)
                ->name('logout');

            Route::post('/create', \App\Http\Controllers\Api\v1\Admin\CreateController::class)
                ->name('create');

            Route::get('/user-listing', \App\Http\Controllers\Api\v1\Admin\UserListingController::class)
                ->name('user-listing');

            Route::put('/user-edit/{user}', \App\Http\Controllers\Api\v1\Admin\UserEditController::class)
                ->name('user-edit');

            Route::delete('/user-delete/{user}', \App\Http\Controllers\Api\v1\Admin\UserDeleteController::class)
                ->name('user-delete');
        });
    });

    Route::get('/products', function (Request $request) {
        return response()->json($request->user());
    })->name('products');
});
