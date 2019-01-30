<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\SellOrderModel
 *
 * @property int $id
 * @property string $young_order 订单号
 * @property int $uid 卖家id
 * @property string $young_status 状态
 * @property float $young_total 总金额
 * @property float $young_remind 剩余金额
 * @property int|null $young_bank_id 银行id
 * @property string|null $young_bank_name 银行名称
 * @property string|null $young_bank_address 支行
 * @property string|null $young_bank_no 银行卡号
 * @property string|null $young_bank_man 收款人姓名
 * @property string|null $young_alipay 支付宝
 * @property string|null $young_note 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungAlipay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungBankAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungBankMan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungBankNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungRemind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\SellOrderModel whereYoungTotal($value)
 * @mixin \Eloquent
 */
class SellOrderModel extends Model
{
    public $status = [
        10 => '匹配中',
        20 => '待收款',
        30 => '完结',
//        30 => '退款',
    ];

    //获取新的订单号
    public function new_order_old()
    {
        $key = 'S' . date('Ymd');

        $number = new SellOrderModel();
        $number = $number->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->count();
        $number++;

        $len = strlen('S20181127000001');

        for ($i = ($len - strlen($key) - strlen($number)); $i > 0; $i--) {

            $key .= '0';
        }

        $key .= $number;

        //验证订单号是否被占用
        $test = new SellOrderModel();
        $test = $test->where('young_order', '=', $key)->first();

        if (!is_null($test)) {

            return self::new_order_old();
        } else {

            return $key;
        }
    }

    public function new_order()
    {
        $num = 100000;

        $number = new SellOrderModel();
        $number = $number->count();
        $number++;

        $num += $number;

        $key = self::test_order($num);

        return $key;
    }

    private function test_order($num)
    {
        $key = 'S' . $num;

        //验证订单号是否被占用
        $test = new SellOrderModel();
        $test = $test->where('young_order', '=', $key)->first();

        if (is_null($test)) return $key;

        $num++;
        return self::test_order($num);
    }
}
