<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午2:46
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberActModel;
use App\Models\Member\MemberModel;
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

        //今日激活的会员id
        $act_ids = ($number < $this->set['accountActNum']) ? $ids : self::rob_act($ids);
        //扣除上级手续费
        self::poundage($act_ids);
        //激活会员
        self::act($act_ids);

        //激活失败的会员
        self::act_fails(array_diff($ids, $act_ids));


    }

    //所有的抢激活的人的id
    private function all_act()
    {
        return MemberActModel::whereYoungStatus('10')->get(['id'])->pluck('id')->toArray();
    }

    //随机选中抢激活的人的id
    private function rob_act($ids)
    {
        //今日激活数
        $number = $this->set['accountActNum'];

        //获取中选的key
        $keys = array_rand($ids, $number);

        //如果只选一人
        if ($number == '1') return [$ids[$keys]];

        //放入结果,比较键名，返回交集
        return array_intersect_key($ids, $keys);
    }

    //添加本次激活记录
    private function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan('act', $record, $status);
    }

    //激活
    public function act($ids)
    {
        $model = new MemberModel();
        $model->whereIn('uid', $ids)->update(['young_act' => '30']);
    }

    //激活失败
    public function act_fails($ids)
    {
        if (count($ids) <= 0) return;

        $model = new MemberModel();
        $model->whereIn('uid', $ids)->update(['young_act' => '10']);
    }

    //扣除上级手续费
    public function poundage($ids)
    {
        $poundage = $this->set['accountActPoundage'];

        $model = new MemberModel();
        $referee = $model->whereIn('uid', $ids)->get(['uid', 'young_referee_id'])->groupBy('young_referee_id')->toArray();

        dd($referee);
    }
}