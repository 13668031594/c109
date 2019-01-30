<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/30
 * Time: 下午2:54
 */

namespace App\Http\Classes\Admin\Order;


use App\Http\Classes\Admin\AdminClass;

class BuyClass extends AdminClass
{
    public function index()
    {
        $where = [];
        $orderBy = [];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
//            'select' => '*,'
        ];

        $result = parent::list_page('buy_order_models as a', $other);

        return $result;
    }
}