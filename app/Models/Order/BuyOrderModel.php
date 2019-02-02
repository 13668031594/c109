<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\BuyOrderModel
 *
 * @property int $id
 * @property string $young_order 订单号
 * @property int $uid 买家id
 * @property string $young_status 状态
 * @property float $young_total 总金额
 * @property int $young_days 收益时间
 * @property float $young_in_pro 利率
 * @property float $young_in 实际收益
 * @property string|null $young_in_over 收益完结时间
 * @property float $young_amount 商品单价
 * @property int $young_number 商品数量
 * @property string $young_name 商品名称
 * @property string|null $young_first_match 首付款匹配时间
 * @property string|null $young_first_end 首付款完结时间
 * @property float $young_first_total 首付款金额
 * @property float $young_first_pro 首付款比例
 * @property string|null $young_tail_match 尾款匹配时间
 * @property string|null $young_tail_end 尾款完结时间
 * @property float $young_tail_total 尾款金额
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $young_from 来源
 * @property float $young_poundage 手续费
 * @property string $young_abn 异常
 * @property float $young_tail_complete 已经匹配尾款
 * @property float $young_gxd_pro 收益贡献点比例
 * @property float $young_gxd 收益贡献点
 * @property string $young_grade 会员下单时候的身份
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungAbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstMatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungGxdPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungInOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungInPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailMatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTotal($value)
 * @mixin \Eloquent
 */
class BuyOrderModel extends Model
{
    public $status = [
        10 => '队列中',
        20 => '付首款',
//        30 => '首款确认',
        40 => '尾款队列',
        50 => '付尾款',
//        60 => '尾款确认',
        70 => '收益中',
        75 => '冻结',
        79 => '付费提现',
        80 => '待提现',
        90 => '已完结',
    ];

    public $abn = [
        10 => '正常',
        20 => '异常',
    ];

    public $from = [
        10 => '手动',
        20 => '自动',
        30 => '抢单'
    ];

    //所有对比数组
    public function arrays()
    {
        $result = [
            'status' => $this->status,
            'abn' => $this->abn,
            'from' => $this->from,
        ];

        return $result;
    }

    //获取新的订单号
    public function new_order_old()
    {
        $key = 'B' . date('Ymd');

        $number = new BuyOrderModel();
        $number = $number->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->count();
        $number++;

        $len = strlen('B20181127000001');

        for ($i = ($len - strlen($key) - strlen($number)); $i > 0; $i--) {

            $key .= '0';
        }

        $key .= $number;

        //验证订单号是否被占用
        $test = new BuyOrderModel();
        $test = $test->where('young_order', '=', $key)->first();

        if (!is_null($test)) {

            return self::new_order_old();
        } else {

            return $key;
        }
    }

    public function new_order_2()
    {
        $num = 100000;

        $number = new BuyOrderModel();
        $number = $number->count();
        $number++;

        $num += $number;

        $key = self::test_order($num);

        return $key;
    }

    private function test_order($num)
    {
        $key = 'B' . $num;

        //验证订单号是否被占用
        $test = new BuyOrderModel();
        $test = $test->where('young_order', '=', $key)->first();

        if (is_null($test)) return $key;

        $num++;
        return self::test_order($num);
    }

    public function new_order()
    {
        $string = 'abcdefghijklmnopqrstuvwxvzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $max = strlen($string) - 1;
        $min = 0;

        $key = 'B';

        for ($i = 6; $i > 0; $i--) {

            $key .= $string[rand($min, $max)];
        }

        //验证订单号是否被占用
        $test = new BuyOrderModel();
        $test = $test->where('young_order', '=', $key)->first();

        if (is_null($test)) return $key;

        return self::new_order();
    }
}
