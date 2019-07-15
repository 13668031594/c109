<?php

namespace App\Http\Controllers\Plan;

use App\Http\Classes\Plan\AccountClass;
use App\Http\Classes\Plan\ActClass;
use App\Http\Classes\Plan\AutoClass;
use App\Http\Classes\Plan\BuyExtendedClass;
use App\Http\Classes\Plan\BuyOverClass;
use App\Http\Classes\Plan\GradeClass;
use App\Http\Classes\Plan\GxdWithClass;
use App\Http\Classes\Plan\MatchClass;
use App\Http\Classes\Plan\MatchSureClass;
use App\Http\Classes\Plan\RobClass;
use App\Http\Classes\Plan\TypeClass;
use App\Http\Classes\Plan\WageClass;
use App\Http\Classes\Plan\PoundageGiveClass;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    //开始执行计划任务
    public function index()
    {

        \DB::beginTransaction();

        new GradeClass();//新老会员

        new TypeClass();//修改会员下单类型

        new AutoClass();//自动排单

        new AccountClass();//封号操作

        new RobClass();//执行抢单发放

        new ActClass();//执行抢激活码任务

        new MatchClass();//执行订单匹配

        new MatchSureClass();//自动确认未收款的匹配订单

        new BuyExtendedClass();//延长订单收益时间

        new BuyOverClass();//订单收益完结

        new PoundageGiveClass();//每日赠送星伙

        new MatchClass('match_simu');//执行订单预匹配

        \DB::commit();
    }

    public function gxd_with()
    {
        new GxdWithClass();//华夏宗亲家谱贡献点同步
    }
}
