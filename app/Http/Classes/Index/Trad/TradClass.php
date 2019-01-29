<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午4:54
 */

namespace App\Http\Classes\Index\Trad;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\ImageTrait;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Trad\TradModel;
use Illuminate\Http\Request;

class TradClass extends IndexClass
{
    use ImageTrait;

    public function index()
    {
        $member = parent::get_member();

        $type = \request()->get('type');

        if (is_null($type)) {

            $where = [
                ['young_status', '=', '10'],
                ['young_sell_uid', '<>', $member['uid']]
            ];

            $orderBy = [
                'young_status' => 'asc',
                'young_amount' => 'asc',
                'created_at' => 'desc',
            ];
        } else {

            if ($type == '1') {

                //我的挂售

                $where = [
                    ['young_sell_uid', '=', $member['uid']]
                ];

                $orderBy = [
                    'young_status' => 'asc',
                    'created_at' => 'desc',
                ];
            } else {

                //我的认购

                $where = [
                    ['young_buy_uid', '=', $member['uid']]
                ];

                $orderBy = [
                    'young_status' => 'asc',
                    'created_at' => 'desc',
                ];
            }

        }

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
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
        $set = $this->set;
        if ($data['gxd'] < $set['consignBase']) parent::error_json('挂售金额不得低于' . $set['consignBase']);
        if (($data['gxd'] % $set['consignTimes']) != '0') parent::error_json('挂售金额必须是『' . $set['consignTimes'] . '』的正整数倍');
        $poundage = empty($set['consignPoundage']) ? 0 : number_format(($data['gxd'] * $set['consignPoundage'] / 100), 2, '.', '');
        $all = $data['gxd'] + $poundage;
        if ($member['gxd'] < $all) parent::error_json($this->set['walletGxd'] . '不足，共需：' . $all);

        $amount = number_format(($data['gxd'] / $data['balance']), 8, '.', '');
        if ($amount <= 0) parent::error_json('单价过低，不得超过小数点后8位');

        $model = new TradModel();
        $model->young_order = $model->new_order();
        $model->young_sell_uid = $member['uid'];
        $model->young_sell_nickname = $member['nickname'];
        $model->young_gxd = $data['gxd'];
        $model->young_balance = $data['balance'];
        $model->young_amount = $amount;
        $model->young_poundage = $poundage;
        $model->save();

        //扣除会员钱包
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_gxd -= $all;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '卖出，订单号『' . $model->young_order . '』,扣除『' . $this->set['walletGxd'] . '』' . $data['gxd'];
        if (!empty($poundage)) $record .= '，支付手续费：' . $poundage;
        $keyword = $model->young_order;
        $change = ['gxd' => (0 - $all)];
        $wallet->store_record($member, $change, 90, $record, $keyword);
    }

    //撤回
    public function back($id)
    {
        $member = parent::get_member();

        $model = TradModel::whereId($id)->first();
        if (is_null($model)) parent::error_json('订单不存在');
        if ($model->young_sell_uid != $member['uid']) parent::error_json('只能撤回自己的订单');
        if ($model->young_status != '10') parent::error_json('该订单已无法撤回');

        $model->young_status = '60';
        $model->save();

        $all = ($model->young_gxd + $model->young_poundage);

        //扣除会员钱包
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_gxd += $all;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '卖出订单撤回，订单号『' . $model->young_order . '』,返还『' . $this->set['walletGxd'] . '』' . $all;
        $keyword = $model->young_order;
        $change = ['gxd' => $all];
        $wallet->store_record($member, $change, 90, $record, $keyword);
    }

    //认购订单
    public function buy($id)
    {
        $trad = TradModel::whereId($id)->first();
        if (is_null($trad)) parent::error_json('订单不存在');

        if ($trad->young_status != '10') parent::error_json('不能认购');

        $member = parent::get_member();
//        if ($trad->young_sell_uid == $member['uid']) parent::error_json('不能认购自己的订单');

        $trad->young_status = '60';
        $trad->young_buy_uid = $member['uid'];
        $trad->young_buy_nickname = $member['nickname'];
        $trad->save();
    }

    //提交付款凭证
    public function pay($id, Request $request)
    {
        $term = [
            'image|支付凭证' => 'required|image|max:1024',
        ];

        parent::validators_json($request->all(), $term);

        //获取会员
        $member = parent::get_member();

        $trad = TradModel::whereId($id)->first();
        if (is_null($trad)) parent::error_json('订单不存在');

        //判断归属人
        if ($trad->young_buy_uid != $member['uid']) parent::error_json('只能支付自己的订单');

        //判断订单状态
        if (!in_array($trad->young_status, [20, 30])) parent::error_json('订单无法付款');

        //保存付款凭证
        $images = $request->file('image')->store('public/Trad');
        //获取图片地址
        $new = $this->cut($images, 400, 'public/Trad/' . $id);
        $url = \Storage::url($new);
//        $url = '123';
        //保存并修改订单状态
        $trad->young_pay = $url;
        $trad->young_pay_time = DATE;
        $trad->young_status = '30';
        $trad->save();
    }

    //确认收款
    public function over($id)
    {
        $trad = TradModel::whereId($id)->first();
        if (is_null($trad)) parent::error_json('订单不存在');

        if ($trad->young_status != '30') parent::error_json('不能完结此订单');

        $member = parent::get_member();
        if ($trad->young_sell_uid != $member['uid']) parent::error_json('只能确认自己的订单');

        $buy = MemberModel::whereUid($trad->young_buy_uid)->first();

        //修改订单状态
        $trad->young_status = 50;
        $trad->save();

        //加会员钱包
        $member = MemberModel::whereUid($buy->uid)->first();
        $member->young_gxd += $trad->young_gxd;
        $member->young_gxd_all += $trad->young_gxd;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '买入，订单号『' . $trad->young_order . '』，获得『' . $this->set['walletGxd'] . '』' . $trad->young_gxd;
        $keyword = $trad->young_order;
        $change = ['gxd' => $trad->young_gxd];
        $wallet->store_record($member, $change, 90, $record, $keyword);
    }


}