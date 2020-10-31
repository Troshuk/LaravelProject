<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['prefix' => 'weather'], function () {
        Route::get('zip/{zip}', [WeatherController::class, 'getByZip']);
        Route::get('city/{city}/{state}', [WeatherController::class, 'getByCityAndState']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('all', [UserController::class, 'getAll']);
        Route::get('', [UserController::class, 'getLoggedIn']);
        Route::put('', [UserController::class, 'update']);
        Route::delete('', [UserController::class, 'delete']);

        Route::group(['prefix' => '{id}'], function () {
            Route::get('', [UserController::class, 'get']);
        });
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('', [NotificationController::class, 'getAll']);
        Route::get('read', [NotificationController::class, 'getRead']);
        Route::put('read', [NotificationController::class, 'readAll']);
        Route::get('unread', [NotificationController::class, 'getUnread']);
        Route::put('unread', [NotificationController::class, 'unreadAll']);
        Route::delete('', [NotificationController::class, 'deleteAll']);

        Route::group(['prefix' => '{id}'], function () {
            Route::get('', [NotificationController::class, 'get']);
            Route::put('read', [NotificationController::class, 'read']);
            Route::put('unread', [NotificationController::class, 'unread']);
            Route::delete('', [NotificationController::class, 'delete']);
        });
    });
});
