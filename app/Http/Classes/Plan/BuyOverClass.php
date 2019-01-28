<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/27
 * Time: 下午5:35
 */

namespace App\Http\Classes\Plan;

use App\Models\Order\BuyOrderModel;

class BuyOverClass extends PlanClass
{
    public function __construct()
    {
        parent::__construct();

        $today_w = date('w', DATE);

        if ($today_w == '6') {

            //今天周六
            self::order_add(2);
        } elseif ($today_w == '0') {

            //今天周日
            self::order_add(1);
        } else {

            //工作日，修改状态
            self::order_over();
        }
    }

    //周六，今天到收益时间的，给增加收益
    public function order_add($add)
    {
        //寻找收益中，且完结时间小于等于今天的
        $buy = BuyOrderModel::whereYoungStatus('70')
            ->where('young_in_over', '<=', date('Y-m-d 23:59:59'))
            ->where('young_in_over', '>=', date('Y-m-d 00:00:00'))
            ->get();

        if (count($buy) <= 0) return;

        //所有参与编辑的
        $update = [];

        foreach ($buy as $v) {

            $add_in = number_format(($v->young_in_pro * $v->young_total * $add / 100), 2, '.', '');

            $u['id'] = $v->id;
            $u['young_in'] = $v['young_in'] + $add_in;
            $u['young_days'] = $v['young_days'] + $add;
            $u['young_in_over'] = date('Y-m-d H:i:s', strtotime('+' . $add . ' day', strtotime($v['young_in_over'])));

            $update[] = $u;
        }

        if (count($update) > 0) parent::table_update('buy_order_models', $update);
    }

    //工作日，正常完结订单
    public function order_over()
    {
        //寻找收益中，且完结时间小于等于今天的
        $buy = BuyOrderModel::whereYoungStatus('70')
            ->where('young_in_over', '<=', DATE)
            ->get();

        if (count($buy) <= 0) return;

        //所有参与编辑的
        $update = [];

        foreach ($buy as $v) {

            //此后的订单，且付了首付款的
            $after = BuyOrderModel::whereUid($v->uid)->where('young_status', '>=', '40')->where('created_at', '>', $v->created_at)->first();

            if (is_null($after)) $status = '75';
            elseif ($v->young_from == '20') $status = '79';
            else $status = '80';

            $u['id'] = $v->id;
            $u['young_status'] = $status;

            $update[] = $u;
        }

        if (count($update) > 0) parent::table_update('buy_order_models', $update);
    }
}