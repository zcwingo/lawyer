<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\lawyerController as lawyer;
use App\Http\Controllers\SlideshowController as slide;

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

//律师工具接口
Route::prefix("v1")->controller(lawyer::class)->group(function(){
    //工作赔偿费
    Route::post('/gspc','workerCompensation')->name('gspc');
    //诉讼保全险
    Route::post('/ssbqx','legalCostCalculator')->name('ssbqx');
    //律师费计算器
    Route::post('/lsfjsq','lawyerFeeCalculator')->name('lsfjsq');
    //仲裁案件计算器
    Route::post('/zcajjsq','arbitration')->name('zcajjsq');
    //房贷计算器
    Route::post('/fdjsq','mortgage')->name('fdjsq');
});

//幻灯片等杂项接口
Route::prefix("v1")->controller(slide::class)->group(function(){
    //幻灯片
    Route::get('/slide/{type}','getSlides')->where('id', '[0-9]+');
});