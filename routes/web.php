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