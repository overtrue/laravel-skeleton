<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/settings', 'SettingController@index');

Route::post('/login', 'Auth\LoginController');
Route::post('/logout', 'Auth\LogoutController');
Route::post('/register', 'Auth\RegisterController');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', 'UserController@user');

    // admin
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::resource('users', 'UserController');
        Route::resource('settings', 'SettingController');
    });
});
