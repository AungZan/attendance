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
    Route::get('/', 'Admin\AdminController@index')->name('admin.home');
    Route::resource('/companies', 'Admin\CompanyController');
    // Route::get('/company', 'Admin\CompanyController@index')->name('company.home');
    // Route::get('/company/create', 'Admin\CompanyController@create')->name('company.create');
    // Route::post('/company/create', 'Admin\CompanyController@create')->name('company.create');
    // Route::get('/company/create', 'Admin\CompanyController@create')->name('company.create');
    // Route::post('/company/create', 'Admin\CompanyController@create')->name('company.create');
    // Route::post('/company/create', 'Admin\CompanyController@create')->name('company.create');
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
