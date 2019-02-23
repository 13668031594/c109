<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午4:54
 */

namespace App\Http\Classes\Index\Trad;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\DxbSmsTrait;
use App\Http\Traits\GetuiTrait;
use App\Http\Traits\ImageTrait;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Trad\TradModel;
use Illuminate\Http\Request;

class TradClass extends IndexClass
{
    use ImageTrait, DxbSmsTrait, GetuiTrait;

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

        foreach ($result['message'] as &$v) {

            $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . $v['pay']);
        }

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
        if (empty($member['bank_no']) ||
            empty($member['bank_man'])
        ) parent::error_json('请先完善收款信息');

        if (empty($member['alipay'])) {

            if (empty($member['bank_id']) ||
                empty($member['bank_name']) ||
                empty($member['bank_address'])
            ) parent::error_json('请先完善收款信息');
        }

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
        $model->young_bank_id = $member['bank_id'] ?? null;
        $model->young_bank_name = $member['bank_name'] ?? null;
        $model->young_bank_address = $member['bank_address'] ?? null;
        $model->young_bank_no = $member['bank_no'] ?? null;
        $model->young_bank_man = $member['bank_man'] ?? null;
        $model->young_alipay = $member['alipay'] ?? null;
        $model->young_note = $member['note'] ?? null;
        $model->save();

        //扣除会员钱包
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_gxd -= $all;
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = $this->set['walletGxd'] . '卖出，订单号『' . $model->young_order . '』,扣除『' . $this->set['walletGxd'] . '』' . $data['gxd'];
        if (!empty($poundage)) $record .= '，支付星伙：' . $poundage;
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

        $trad->young_status = '20';
        $trad->young_buy_uid = $member['uid'];
        $trad->young_buy_nickname = $member['nickname'];
        $trad->save();

        $seller = MemberModel::whereUid($trad->young_sell_uid)->first();
        if (is_null($seller)) return;
        $body = '您的挂售订单被认购了';
        $content = '您的挂售订单被认购了，订单号『' . $trad->young_order . '』';
        if (!empty($seller->young_phone)) $this->sendSms($seller->young_phone, $content);
        if (!empty($seller->young_cid)) $this->pushSms($seller->young_cid, $body);
    }

    //提交付款凭证
    public function pay($id, Request $request)
    {
        $term = [
            'image|支付凭证' => 'required|image|max:5120',
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

        $seller = MemberModel::whereUid($trad->young_sell_uid)->first();
        if (is_null($seller)) return;
        $body = '您的挂售订单已经付款，请确认';
        $content = '您的挂售订单已经付款，请确认，订单号『' . $trad->young_order . '』';
        if (!empty($seller->young_phone)) $this->sendSms($seller->young_phone, $content);
        if (!empty($seller->young_cid)) $this->pushSms($seller->young_cid, $body);
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

        $buyer = MemberModel::whereUid($trad->young_buy_uid)->first();
        if (is_null($buyer)) return;
        $body = '你购买的挂售订单已经确认收款了';
        $content = '你购买的挂售订单已经确认收款了，订单号『' . $trad->young_order . '』';
        if (!empty($buyer->young_phone)) $this->sendSms($buyer->young_phone, $content);
        if (!empty($buyer->young_cid)) $this->pushSms($buyer->young_cid, $body);
    }


}