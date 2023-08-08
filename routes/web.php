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

Route::group(['middleware' => ['auth']], function () {
    // Your authenticated routes go here
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/companies', 'App\Http\Controllers\CompaniesController@index')->name('companies.index');
        Route::get('/companies/create', 'App\Http\Controllers\CompaniesController@create')->name('companies.create');
        Route::get('/companies/{companyId}/edit', 'App\Http\Controllers\CompaniesController@edit')->name('companies.edit');
        Route::put('/companies/{companyId}/update', 'App\Http\Controllers\CompaniesController@update')->name('companies.update');
        // Add more routes as needed
    });
});

// Catch-all route (keep this at the end)
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
