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

// admin site routes
Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login.form');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
    Route::get('/', 'Admin\MasterController@index')->name('masters.index');

    // CRUD route for master
    Route::resource('/masters', 'Admin\MasterController');

    // CRUD route for company
    Route::resource('/companies', 'Admin\CompanyController');
});

// master site routes
Route::prefix('master')->group(function() {
    Route::get('/login', 'Auth\MasterLoginController@showLoginForm')->name('master.login.form');
    Route::post('/login', 'Auth\MasterLoginController@login')->name('master.login');
    Route::get('/', 'Master\UserController@index')->name('users.index');

    // CRUD route for user
    Route::resource('/users', 'Master\UserController');
});

// user site routes
Auth::routes();

Route::resource('/home', 'HomeController', ['only' => ['index', 'update']]);
