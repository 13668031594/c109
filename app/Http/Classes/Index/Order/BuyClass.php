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
use Illuminate\Http\Request;

class BuyClass extends IndexClass
{
    public function index()
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']]
        ];

        $other = [
            'where' => $where,
            'orderBy' => [
                'created_at' => 'desc'
            ],
            'select' => ['id', 'young_order as orderNo', 'young_amount', 'created_at', 'young_status', 'young_number'],
        ];

        $result = parent::list_page('buy_order', $other);

        //判断是否加速
        $number = $this->set['matchNewMember'];
        $model = new BuyOrderModel();
        $ids = $model->where('uid', '=', $member['uid'])->limit($number)->orderBy('created_at', 'asc')->get(['id']);
        $speed = [];
        if (count($ids) > 0) $speed = $ids->pluck('id')->toArray();
        foreach ($result['message'] as &$v) $v['speed'] = in_array($v['id'], $speed) ? '1' : '0';

        return $result;
    }

    public function match($id)
    {
        $where = [
            ['young_buy_id', '=', $id]
        ];

        $order = [
            'created_at' => 'desc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $order,
            'select' => [
                'id', 'young_buy_order as buyCode', 'young_sell_order as sellCode', 'young_total as amount', 'created_at',
                'young_status', 'young_buy_nickname as to', 'young_pay_time as payTime', 'young_bank_name as bankName',
                'young_bank_no as bankNo', 'young_bank_address as bankAddress', 'young_bank_man as bankUser', 'young_alipay',
                'young_note as bankNote', 'young_sell_nickname as payee', 'young_sell_uid'
            ],
        ];

        $member = parent::get_member();

        $result = parent::list_all('match_order', $other);
        foreach ($result as &$v) {

            $v['payeeReferee'] = MemberModel::whereUid($v['sell_uid'])->first()->young_referee_nickname;
            unset($v['sell_uid']);
            $v['toReferee'] = $member['referee_nickname'];
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
                $set['goodsLower'] = $setting['goodsLower0'];
                $set['goodsCeil'] = $setting['goodsCeil0'];
                break;
            case '20':
                $set['goodsNumber'] = $setting['goodsTop1'];
                $set['goodsLower'] = $setting['goodsLower1'];
                $set['goodsCeil'] = $setting['goodsCeil1'];
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

        //寻找该会员的最后一个订单
        $last = new BuyOrderModel();
        $last = $last->where('uid', '=', $member['uid'])->where('young_status', '<', '70')->orderBy('created_at', 'desc')->first();
        if (!is_null($last)) parent::error_json('上一个订单尚未付完全款');

        $number_max = 0;
        $time_lower = 0;
        $time_ceil = 0;
        switch ($member['mode']) {
            case '10':
                $time_lower = $set['goodsLower0'];
                $time_ceil = $set['goodsCeil0'];
                $number_max = $set['goodsTop0'];
                break;
            case '20':
                $time_lower = $set['goodsLower1'];
                $time_ceil = $set['goodsCeil1'];
                $number_max = $set['goodsTop1'];
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
            'poundage|手续费' => 'required|integer|between:1,100000000',
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
        if ($data['poundage'] != $set['buyPoundage']) parent::error_json('请刷新重试（poundage）');
        if ($data['amount'] != $set['goodsTotal']) parent::error_json('请刷新重试（amount）');
        if ($data['total'] != ($data['amount'] * $data['number'])) parent::error_json('请刷新重试（total）');
        $top = self::top_order();
        if (($set['buyTotalUpSwitch'] == 'on') && ($data['total'] < $top)) parent::error_json('订单金额不得低于' . $top);
    }

    public function store(Request $request)
    {
        $data = $request->post();
        $member = parent::get_member();
        $poundage = $data['poundage'] * $data['number'];

        //新增订单信息
        $order = new BuyOrderModel();
        $order->young_order = $order->new_order();
        $order->young_from = '10';//系统派单
        $order->uid = $member['uid'];
        $order->young_total = $data['total'];
        $order->young_days = $data['time'];
        $order->young_in_pro = $data['inPro'];
        $order->young_in = number_format(($data['inPro'] * $data['total'] / 100), 2, '.', '');
        $order->young_amount = $data['amount'];
        $order->young_number = $data['number'];
        $order->young_poundage = $poundage;
        $order->young_name = $this->set['goodsName'];
        $order->young_first_total = number_format(($data['total'] * $this->set['matchFirstPro'] / 100), 2, '.', '');
        $order->young_first_pro = $this->set['matchFirstPro'];
        $order->young_tail_total = $order->young_total - $order->young_first_total;
        $order->save();

        //扣除会员手续费
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

            $begin = strtotime($last->created_at) + strtotime($last->young_days);
        }

        $set = $this->set;
        $amount = $set['goodsTotal'];
        $number_max = 0;
        $time_lower = 0;
        $time_ceil = 0;
        switch ($member['mode']) {
            case '10':
                $time_lower = $set['goodsLower0'];
                $time_ceil = $set['goodsCeil0'];
                $number_max = $set['goodsTop0'];
                break;
            case '20':
                $time_lower = $set['goodsLower1'];
                $time_ceil = $set['goodsCeil1'];
                $number_max = $set['goodsTop1'];
                break;
            default:
                parent::error_json('请刷新重试（mode）');
                break;
        }

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

        $number_max = 0;
        $time_lower = 0;
        $time_ceil = 0;
        switch ($member['mode']) {
            case '10':
                $time_lower = $set['goodsLower0'];
                $time_ceil = $set['goodsCeil0'];
                $number_max = $set['goodsTop0'];
                break;
            case '20':
                $time_lower = $set['goodsLower1'];
                $time_ceil = $set['goodsCeil1'];
                $number_max = $set['goodsTop1'];
                break;
            default:
                parent::error_json('请刷新重试（mode）');
                break;
        }

        $term = [
            'switchValue|自动采集开关' => 'required|numeric|between:1,100000000',
            'number|采集数量' => 'required|integer|between:1,' . $number_max,
            'time|收益时间' => 'required|integer|between:' . $time_lower . ',' . $time_ceil,
        ];

        parent::validators_json($request->post(), $term);

        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_auto_buy = $request->post('switchValue');
        $member->young_auto_number = $request->post('number');
        $member->young_auto_time = $request->post('time');
        $member->save();
    }
}