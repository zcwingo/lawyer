<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LawyerController extends Controller
{
    //工伤赔偿
    public function workerCompensation(Request $request) {
        $scdj = $request->post('scdj');
        $bygz = $request->post('bygz');
        $datas = $request->post('datas')??'';
        //山东省数据
        $lawyerArea = WorkerCompensation($scdj,$bygz,1,$datas);
        return response()->json($lawyerArea);
    }

    //诉讼费计算器
    public function legalCostCalculator(Request $request) {
        $money = $request->post('money');
        $moneyArr = litigationAllRisksInsurance($money);
		return response()->json($moneyArr);
    }

    //律师费计算器
    public function lawyerFeeCalculator(Request $request) {
        $money = $request->post('money');
        $type = $request->post('type');
        //山东省律师费
        $lawyerMoney = lawyerFeeCalculator($type,$money,1);
        return response()->json($lawyerMoney);
    }
    //仲裁案件受理费
    public function arbitration(Request $request) {
        $money = $request->post('money');
        $lawyerMoney = arbitration($money);
        return $lawyerMoney;
    }
}
