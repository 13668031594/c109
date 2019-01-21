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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstMatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungFirstTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungInOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungInPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailMatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTailTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\BuyOrderModel whereYoungTotal($value)
 * @mixin \Eloquent
 */
class BuyOrderModel extends Model
{
    public $status = [
        10 => '首付款匹配中',
        20 => '首付款待付款',
        30 => '首付款待确认',
        40 => '尾款匹配中',
        50 => '尾款待付款',
        60 => '尾款待确认',
        70 => '收益中',
        79 => '冻结',
        80 => '待提现',
        90 => '完结',
    ];

    public $abn = [
        10 => '正常',
        20 => '异常',
    ];
}
