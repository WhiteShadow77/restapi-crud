<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'jwt', 'prefix' => 'auth'], function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});

Route::group(['middleware' => 'jwt'], function () {

    Route::resource('tasks', TaskController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('users', [UserController::class, 'getUsers'])->middleware('admin');
    Route::get('users/tasks', [UserController::class, 'getUsersWithTasks'])->middleware('admin');

});