<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/25
 * Time: 下午4:57
 */

namespace App\Http\Classes\Plan;

use App\Http\Traits\DxbSmsTrait;
use App\Http\Traits\GetuiTrait;
use App\Http\Traits\MessageTrait;
use App\Models\Member\MemberModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;
use App\Models\Plan\PlanModel;

class MatchClass extends PlanClass
{
    use DxbSmsTrait, GetuiTrait, MessageTrait;

    private $remind;//剩余卖出金额
    private $sell;//卖出订单
    private $match = [];//匹配订单添加数组
    private $buy_10 = [];//购买订单编辑数组
    private $buy_40 = [];//购买订单编辑数组
    private $match_order;//匹配交易号
    private $users = [];//会员信息表
    private $sell_message = [];//卖出订单匹配情况
    private $buy_message = [];//买入订单匹配情况

    public function __construct($type = 'match')
    {
        parent::__construct();

        $this->keyword = $type;

        switch ($type) {
            case 'match_simu';
                self::simu();
                break;
            default:
                self::match();
                break;
        }
    }

    private function simu()
    {
        $test_time = $this->set_time($this->set['matchSimu']);

        if (time() < $test_time) return;

        if (parent::test_plan()) return;

        //获取总卖出金额
        self::all_remind();
        if ($this->remind <= 0) {

            $record = '没有卖出订单，匹配无法进行！';
            parent::store_plan($record);
            return;
        }//没有可以匹配的订单

        //获取全部卖出订单
        self::all_sell();

        //获取新会员的快速匹配订单
        $new = self::new_member();

        //计算交易号
        self::match_order();

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

        $day = (int)$this->set['matchFirstStart'];
        $day = $day - 1;

        if (empty($day) || ($day <= 0)) $date = date('Y-m-d 00:00:00', strtotime('tomorrow'));
        else $date = date('Y-m-d 00:00:00', strtotime('-' . $day . ' day', strtotime('tomorrow')));

        //获取所有首付款匹配订单
        $first = self::first_match($others,$date);

        //首付款匹配
        self::match_10($first);

        //新会员尾款匹配
        self::match_40($_40);

        $day = (int)$this->set['matchTailStart'];
        $day = $day - 1;

        if (empty($day) || ($day <= 0)) $date = date('Y-m-d 00:00:00', strtotime('tomorrow'));
        else $date = date('Y-m-d 00:00:00', strtotime('-' . $day . ' day', strtotime('tomorrow')));
//        dd($this->set['matchTailStart'],$date);
        //获取所有尾款订单
        $tail = self::tail_match($others,  $date);

        //匹配尾款
        self::match_40($tail);

        $_10_number = 0;
        $_10_total = 0;
        $_20_number = 0;
        $_20_total = 0;
        foreach ($this->match as $v) {

            if ($v['type'] == '10') {

                $_10_number += 1;
                $_10_total += $v['young_total'];
            } else {

                $_20_number += 1;
                $_20_total += $v['young_total'];
            }
        }
//dd($this->sell,$this->match,$first,$tail);
        $record = '即将匹配首付款：' . $_10_number . '单，合计：' . $_10_total . '；匹配尾款：' . $_20_number . '单，合计：' . $_20_total . '。';
        parent::store_plan($record);
    }

    private function match()
    {
        $test = parent::test_plan();

        //获取总卖出金额
        self::all_remind();
        if ($this->remind <= 0) return;//没有可以匹配的订单

        //获取全部卖出订单
        self::all_sell();

        //获取新会员的快速匹配订单
        $new = self::new_member();

        //计算交易号
        self::match_order();

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

//        if (!$test) {

        //获取所有首付款匹配订单
        $first = self::first_match($others);

        //首付款匹配
        self::match_10($first);
//        };

        //新会员尾款匹配
        self::match_40($_40);

        if (!$test) {

            //获取所有尾款订单
            $tail = self::tail_match($others);

            //匹配尾款
            self::match_40($tail);
        }

        //修改所有修改
        self::all_change();

        //发送推送消息
        self::push_send();

        if (!$test) {

            $plan = new PlanModel();
            $plan->store_plan('match', '', 10);
        }
    }

    private function all_remind()
    {
        $model = new SellOrderModel();

        $this->remind = $model->where('young_remind', '>', 0)->sum('young_remind');
    }

    private function match_order()
    {
        $order = 375895;

        $add = new MatchOrderModel();
        $add = $add->count();

        $this->match_order = ($order + $add + 1);
    }

    //所有的卖出订单
    private function all_sell()
    {
        $sql = "SELECT s.*,u.young_nickname, u.young_phone, u.young_cid FROM young_sell_order_models as s,young_member_models as u 
WHERE s.young_remind > 0 
AND u.young_status = 10
AND s.uid = u.uid 
AND s.young_status = 10
ORDER BY u.young_match_level DESC,s.young_remind ASC,s.created_at ASC 
";

        $this->sell = \DB::select($sql);
    }

    //新会员立即匹配
    private function new_member()
    {
        $number = $this->set['matchNewMember'];
//        $number = 10;

        if (empty($number)) return [];

        $sql = "SELECT b.* , u.young_nickname, u.young_phone, u.young_cid, u.young_mode FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND u.young_status = 10
AND (SELECT COUNT('*') FROM young_buy_order_models WHERE uid = u.uid) <= {$number}
AND b.young_abn = 10
AND b.young_status in (10,40)
AND b.young_tail_complete < b.young_tail_total
ORDER BY u.young_match_level DESC,b.young_status ASC, b.created_at ASC
";

        $a = \DB::select($sql);

        return $a;
    }

