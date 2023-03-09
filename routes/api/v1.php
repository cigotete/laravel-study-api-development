<?php

use App\Http\Controllers\Api\v1\RegisterController;
use App\Http\Controllers\Api\v1\CategoryController;
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

Route::post('/register', [RegisterController::class, 'store'])->name('api.v1.register');
Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');