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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// user
Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/get-user-table', 'UserController@getUserTable')->name('getUserTable');
Route::get('/user/get-user-data', 'UserController@getUserData')->name('getUserData');
Route::get('/user/email-checking', 'UserController@emailChecking')->name('emailChecking');
Route::post('/user/create-user', 'UserController@createUser')->name('createUser');
Route::post('/user/edit-user', 'UserController@editUser')->name('editUser');
Route::post('/user/change-password', 'UserController@changePassword')->name('changePassword');
Route::post('/user/delete-user', 'UserController@deleteUser')->name('deleteUser');

// demand
Route::get('/request', 'DemandController@index')->name('request');
Route::get('/request/get-demand-table', 'DemandController@getDemandTable')->name('getDemandTable');
Route::post('/request/create-request', 'DemandController@createDemand')->name('createDemand');

// item
Route::get('/request/get-item-table', 'DemandController@getItemTable')->name('getItemTable');
Route::get('/request/get-item-data', 'DemandController@getItemData')->name('getItemData');
Route::post('/request/create-item', 'DemandController@createItem')->name('createItem');
Route::post('/request/edit-item', 'DemandController@editItem')->name('editItem');
Route::post('/request/delete-item', 'DemandController@deleteItem')->name('deleteItem');

// payment
Route::get('/payment', 'PaymentController@index')->name('payment');

// stock
Route::get('/atk', 'StockController@index')->name('stock');