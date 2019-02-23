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
use App\Models\Member\MemberWalletModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Plan\PlanModel;

class WageClass extends PlanClass
{
    private $where_time;//筛选时间段
    private $order_poundage;//订单支付的星伙
    private $rank;//参与发工资的等级
    private $wage;//工资发放表
    private $wallet;//工资发放记录

    public function __construct()
    {
        parent::__construct();

        //今天几号
        $day = date('d');

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
        self::group_wage();

        //每人可以发
        if (empty($this->wage)) {

            $record = '没有人满足工资发放条件，工资发放为0';
            self::store_plan($record);
            return;
        }

        //添加钱包变更记录
        self::insert_wallet($day);

        //修改会员资料
        self::update_member();

        //发放完毕
        $record = '本次发放工资：' . array_sum($this->wallet) . '，发放人数：' . count($this->wallet);
        self::store_plan($record);
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
            ['created_at', '>=', $this->where_time['begin']],
            ['created_at', '<', $this->where_time['end']],
            ['young_status', '=', '90']
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

        //组合成下单人与总星伙的键值对
        foreach ($buys as $k => $v) $this->order_poundage[$k] = array_sum(array_pluck($v, 'young_poundage'));
    }

    public function rank()
    {
        $rank = new MemberRankModel();
        $rank = $rank->where('young_wage', '>', 0)->orderBy('young_sort', 'asc')->get(['id', 'young_wage']);

        if (count($rank) <= 0) return;

        foreach ($rank as $v) $this->rank[$v->id] = $v->young_wage;
    }

    public function group_wage()
    {
        foreach ($this->order_poundage as $k => $v) {

            //寻找会员
            $member = MemberModel::whereUid($k)->first();
//            $member->young_families = '1,2,3,4';
            if (is_null($member) || empty($member->young_families)) return;

            //寻找参与发放工资的上级
            $referee_ids = explode(',', $member->young_families);
            $families = new MemberModel();
            $families = $families->whereIn('uid', $referee_ids)//是上级
            ->whereIn('young_rank_id', array_keys($this->rank))//属于参与分佣的等级
            ->where('young_status', '!=', '30')//没有被封停
            ->orderBy('young_rank_id', 'asc')//由近及远
            ->orderBy('uid', 'desc')//由近及远
            ->get();

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
                $wage = number_format(($v * $pro * $this->set['walletPoundageBalance']), 2, '.', '');

                //没有可发工资，下一个
                if ($wage <= 0) continue;

                //初始化会员变更数组中的数据
                if (!isset($this->wage[$va->uid])) {

                    $this->wage[$va->uid] = [
                        'uid' => $va->uid,
                        'young_reward' => $va->young_reward,
                        'young_reward_all' => $va->young_reward_all,
                        'young_balance' => $va->young_balance,
                        'young_balance_all' => $va->young_balance_all,
                        'young_gxd' => $va->young_gxd,
                        'young_gxd_all' => $va->young_gxd_all,
                        'young_poundage' => $va->young_poundage,
                        'young_poundage_all' => $va->young_poundage_all,
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

    //修改会员记录
    private function update_member()
    {
        parent::table_update('member_models', $this->wage, 'uid');
    }

    //添加工资发放记录
    private function insert_wallet($day)
    {
        $insert = [];

        foreach ($this->wallet as $k => $v) {

            $member = $this->wage[$k];

            $i['uid'] = $member['uid'];
            $i['young_type'] = '91';
            $i['young_record'] = '每月' . $day . '日工资发放，本次发放：' . $v;
            $i['young_keyword'] = '';
            $i['young_balance'] = 0;
            $i['young_balance_all'] = $member['young_balance_all'];
            $i['young_balance_now'] = $member['young_balance'];
            $i['young_poundage'] = 0;
            $i['young_poundage_all'] = $member['young_poundage_all'];
            $i['young_poundage_now'] = $member['young_poundage'];
            $i['young_gxd'] = 0;
            $i['young_gxd_all'] = $member['young_gxd_all'];
            $i['young_gxd_now'] = $member['young_gxd'];
            $i['young_reward'] = $v;
            $i['young_reward_all'] = $member['young_reward_all'];
            $i['young_reward_now'] = $member['young_reward'];
            $i['created_at'] = DATE;
            $i['updated_at'] = DATE;

            $insert[] = $i;
        }

        if (count($insert) > 0) {

            $model = new MemberWalletModel();
            $model->insert($insert);
        }
    }
}