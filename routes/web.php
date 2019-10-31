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

Route::get('admin', array('as' => 'admin', function(){
    return View::make('welcome');
}));

Route::resource('users', 'UserController');

Route::resource('usersManagers', 'UsersManagerController');

Route::resource('usersAttendants', 'UsersAttendantController');


Route::resource('contacts', 'ExtendedContactController');
// Route::get('contacts', 'ExtendedContactController');
// Route::post('contacts/{id}', 'CourseController@update');
// Route::delete('contacts/{id}', 'CourseController@delete');
// Route::post('contacts/{id}/update_image', 'CourseController@update_image');

Route::resource('contacts_status', 'ExtendedContactsStatusController');
    
Route::resource('messageTypes', 'MessageTypeController');

Route::resource('statuses', 'StatusController');

Route::resource('attendantsContacts', 'AttendantsContactController');

Route::resource('roles', 'RoleController');

Route::resource('passwordResets', 'PasswordResetController');

Route::resource('systemConfigs', 'SystemConfigController');





Route::resource('usersStatuses', 'UsersStatusController');

Route::resource('contactsStatuses', 'ExtendedContactsStatusController');

Route::resource('messagesStatuses', 'MessagesStatusController');

Route::resource('attendantsContacts', 'AttendantsContactController');

Route::resource('users', 'UserController');

Route::resource('contacts', 'ExtendedContactController');

Route::resource('companies', 'CompanyController');

Route::resource('companies', 'CompanyController');

Route::resource('contacts', 'ExtendedContactController');

Route::resource('users', 'UserController');

Route::resource('usersAttendants', 'UsersAttendantController');

Route::resource('usersManagers', 'UsersManagerController');

Route::resource('contacts', 'ExtendedContactController');

Route::resource('companies', 'CompanyController');

Route::resource('companies', 'CompanyController');

Route::resource('contacts', 'ExtendedContactController');

Route::resource('users', 'UserController');

Route::resource('usersAttendants', 'UsersAttendantController');

Route::resource('usersManagers', 'UsersManagerController');

Route::resource('usersSellers', 'UsersSellerController');

Route::resource('chats', 'ChatController');