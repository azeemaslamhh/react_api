<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CustomFieldsController;
use App\Http\Controllers\API\EmailController;
use App\Http\Controllers\API\MenuListController;
use App\Http\Controllers\API\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/clientLogoutActivity', [App\Http\Controllers\API\RegisterController::class, 'clientLogoutActivity'])->name('api.client.logout.activity');
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'createUser');
    Route::post('login', 'login')->name("client.login");
});
//// routes/api.php
Route::middleware(['verify.token'])->group(function () {
    Route::controller(EmailController::class)->group(function () {
        Route::post('/sendEmail', 'sendEmail')->name('send.email');
    });
    Route::controller(UserController::class)->group(function () {
        Route::post('/updateUser', 'updateUser')->name('user.updateUser');
    });
});

Route::controller(MenuListController::class)->group(function () {
    Route::get('/getMenu', 'getMenu')->name('get.Menu');
});
