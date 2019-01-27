<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午6:25
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\MemberWithdrawModel;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\SellOrderModel;
use Illuminate\Http\Request;

class SellClass extends IndexClass
{
    public function index()
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']]
        ];

        $other = [
            'where' => $where
        ];

        return parent::list_page('sell_order', $other);
    }

    public function match($id)
    {
        $where = [
            ['young_sell_id', '=', $id]
        ];

        $order = [
            'created_at' => 'desc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $order,
            'select' => [
                'id','young_buy_order as buyCode','young_sell_order as sellCode','young_total as amount','created_at',
                'young_status','young_buy_nickname as to','young_pay_time as payTime','young_bank_name as bankName',
                'young_bank_no as bankNo','young_bank_address as bankAddress','young_bank_man as bankUser','young_alipay',
                'young_note as bankNote','young_sell_nickname as payee','young_buy_uid'
            ],
        ];

        $member = parent::get_member();

        $result = parent::list_all('match_order', $other);
        foreach ($result as &$v){

            $v['toReferee'] = MemberModel::whereUid($v['buy_uid'])->first()->young_referee_nickname;
            unset($v['buy_uid']);
            $v['payeeReferee'] = $member['referee_nickname'];
        }

        return $result;
    }

    public function record($id)
    {
        $where = [
            ['young_order', '=', $id]
        ];

        $order = [
            'created_at' => 'desc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $order,
        ];

        return parent::list_all('sell_order_record', $other);
    }

    public function member_set()
    {
        $setting = $this->set;

        $set = [
            'sellBase' => $setting['sellBase'],
            'sellTimes' => $setting['sellTimes'],
        ];

        return $set;
    }

    public function validator_store(Request $request)
    {
        $set = $this->set;//配置文件
        $data = $request->post();//获取参数
        $member = parent::get_member();//会员参数

        if (($set['sellPoundageNone'] == 'off') && ($member['poundage'] < 0)) parent::error_json('手续费为负时，无法卖出');

        $term = [
            'amount|订单总价' => 'required|numeric|between:1,100000000',
            'accountType|支付类型' => 'required|in:1,2'
        ];

        parent::validators_json($request->post(), $term);

        $data['total'] = $data['amount'];
        $data['type'] = $data['accountType'];

        if (($data['total'] % $set['sellTimes']) != '0') parent::error_json('卖出金额必须是『' . $set['sellTimes'] . '』的正整数倍');
        if ($data['total'] < $set['sellBase']) parent::error_json('卖出金额必须大于：' . $set['sellBase']);

        if (empty($member['bank_no']) ||
            empty($member['bank_man'])
        ) parent::error_json('请先完善收款信息');

        if (empty($member['alipay'])) {

            if (empty($member['bank_id']) ||
                empty($member['bank_name']) ||
                empty($member['bank_address'])
            ) parent::error_json('请先完善收款信息');
        }

        $type = $request->post('type');
        if ($type == '1') {

            if ($member['balance'] < $data['total']) parent::error_json($this->set['walletBalance'] . '不足');
        } else {

            //判断负手续费提现
            if (($set['rewardPoundageNone'] == 'off') && ($member['poundage'] < 0)) parent::error_json('手续费为负时，无法提现' . $set['walletReward']);

            //判断提现次数
            $begin = date('Y-m-d 00:00:00');
            $test = MemberWithdrawModel::whereUid($member['uid'])->where('created_at', '>', $begin)->first();
            if (!is_null($test)) parent::error_json('今天不能再提现了');

            //判断提现数额是否小于上次
            $last = MemberWithdrawModel::whereUid($member['uid'])->orderBy('created_at', 'desc')->first();
            if (!is_null($last) && ($data['total'] < $last->young_reward)) parent::error_json('提现数额不得小于上次提现数额：' . $last->young_reward);

            //判断奖励账户是否足够
            $reward = number_format(($data['total'] / $set['rewardDeposit'] * 100), 2, '.', '');
            if ($member['reward'] < $reward) parent::error_json($this->set['walletReward'] . '不足,需要：' . $reward);
        }
    }

    public function store(Request $request)
    {
        $data = $request->post();
        $member = parent::get_member();

        $data['total'] = $data['amount'];
        $data['type'] = $data['accountType'];

        //新增订单信息
        $order = new SellOrderModel();
        $order->young_order = $order->new_order();
        $order->uid = $member['uid'];
        $order->young_total = $data['total'];
        $order->young_remind = $data['total'];
        $order->young_bank_id = $member['bank_id'] ?? null;
        $order->young_bank_name = $member['bank_name'] ?? null;
        $order->young_bank_address = $member['bank_address'] ?? null;
        $order->young_bank_no = $member['bank_no'] ?? null;
        $order->young_bank_man = $member['bank_man'] ?? null;
        $order->young_alipay = $member['alipay'] ?? null;
        $order->young_note = $member['note'] ?? null;
        $order->save();

        //扣除会员余额
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_balance -= $data['total'];
        if (is_null($member->young_first_sell_time)) {
            $member->young_first_sell_time = DATE;
            $member->young_first_sell_total = $data['total'];
        }
        $member->young_last_sell_time = DATE;
        $member->young_last_sell_total = $data['total'];
        $member->young_all_sell_total += $data['total'];

        if ($data['type'] == '1') {

            $member->young_balance -= $data['total'];

            //添加钱包记录
            $wallet = new MemberWalletModel();
            $record = '挂卖订单，订单号『' . $order->young_order . '』,扣除『' . $this->set['walletBalance'] . '』' . $data['total'];
            $keyword = $order->young_order;
            $change = ['balance' => (0 - $data['total'])];
            $wallet->store_record($member, $change, 50, $record, $keyword);
        } else {

            $member->young_reward -= $data['total'];

            //添加钱包记录
            $wallet = new MemberWalletModel();
            $record = '提现' . $this->set['walletReward'] . '，订单号『' . $order->young_order . '』,扣除『' . $this->set['walletReward'] . '』' . $data['total'];
            $keyword = $order->young_order;
            $change = ['reward' => (0 - $data['total'])];
            $wallet->store_record($member, $change, 55, $record, $keyword);
        }


        $member->save();
    }
}