<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/30
 * Time: 下午2:54
 */

namespace App\Http\Classes\Admin\Order;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use Illuminate\Http\Request;

class BuyClass extends AdminClass
{
    //对比数组
    public function arrays()
    {
        $model = new BuyOrderModel();

        $arrays = $model->arrays();

        $member = new MemberModel();

        $arrays['grade'] = $member->arrays()['grade'];

        $match = new MatchOrderModel();
        $arrays['match_arrays'] = $match->arrays();

        return $arrays;
    }

    //列表
    public function index()
    {
        $where = [];
        $orderBy = [
            'created_at' => 'desc'
        ];

        $leftJoin = [[
            'table' => 'member as u',
            'where' => ['a.uid', '=', 'u.uid'],
        ]];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => ["a.*", "u.young_nickname", 'u.young_account', 'u.young_phone'],
            'leftJoin' => $leftJoin
        ];

        $result = parent::list_page('buy_order as a', $other);

        return $result;
    }

    //详情
    public function show($id)
    {
        $select = [
            'buy_order_models.*', 'u.young_nickname', 'u.young_phone', 'u.young_account', 'u.young_grade as u_grade',
            'u.young_referee_account', 'u.young_referee_nickname'
        ];

        $order = BuyOrderModel::whereId($id)
            ->leftJoin('member_models as u', 'u.uid', '=', 'buy_order_models.uid')
            ->select($select)
            ->first();

        if (is_null($order)) exit('订单不存在');

        $order = parent::delete_prefix($order->toArray());

        return $order;
    }

    //匹配情况
    public function match($id)
    {
        $where = [
            ['young_buy_id', '=', $id]
        ];

        $orderBy = [
            'created_at' => 'asc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
        ];

        $result = parent::list_all('match_order', $other);

        foreach ($result as &$v) $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . '/' . $v['pay']);

        return $result;
    }

    //清除异常状态
    public function abn($id)
    {
        BuyOrderModel::whereId($id)->update(['young_abn' => '10']);
        MatchOrderModel::whereYoungBuyId($id)->update(['young_abn' => '10']);
    }

    public function validator_update($id,Request $request)
    {
    }
}