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
Route::get('/request/get-request-data', 'DemandController@getDemandData')->name('getDemandData');
Route::get('/request/get-request-table', 'DemandController@getDemandTable')->name('getDemandTable');
Route::get('/request/print-request/{id}', 'DemandController@printDemand')->name('printDemand');
Route::post('/request/create-request', 'DemandController@createDemand')->name('createDemand');
Route::post('/request/edit-request', 'DemandController@editDemand')->name('editDemand');
Route::post('/request/delete-request', 'DemandController@deleteDemand')->name('deleteDemand');
Route::post('/request/approve-or-reject', 'DemandController@approveOrReject')->name('approveOrReject');

// item
Route::get('/request/get-item-table', 'DemandController@getItemTable')->name('getItemTable');
Route::get('/request/get-item-data', 'DemandController@getItemData')->name('getItemData');
Route::post('/request/create-item', 'DemandController@createItem')->name('createItem');
Route::post('/request/edit-item', 'DemandController@editItem')->name('editItem');
Route::post('/request/delete-item', 'DemandController@deleteItem')->name('deleteItem');

// payment
Route::get('/payment', 'PaymentController@index')->name('payment');
Route::get('/payment/get-payment-data', 'PaymentController@getPaymentData')->name('getPaymentData');
Route::get('/payment/get-payment-table', 'PaymentController@getPaymentTable')->name('getPaymentTable');
Route::get('/payment/print-payment', 'PaymentController@printPayment')->name('printPayment');
Route::post('/payment/approve-or-reject', 'PaymentController@approveOrReject')->name('approveOrRejectPayment');

// stock
Route::get('/atk', 'StockController@index')->name('stock');