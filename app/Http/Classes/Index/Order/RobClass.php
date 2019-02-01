<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午3:26
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
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
    public function store(Request $request)
    {
        $member = parent::get_member();//会员参数

        if ($member['mode'] != '20') parent::error_json('只有开启未防撞模式的会员才能参与抢单');

        $set = $this->set;//配置文件

        if ($set['robSwitch'] != 'on') parent::error_json('暂时无法抢单');//手动采集开关

        //判断抢单时间段
        $begin = parent::set_time($this->set['robStartTime']);
        $end = parent::set_time($this->set['robEndTime']);
        $now = time();
        if (($now < $begin) || ($now > $end)) parent::error_json('请在每天 ' . $this->set['robStartTime'] . ' 至 ' . $this->set['robEndTime'] . ' 参与抢单');

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
        if (!is_null($test)) parent::error_json('上一个抢单中选后尚未采集');

        //寻找该会员的最后一个订单
        $last = new BuyOrderModel();
        $last = $last->where('uid', '=', $member['uid'])
//            ->where('young_from', '=', '30')
//            ->where('young_status', '<', '40')
            ->orderBy('created_at', 'desc')
            ->first();
        if (!is_null($last)) {

            if ($last->young_status < 40) parent::error_json('上一个订单尚未付首款');
            if ($last->created_at >= date('Y-m-d 00:00:00')) parent::error_json('一天只能下一个单');
        }

        //各项参数
        $time_lower = $set['goodsLower1'];
        $time_ceil = $set['goodsCeil1'];
        $number_max = $set['goodsTop1'];

        $term = [
            'total|订单总价' => 'required|numeric|between:1,100000000',
            'amount|商品单价' => 'required|numeric|between:1,100000000',
            'number|采集数量' => 'required|integer|between:1,' . $number_max,
            'time|收益时间' => 'required|integer|between:' . $time_lower . ',' . $time_ceil,
            'poundage|手续费' => 'required|integer|between:1,100000000',
            'inPro|收益率' => 'required|numeric|between:0,100',
        ];

        parent::validators_json($request->post(), $term);

        $data = $request->post();

        switch ($member['type']) {
            case '20':
                if ($data['inPro'] != $set['typePro0']) parent::error_json('请刷新重试（inPro）');
                break;
            default:
                if ($data['inPro'] != $set['typePro1']) parent::error_json('请刷新重试（inPro）');
                break;
        }

        $poundage = $set['buyPoundage'] * $data['number'];

        if (($set['buyPoundageNone'] != 'on') && ($poundage > $member['poundage'])) parent::error_json($this->set['walletPoundage'] . '不足');
        if ($data['poundage'] != $poundage) parent::error_json('请刷新重试（poundage）');
        if ($data['amount'] != $set['goodsTotal']) parent::error_json('请刷新重试（amount）');
        if ($data['total'] != ($data['amount'] * $data['number'])) parent::error_json('请刷新重试（total）');
        $top = self::top_order();
        if (($set['buyTotalUpSwitch'] == 'on') && ($data['total'] < $top)) parent::error_json('订单金额不得低于' . $top);

        //满足抢单条件，生成抢单记录
        $rob->uid = $member['uid'];
        $rob->young_total = $data['total'];
        $rob->young_time = $data['time'];
        $rob->young_in_pro = $data['inPro'];
        $rob->young_amount = $data['amount'];
        $rob->young_number = $data['number'];
        $rob->young_poundage = $poundage;
        $rob->save();
    }

    //历史订单最高金额
    public function top_order()
    {
        $member = parent::get_member();

        //获取历史金额最高的一单
        $top = BuyOrderModel::whereUid($member['uid'])->orderBy('young_total', 'desc')->first();

        return !$top ? '0' : $top['young_total'];
    }
}