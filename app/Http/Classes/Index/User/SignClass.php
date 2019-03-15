<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/27
 * Time: 下午6:22
 */

namespace App\Http\Classes\Index\User;

use App\Exceptions\JsonException;
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
        /*$member = parent::get_member();
        if ($member['phone'] === '13608302076'){
            $result = [
                'status' => 'success',
                'data' => [
                    'number' => 1,
                    'message' => '哈哈哈哈',
                ],
                'message' => '操作成功',
            ];

            throw new JsonException(json_encode($result));
        }*/

        $begin = $this->set_time($this->set['signStart']);
        $end = $this->set_time($this->set['signEnd']);

        if (time() < $begin || time() > $end) self::sign_0("请在每天 {$begin} 至 {$end} 签到");
    }

    //今天是否签到过
    public function validator_today()
    {
        $member = parent::get_member();

        $today = date('Y-m-d 00:00:00');

        $test = OrderSignModel::whereUid($member['uid'])->where('created_at', '>=', $today)->first();

        if (!is_null($test)) self::sign_0("今天已经签到过了");
    }

    //获取今日收益
    public function today_in()
    {
        $member = parent::get_member();

        //进入收益中，尚未提现的订单
        $orders = BuyOrderModel::whereUid($member['uid'])->whereIn('young_status', [70, 75, 79, 80])->get();

        $today_in = 0;
        if (count($orders) > 0) foreach ($orders as $v) {

            if ($v->young_sign_days >= $v->young_days) continue;

            //剩余可领取金额
            $total = ($v->young_total + $v->young_in - $v->young_sign_total);

            //剩余可领取天数
            $day = $v->young_days - $v->young_sign_days;

            //增加今日领取收益数
            $today_in += number_format(($total / $day), 2, '.', '');
        }

        if ($today_in <= 0) self::sign_0("今天已经签到过了");

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

    //报错
    public function sign_0($message)
    {
        $result = [
            'status' => 'success',
            'data' => [
                'number' => 0,
                'message' => $message,
            ],
            'message' => '操作成功',
        ];

        throw new JsonException(json_encode($result));
    }
}