<?php

namespace App\Http\Controllers\Plan;

use App\Http\Classes\Plan\AccountClass;
use App\Http\Classes\Plan\ActClass;
use App\Http\Classes\Plan\AutoClass;
use App\Http\Classes\Plan\MatchClass;
use App\Http\Classes\Plan\RobClass;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    //开始执行计划任务
    public function index()
    {
        \DB::beginTransaction();

        new AccountClass();//封号操作

        new RobClass();//执行抢单发放

        new ActClass();//执行抢激活码任务

        new AutoClass();//自动排单

        new MatchClass();//执行订单匹配

        \DB::commit();
    }
}
