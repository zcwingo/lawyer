<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LawyerController extends Controller
{
    //工伤赔偿
    public function workerCompensation(Request $request) {
        $request->post('a');
        //山东省数据
        $lawyerArea = getLawyerByArea();
        var_dump($lawyerArea);
        exit;
    }
}
