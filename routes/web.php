<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('attendant');
    //     return view('welcome');
});

Route::get('admin', array('as' => 'admin', function()
{
    return View::make('welcome');
}));


Route::resource('messageTypes', 'MessageTypeController');

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('statuses', 'StatusController');

Route::resource('attendentsContacts', 'AttendentsContactController');

Route::resource('roles', 'RoleController');