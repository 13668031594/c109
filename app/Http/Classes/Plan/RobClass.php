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
use App\Models\Member\MemberWalletModel;
use App\Models\Order\RobModel;
use App\Models\Plan\PlanModel;

class RobClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //判断是否到了结果发放时间
        if (time() < parent::set_time($this->set['robResultTime'])) return;

        //判断今天是否成功触发了抢单
        $test = new PlanModel();
        $test->where('young_type', '=', 'rob')
            ->where('young_status', '=', '10')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->first();

        //已经成功发放过抢单
        if (!empty($test->toArray())) return;

        //判断今天抢单人数
        $number = RobModel::whereYoungStatus('10')->count();

        //无人需要激活
        if ($number <= 0) {

            $record = '抢单人数0，发放数0';
            self::store_plan($record);
            return;
        }

        if ($this->set['robNum'] <= 0) {

            $record = '抢单发放数为0,抢到人数0';
            self::store_plan($record);
            return;
        }

        $ids = self::all_rob();

        //今日抢到的抢单id
        $rob_ids = ($number < $this->set['robNum']) ? $ids : self::rob_rob($ids);

        //激活会员
        self::rob($rob_ids);

        //激活失败的会员
        self::rob_fails(array_diff($ids, $rob_ids));
    }

    //所有的抢激活的人的id
    private function all_rob()
    {
        return RobModel::whereYoungStatus('10')->get(['id'])->pluck('id')->toArray();
    }

    //随机选中抢激活的人的id
    private function rob_rob($ids)
    {
        //今日激活数
        $number = $this->set['robNum'];

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
        $plan->store_plan('rob', $record, $status);
    }

    //激活
    public function rob($ids)
    {
        if (count($ids) <= 0) return;

        $model = new RobModel();
        $model->whereIn('id', $ids)->where('young_status', '=', '10')->update(['young_status' => '20']);
    }

    //激活失败
    public function rob_fails($ids)
    {
        if (count($ids) <= 0) return;

        $model = new RobModel();
        $model->whereIn('id', $ids)->where('young_status', '=', '10')->update(['young_status' => '30']);
    }
}