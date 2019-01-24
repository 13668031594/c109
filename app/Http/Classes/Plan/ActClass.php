<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午2:46
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberActModel;
use App\Models\Plan\PlanModel;

class ActClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //判断是否到了结果发放时间
        if (time() < parent::set_time($this->set['accountActResult'])) return;

        //判断今天是否成功发放了激活码
        $test = new PlanModel();
        $test->where('young_type', '=', 'act')
            ->where('young_status', '=', '10')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->first();

        //已经成功发放过激活码
        if (!empty($test->toArray())) return;

        //判断今天抢激活码的人数是否超过总发放激活码数
        $number = MemberActModel::whereYoungStatus('10')->count();

        //无人需要激活
        if ($number <= 0) {

            $record = '抢激活人数0，激活人数0';
            self::store_plan($record);
            return;
        }

        //今日激活的会员id
        $ids = ($number <= $this->set['accountActNum']) ? self::all_act() : self::rob_act();

        dd($ids);
    }

    private function all_act()
    {
        return MemberActModel::whereYoungStatus('10')->get(['id'])->pluck('id')->toArray();
    }

    private function rob_act()
    {
        //今日激活数
        $number = $this->set['accountActNum'];

        //今日抢激活的所有id
        $ids = self::all_act();


    }

    private function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan('act', $record, $status);
    }
}