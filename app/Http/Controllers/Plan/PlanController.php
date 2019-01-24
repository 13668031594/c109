<?php

namespace App\Http\Controllers\Plan;

use App\Http\Classes\Plan\ActClass;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    //开始执行计划任务
    public function index()
    {
        new ActClass();//执行抢激活码任务
    }
}
