<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/24
 * Time: 下午6:25
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\OrderSignModel;
use App\Models\Order\RobModel;
use Illuminate\Http\Request;

class BuyClass extends IndexClass
{
    public function index($type = null)
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']],
        ];

        $select = ['id', 'young_order as orderNo', 'young_total as amount', 'created_at', 'young_status', 'young_number', 'young_abn', 'young_from', 'young_grade'];

        $type = \request()->get('type');
        if ($type == '1') {

            $where[] = ['young_status', '<', 70];
        }
        if ($type == '2') {
            $where[] = ['young_status', '>=', 70];
            $where[] = ['young_status', '<', 90];
            $select = array_merge($select, ['young_in_over', 'young_in']);
        }
        if ($type == '3') {
            $where[] = ['young_status', '>=', 70];
            $select = array_merge($select, ['young_in_over', 'young_in']);
        }

        $other = [
            'where' => $where,
            'orderBy' => [
                'young_status' => 'asc',
                'created_at' => 'desc',
            ],
            'select' => $select,
        ];

        $result = parent::list_page('buy_order', $other);

        //判断是否加速
        foreach ($result['message'] as &$v) $v['speed'] = ($v['grade'] == '10') ? '1' : '0';

        return $result;
    }

    public function existAmount($id)
    {
        $amount = 0;

        $order = BuyOrderModel::whereId($id)->first();

        if (!is_null($order->young_first_match)) $amount += $order->young_first_total;

        $amount += $order->young_tail_complete;

        return $amount;
    }

    public function match($id)
    {
        $where = [
            ['young_buy_id', '=', $id]
        ];

        $order = [
            'young_status' => 'asc',
            'created_at' => 'desc',
        ];

        $other = [
            'where' => $where,
            'orderBy' => $order,
            'select' => [
                'id', 'young_buy_order as buyCode', 'young_sell_order as sellCode', 'young_total as amount', 'created_at',
                'young_status', 'young_buy_nickname as to', 'young_pay_time as payTime', 'young_bank_name as bankName',
                'young_bank_no as bankNo', 'young_bank_address as bankAddress', 'young_bank_man as bankUser', 'young_alipay',
                'young_note as bankNote', 'young_sell_nickname as payee', 'young_sell_uid', 'young_abn', 'young_pay',
                'young_pay_time', 'young_order'
            ],
        ];

        $member = parent::get_member();

        $result = parent::list_all('match_order', $other);
        foreach ($result as &$v) {

            $v['payeeReferee'] = MemberModel::whereUid($v['sell_uid'])->first()->young_referee_nickname;
            $v['toReferee'] = $member['referee_nickname'];
            $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . $v['pay']);
            unset($v['sell_uid']);
            unset($v['pay']);
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

        return parent::list_all('buy_order_record', $other);
    }

    //历史订单最高金额
    public function top_order()
    {
        $member = parent::get_member();

        //获取历史金额最高的一单
        $top = BuyOrderModel::whereUid($member['uid'])->orderBy('young_total', 'desc')->first();

        return !$top ? '0' : $top['young_total'];
    }

    public function member_set()
    {
        $setting = $this->set;

        $set = [
            'buySwitch' => $setting['buySwitch'],
            'buyPoundage' => $setting['buyPoundage'],
            'buyPoundageNone' => $setting['buyPoundageNone'],
            'buyTotalUpSwitch' => $setting['buyTotalUpSwitch'],
            'goodsName' => $setting['goodsName'],
            'goodsTotal' => $setting['goodsTotal'],
            'goodsCover' => 'http://' . env('LOCALHOST') . '/' . $setting['goodsCover'],
            'topOrder' => self::top_order(),
        ];

        $member = parent::get_member();

        switch ($member['mode']) {
            case '10':
                $set['goodsNumber'] = $setting['goodsTop0'];
                $set['goodsLower'] = $setting['goodsType0'];
                $set['goodsCeil'] = $setting['goodsType0'];
                break;
            case '20':
                $set['goodsNumber'] = $setting['goodsTop1'];
                $set['goodsLower'] = $setting['goodsType1'];
                $set['goodsCeil'] = $setting['goodsType1'];
                break;
            default:
                parent::error_json('请刷新重试（mode）');
                break;
        }

        switch ($member['type']) {
            case '20':
                $set['inPro'] = $setting['typePro0'];
                break;
            default:
                $set['inPro'] = $setting['typePro1'];
                break;
        }

        return $set;
    }

    public function validator_store(Request $request)
    {
        $set = $this->set;//配置文件
        $data = $request->post();//获取参数
        $member = parent::get_member();//会员参数

        if ($set['buySwitch'] != 'on') parent::error_json('暂时无法采集');//手动采集开关

        $number_max = 0;
        $time_lower = 0;
        $time_ceil = 0;
        switch ($member['mode']) {
            case '10':
                $time_lower = $set['goodsType0'];
                $time_ceil = $set['goodsType0'];
                $number_max = $set['goodsTop0'];
                //寻找该会员的最后一个订单
                $last = new BuyOrderModel();
                $last = $last->where('uid', '=', $member['uid'])->where('young_status', '<', '70')->orderBy('created_at', 'desc')->first();
                if (!is_null($last)) parent::error_json('上一个订单尚未付完全款');
                break;
            case '20':
                $time_lower = $set['goodsType1'];
                $time_ceil = $set['goodsType1'];
                $number_max = $set['goodsTop1'];
                //寻找该会员的最后一个订单
                $last = new BuyOrderModel();
                $last = $last->where('uid', '=', $member['uid'])->orderBy('created_at', 'desc')->first();
                if (!is_null($last)) {

                    if ($last->young_status < 40) parent::error_json('上一个订单尚未付首款');
                    if ($last->created_at >= date('Y-m-d 00:00:00')) parent::error_json('一天只能下一个单');
//                    if (time() < strtotime('+' . $this->set['goodsLower1'] . ' day', strtotime($last->created_at))) parent::error_json('还未到下一个排单周期');
                }
                break;
            default:
                parent::error_json('请刷新重试（mode）');
                break;
        }

        $term = [
            'total|订单总价' => 'required|numeric|between:1,100000000',
            'amount|商品单价' => 'required|numeric|between:1,100000000',
            'number|采集数量' => 'required|integer|between:1,' . $number_max,
            'time|收益时间' => 'required|integer|between:' . $time_lower . ',' . $time_ceil,
            'poundage|星伙' => 'required|integer|between:1,100000000',
            'inPro|收益率' => 'required|numeric|between:0,100',
        ];

        parent::validators_json($request->post(), $term);

        switch ($member['type']) {
            case '20':
                if ($data['inPro'] != $set['typePro0']) parent::error_json('请刷新重试（inPro）');
                break;
            default:
                if ($data['inPro'] != $set['typePro1']) parent::error_json('请刷新重试（inPro）');
                break;
        }

        $poundage = $data['poundage'] * $data['number'];

        if (($set['buyPoundageNone'] != 'on') && ($poundage > $member['poundage'])) parent::error_json($this->set['walletPoundage'] . '不足');
        if ($data['poundage'] != ($set['buyPoundage'] * $data['number'])) parent::error_json('请刷新重试（poundage）');
        if ($data['amount'] != $set['goodsTotal']) parent::error_json('请刷新重试（amount）');
        if ($data['total'] != ($data['amount'] * $data['number'])) parent::error_json('请刷新重试（total）');
        $top = self::top_order();
        if (($set['buyTotalUpSwitch'] == 'on') && ($data['total'] < $top)) parent::error_json('订单金额不得低于' . $top);
    }

    public function store(Request $request)
    {
        $data = $request->post();
        $member = parent::get_member();
        $set = $this->set;
        $poundage = $data['poundage'];
        $gxd_pro = 0;//贡献点比例
        $gxd = 0;//贡献点
        if ($member['type'] == '20') {

            $gxd_pro = ($set['typePro1'] - $set['typePro0']);
            if ($gxd_pro > 0) {

                $gxd = number_format(($gxd_pro * $data['total'] * $data['time'] / 100), 2, '.', '');
            } else {

                $gxd_pro = 0;
            }
        }

        //新增订单信息
        $order = new BuyOrderModel();
        $order->young_order = $order->new_order();
        $order->young_from = '10';//系统派单
        $order->uid = $member['uid'];
        $order->young_total = $data['total'];
        $order->young_days = $data['time'];
        $order->young_in_pro = $data['inPro'];
        $order->young_in = number_format(($data['inPro'] * $data['total'] * $data['time'] / 100), 2, '.', '');
        $order->young_amount = $data['amount'];
        $order->young_number = $data['number'];
        $order->young_poundage = $poundage;
        $order->young_name = $this->set['goodsName'];
        $order->young_first_total = number_format(($data['total'] * $this->set['matchFirstPro'] / 100), 2, '.', '');
        $order->young_first_pro = $this->set['matchFirstPro'];
        $order->young_tail_total = $order->young_total - $order->young_first_total;
        $order->young_gxd_pro = $gxd_pro;
        $order->young_gxd = $gxd;
        $order->young_grade = $member['grade'];
        $order->save();

        //扣除会员星伙
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_poundage -= $poundage;
        if (is_null($member->young_first_buy_time)) {
            $member->young_first_buy_time = DATE;
            $member->young_first_buy_total = $data['total'];
        }
        $member->young_last_buy_time = DATE;
        $member->young_last_buy_total = $data['total'];
        $member->young_all_buy_total += $data['total'];
        $member->save();

        //添加钱包记录
        $wallet = new MemberWalletModel();
        $record = '自主采集，订单号『' . $order->young_order . '』,扣除『' . $this->set['walletPoundage'] . '』' . $poundage;
        $keyword = $order->young_order;
        $change = ['poundage' => (0 - $poundage)];
        $wallet->store_record($member, $change, 40, $record, $keyword);

        //将自动抢单设定为失败
        RobModel::whereUid($member->uid)->update(['young_status' => '30']);
    }

    //自主采集列表
    public function auto_list($number, $time)
    {
        $member = parent::get_member();

        if ($member['mode'] != '20') parent::error_json('只有未防撞状态才能开启自动采集');

        $last = new BuyOrderModel();
        $last = $last->where('uid', '=', $member['uid'])->orderBy('created_at', 'desc')->first();

        if (is_null($last)) {

            $begin = strtotime('tomorrow');
        } else {

            $add = empty($member['auto_time']) ? $this->set['goodsLower1'] : $member['auto_time'];

            $begin = strtotime('+ ' . $add . 'day', strtotime($last->created_at));
        }

        $set = $this->set;
        $amount = $set['goodsTotal'];
        $time_lower = $set['goodsLower1'];
        $time_ceil = $set['goodsCeil1'];
        $number_max = $set['goodsTop1'];

        if ($time < $time_lower) $time = $time_lower;//保证收益周期不低于配置周期
        if ($time > $time_ceil) $time = $time_ceil;//保证收益周期不高于配置周期
        if ($number <= 0) $number = 1;//保证采集数量不小于1
        if ($number > $number_max) $number = $number_max;//保证采集数量不大于配置最高数量

        $result = [];
        for ($i = 6; $i > 0; $i--) {

            $date = date('Y-m-d', $begin);

            $a = [
                'number' => $number,
                'time' => $time,
                'amount' => $amount,
                'total' => number_format(($amount * $number), 2, '.', ''),
                'date' => $date
            ];

            $begin = strtotime('+ ' . $time . 'day', $begin);

            $result[] = $a;
        }

        return $result;
    }

    public function auto_change(Request $request)
    {
        $set = $this->set;//配置文件
        $member = parent::get_member();//会员参数

        if ($member['mode'] != '20') parent::error_json('只有未防撞状态才能开启自动采集');
        if ($set['buySwitch'] != 'on') parent::error_json('暂时无法采集');//手动采集开关
        $top_order = self::top_order();

        $time_lower = $set['goodsLower1'];
        $time_ceil = $set['goodsCeil1'];
        $number_max = $set['goodsTop1'];

        $term = [
            'switchValue|自动采集开关' => 'required|in:10,20',
            'number|采集数量' => 'required_if:switchValue,10|integer|between:1,' . $number_max,
            'time|收益时间' => 'required_if:switchValue,10|integer|between:' . $time_lower . ',' . $time_ceil,
        ];

        parent::validators_json($request->post(), $term);

        $total = $request->post('number') * $this->set['goodsTotal'];

        if (($request->post('switchValue') == '10') && ($this->set['buyTotalUpSwitch'] == 'on') && ($total < $top_order)) parent::error_json('采集金额必须大于历史最大金额：' . $top_order);

        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_auto_buy = $request->post('switchValue');
        $member->young_auto_number = $request->post('number') ?? null;
        $member->young_auto_time = $request->post('time') ?? null;
        $member->save();
    }

    public function withdraw($id)
    {
        $member = parent::get_member();

        $buy = BuyOrderModel::whereId($id)->first();

        if ($buy->uid != $member['uid']) parent::error_json('只能提现自己的订单');

        if (($buy->young_status != 79) && ($buy->young_status != 80)) parent::error_json('此订单还不能提现');

        if (($buy->young_status == 79) && ($member['poundage'] < $buy->young_poundage) && ($this->set['buyPoundageNone'] != 'on')) parent::error_json('请先充值' . $this->set['walletPoundage'] . '为正数');

        if (($member['gxd'] < 0) && ($this->set['withdrawSwitch'] != 'on')) parent::error_json('请先充值' . $this->set['walletGxd'] . '为正数');

//        if ($buy->young_sign_days < $buy->young_days) parent::error_json('签到时间不足，无法提现，需再签到：' . ($buy->young_days - $buy->young_sign_days));

        $member = MemberModel::whereUid($member['uid'])->first();
        $change = [];
        $record = '';
        $all = $buy->young_in + $buy->young_total;
        if ($buy->young_status == 79) {

            $member->young_poundage -= $buy->young_poundage;

            //添加钱包记录
            $record = '订单提现，订单号『' . $buy->young_order . '』,获得『' . $this->set['walletBalance'] . '』' . $all . '，补缴『' . $this->set['walletPoundage'] . '』' . $buy->young_poundage;
            $change = ['balance' => $all, 'poundage' => (0 - $buy->young_poundage)];
        } elseif ($buy->young_status == 80) {

            //添加钱包记录
            $record = '订单提现，订单号『' . $buy->young_order . '』,获得『' . $this->set['walletBalance'] . '』' . $all;
            $change = ['balance' => $all];
        } else {

            parent::error_json('提现失败');
        }

        $buy->young_status = 90;
        $buy->save();

        //取消贡献点奖励
//        $buy->young_gxd = 0;
        $gxd = number_format(($buy->young_in * $this->set['withdrawPro'] / 100 / $this->set['walletGxdBalance']), 2, '.', '');
        if ($gxd > 0) {

            $change['gxd'] = (0 - $gxd);
            $record .= '，扣除『' . $this->set['walletGxd'] . '』' . $gxd;
            $member->young_gxd -= $gxd;
        }

        $member->young_balance += $all;
        $member->young_balance_all += $all;
        $member->young_all_in_total += $buy->young_in;
        /*if ($buy->young_gxd > 0) {

            $member->young_gxd += $buy->young_gxd;
            $member->young_gxd_all += $buy->young_gxd;

            $change['gxd'] = $buy->young_gxd;
            $record .= '，获得『' . $this->set['walletGxd'] . '』' . $buy->young_gxd;
        }*/
        $member->save();

        $wallet = new MemberWalletModel();
        $keyword = $buy->young_order;
        $wallet->store_record($member, $change, 41, $record, $keyword);

    }

    public function auto_set()
    {
        $setting = $this->set;

        $set = [
            'buySwitch' => $setting['buySwitch'],
            'buyPoundage' => $setting['buyPoundage'],
            'buyPoundageNone' => $setting['buyPoundageNone'],
            'buyTotalUpSwitch' => $setting['buyTotalUpSwitch'],
            'goodsName' => $setting['goodsName'],
            'goodsTotal' => $setting['goodsTotal'],
            'goodsCover' => 'http://' . env('LOCALHOST') . '/' . $setting['goodsCover'],
            'topOrder' => self::top_order(),
        ];

        $member = parent::get_member();

        $set['goodsLower'] = $setting['goodsLower1'];
        $set['goodsCeil'] = $setting['goodsCeil1'];
        $set['goodsNumber'] = $setting['goodsTop1'];

        switch ($member['type']) {
            case '20':
                $set['inPro'] = $setting['typePro0'];
                break;
            default:
                $set['inPro'] = $setting['typePro1'];
                break;
        }

        return $set;
    }
}