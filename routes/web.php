<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PaketController;
use Illuminate\Support\Facades\Route;


// Start Here

// Home Controller
Route::get('/', [HomeController::class, 'index']);

// Outlet Resource Route
Route::resource('outlet', OutletController::class);
// Paket Resource Route
Route::resource('paket', PaketController::class);
// Member Resource Route
Route::resource('member', MemberController::class);

