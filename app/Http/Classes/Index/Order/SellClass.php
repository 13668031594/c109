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
use App\Models\Order\MatchOrderModel;
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

        $type = \request()->get('type');
        if ($type == '1') $where[] = ['young_status', '<>', '30'];
        if ($type == '2') $where[] = ['young_status', '=', '30'];

        $other = [
            'where' => $where,
            'select' => ['id', 'young_order as orderNo', 'young_total as amount', 'created_at', 'young_status'],
            'orderBy' => [
                'young_status' => 'asc',
                'created_at' => 'desc',
            ],
        ];

        $result = parent::list_page('sell_order', $other);

        foreach ($result['message'] as &$v) {

            $v['match_20'] = MatchOrderModel::whereYoungSellId($v['id'])->where('young_status', '=', '20')->count();
            $v['match'] = MatchOrderModel::whereYoungSellId($v['id'])->count();
        }

        return $result;
    }

    public function match($id)
    {
        $where = [
            ['young_sell_id', '=', $id]
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
                'young_note as bankNote', 'young_sell_nickname as payee', 'young_buy_uid', 'young_abn', 'young_pay',
                'young_pay_time', 'young_order'
            ],
        ];

        $member = parent::get_member();

        $result = parent::list_all('match_order', $other);
        foreach ($result as &$v) {

            $v['toReferee'] = MemberModel::whereUid($v['buy_uid'])->first()->young_referee_nickname;
            $v['payeeReferee'] = $member['referee_nickname'];
            $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . $v['pay']);
            $v['created_at'] = date('Y-m-d', strtotime($v['created_at']));
            unset($v['buy_uid']);
            unset($v['pay']);
        }

        return $result;
    }

    public function existAmount($id)
    {
        $a = SellOrderModel::whereId($id)->first();

        $amount = $a->young_total - $a->young_remind;

        return $amount;
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

        //卖出开关关闭
        if ($set['sellSwitch'] == 'off') {

            //获取例外账号信息
            $str = str_replace(" ", '', $set['sellExceptionTxt']);//将例外账号去空格
            $exception = explode("\n", $str);//按行分组
            $exceptions = [];
            foreach ($exception as $va) {

                $va = preg_replace("/(，)/", ',', $va);//去逗号
                $exceptions = array_merge($exceptions, explode(',', $va));
            }

            //若账号和手机号都不在例外账户中，报错
            if (!in_array($member['account'], $exceptions) && !in_array($member['phone'], $exceptions)) parent::error_json($set['sellCloseTxt']);
        }


        if (($set['sellPoundageNone'] == 'off') && ($member['poundage'] < 0)) parent::error_json('星伙为负时，无法卖出');

        $today_sell = SellOrderModel::whereUid($member['uid'])->where('created_at', '>', date('Y-m-d 00:00:00'))->first();
        if (!is_null($today_sell)) parent::error_json('一天只能添加一个卖出订单');

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

        //单日卖出上限
        $top = $set['sellTop'];
        $today = SellOrderModel::whereUid($member['uid'])->where('created_at', '>=', date('Y-m-d 00:00:00'))->sum('young_total');
        if (($data['total'] + $today) > $top) parent::error_json('超出单日卖出上限（剩余：' . ($top - $today) . '）');

        //只能存在一个卖出订单
        $test = SellOrderModel::whereYoungStatus(10)->where('uid', '=', $member['uid'])->first();
        if ($test) parent::error_json('同一时间只能有一个正在匹配的卖出订单');

        $type = $request->post('accountType');
        if ($type == '1') {

            if ($member['balance'] < $data['total']) parent::error_json($this->set['walletBalance'] . '不足');
        } else {

            //判断负星伙提现
            if (($set['rewardPoundageNone'] == 'off') && ($member['poundage'] < 0)) parent::error_json('星伙为负时，无法提现' . $set['walletReward']);

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
//        $member->young_balance -= $data['total'];
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

            $withdraw = new MemberWithdrawModel();
            $withdraw->uid = $member['uid'];
            $withdraw->young_reward = $data['total'];
            $withdraw->save();
        }


        $member->save();
    }

    public function sell_list()
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']],
        ];

        $select = ['young_order as orderNo', 'young_total as amount', 'young_status', 'young_remind', 'created_at as date', 'id'];

        $where[] = ['young_status', '<', 30];

        $other = [
            'where' => $where,
            'orderBy' => [
                'created_at' => 'desc',
            ],
            'select' => $select,
        ];

        $result = parent::list_page('sell_order', $other);

        $status = new SellOrderModel();
        $status = $status->status;

        $order = new MatchOrderModel();
        $match_status = $order->status;

        //判断是否加速
        foreach ($result['message'] as &$v) {

            $children = $order->where([
                ['young_sell_id', '=', $v['id']],
            ])->get();

            $children = parent::delete_prefix($children->toArray());

            foreach ($children as &$va) {

                $seller = MemberModel::whereUid($va['sell_uid'])->first();
                if (is_null($seller)){

                    $va['sell_p'] = '未知';
                }elseif(empty($seller->young_referee_id)){

                    $va['sell_p'] = '公司';
                }else{

                    $sell_p = MemberModel::whereUid($seller->young_referee_id)->first();
                    if (is_null($sell_p))$va['sell_p'] = '未知';
                    else $va['sell_p'] = $sell_p->young_nickname;
                }

                $buyer = MemberModel::whereUid($va['buy_uid'])->first();
                if (is_null($buyer)){

                    $va['buy_p'] = '未知';
                }elseif(empty($buyer->young_referee_id)){

                    $va['buy_p'] = '公司';
                }else{

                    $buy_p = MemberModel::whereUid($buyer->young_referee_id)->first();
                    if (is_null($buy_p))$va['sell_p'] = '未知';
                    else $va['buy_p'] = $buy_p->young_nickname;
                }

                $va['buyNo'] = $va['buy_order'];
                $va['sellNo'] = $va['sell_order'];
                $va['status'] = $match_status[$va['status']];
                $va['date'] = $va['created_at'];
                $va['from'] = $va['buy_nickname'];
                $va['to'] = '我';
                $va['amount'] = $va['total'];
            }

            $v['typeName'] = '卖出申请';
            $v['username'] = $member['nickname'];
            $v['statusName'] = $status[$v['status']];
            $v['isExistTotal'] = $v['total'] = $v['remind'];
            $v['children'] = $children;

            $v['goodsName'] = '余额';
            $v['number'] = '1';
        };

        return $result;
    }
}