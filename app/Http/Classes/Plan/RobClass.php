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
use App\Models\Order\BuyOrderModel;
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
        $model->whereIn('id', $ids)->where('young_status', '=', '10')->update(['young_status' => '30']);

        foreach ($ids as $v)self::store_buy($v);
    }

    //激活失败
    public function rob_fails($ids)
    {
        if (count($ids) <= 0) return;

        $model = new RobModel();
        $model->whereIn('id', $ids)->where('young_status', '=', '10')->update(['young_status' => '30']);
    }

    public function store_buy($id)
    {
        $rob = RobModel::whereId($id)->first();

        $member = MemberModel::whereUid($rob->uid)->first();
        $poundage = $rob->young_poundage;

        //新增订单信息
        $order = new BuyOrderModel();
        $order->young_order = $order->new_order();
        $order->young_from = '30';//抢单
        $order->uid = $member->uid;
        $order->young_total = $rob->young_total;
        $order->young_days = $rob->young_time;
        $order->young_in_pro = $rob->young_in_pro;
        $order->young_amount = $rob->young_amount;
        $order->young_number = $rob->young_number;
        $order->young_poundage = $poundage;
        $order->young_in = number_format(($rob->young_in_pro * $rob->young_total / 100), 2, '.', '');
        $order->young_name = $this->set['goodsName'];
        $order->young_first_total = number_format(($rob->young_total * $this->set['matchFirstPro'] / 100), 2, '.', '');
        $order->young_first_pro = $this->set['matchFirstPro'];
        $order->young_tail_total = $order->young_total - $order->young_first_total;
        $order->save();

        //扣除会员手续费
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_poundage -= $poundage;
        if (is_null($member->young_first_buy_time)) {
            $member->young_first_buy_time = DATE;
            $member->young_first_buy_total = $rob->young_total;
        }
        $member->young_last_buy_time = DATE;
        $member->young_last_buy_total = $rob->young_total;
        $member->young_all_buy_total += $rob->young_total;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = '抢单采集，订单号『' . $order->young_order . '』,扣除『' . $this->set['walletPoundage'] . '』' . $poundage;
        $keyword = $order->young_order;
        $change = ['poundage' => (0 - $poundage)];
        $wallet->store_record($member, $change, 42, $record, $keyword);

        //修改抢单记录
        $rob->young_order = $order->young_order;
        $rob->young_order_id = $order->id;
        $rob->young_status = '50';
        $rob->save();
    }
}