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

        if ($this->set['accountActNum'] <= 0) {

            $record = '激活码发放数为0,激活人数0';
            self::store_plan($record);
            return;
        }

        $ids = self::all_act();
        $this->set['accountActNum'] = 1;
        //今日激活的会员id
        $act_ids = ($number <= $this->set['accountActNum']) ? $ids : self::rob_act($ids);

        dd($act_ids);
    }

    private function all_act()
    {
        return MemberActModel::whereYoungStatus('10')->get(['id'])->pluck('id')->toArray();
    }

    private function rob_act($ids)
    {
        //今日激活数
        $number = $this->set['accountActNum'];

        array_rand($ids,$number);

        return $ids;
    }

    private function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan('act', $record, $status);
    }
}