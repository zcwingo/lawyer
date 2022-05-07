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
    //工作赔偿费
    Route::post('/gspc','workerCompensation')->name('gspc');
    //诉讼保全险
    Route::post('/ssbqx','legalCostCalculator')->name('ssbqx');
    //律师费计算器
    Route::post('/lsfjsq','lawyerFeeCalculator')->name('lsfjsq');
    //仲裁案件计算器
    Route::post('/zcajjsq','arbitration')->name('zcajjsq');
});