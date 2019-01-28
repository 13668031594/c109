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
    private $rank;//参与发工资的等级
    private $wage;//工资发放表
    private $wallet;//工资发放记录

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
        self::rank();

        //没有符合发工资的等级
        if (empty($this->rank)) {

            $record = '没有符合工资发放条件的会员等级，工资发放为0';
            self::store_plan($record);
            return;
        }

        //循环订单，组合工资发放数组


        dd('123');
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
        $rank = $rank->where('young_wage', '>', 0)->orderBy('young_sort', 'asc')->all(['id', 'young_wage']);

        if (count($rank) <= 0) return;

        foreach ($rank as $v) $this->rank[$v->id] = $v->young_wage;
    }

    public function group_wage()
    {
        foreach ($this->order_poundage as $k => $v) {

            //寻找会员
            $member = MemberModel::whereUid($k)->first();
            if (is_null($member) || empty($member->young_families)) return;

            //寻找参与发放工资的上级
            $referee_ids = explode(',', $member->young_families);
            $families = new MemberModel();
            $families = $families->whereIn('uid', $referee_ids)//是上级
            ->whereIn('young_rank_id', array_keys($this->rank))//属于参与分佣的等级
            ->where('young_status', '!=', '30')//没有被封停
            ->orderBy('uid', 'desc')//由近及远
            ->all();

            //没有上级，下一个
            if (empty($families)) continue;

            //赋值等级数组
            $rank = $this->rank;

            //循环发放工资
            foreach ($families as $va) {

                //没有可以发放工资的等级了
                if (empty($rank)) break;

                //当前等级工资已经发放过了
                if (!in_array($va->young_rank_id, array_keys($rank))) break;

                //初始化工资比例
                $pro = 0;

                //计算当发工资
                foreach ($rank as $k => $v) {

                    //等级已经大于上级等级，跳出循环
                    if ($k > $va->young_rank_id) break;

                    //叠加工资比例
                    $pro += $v;

                    //工资已发，剔除数组
                    unset($rank[$k]);
                }

                //没有工资可发
                if ($pro <= 0) continue;

                //计算当发工资
                $wage = number_format(($v * $pro), 2, '.', '');

                //没有可发工资，下一个
                if ($wage <= 0) continue;

                //初始化会员变更数组中的数据
                if (!isset($this->wage[$va->uid])) {

                    $this->wage[$va->uid] = [
                        'uid' => $va->uid,
                        'young_reward' => $va->young_reward,
                        'young_reward_all' => $va->young_reward_all
                    ];
                }

                //初始化会员钱包变更数组中的数据
                if (!isset($this->wallet[$va->uid])) $this->wallet[$va->uid] = 0;

                //修改会员奖励抢包
                $this->wage[$va->uid]['young_reward'] += $wage;
                $this->wage[$va->uid]['young_reward_all'] += $wage;

                //修改记录中的奖励钱包变更数
                $this->wallet[$va->uid] += $wage;
            }
        }
    }
}