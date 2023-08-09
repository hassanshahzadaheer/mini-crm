<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
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

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/api/user', 'UserController@getUser')->middleware('auth');


Route::get('/companies',[CompanyController::class,'index']);
Route::post('/companies', [CompanyController::class, 'store']);

Route::get('/companies/{companyId}', [CompanyController::class, 'show']);
Route::put('/companies/{companyId}', [CompanyController::class, 'update']);

Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
