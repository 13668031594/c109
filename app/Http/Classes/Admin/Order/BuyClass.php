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

        $leftJoin = [[
            'table' => 'member as u',
            'where' => ['a.uid', '=', 'u.uid'],
        ]];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => ["a.*", "u.young_nickname",'u.young_account','u.young_phone'],
            'leftJoin' => $leftJoin
        ];

        $result = parent::list_page('buy_order as a', $other);

        return $result;
    }
}