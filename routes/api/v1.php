<?php

use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\v1\Auth\LoginController;

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
Route::post('login', [LoginController::class, 'validateUser']);
Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');
Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');
Route::apiResource('posts', PostController::class)->names('api.v1.posts');
