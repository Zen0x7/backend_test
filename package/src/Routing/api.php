<?php

use Illuminate\Support\Facades\Route;

Route::get("/api/v1/bacs", \SpiritSaint\LaravelBacs\Http\Controllers\IndexController::class);

