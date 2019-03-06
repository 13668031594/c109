<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Http\Traits\DxbSmsTrait;
use App\Http\Traits\GetuiTrait;
use App\Http\Traits\MessageTrait;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Plan\PlanModel;

class MatchSureClass extends PlanClass
{
    use DxbSmsTrait, GetuiTrait, MessageTrait;

    public function __construct()
    {
        parent::__construct();

        if (time() < parent::set_time($this->set['inEnd'])) return;

        //判断今天是否成功对确认收款超时进行处罚
        $test = new PlanModel();
        $test = $test->where('young_type', '=', 'match_sure')
            ->where('young_status', '=', '10')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->first();

        //已经成功发放过激活码
        if (!is_null($test)) return;

        //所有超时订单
        $match_model = new MatchOrderModel();
        $match = $match_model->where('young_status', '=', '20')//待确认状态
        ->where('young_abn', '=', '10')//未异常
        ->get();

        if (count($match) <= 0) return;

        $gxd = $this->set['inOvertimePunishGxd'];
        $poundage = $this->set['inOvertimePunishPoundage'];
        $member_model = new MemberModel();
        $wallet_model = new MemberWalletModel();
        foreach ($match as $v) {

            //有贡献点惩罚
            if (($gxd > 0) || ($poundage > 0)) {

                $member = $member_model->where('young_status', '!=', '30')->find($v->young_sell_uid);
                if (!is_null($member)) {

                    $change = [];
                    $record = '匹配订单『' . $v->young_order . '』确认收款超时，罚款';
                    if ($gxd > 0) {

                        $member->young_gxd -= $gxd;
                        $change['gxd'] = (0 - $gxd);
                        $record .= '『' . $this->set['walletGxd'] . '』' . $gxd . '。';
                    }
                    if ($poundage > 0) {

                        $member->young_poundage -= $poundage;
                        $change['poundage'] = (0 - $poundage);
                        $record .= '『' . $this->set['walletPoundage'] . '』' . $poundage . '。';
                    }
                    $member->save();
                    $wallet_model->store_record($member, $change, 51, $record);

                    $this->sendMessage($member->uid, 10, $record);
//                    if (!empty($member->young_phone)) $this->sendSms($member->young_phone, $record);
                    if (!empty($member->young_cid)) $this->pushSms($member->young_cid, $record);
                }
            }

            //自动确认收款
            if ($this->set['inOvertimeAuto'] == 'on') {

                $buyer = MemberModel::whereUid($v->young_buy_uid)->first();
                if (is_null($buyer)) return;
                $body = '您的采集订单有了新的进展';
                $content = '您的采集订单有了新的进展，订单号『' . $v->young_buy_order . '』，交易号『' . $v->young_order . '』';
                $this->sendMessage($buyer->uid, 20, $content);
//                if (!empty($buyer->young_phone)) $this->sendSms($buyer->young_phone, $content);
                if (!empty($buyer->young_cid)) $this->pushSms($buyer->young_cid, $body);

                MatchOrderModel::whereId($v->id)->update(['young_status' => '30']);

                $match_model->match_end($v->id);
            }
        }

        self::store_plan('成功处罚超时订单：' . count($match) . '个', 10);
    }

    //添加本次激活记录
    private function store_plan($record, $status = 10)
    {
        $plan = new PlanModel();
        $plan->store_plan('act', $record, $status);
    }
}