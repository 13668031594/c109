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
use App\Models\Order\MatchOrderModel;

class MatchSureClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        if (time() < parent::set_time($this->set['inEnd'])) return;

        //所有超时订单
        $match_model = new MatchOrderModel();
        $match = $match_model->where('young_status', '=', '20')//待确认状态
        ->where('young_abn', '=', '10')//未异常
        ->get(['id', 'young_sell_uid', 'young_order']);

        if (count($match) <= 0) return;

        $gxd = $this->set['inOvertimePunishGxd'];
        $member_model = new MemberModel();
        $wallet_model = new MemberWalletModel();
        foreach ($match as $v) {

            //有贡献点惩罚
            if ($gxd > 0) {

                $member = $member_model->where('young_status', '!=', '30')->find($v->young_sell_uid);
                if (!is_null($member)) {

                    $member->young_gxd -= $gxd;
                    $member->save();
                    $change = ['gxd' => (0 - $gxd)];
                    $record = '匹配订单『交易号：' . $v->young_order . '』确认收款超时，罚款『' . $this->set['walletGxd'] . '』' . $gxd;
                    $wallet_model->store_record($member, $change, 51, $record);
                }
            }

            //自动确认收款
            if ($this->set['inOvertimeAuto'] == 'on') {

                MatchOrderModel::whereId($v->id)->update(['young_status' => '30']);

                $match_model->match_end($v->id);
            }
        }
    }
}