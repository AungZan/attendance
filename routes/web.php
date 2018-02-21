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

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login.form');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');
    Route::get('/', 'Admin\AdminController@index')->name('masters.index');

    // CRUD route for master
    Route::resource('/masters', 'Admin\AdminController');

    // CRUD route for company
    Route::resource('/companies', 'Admin\CompanyController');
});

Route::prefix('master')->group(function() {
    Route::get('/login', function() {
        return view('auth.master-login');
    });

    Route::get('/', function() {
        return view('master-welcome');
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
