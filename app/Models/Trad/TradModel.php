<?php

namespace App\Models\Trad;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Trad\TradModel
 *
 * @property int $id
 * @property string $young_order 订单号
 * @property string $young_status 状态
 * @property float $young_gxd 卖出贡献点
 * @property float $young_balance 收入余额
 * @property float $young_amount 单价
 * @property int|null $young_buy_uid 购买人id
 * @property string|null $young_buy_nickname 购买人昵称
 * @property int $young_sell_uid 出售人id
 * @property string $young_sell_nickname 出售人昵称
 * @property string|null $young_pay_time 交易时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $young_pay 支付凭证
 * @property float $young_poundage 手续费
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungBuyNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungBuyUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungPayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungSellNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungSellUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trad\TradModel whereYoungStatus($value)
 * @mixin \Eloquent
 */
class TradModel extends Model
{
    public $status = [
        10 => '正常',
        20 => '待付款',
        30 => '待确认',
        50 => '完结',
        60 => '撤回',
    ];

    //获取新的订单号
    public function new_order()
    {
        $key = 'T' . date('Ymd');

        $number = new self;
        $number = $number->where('created_at', '>=', date('Y-m-d') . ' 00:00:00')->count();
        $number++;

        $len = strlen('T20181127000001');

        for ($i = ($len - strlen($key) - strlen($number)); $i > 0; $i--) {

            $key .= '0';
        }

        $key .= $number;

        //验证订单号是否被占用
        $test = new self;
        $test = $test->where('young_order', '=', $key)->first();

        if (!is_null($test)) {

            return self::new_order();
        } else {

            return $key;
        }
    }
}
