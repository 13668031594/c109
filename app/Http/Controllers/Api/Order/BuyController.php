<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Classes\Index\Order\BuyClass;
use App\Http\Classes\Index\Order\PayClass;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class BuyController extends ApiController
{
    private $classes;

    public function __construct()
    {
        $this->classes = new BuyClass();
    }

    //购买订单列表
    public function index()
    {
        $result = $this->classes->index('1');
$result['date'] = DATE;
        return parent::success($result);
    }

    //购买订单详情
    public function show($id)
    {
        $match = $this->classes->match($id);

//        $record = $this->classes->record($id);

        $result = [
            'existAmount' => $this->classes->existAmount($id),
            'match' => $match,
//            'record' => $record,
        ];

        return parent::success($result);
    }

    //排单设置
    public function create()
    {
        $set = $this->classes->member_set();

        return parent::success($set);
    }

    //排单
    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        \DB::beginTransaction();

        $this->classes->store($request);

        \DB::commit();

        return parent::success();
    }

    //自动排单设置页面
    public function auto_index()
    {
        $member = $this->classes->get_member();

        $m = [
            'auto_buy' => $member['auto_buy'],
            'auto_number' => $member['auto_number'],
            'auto_time' => $member['auto_time'],
        ];

        $set = $this->classes->member_set();

        $list = ($member['auto_buy'] == '10') ? $this->classes->auto_list($member['auto_number'], $member['auto_time']) : [];

//        $set['goodsTotal'] *= $member['auto_number'];

        $result = [
            'set' => $set,
            'member' => $m,
            'list' => $list,
        ];

        return parent::success($result);
    }

    //自动排单设置修改
    public function auto_change(Request $request)
    {
        $this->classes->auto_change($request);

        $list = ($request->post('switchValue') == '10') ? $this->classes->auto_list($request->post('number'), $request->post('time')) : [];

        return parent::success(['list' => $list]);
    }

    //订单付款
    public function pay($id,Request $request)
    {
        \DB::beginTransaction();

        //支付类
        $class = new PayClass();

        //添加支付信息
        $class->pay($id,$request);

        //给予支付奖励
        $class->pay_reward();

        \DB::commit();

        return parent::success();
    }

    //全部数据
    public function all()
    {
        $result = $this->classes->index();

        return parent::success($result);
    }

    //全部数据
    public function withdraw()
    {
        \DB::beginTransaction();
        $result = $this->classes->index('2');
        \DB::commit();

        return parent::success($result);
    }

    public function withdraw_post($id)
    {
        \DB::beginTransaction();
        $this->classes->withdraw($id);
        \DB::commit();

        return parent::success();
    }
}