    //首付款匹配订单
    private function first_match($others, $time = null)
    {
//        $add = (int)$this->set['matchFirstStart'];
//        $str = empty($add) ? 'today' : '-' . ($add - 1) . ' day';
//        $date = date('Y-m-d 00:00:00', strtotime($str));
        $date = is_null($time) ? parent::return_date($this->set['matchFirstStart']) : $time;

        $sql = "SELECT b.*, u.young_nickname , u.young_phone, u.young_cid, u.young_mode FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND u.young_status = 10
AND b.young_abn = 10
AND b.young_status = 10
AND b.created_at <= '{$date}'";
        if (count($others) > 0) $sql .= " AND b.id NOT IN (" . implode(',', $others) . ")";

        $sql .= " ORDER BY  u.young_match_level DESC,b.young_grade ASC , b.created_at ASC";
//dd($sql);
        $a = \DB::select($sql);

        return $a;
    }

    private function tail_match($others, $time = null)
    {
//        $add = (int)$this->set['matchTailStart'];
//        $str = empty($add) ? 'today' : '-' . ($add - 1) . ' day';
//        $date = date('Y-m-d H:i:s', strtotime($str));
        $date = is_null($time) ? parent::return_date($this->set['matchTailStart']) : $time;

        $sql = "SELECT b.*, u.young_nickname , u.young_phone, u.young_cid FROM young_member_models as u,young_buy_order_models as b 
WHERE b.uid = u.uid 
AND u.young_status = 10
AND b.young_abn = 10
AND b.young_status = 40
AND b.created_at <= '{$date}'
AND b.young_tail_complete < b.young_tail_total";
        if (count($others) > 0) $sql .= " AND b.id NOT IN (" . implode(',', $others) . ")";

        $sql .= " ORDER BY  u.young_match_level DESC,b.young_grade ASC , b.created_at ASC";

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

            if ($v->mode == '10'){

                //判断上一个订单是否收益完成了
                $last_buy = BuyOrderModel::whereUid($v->uid)->where('created_at', '<', $v->created_at)->orderBy('created_at', 'desc')->first();

                if (!is_null($last_buy) && !is_null($last_buy->young_in_over)) {

                    //有上一个订单，且上一个订单收益未完成，不匹配尾款
                    if ($last_buy->young_status <= 70) continue;

                    //判断上一个订单完结后，是否有卖出订单，卖出订单是否完结
                    $last_sell = SellOrderModel::whereUid($v->uid)->where('created_at', '>=', $last_buy->young_in_over)->orderBy('created_at', 'asc')->first();

                    //完结后没有卖出，或卖出订单没有完结，不匹配尾款
                    if (is_null($last_sell) || ($last_sell->young_status < 20)) continue;
                }
            }

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
//        dump($buy);
        $order = 'M' . $this->match_order;
        $match = [
            'young_order' => $order,
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

        $this->match_order++;

        if (!isset($this->users[$buy->uid])) {

            $this->users[$buy->uid] = [
                'phone' => $buy->young_phone,
                'cid' => $buy->young_cid,
                'content' => [],
                'body' => [],
            ];
        }
        if (!isset($this->buy_message[$buy->uid])) {

            $this->buy_message[$buy->uid] = [
                'content' => [],
            ];
        }
        if (!isset($this->users[$sell->uid])) {

            $this->users[$sell->uid] = [
                'phone' => $sell->young_phone,
                'cid' => $sell->young_cid,
                'content' => [],
                'body' => [],
            ];
        }
        if (!isset($this->sell_message[$sell->uid])) {

            $this->sell_message[$sell->uid] = [
                'content' => [],
            ];
        }
        $buy_content = '您的采集订单『' . $buy->young_order . '』已经匹配成功，交易号『' . $order . '』，请尽快付款';
        $buy_body = '您的采集订单有了新的匹配情况';
        $sell_content = '您的卖出订单『' . $sell->young_order . '』已经匹配成功，交易号『' . $order . '』，请注意收款';
        $sell_body = '您的卖出订单有了新的匹配情况';
        $this->users[$buy->uid]['content'][] = $buy_content;
        $this->users[$buy->uid]['body'][] = $buy_body;
        $this->users[$sell->uid]['content'][] = $sell_content;
        $this->users[$sell->uid]['body'][] = $sell_body;
        $this->buy_message[$buy->uid]['content'][] = $buy_content;
        $this->sell_message[$sell->uid]['content'][] = $sell_content;
    }

    private function all_change()
    {
        if (count($this->match) <= 0) return;

        //修改卖出订单格式
        $sell = [];
        foreach ($this->sell as $v) {

            $a = (array)$v;
            unset($a['young_nickname']);
            unset($a['young_phone']);
            unset($a['young_cid']);
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

    private function push_send()
    {
        if (count($this->users) > 0) foreach ($this->users as $v) {

//            if (!empty($v['phone'])) foreach ($v['content'] as $va) $this->sendSms($v['phone'], $va);
            if (!empty($v['cid'])) foreach ($v['body'] as $va) $this->pushSms($v['cid'], $va);
        }
        if (count($this->sell_message) > 0) foreach ($this->sell_message as $k => $v) {

            foreach ($v['content'] as $va) $this->sendMessage($k, 10, $va);
        }
        if (count($this->buy_message) > 0) foreach ($this->buy_message as $k => $v) {

            foreach ($v['content'] as $va) $this->sendMessage($k, 20, $va);
        }

    }
}
