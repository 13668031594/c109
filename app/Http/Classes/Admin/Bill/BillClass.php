<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/3
 * Time: 下午2:12
 */

namespace App\Http\Classes\Admin\Bill;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;

class BillClass extends AdminClass
{
    public $join_name = null;
    public $column = 'created_at';
    public $type;
    public $types;
    public $times;
    public $where;
    public $wheres;
    public $begin;
    public $end;

    //今日新增会员
    public function all_bill()
    {
        //会员模型
        $member_model = new MemberModel();
        $buy_order = new BuyOrderModel();
        $sell_order = new SellOrderModel();
        $match_order = new MatchOrderModel();
        $today = date('Y-m-d 00:00:00');
        $yesterday = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $times = self::time_type('all');
        $begin = $times['begin'];
        $end = $times['end'];

        $where_all = [['created_at', '>=', $begin], ['created_at', '<', $end]];
        $where_today = [['created_at', '>=', $today]];
        $where_yesterday = [['created_at', '>=', $yesterday], ['created_at', '<', $today]];

//        dd($begin, $end);

        //注册
        $all_reg = $member_model->where($where_all)->count();
        $today_reg = $member_model->where($where_today)->count();
        $yesterday_reg = $member_model->where($where_yesterday)->count();

        //激活
        $all_act = $member_model->where([['young_act_time', '>=', $begin], ['young_act_time', '<', $end]])->count();
        $today_act = $member_model->where([['young_act_time', '>=', $today]])->count();
        $yesterday_act = $member_model->where([['young_act_time', '>=', $yesterday], ['young_act_time', '<', $today]])->count();

        //买入数
        $all_buy_num = $buy_order->where($where_all)->count();
        $today_buy_num = $buy_order->where($where_today)->count();
        $yesterday_buy_num = $buy_order->where($where_yesterday)->count();

        //买入额
        $all_buy_total = $buy_order->where($where_all)->sum('young_total');
        $today_buy_total = $buy_order->where($where_today)->sum('young_total');
        $yesterday_buy_total = $buy_order->where($where_yesterday)->sum('young_total');

        //卖出数
        $all_sell_num = $sell_order->where($where_all)->count();
        $today_sell_num = $sell_order->where($where_today)->count();
        $yesterday_sell_num = $sell_order->where($where_yesterday)->count();

        //卖出额
        $all_sell_total = $sell_order->where($where_all)->sum('young_total');
        $today_sell_total = $sell_order->where($where_today)->sum('young_total');
        $yesterday_sell_total = $sell_order->where($where_yesterday)->sum('young_total');

        //匹配数
        $all_match_num = $match_order->where($where_all)->count();
        $today_match_num = $match_order->where($where_today)->count();
        $yesterday_match_num = $match_order->where($where_yesterday)->count();

        //匹配额
        $all_match_total = $match_order->where($where_all)->sum('young_total');
        $today_match_total = $match_order->where($where_today)->sum('young_total');
        $yesterday_match_total = $match_order->where($where_yesterday)->sum('young_total');

        return [
            'type' => $times['type2'],
            'begin' => $begin,
            'end' => $end,
            'all_reg' => $all_reg,
            'today_reg' => $today_reg,
            'yesterday_reg' => $yesterday_reg,
            'all_act' => $all_act,
            'today_act' => $today_act,
            'yesterday_act' => $yesterday_act,
            'all_buy_num' => $all_buy_num,
            'today_buy_num' => $today_buy_num,
            'yesterday_buy_num' => $yesterday_buy_num,
            'all_buy_total' => $all_buy_total,
            'today_buy_total' => $today_buy_total,
            'yesterday_buy_total' => $yesterday_buy_total,
            'all_sell_num' => $all_sell_num,
            'today_sell_num' => $today_sell_num,
            'yesterday_sell_num' => $yesterday_sell_num,
            'all_sell_total' => $all_sell_total,
            'today_sell_total' => $today_sell_total,
            'yesterday_sell_total' => $yesterday_sell_total,
            'all_match_num' => $all_match_num,
            'today_match_num' => $today_match_num,
            'yesterday_match_num' => $yesterday_match_num,
            'all_match_total' => $all_match_total,
            'today_match_total' => $today_match_total,
            'yesterday_match_total' => $yesterday_match_total,
        ];
    }

