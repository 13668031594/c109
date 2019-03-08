<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Plan\PlanModel;

class PoundageGiveClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        $this->keyword = 'reggive';

        //已经成功发放过激活码
        if (parent::test_plan()) return;

        //判断是否有赠送
        $number = $this->set['accountRegGive'];
        $number = number_format($number, 2, '.', '');
        if ($number <= 0) {

            $record = '赠送数为0，停止赠送！';
            parent::store_plan($record);
            return;
        }

        //获取所有正常状态的会员
        $members = self::members();

        if (count($members) <= 0) {

            $record = '可赠送人数为0，赠送' . $this->set['walletPoundage'] . '0';
            parent::store_plan($record);
            return;
        }

        $mr = new MemberWalletModel();

        //循环赠送星火
        foreach ($members as $v) {

            $member = MemberModel::whereUid($v['uid'])->first();

            $member->young_poundage += $number;
            $member->young_poundage_all += $number;
            $member->save();

            $change = ['poundage' => $number];
            $r = '每日增送『' . $this->set['walletPoundage'] . '』' . $number;
            $mr->store_record($member, $change, 21, $r);
        }

        $record = '赠送' . $this->set['walletPoundage'] . ($number * count($members)) . '，合计赠送会员『' . count($members) . '』人';
        parent::store_plan($record);
    }

    private function members()
    {
        $members = MemberModel::whereYoungStatus('10')->get(['uid'])->toArray();
        foreach ($members as $k => $v){

            $test = BuyOrderModel::whereUid($v['uid'])->first();
            if (!is_null($test))unset($members[$k]);
        }

        return $members;
    }
}