<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/26
 * Time: 下午3:43
 */

namespace App\Http\Classes\Plan;


use App\Models\Order\BuyOrderModel;

class AutoClass extends PlanClass
{
    private $member = [];
    private $insert = [];

    public function __construct()
    {
        parent::__construct();

        $this->keyword = 'auto';

        if (parent::test_plan())return;

        //获取所有开启了自动采集的会员
        self::all_member();

        //添加订单
        self::add_buy();

        $record = '新增自动采集订单：'.count($this->insert).'个';
        parent::store_plan($record);
    }

    public function all_member()
    {
        $sql = "SELECT * FROM young_member_models WHERE young_auto_buy = 10 AND young_mode = 20 AND young_status = 10";

        $this->member = \DB::select($sql);
    }

    public function add_buy()
    {
        //初始化配置文件
        $set = $this->set;
        $order = new BuyOrderModel();
        $young_order = $order->new_order();
        $members = [];

        foreach ($this->member as $v) {

            //赋值会员模型
            $member = (array)$v;

            //没完善自主排单信息
            if (empty($member['young_auto_number']) ||
                empty($member['young_auto_time'])
            ) continue;

            $day = $member['young_auto_time'];
            $time_lower = $set['goodsLower1'];
            $time_ceil = $set['goodsCeil1'];
            if ($day < $time_lower) $day = $time_lower;//保证收益周期不低于配置周期
            if ($day > $time_ceil) $day = $time_ceil;//保证收益周期不高于配置周期

            //寻找该会员的最后一个订单
            $last = new BuyOrderModel();
            $last = $last->where('uid', '=', $member['uid'])->orderBy('created_at', 'desc')->first();

            //有下过单
            if (!is_null($last)) {

                //上一个订单尚未付款完成
                if ($last->young_status < 40) continue;

                //计算下次下单时间
                $begin = strtotime('+' . $day . ' day', strtotime($last->created_at));

                //预算时间未到
                if ($begin > time()) continue;

                //今天采集过了
                if ($last->created_at >= date('Y-m-d 00:00:00')) continue;
            }


            //商品单价
            $amount = $set['goodsTotal'];
            //初始化对比变量
            $time = $set['goodsType1'];
            $number = $member['young_auto_number'];
            $number_max = $set['goodsTop1'];

            switch ($member['young_type']) {
                case '20':
                    $inPro = $set['typePro0'];
                    break;
                default:
                    $inPro = $set['typePro1'];
                    break;
            }

            if ($number <= 0) $number = 1;//保证排单数量不小于1
            if ($number > $number_max) $number = $number_max;//保证排单数量不大于配置最高数量

            //计算总金额
            $total = $number * $amount;

            $gxd_pro = 0;//贡献点比例
            $gxd = 0;//贡献点
            if ($member['young_type'] == '20') {

                $gxd_pro = ($set['typePro1'] - $set['typePro0']);
                if ($gxd_pro > 0) {

                    $gxd_pro = 0;
                    $gxd = number_format(($gxd_pro * $total * $time / 100), 2, '.', '');
                }
            }

            //新增订单信息
            $insert = [];
            $insert['young_order'] = $young_order;
            $insert['young_from'] = '20';//系统派单
            $insert['uid'] = $member['uid'];
            $insert['young_total'] = $total;
            $insert['young_days'] = $time;
            $insert['young_in_pro'] = $inPro;
            $insert['young_in'] = number_format(($inPro * $total * $time / 100), 2, '.', '');
            $insert['young_amount'] = $amount;
            $insert['young_number'] = $number;
            $insert['young_poundage'] = $set['buyPoundage'] * $number;
            $insert['young_name'] = $set['goodsName'];
            $insert['young_first_total'] = number_format(($total * $set['matchFirstPro'] / 100), 2, '.', '');
            $insert['young_first_pro'] = $set['matchFirstPro'];
            $insert['young_tail_total'] = $insert['young_total'] - $insert['young_first_total'];
            $insert['young_gxd'] = $gxd;
            $insert['young_gxd_pro'] = $gxd_pro;
            $insert['young_grade'] = $member['young_grade'];
            $insert['created_at'] = DATE;
            $insert['updated_at'] = DATE;

            $this->insert[] = $insert;

            //会员信息变更
            $m = [
                'uid' => $member['uid']
            ];
            if (is_null($member['young_first_buy_time'])) {
                $m['young_first_buy_time'] = DATE;
                $m['young_first_buy_total'] = $total;
            } else {

                $m['young_first_buy_time'] = $member['young_first_buy_time'];
                $m['young_first_buy_total'] = $member['young_first_buy_total'];
            }
            $m['young_last_buy_time'] = DATE;
            $m['young_last_buy_total'] = $total;
            $m['young_all_buy_total'] = $member['young_all_buy_total'] + $total;
            $members[] = $m;

            $young_order++;
        }

        if (count($this->insert) > 0) {

            $order->insert($this->insert);
            $this->table_update('member_models', $members, 'uid');
        }
    }
}