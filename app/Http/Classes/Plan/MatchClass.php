<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/25
 * Time: 下午4:57
 */

namespace App\Http\Classes\Plan;

use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;

class MatchClass extends PlanClass
{

    private $remind;//剩余卖出金额
    private $sell;//卖出订单
    private $match = [];//匹配订单添加数组
    private $buy_10 = [];//购买订单编辑数组
    private $buy_40 = [];//购买订单编辑数组

    public function __construct()
    {
        parent::__construct();

        //获取总卖出金额
        self::all_remind();
        if ($this->remind <= 0) return;//没有可以匹配的订单

        //获取全部卖出订单
        self::all_sell();

        //获取新会员的快速匹配订单
        $new = self::new_member();

        $others = [];//排除id
        $_10 = [];//首付款匹配订单
        $_40 = [];//付款匹配订单
        //循环放入数组
        foreach ($new as $v) {

            $others[] = $v->id;
            if ($v->young_status == '10') $_10[] = $v;
            if ($v->young_status == '40') $_40[] = $v;
        }

        //新会员首付款匹配
        self::match_10($_10);

        //新会员尾款匹配
        self::match_40($_40);

        //获取所有首付款匹配订单
        $first = self::first_match($others);

        //首付款匹配
        self::match_10($first);

        //获取所有尾款订单
        $tail = self::tail_match($others);

        //匹配尾款
        self::match_40($tail);

        self::all_change();
    }

    private function all_remind()
    {
        $model = new SellOrderModel();

        $this->remind = $model->where('young_remind', '>', 0)->sum('young_remind');
    }

    //所有的卖出订单
    private function all_sell()
    {
        $sql = "SELECT s.*,u.young_nickname FROM young_sell_order_models as s,young_member_models as u 
WHERE young_remind > 0 
AND s.uid = u.uid 
AND s.young_status = 10
ORDER BY young_remind ASC,created_at ASC 
";

        $this->sell = \DB::select($sql);
    }

    //新会员立即匹配
    private function new_member()
    {
        $number = $this->set['matchNewMember'];
//        $number = 10;

        if (empty($number)) return [];

        $sql = "SELECT b.* , u.young_nickname FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND (SELECT COUNT('*') FROM young_buy_order_models WHERE uid = u.uid) <= {$number}
AND b.young_abn = 10
AND b.young_status in (10,40)
AND b.young_tail_complete < b.young_tail_total
ORDER BY b.young_status ASC, b.created_at ASC
";

        $a = \DB::select($sql);

        return $a;
    }

    private function first_match($others)
    {
        $add = $this->set['matchFirstStart'];
        $str = empty($add) ? 'today' : '- ' . $add . 'day';
        $date = date('Y-m-d H:i:s', strtotime($str));

        $sql = "SELECT b.* FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND b.young_abn = 10
AND b.young_status = 10
AND b.created_at <= '{$date}'
ORDER BY b.created_at ASC
";
        if (count($others) > 0) $sql .= "AND b.id NOT IN (" . implode(',', $others) . ")";

        $a = \DB::select($sql);

        return $a;
    }

    private function tail_match($others)
    {
        $add = $this->set['matchTailStart'];
        $str = empty($add) ? 'today' : '- ' . $add . 'day';
        $date = date('Y-m-d H:i:s', strtotime($str));

        $sql = "SELECT b.* FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND b.young_abn = 10
AND b.young_status = 40
AND b.created_at <= '{$date}'
AND b.young_tail_complete < b.young_tail_total
ORDER BY b.created_at ASC
";
        if (count($others) > 0) $sql .= "AND b.id NOT IN (" . implode(',', $others) . ")";

        $a = \DB::select($sql);

        return $a;
    }

