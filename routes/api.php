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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/companies',[CompanyController::class,'index']);
Route::post('/companies', [CompanyController::class, 'store']);

Route::get('/companies/{companyId}', [CompanyController::class, 'show']);
Route::put('/companies/{companyId}', [CompanyController::class, 'update']);

Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
