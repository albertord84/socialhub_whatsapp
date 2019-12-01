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

// Route::post('storeFromRPi', 'ExtendedChatController@storeFromRPi');
// Route::get('reciveFileMessage', function () {
//     die("ok");
// });

Route::group(['prefix' => 'RPI'], function ($router) {
    Route::post('reciveFileMessage', 'RPIController@reciveFileMessage');
    Route::post('reciveTextMessage', 'RPIController@reciveTextMessage');
    Route::post('sendTextMessage', 'RPIController@sendMessage');

    Route::post('update', 'RPIController@update');
});

Route::get('/', function () {
    return view('welcome');
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

Route::resource('usersStatuses', 'UsersStatusController');
Route::resource('roles', 'RoleController');
Route::resource('users', 'ExtendedUserController');
Route::post('users/{id}/update_image', 'ExtendedUserController@update_image');

Route::resource('usersManagers', 'ExtendedUsersManagerController');
Route::post('usersManagers/{company_id}/getManager', 'ExtendedUsersManagerController@getManager');

Route::resource('usersAttendants', 'ExtendedUsersAttendantController');
Route::resource('usersSellers', 'ExtendedUsersSellerController');
Route::resource('passwordResets', 'PasswordResetController');

// Route::resource('contacts', 'ContactController');
Route::resource('contacts', 'ExtendedContactController');
Route::resource('contacts_status', 'ExtendedContactsStatusController');
Route::resource('contactsStatuses', 'ExtendedContactsStatusController');
Route::resource('attendantsContacts', 'AttendantsContactController');

Route::resource('companies', 'CompanyController');

Route::resource('messagesStatuses', 'MessagesStatusController');

Route::resource('systemConfigs', 'SystemConfigController');

Route::resource('chats', 'ExtendedChatController');

Route::resource('test', 'TestController');

Route::resource('socialnetworks', 'SocialnetworkController');

Route::resource('messagesTypes', 'MessagesTypeController');


Route::resource('rpis', 'RpiController');