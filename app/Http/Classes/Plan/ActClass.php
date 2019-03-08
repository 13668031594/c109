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
use App\Models\Plan\PlanModel;

class ActClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        //判断是否到了结果发放时间
        if (time() < parent::set_time($this->set['accountActResult'])) return;

        $this->keyword = 'act';
        if (parent::test_plan())return;

        //判断今天抢激活码的人数是否超过总发放激活码数
        $number = MemberActModel::whereYoungStatus('10')->count();

        //无人需要激活
        if ($number <= 0) {

            $record = '抢激活人数0，激活人数0';
            parent::store_plan($record);
            return;
        }

        if ($this->set['accountActNum'] <= 0) {

            $record = '激活码发放数为0,激活人数0';
            parent::store_plan($record);
            return;
        }

        $ids = self::all_act();

        //今日激活的会员id
        $act_ids = ($number < $this->set['accountActNum']) ? $ids : self::rob_act($ids);

        //激活会员
        self::act($act_ids);

        //激活失败的会员
        self::act_fails(array_diff($ids, $act_ids));

        //扣除上级星伙
        self::poundage($act_ids);
    }

    //所有的抢激活的人的id
    private function all_act()
    {
        return MemberActModel::whereYoungStatus('10')->get(['uid'])->pluck('uid')->toArray();
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

    //激活
    public function act($ids)
    {
        if (count($ids) <= 0) return;

        $model = new MemberModel();
        $model->whereIn('uid', $ids)->update(['young_act' => '30', 'young_act_time' => DATE, 'young_act_from' => '20']);
        $model = new MemberActModel();
        $model->whereIn('uid', $ids)->where('young_status', '=', '10')->update(['young_status' => '20']);
    }

    //激活失败
    public function act_fails($ids)
    {
        if (count($ids) <= 0) return;

        $model = new MemberModel();
        $model->whereIn('uid', $ids)->update(['young_act' => '10']);
        $model = new MemberActModel();
        $model->whereIn('uid', $ids)->where('young_status', '=', '10')->update(['young_status' => '30']);
    }

    //扣除上级星伙
    public function poundage($ids)
    {
        //激活星伙
        $poundage = $this->set['accountActPoundage'];

        //未收取星伙
        if ($poundage <= 0) return;

        //获取所有信息
        $model = new MemberModel();
        $referee = $model->whereIn('uid', $ids)->get(['uid', 'young_referee_id'])->groupBy('young_referee_id')->toArray();

        //结果数组
        $record = [];

        //结算每人激活的会员数量
        foreach ($referee as $k => $v) {

            //合计扣除的星伙
            $diff = count($v) * $poundage;

            //扣除星伙
            $member = MemberModel::whereUid($k)->first();
            $member->young_poundage -= $diff;
            $member->save();

            //添加扣除记录
            $record[$k]['uid'] = $k;
            $record[$k]['young_type'] = '30';
            $record[$k]['young_record'] = '激活了 ' . count($v) . ' 个账号，扣除 ' . $this->set['walletPoundage'] . ' ： ' . $diff;
            $record[$k]['young_keyword'] = '';
            $record[$k]['young_balance_all'] = $member->young_balance_all;
            $record[$k]['young_balance_now'] = $member->young_balance;
            $record[$k]['young_poundage_all'] = $member->young_poundage_all;
            $record[$k]['young_poundage_now'] = $member->young_poundage;
            $record[$k]['young_reward_all'] = $member->young_reward_all;
            $record[$k]['young_reward_now'] = $member->young_reward;
            $record[$k]['young_gxd_all'] = $member->young_gxd_all;
            $record[$k]['young_gxd_now'] = $member->young_gxd;
            $record[$k]['young_poundage'] = (0 - $diff);
            $record[$k]['created_at'] = DATE;
            $record[$k]['updated_at'] = DATE;
        }

        //扣除
        if (count($record) > 0) {

            $wallet = new MemberWalletModel();
            $wallet->insert($record);
        }
    }
}