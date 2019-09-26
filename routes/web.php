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

// Route::get('admin', array('as' => 'admin', function(){
//     return View::make('welcome');
// }));

Route::resource('users', 'UserController');
Route::resource('users', 'UserController');

Route::resource('usersManagers', 'UsersManagerController');
Route::resource('usersManagers', 'UsersManagerController');

Route::resource('usersAttendants', 'UsersAttendantController');
Route::resource('usersAttendants', 'UsersAttendantController');


Route::resource('contacts', 'ContactController');
// Route::get('contacts', 'ContactController');
// Route::get('contacts', function () {
//     dd("ok");
// });

// Route::post('contacts/{id}', 'CourseController@update');
// Route::delete('contacts/{id}', 'CourseController@delete');
//Route::post('contacts/{id}/update_image', 'CourseController@update_image');

Route::resource('messageTypes', 'MessageTypeController');
Route::resource('messageTypes', 'MessageTypeController');

Route::resource('statuses', 'StatusController');
Route::resource('statuses', 'StatusController');

Route::resource('attendantsContacts', 'AttendantsContactController');
Route::resource('attendantsContacts', 'AttendantsContactController');

Route::resource('roles', 'RoleController');
Route::resource('roles', 'RoleController');
Route::resource('roles', 'RoleController');

Route::resource('passwordResets', 'PasswordResetController');

Route::resource('systemConfigs', 'SystemConfigController');





Route::resource('usersStatuses', 'UsersStatusController');

Route::resource('contactsStatuses', 'ContactsStatusController');

Route::resource('messagesStatuses', 'MessagesStatusController');