    //首付款匹配
    private function match_10($orders)
    {
        //剩余卖出款不足
        if ($this->remind <= 0) return;

        //循环出售列表
        foreach ($this->sell as $ke => &$va) {

            //循环买入列表
            foreach ($orders as $k => $v) {

                //剩余卖出款不足
                if ($this->remind <= 0) return;

                if ($v->uid == $va->uid) continue;//同一个人的订单，跳过

                //卖出订单可以一次性付清首付款
                if ($v->young_first_total <= $va->young_remind) {

                    //金额为买入订单首付款金额
                    $total = $v->young_first_total;

                    //添加匹配订单
                    self::match_add($v, $va, $total, '10');

                    //买入订单修改
                    $buy = [
                        'id' => $v->id,
                        'young_status' => '20',
                        'young_first_match' => DATE,
                    ];

                    //加入全局数组
                    $this->buy_10[$v->id] = $buy;

                    //修改卖出订单剩余金额
                    $va->young_remind -= $total;

                    //卖出订单剩余金额不足，
                    if ($va->young_remind <= 0) $va->young_status = '20';

                    //修改总卖出金额剩余
                    $this->remind -= $total;

                    //删除该订单匹配
                    unset($orders[$k]);
                }

                //若卖出订单余额为0，跳出循环，进入下一个卖出订单
                if ($va->young_remind <= 0) break;
            }
        }
    }

    //尾款款匹配
    private function match_40($orders)
    {
        //剩余卖出款不足
        if ($this->remind <= 0) return;

        //循环买入列表
        foreach ($orders as $k => $v) {

            //剩余匹配金额
            $complete = $v->young_tail_total - $v->young_tail_complete;

            $this->buy_40[$v->id] = [
                'id' => $v->id,
                'young_status' => '40',
                'young_tail_match' => empty($v->young_tail_match) ? DATE : $v->young_tail_match,
                'young_tail_complete' => $v->young_tail_complete,
            ];

            //循环出售列表
            foreach ($this->sell as $ke => &$va) {

                //剩余卖出款不足
                if ($this->remind <= 0) return;

                //若卖出订单余额为0，进入下一个卖出订单
                if ($va->young_remind <= 0) continue;

                //买入订单已经全部匹配完成，进入下一个订单
                if ($complete <= 0) break;

                if ($v->uid == $va->uid) continue;//同一个人的订单，跳过

                //金额为买入订单首付款金额
                $total = ($complete >= $va->young_remind) ? $va->young_remind : $complete;

                //添加匹配订单
                self::match_add($v, $va, $total, '20');

                //剩余匹配款减去
                $complete -= $total;

                //修改卖出订单剩余金额
                $va->young_remind -= $total;

                //卖出订单剩余金额不足，
                if ($va->young_remind <= 0) $va->young_status = '20';

                //修改总卖出金额剩余
                $this->remind -= $total;
            }

            $this->buy_40[$v->id]['young_tail_complete'] = $v->young_tail_total - $complete;
            if ($complete <= 0) $this->buy_40[$v->id]['young_status'] = '50';
        }
    }

    //添加匹配订单
    private function match_add($buy, $sell, $total, $type)
    {
        $match = [
            'young_total' => $total,
            'young_buy_id' => $buy->id,
            'young_buy_order' => $buy->young_order,
            'young_buy_uid' => $buy->uid,
            'young_buy_nickname' => $buy->young_nickname,
            'young_sell_id' => $sell->id,
            'young_sell_order' => $sell->young_order,
            'young_sell_uid' => $sell->uid,
            'young_sell_nickname' => $sell->young_nickname,
            'young_bank_id' => $sell->young_bank_id,
            'young_bank_name' => $sell->young_bank_name,
            'young_bank_address' => $sell->young_bank_address,
            'young_bank_no' => $sell->young_bank_no,
            'young_bank_man' => $sell->young_bank_man,
            'young_alipay' => $sell->young_alipay,
            'young_note' => $sell->young_note,
            'young_type' => $type,
            'created_at' => DATE,
            'updated_at' => DATE,
        ];

        $this->match[] = $match;
    }

    private function all_change()
    {
        if (count($this->match) <= 0) return;

        //修改卖出订单格式
        $sell = [];
        foreach ($this->sell as $v) {

            $a = (array)$v;
            unset($a['young_nickname']);
            $sell[] = $a;
        }

        //修改卖出订单信息
        $this->table_update('sell_order_models', $sell);

        //添加新的匹配订单
        $model = new MatchOrderModel();
        $model->insert($this->match);

        //修改买入订单信息
        if (count($this->buy_10) > 0) $this->table_update('buy_order_models', $this->buy_10);
        if (count($this->buy_40) > 0) $this->table_update('buy_order_models', $this->buy_40);
    }
}
