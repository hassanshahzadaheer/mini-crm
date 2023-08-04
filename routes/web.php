<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






Route::group(['middleware' => ['auth']], function () {
    // Your authenticated routes go here

    // If you want to further restrict access to admin users only:
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/companies', 'App\Http\Controllers\CompaniesController@index')->name('companies.index');
        Route::get('/companies/create', 'App\Http\Controllers\CompaniesController@create')->name('companies.create');

    });
});
