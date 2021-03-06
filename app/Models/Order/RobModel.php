<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\RobModel
 *
 * @property int $id
 * @property int $uid 需要激活的会员id
 * @property string $young_status 状态
 * @property string|null $young_order 下单的订单号
 * @property string|null $young_order_id 下单的id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $young_total 总价
 * @property float $young_amount 商品单价
 * @property float $young_poundage 手续费
 * @property float $young_in_pro 收益率
 * @property int $young_number 采集数量
 * @property int $young_time 收益时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungInPro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereYoungTotal($value)
 * @mixin \Eloquent
 */
class RobModel extends Model
{
    public $status = [
        '10' => '待摇号',
        '20' => '中选',
        '30' => '落选',
        '40' => '作废',
        '50' => '已下单'
    ];
}
