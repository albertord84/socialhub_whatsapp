<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('password_reset', 'AuthController@passwordReset');
    Route::get('user_list', 'AuthController@user_list');
    Route::post('password_save', 'AuthController@passwordSave');
    Route::post('add_user', 'AuthController@addUser');
    Route::get('get_user/{user_id}', 'AuthController@getUser');
    Route::post('edit_user', 'AuthController@editUser');
    Route::get('delete_user/{user_id}', 'AuthController@deleteUser');
});
