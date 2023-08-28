<?php

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

Route::prefix('/v1')->as('api::v1::')->group(function () {
    Route::prefix('/admin')->as('admin::')->group(function () {
        Route::post('/login', \App\Http\Controllers\Api\v1\Admin\LoginController::class)
            ->name('login');
    });

    Route::get('/products', function (Request $request) {
        return response()->json();
    })->name('products');
});
