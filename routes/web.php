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

// https://app.socialhub.pro/testsalesbling
Route::post('testsalesbling', 'TestController@testsalesbling');
Route::get('testsalesbling', 'TestController@testsalesbling');

Route::group(['prefix' => 'RPI'], function ($router) {
    Route::post('reciveFileMessage', 'ExternalRPIController@reciveFileMessage');
    Route::post('reciveTextMessage', 'ExternalRPIController@reciveTextMessage');
    Route::post('sendTextMessage', 'ExternalRPIController@sendMessage');
    Route::get('getContactInfo/{whatsapp_id}', 'ExternalRPIController@getContactInfo');
    Route::post('getContactInfo', 'ExternalRPIController@getContactInfo');
    Route::get('getQRCode', 'ExternalRPIController@getQRCode');
    Route::post('update', 'ExternalRPIController@update');
    Route::post('status', 'ExternalRPIController@status');
    Route::post('logout', 'ExternalRPIController@logout');
    Route::get('test', 'ExternalRPIController@test');
    
    Route::post('tests/{option}', 'ExternalRPIController@tests');
    Route::get('tests/{option}', 'ExternalRPIController@tests');
});

Route::get('/', 'AuthController@index');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('beforeLogout', 'AuthController@beforeLogout');
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
// Route::delete('deleteAllByManagerId/{user_manager_id}', 'ExtendedUsersAttendantController@deleteAllByManagerId');    //ECR

Route::resource('usersSellers', 'ExtendedUsersSellerController');
Route::get('cep/{cep}', 'ExtendedUsersSellerController@cep');
Route::resource('passwordResets', 'PasswordResetController');

// Route::resource('contacts', 'ContactController');
Route::post('contactsFromCSV', 'ExtendedContactController@contactsFromCSV');
Route::resource('contacts', 'ExtendedContactController');
Route::get('updateContactPicture/{contact_id}', 'ExtendedContactController@updatePicture');

Route::resource('contacts_status', 'ExtendedContactsStatusController');
Route::resource('contactsStatuses', 'ExtendedContactsStatusController');
// Route::delete('deleteAllByCompanyId/{company_id}', 'ExtendedContactController@deleteAllByCompanyId');    //ECR


Route::resource('attendantsContacts', 'ExtendedAttendantsContactController');
Route::delete('deleteAllByAttendantId/{id}', 'ExtendedAttendantsContactController@deleteAllByAttendantId');

Route::resource('companies', 'ExtendedCompanyController');

Route::resource('messagesStatuses', 'MessagesStatusController');

Route::resource('systemConfigs', 'SystemConfigController');

Route::resource('chats', 'ExtendedChatController');
Route::get('getBagContact', 'ExtendedChatController@getBagContact');
Route::get('getBagContactsCount', 'ExtendedChatController@getBagContactsCount');

Route::resource('test', 'TestController');

Route::resource('socialnetworks', 'SocialnetworkController');

Route::resource('messagesTypes', 'MessagesTypeController');


Route::resource('rpis', 'ExtendedRpiController');



Route::resource('contactsOrigins', 'ContactsOriginsController');

Route::resource('blings', 'BlingController');

Route::resource('sales', 'SalesController');
Route::get('get_sales_bling', 'BlingController@get_sales_bling');

Route::resource('chatsBlings', 'ChatsBlingController');