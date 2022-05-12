<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slideshow;

class SlideshowController extends Controller
{
    //获取幻灯片
    public function getSlides($id) {
        $slides = Slideshow::find(1);
        var_dump($slides->title);
        exit;
        return view('users.index', compact('users'));
    }
}
