<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// user api

Route::get('/api/user', 'UserController@getUser')->middleware('auth');

// companies routes

Route::get('/companies',[CompanyController::class,'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::get('/companies/{companyId}', [CompanyController::class, 'show']);
Route::put('/companies/{companyId}', [CompanyController::class, 'update']);
Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);


// employee routes

Route::get('/employees', 'App\Http\Controllers\Api\EmployeeController@index');
Route::get('/employees/{employee}', 'App\Http\Controllers\Api\EmployeeController@show');
Route::post('/employees', 'App\Http\Controllers\Api\EmployeeController@store');
Route::put('/employees/{employee}', 'App\Http\Controllers\Api\EmployeeController@update');
Route::delete('/employees/{employee}', 'App\Http\Controllers\Api\EmployeeController@destroy');


// get Statistics of employee and

Route::get('totals', 'App\Http\Controllers\Api\EmployeeController@getTotal');
