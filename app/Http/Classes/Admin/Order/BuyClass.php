<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/30
 * Time: 下午2:54
 */

namespace App\Http\Classes\Admin\Order;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Order\BuyOrderModel;

class BuyClass extends AdminClass
{
    public function index()
    {
        $where = [];
        $orderBy = [];

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

    public function show($id)
    {
        $order = BuyOrderModel::whereId($id)
            ->leftJoin('member_models as u','u.uid','=','buy_order_models.uid')
            ->select(['buy_order_models.*','u.young_nickname','u.young_phone','u.young_account'])
            ->first();

        if (is_null($order)) exit('订单不存在');

        $order = parent::delete_prefix($order->toArray());

        return $order;
    }

    public function arrays()
    {
        $model = new BuyOrderModel();

        return $model->arrays();
    }
}