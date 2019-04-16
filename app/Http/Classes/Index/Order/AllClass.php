<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/4/11
 * Time: 下午5:02
 */

namespace App\Http\Classes\Index\Order;

use App\Http\Classes\Index\IndexClass;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;

class AllClass extends IndexClass
{
    public function index()
    {
        $user = parent::get_member();

        $order = new MatchOrderModel();
        $order = $order->where([
            ['young_status','=',10],
            ['young_abn','=',10],
            ['young_buy_uid','=',$user['uid']],
        ])->orWhere([
            ['young_status','=',20],
            ['young_abn','=',10],
            ['young_sell_uid','=',$user['uid']],
        ])->get();

        $buy = [];
        $sell = [];
        foreach ($order as $v){

            if (($v->young_status == 10) && ($v->young_buy_uid == $user['uid']))$buy[] = $v->young_buy_id;
            if (($v->young_status == 20) && ($v->young_sell_uid == $user['uid']))$sell[] = $v->young_sell_id;
        }

        $buy_select = ['id', 'young_order as orderNo', 'young_total as amount', 'created_at', 'young_status', 'young_number', 'young_abn', 'young_from', 'young_grade','young_fast_order','young_in as in'];
        $buy = BuyOrderModel::whereUid($user['uid'])->where('young_status','<','90')->whereIn('id',$buy)->orderBy('created_at','asc')->get($buy_select);
        $buy = parent::delete_prefix($buy->toArray());
        foreach ($buy as &$v) $v['speed'] = ($v['grade'] == '10') ? '1' : '0';

        $sell_select = ['id', 'young_order as orderNo', 'young_total as amount', 'created_at', 'young_status'];
        $sell = SellOrderModel::whereUid($user['uid'])->where('young_status','<','30')->whereIn('id',$sell)->orderBy('created_at','asc')->get($sell_select);
        $sell = parent::delete_prefix($sell->toArray());
        foreach ($sell as &$v) {

            $v['match_20'] = MatchOrderModel::whereYoungSellId($v['id'])->where('young_status', '=', '20')->count();
            $v['match'] = MatchOrderModel::whereYoungSellId($v['id'])->count();
        }

        $result = [
            'buy' => $buy,
            'sell' => $sell,
        ];

        return $result;
    }
}