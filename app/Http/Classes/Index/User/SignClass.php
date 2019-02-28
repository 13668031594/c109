<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/27
 * Time: 下午6:22
 */

namespace App\Http\Classes\Index\User;

use App\Http\Classes\Index\IndexClass;
use App\Http\Traits\TimeTrait;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\OrderSignModel;

class SignClass extends IndexClass
{
    use TimeTrait;

    //验证签到时间
    public function validator_time()
    {
        $begin = $this->set_time($this->set['signStart']);
        $end = $this->set_time($this->set['signEnd']);

        if (time() < $begin || time() > $end) parent::error_json('请在每天 ' . $this->set['signStart'] . ' 至 ' . $this->set['signEnd'] . ' 签到!');
    }

    //今天是否签到过
    public function validator_today()
    {
        $member = parent::get_member();

        $today = date('Y-m-d 00:00:00');

        $test = OrderSignModel::whereUid($member['uid'])->where('created_at', '>=', $today)->first();

        if (!is_null($test)) parent::error_json('今天已经签到过了');
    }

    //获取今日收益
    public function today_in()
    {
        $member = parent::get_member();

        //进入收益中，尚未提现的订单
        $orders = BuyOrderModel::whereUid($member['uid'])->whereIn('young_status', [70, 75, 79, 80])->get();

        $today_in = 0;
        if (count($orders) > 0) foreach ($orders as $v) {

            //进入收益后已经签到的次数
            $signs = OrderSignModel::whereUid($member['uid'])
                ->where('created_at', '>', $v->young_tail_end)
                ->count();

            //签到次数少于收益天数,可以签到
            if ($signs < $v->young_days) {

                //增加今日领取收益数
                $today_in += number_format((($v->young_in + $v->young_total) / $v->young_days), 2, '.', '');
            }
        }

        return $today_in;
    }

    //添加今日签到记录
    public function created_sign()
    {
        $member = parent::get_member();

        $model = new OrderSignModel();
        $model->uid = $member['uid'];
        $model->save();
    }
}