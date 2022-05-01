<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\lawyerController as lawyer;

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

Route::prefix("v1")->controller(lawyer::class)->group(function(){
    Route::post('/gspc','workerCompensation')->name('gspc');
    Route::post('/ssbqx','legalCostCalculator')->name('ssbqx');
    Route::post('/lsfjsq','lawyerFeeCalculator')->name('lsfjsq');
});