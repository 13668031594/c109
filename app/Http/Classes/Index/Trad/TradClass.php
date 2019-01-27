<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午4:54
 */

namespace App\Http\Classes\Index\Trad;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Trad\TradModel;
use Illuminate\Http\Request;

class TradClass extends IndexClass
{
    public function index()
    {
        $member = parent::get_member();

        $where = [

        ];

        if (request()->get('id')) $where[] = ['young_sell_uid', '=', $member['uid']];

        $other = [
            'where' => $where,
            'orderBy' => [
                'young_status' => 'asc',
                'young_amount' => 'asc',
            ],
        ];

        $result = parent::list_page('trad', $other);

        return $result;
    }

    public function store(Request $request)
    {
        $term = [
            'gxd|卖出' . $this->set['walletGxd'] => 'required|numeric|between:1,100000000',
            'balance|收入' . $this->set['walletBalance'] => 'required|numeric|between:1,100000000',
        ];

        parent::validators_json($request->post(), $term);

        $member = parent::get_member();
        $data = $request->post();

        if ($member['gxd'] < $data['gxd']) parent::error_json($this->set['walletGxd'] . '不足');

        $amount = number_format(($data['gxd'] / $data['balance']), 8, '.', '');
        if ($amount <= 0) parent::error_json('单价过低，不得超过小数点后8位');

        $model = new TradModel();
        $model->young_order = $model->new_order();
        $model->young_sell_uid = $member['uid'];
        $model->young_sell_nickname = $member['nickname'];
        $model->young_gxd = $data['gxd'];
        $model->young_balance = $data['balance'];
        $model->young_amount = $amount;
        $model->save();

        //扣除会员钱包
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_gxd -= $data['gxd'];
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '卖出，订单号『' . $model->young_order . '』,扣除『' . $this->set['walletGxd'] . '』' . $data['gxd'];
        $keyword = $model->young_order;
        $change = ['gxd' => (0 - $data['gxd'])];
        $wallet->store_record($member, $change, 90, $record, $keyword);
    }

    public function buy($id)
    {
        $trad = TradModel::whereId($id)->first();
        if (is_null($trad)) parent::error_json('订单不存在');

        $member = parent::get_member();
        if ($trad->young_sell_uid == $member['uid']) parent::error_json('不能购买自己的订单');

        if ($member['balance'] < $trad->young_balance) parent::error_json($this->set['walletBalance'] . '不足');

        //修改订单状态
        $trad->young_status = 50;
        $trad->young_buy_uid = $member['uid'];
        $trad->young_buy_nickname = $member['nickname'];
        $trad->young_pay_time = DATE;
        $trad->save();

        //扣除会员钱包
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_balance -= $trad->young_balance;
        $member->young_gxd += $trad->young_gxd;
        $member->young_gxd_all += $trad->young_gxd;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '买入，订单号『' . $trad->young_order . '』,扣除『' . $this->set['walletBalance'] . '』' . $trad->young_balance . '，获得『' . $this->set['walletGxd'] . '』' . $trad->young_gxd;
        $keyword = $trad->young_order;
        $change = ['gxd' => $trad->young_gxd, 'balance' => (0 - $trad->young_balance)];
        $wallet->store_record($member, $change, 90, $record, $keyword);

        //扣除会员钱包
        $member = MemberModel::whereUid($trad->young_sell_uid)->first();
        $member->young_balance += $trad->young_balance;
        $member->young_balance_all += $trad->young_balance;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '卖出成功，订单号『' . $trad->young_order . '』,获得『' . $this->set['walletBalance'] . '』' . $trad->young_balance;
        $keyword = $trad->young_order;
        $change = ['balance' => $trad->young_balance];
        $wallet->store_record($member, $change, 90, $record, $keyword);
    }
}