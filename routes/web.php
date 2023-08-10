<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\HomeController;
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
    return view('home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    // Only admin can have access
    Route::group(['middleware' => ['role:admin']], function () {
        // Company routes
        Route::get('/companies', 'App\Http\Controllers\CompaniesController@index')->name('companies.index');
        Route::get('/companies/create', 'App\Http\Controllers\CompaniesController@create')->name('companies.create');
        Route::get('/companies/{companyId}/edit', 'App\Http\Controllers\CompaniesController@edit')->name('companies.edit');
        Route::put('/companies/{companyId}/update', 'App\Http\Controllers\CompaniesController@update')->name('companies.update');

        // Employee routes
        Route::get('/employees', 'App\Http\Controllers\EmployeesController@index')->name('employees.index');
        Route::get('/employees/create', 'App\Http\Controllers\EmployeesController@create')->name('employees.create');
        Route::get('/employees/{employeeId}/edit', 'App\Http\Controllers\EmployeesController@edit')->name('employees.edit');
        Route::post('/employees', 'App\Http\Controllers\EmployeesController@store')->name('employees.store');
        Route::put('/employees/{employeeId}', 'App\Http\Controllers\EmployeesController@update')->name('employees.update');
        Route::delete('/employees/{employeeId}', 'App\Http\Controllers\EmployeesController@destroy')->name('employees.destroy');
    });
});

// go to home dashboard
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

// let vue know that there are some routes
Route::get('/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
