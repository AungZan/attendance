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
    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login.form');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login');

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

    // CRUD routes for user
    Route::resource('/users', 'Master\UserController');

    // CRUD routes for attendance
    Route::resource('/attendances', 'Master\AttendanceController');

    //routes for attendance_changes
    Route::get('/attendance_changes', 'Master\AttendanceChangesController@index')
            ->name('attendance_changes.index');
    Route::match(['PUT', 'PATCH'], '/attendance_changes/{id}/approve', 'Master\AttendanceChangesController@approve')
            ->name('attendance_changes.approve');
    Route::match(['PUT', 'PATCH'], '/attendance_changes/{id}/decline', 'Master\AttendanceChangesController@decline')
            ->name('attendance_changes.decline');
    Route::match(['PUT', 'PATCH'], '/attendance_changes/{id}/revoke', 'Master\AttendanceChangesController@revokeDecline')
            ->name('attendance_changes.revoke');

    // CRUD routes for settings
    Route::resource('/settings', 'Master\SettingController', ['only' => ['index', 'update']]);
});

// user site routes
Auth::routes();

Route::resource('/home', 'HomeController', ['only' => ['index', 'update']]);
