<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\AuthController;

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
Route::group([
    'prefix' => 'v1'], function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::group([
        'middleware' => ['auth:sanctum']], function () {
        Route::apiResources([
            'users' => UsersController::class,
        ]);
    });
});