    public function time_type($type2 = null)
    {
        $type = null;
        $begin_time = null;
        $end_time = null;
        $type2 = request()->get('type') ? request()->get('type') : $type2;

        switch ($type2) {
            case '1':
                //本月
                $type = 'week';
                $month = date('Y-m');
                $begin_time = $month . '-01 00:00:00';
                $end_time = self::time_date(strtotime('-8 day', strtotime('+1 month', self::time_stamp($begin_time))));
                break;
            case '2':
                //本季度
                $type = 'month';
                $month = date('m');
                $year = date('Y');
                if (in_array($month, [1, 2, 3])) {
                    $begin_time = $year . '-01-01 00:00:00';
                }
                if (in_array($month, [4, 5, 6])) {
                    $begin_time = $year . '-04-01 00:00:00';
                }
                if (in_array($month, [7, 8, 9])) {
                    $begin_time = $year . '-07-01 00:00:00';
                }
                if (in_array($month, [10, 11, 12])) {
                    $begin_time = $year . '-10-01 00:00:00';
                }

                $end_time = self::time_date(strtotime('+2 month', self::time_stamp($begin_time)));

                break;
            case '4':
                //时间段
                //获取起始时间段
                $begin_time = is_null($begin_time) ? (is_null(request()->get('startTime')) ? '2018-01-01 00:00:00' : request()->get('startTime')) : $begin_time;

                //获取结束时间段
                $end_time = is_null($end_time) ? (is_null(request()->get('endTime')) ? self::time_date() : request()->get('endTime')) : $end_time;

                if ($end_time < $begin_time) parent::error_json(000, ['起始时间不得大于结束时间']);

                //判断差距时间
                $diff = strtotime($end_time) - strtotime($begin_time);//差距秒数
                $one_day = 60 * 60 * 24;//1天的秒数
                $diff_days = $diff / $one_day;//差距天数

                $type = 'day';//默认按天算
                if ($diff_days > 7) $type = 'week';//超过7天按周算
                if ($diff_days > 31) $type = 'month';//超过31天按月算
                if ($diff_days > 366) $type = 'year';//超过365天按年算
                break;
            case 'today':
                //今天
                $begin_time = date('Y-m-d 00:00:00');
                $end_time = self::time_date(strtotime('+1 day', self::time_stamp($begin_time)));
                break;
            case 'yesterday':
                //明天
                $end_time = date('Y-m-d 00:00:00');
                $begin_time = self::time_date(strtotime('-1 day', self::time_stamp($end_time)));
                break;
            case 'all':
                //全部
                $end_time = date('Y-m-d H:i:s');
                $begin_time = '2018-10-01 00:00:00';
                break;
            default:
                break;
        }

        return [
            'type' => $type,
            'type2' => $type2,
            'begin' => $begin_time,
            'end' => $end_time
        ];
    }

    public function time_type_2()
    {
        $result = self::time_type();

        self::time($result['type'], $result['begin'], $result['end']);
    }

