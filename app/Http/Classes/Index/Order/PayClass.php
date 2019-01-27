<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/26
 * Time: 下午4:23
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\ImageTrait;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\MatchOrderModel;
use Illuminate\Http\Request;

class PayClass extends IndexClass
{
    use ImageTrait;

    //付款惩罚
    public function pay(Request $request)
    {
        $term = [
            'image|支付凭证' => 'required|file|image|max:1024',
        ];

        parent::validators_json($request->file(), $term);

        $begin = parent::set_time($this->set['payStart']);
        $end = parent::set_time($this->set['payEnd']);
        $now = time();
        if (($now < $begin) || ($now > $end)) parent::error_json('请在每天 ' . $this->set['payStart'] . ' 至 ' . $this->set['payEnd'] . ' 付款');

        $id = $request->post('id');

        //获取会员
        $member = parent::get_member();

        //获取匹配订单
        $match = MatchOrderModel::whereId(100)->first();

        if (is_null($match)) parent::error_json('未找到该匹配订单');

        //判断归属人
        if ($match->young_buy_uid != $member['uid']) parent::error_json('只能支付自己的订单');

        //判断订单状态
        if (!in_array($match->young_status, [10, 11])) parent::error_json('订单已经付过款了');

        //保存付款凭证
        $images = $request->file('images')->store('public/Set');
        //获取图片地址
        $new = $this->cut($images, 400, 'public/Order/' . $id);
        $url = \Storage::url($new);
//        $url = 'test';

        //保存并修改订单状态
        $match->young_pay = $url;
        $match->young_status = 20;
        $match->save();
    }

    //付款奖励
    public function pay_reward()
    {
        $now = time();
        $member = parent::get_member();

        //有奖励
        if (!empty($set['payRewardGxd'])) {

            //判断奖励时间段
            $begin = parent::set_time($this->set['payRewardStart']);
            $end = parent::set_time($this->set['payRewardEnd']);
            if (($now >= $begin) && ($now <= $end)) {

                //奖励贡献点
                $gxd = $set['payRewardGxd'];

                $member = MemberModel::whereUid($member['uid']);
                $member->young_gxd += $gxd;
                $member->save();

                $wallet = new MemberWalletModel();
                $record = '订单快速付款，奖励『' . $this->set['walletGxd'] . '』' . $gxd;
                $change = ['gxd' => $gxd];
                $wallet->store_record($member, $change, 60, $record);
            }
        }

        //有惩罚
        if (!empty($set['payPunishGxd'])) {

            //判断惩罚时间段
            $begin = parent::set_time($this->set['payPunishStart']);
            $end = parent::set_time($this->set['payPunishEnd']);
            if (($now >= $begin) && ($now <= $end)) {

                //惩罚贡献点
                $gxd = $set['payPunishGxd'];

                $member = MemberModel::whereUid($member['uid']);
                $member->young_gxd -= $gxd;
                $member->save();

                $wallet = new MemberWalletModel();
                $record = '订单付款过慢，惩罚『' . $this->set['walletGxd'] . '』' . $gxd;
                $change = ['gxd' => (0 - $gxd)];
                $wallet->store_record($member, $change, 70, $record);
            }
        }
    }

    //确认付款
    public function confirm($id)
    {
        $begin = parent::set_time($this->set['inStart']);
        $end = parent::set_time($this->set['inEnd']);
        $now = time();
        if (($now < $begin) || ($now > $end)) parent::error_json('请在每天 ' . $this->set['inStart'] . ' 至 ' . $this->set['inEnd'] . ' 确认收款');

        //获取会员
        $member = parent::get_member();

        //获取匹配订单
        $match = MatchOrderModel::whereId($id)->first();

        if (is_null($match)) parent::error_json('未找到该匹配订单');

        //判断归属人
        if ($match->young_sell_uid != $member['uid']) parent::error_json('只能确认自己的订单');

        //判断订单状态
        if ($match->young_status != '20') parent::error_json('该订单无法确认收款');

        //保存并修改订单状态
        $match->young_status = 30;
        $match->save();

        //触发付款完结后的一系列操作
        $match->match_end($id);
    }
}