<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午3:26
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\RobModel;
use Illuminate\Http\Request;

class RobClass extends IndexClass
{
    public function index()
    {
        $member = parent::get_member();

        $where = [
            ['uid', '=', $member['uid']]
        ];

        $other = [
            'where' => $where,
//            'select' => ['id', 'young_order as orderNo', 'young_amount', 'created_at', 'young_status', 'young_number'],
        ];

        return parent::list_page('rob', $other);
    }

    //开始抢单
    public function store()
    {
        $member = parent::get_member();//会员参数

        if ($member['mode'] != '20') parent::error_json('只有开启未防撞模式的会员才能参与抢单');

        $set = $this->set;//配置文件

        if ($set['robSwitch'] != 'on') parent::error_json('暂时无法抢单');//手动排单开关

        //判断抢单时间段
        $begin = parent::set_time($this->set['robStartTime']);
        $end = parent::set_time($this->set['robEndTime']);
        $now = time();
        if (($now < $begin) || ($now > $end)) parent::error_json('请在每天 ' . $this->set['payStart'] . ' 至 ' . $this->set['payEnd'] . ' 参与抢单');

        //抢单模型
        $rob = new RobModel();

        //最后一次抢单
        $begin = date('Y-m-d 00:00:00');
        $test = $rob->where('uid', '=', $member['uid'])
            ->where('created_at', '>=', $begin)
            ->first();
        if (!is_null($test)) parent::error_json('今天已经抢过单了');

        //寻找最后一个成功抢单
        $test = $rob->where('uid', '=', $member['uid'])
            ->where('young_status', '=', '20')
            ->first();
        if (!is_null($test)) parent::error_json('上一个抢单中选后尚未下单');

        //寻找该会员的最后一个订单
        $last = new BuyOrderModel();
        $last = $last->where('uid', '=', $member['uid'])
            ->where('young_from', '=', '30')
            ->where('young_status', '<', '70')
            ->orderBy('created_at', 'desc')
            ->first();
        if (!is_null($last)) parent::error_json('上一个抢单的订单尚未付完全款');

        //满足抢单条件，生成抢单记录
        $rob->uid = $member['uid'];
        $rob->save();
    }

    public function validator_store(Request $request)
    {
        $set = $this->set;//配置文件
        $data = $request->post();//获取参数
        $member = parent::get_member();//会员参数

        if ($member['mode'] != '20') parent::error_json('只有开启未防撞模式的会员才能参与抢单');

        if ($set['buySwitch'] != 'on') parent::error_json('暂时无法排单');//手动排单开关

        //寻找该会员的最后一个订单
        $last = new BuyOrderModel();
        $last = $last->where('uid', '=', $member['uid'])
            ->where('young_from', '=', '30')
            ->where('young_status', '<', '70')
            ->orderBy('created_at', 'desc')
            ->first();
        if (!is_null($last)) parent::error_json('上一个抢单的订单尚未付完全款');

        //各项参数
        $time_lower = $set['goodsLower1'];
        $time_ceil = $set['goodsCeil1'];
        $number_max = $set['goodsTop1'];

        $term = [
            'id|抢单记录' => 'required|exitst:rob_models,id',
            'total|订单总价' => 'required|numeric|between:1,100000000',
            'amount|商品单价' => 'required|numeric|between:1,100000000',
            'number|排单数量' => 'required|integer|between:1,' . $number_max,
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
        $record = '自主排单，订单号『' . $order->young_order . '』,扣除『' . $this->set['walletPoundage'] . '』' . $poundage;
        $keyword = $order->young_order;
        $change = ['poundage' => (0 - $poundage)];
        $wallet->store_record($member, $change, 40, $record, $keyword);
    }
}