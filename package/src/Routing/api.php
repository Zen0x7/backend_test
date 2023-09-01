<?php

use Illuminate\Support\Facades\Route;

Route::get("/api/bacs", \SpiritSaint\LaravelBacs\Http\Controllers\IndexController::class);