    //时间与筛选
    public function time($type = null, $begin_time = null, $end_time = null)
    {
        //获取折线图时间模式
        $type = is_null($type) ? request()->get('type') : $type;

        //获取起始时间段
        $begin_time = is_null($begin_time) ? (is_null(request()->get('startTime')) ? '2018-1-1 00:00:00' : request()->get('startTime')) : $begin_time;

        //获取结束时间段
        $end_time = is_null($end_time) ? (is_null(request()->get('endTime')) ? self::time_date() : request()->get('endTime')) : $end_time;

        if ($end_time < $begin_time) parent::error_json('起始时间不得大于结束时间');

        //计算起止时间,并给予计算时间戳
        switch ($type) {
            case 'year':

                $types = '+1 year';

                //起始点
                $begin_date = self::time_date(self::time_stamp($begin_time), 'Y') . '-01-01 00:00:00';

                //结束点
                $end_date = self::time_date(strtotime($types, self::time_stamp($end_time)), 'Y') . '-01-01 00:00:00';

                break;
            case 'month':

                $types = '+1 month';

                //起始点
                $begin_date = self::time_date(self::time_stamp($begin_time), 'Y-m') . '-01 00:00:00';

                //结束点
                $end_date = self::time_date(strtotime($types, self::time_stamp($end_time)), 'Y-m') . '-01 00:00:00';

                break;
            case 'day':
                $types = '+1 day';

                //起始点
                $begin_date = self::time_date(self::time_stamp($begin_time), 'Y-m-d') . ' 00:00:00';
                //结束点
                $end_date = self::time_date(strtotime($types, self::time_stamp($end_time)), 'Y-m-d') . ' 00:00:00';;

                break;
            case 'week':
                $types = '+7 day';

                //起始点
                $begin_date = self::time_date(self::time_stamp($begin_time), 'Y-m-d') . ' 00:00:00';
                //结束点
                $end_date = self::time_date(strtotime($types, self::time_stamp($end_time)), 'Y-m-d') . ' 00:00:00';;

                break;
            default:
                //结束点
                $end_date = self::time_date(strtotime('+1 day', self::time_stamp()), 'Y-m-d') . ' 00:00:00';;

                //起始时间
                $begin_date = self::time_date(strtotime('-7 day', strtotime($end_date)));

                $type = 'day';
                $types = '+1 day';

                break;
        }

        //初始化times
        $times = [];
        $where = [];
        $wheres = [];
        $key = 0;

        $this->begin = $begin_date;
        $this->end = $end_date;

        //组合数据及筛选条件
        while (($begin_date < $end_date)) {

            $end = self::time_date(strtotime($types, self::time_stamp($begin_date)));


            $where[$key] = [
                [($this->join_name . $this->column), '>=', $begin_date],
                [($this->join_name . $this->column), '<', $end],
                /*($this->join_name . $this->column) => [
                    ['>=', $begin_date],
                    ['<', $end]
                ]*/
            ];

            switch ($type) {
                case 'month':
                    $the = date('Y-m', strtotime($begin_date));
                    break;
                case 'year':
                    $the = date('Y', strtotime($begin_date));
                    break;
                default:
                    $the = date('Y-m-d', strtotime($begin_date));
                    break;
            }
            $times[$key] = $the;

            $wheres[$key]['begin'] = $begin_date;
            $begin_date = self::time_date(strtotime($types, self::time_stamp($begin_date)));
            $wheres[$key]['end'] = $begin_date;

            $key++;
        }


        $this->type = $type;
        $this->types = $types;
        $this->times = $times;
        $this->where = $where;
        $this->wheres = $wheres;
    }

    /**
     * 时间,返回时间戳
     *
     * @param null $date
     * @return false|int
     */
    private function time_stamp($date = null)
    {
        if (is_null($date)) {

            $time = time();
        } else {

            $time = strtotime($date);
        }

        return $time;
    }

    /**
     * 时间，返回字符串
     *
     * @param null $time
     * @param string $style
     * @return false|string
     */
    private function time_date($time = null, $style = 'Y-m-d H:i:s')
    {
        if (is_null($time)) {

            $date = date($style);
        } else {

            $date = date($style, $time);
        }

        return $date;
    }

    //订单数
    public function order_number()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->count();
        }

        return [
            'title' => '订单数',
            'subtitle' => '新增订单总数',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //订单金额
    public function order_total()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->sum('total');
        }

        return [
            'title' => '订单金额',
            'subtitle' => '新增订单总额',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //快递数
    public function express_number()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->sum('express_number');
        }

        return [
            'title' => '快递数量',
            'subtitle' => '快递数量',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //快递金额
    public function express_total()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->sum('total_express');
        }

        return [
            'title' => '快递金额',
            'subtitle' => '快递金额',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //商品数
    public function goods_number()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->sum('goods_number');
        }

        return [
            'title' => '商品数量',
            'subtitle' => '商品数量',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //商品金额
    public function goods_total()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $order = new OrderModel();

            $result[$k] = $order->where($v)->sum('total_goods');
        }

        return [
            'title' => '商品金额',
            'subtitle' => '商品金额',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //新增会员
    public function new_member()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $member = new MemberModel();

            $result[$k] = $member->where($v)->count();
        }

        return [
            'title' => '新增会员',
            'subtitle' => '新增会员',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //充值金额
    public function recharge()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $recharge = new RechargeModel();

            $result[$k] = $recharge->where($v)->where('status', '=', 1)->sum('total');
        }

        return [
            'title' => '充值金额',
            'subtitle' => '充值金额',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //购买会员数
    public function buy_grade_number()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $result[$k] = 0;
        }

        return [
            'title' => '购买会员数',
            'subtitle' => '购买会员数',
            'data' => $result,
            'name' => $this->times
        ];
    }

    //购买会员数
    public function buy_grade_total()
    {
        $result = [];

        foreach ($this->where as $k => $v) {

            $result[$k] = 0;
        }

        return [
            'title' => '购买会员金额',
            'subtitle' => '购买会员金额',
            'data' => $result,
            'name' => $this->times
        ];
    }
}