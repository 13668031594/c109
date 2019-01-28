<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;
use App\Models\Member\MemberRankModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Plan\PlanModel;

class WageClass extends PlanClass
{
    private $where_time;//筛选时间段
    private $order_poundage;//订单支付的手续费

    public function __construct()
    {
        parent::__construct();

        //今天几号
        $day = date('d');
        $day = 5;
        //5号和20号发工资
        if (($day != '5') && ($day != '20')) return;

        //工资发了没
        $test = new PlanModel();
        $test->where('young_type', '=', 'wage')
            ->where('young_status', '=', '10')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->first();

        //已经发了
        if (!empty($test->toArray())) return;

        //计算时间筛选
        self::where_date($day);

        //获取所有满足条件的订单
        self::buy_order();

        //判断是否有需要分佣的
        if (empty($this->order_poundage)) {

            $record = '没有新的采集订单完结，工资发放为0';
            self::store_plan($record);
            return;
        }

        //获取满足分佣条件的会员等级
    }

    //添加本次激活记录
    private function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan('wage', $record, $status);
    }

    //计算时间
    public function where_date($day)
    {
        $begin = '';
        $end = '';

        if ($day == '5') {

            $begin = date('Y-m-20 00:00:00', strtotime('-1 month'));
            $end = date('Y-m-5 00:00:00');
        }
        if ($day == '20') {
            $begin = date('Y-m-5 00:00:00');
            $end = date('Y-m-20 00:00:00');
        }

        $this->where_time = [
            'begin' => $begin,
            'end' => $end,
        ];
    }

    //获取所有满足条件的订单
    public function buy_order()
    {
        //时间筛选
        $where = [
//            ['created_at', '>=', $this->where_time['begin']],
//            ['created_at', '<', $this->where_time['end']],
//            ['young_status', '=', '90']
        ];

        //获取字段
        $select = ['id', 'uid', 'young_poundage'];

        //获取满足条件的订单
        $buys = new BuyOrderModel();
        $buys = $buys->where($where)->get($select);

        //没有满足条件的订单
        if (count($buys) <= 0) return;

        //按下单人分组
        $buys = $buys->groupBy('uid');

        //组合成下单人与总手续费的键值对
        foreach ($buys as $k => $v) $this->order_poundage[$k] = array_sum(array_pluck($v, 'young_poundage'));
    }

    public function rank()
    {
        $rank = new MemberRankModel();
        $rank = $rank->where('young_wage','>',0)->orderBy('young_sort');
    }
}