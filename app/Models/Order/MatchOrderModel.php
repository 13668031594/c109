<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\MatchOrderModel
 *
 * @property int $id
 * @property string $young_status 状态
 * @property float $young_total 金额
 * @property int $young_buy_id 购买订单id
 * @property string $young_buy_order 购买订单的订单号
 * @property int $young_buy_uid 购买人id
 * @property string $young_buy_nickname 购买人昵称
 * @property int $young_sell_id 出售订单id
 * @property string $young_sell_order 出售订单的订单号
 * @property int $young_sell_uid 出售人id
 * @property string $young_sell_nickname 出售人昵称
 * @property int|null $young_bank_id 银行id
 * @property string|null $young_bank_name 银行名称
 * @property string|null $young_bank_address 支行
 * @property string|null $young_bank_no 银行卡号
 * @property string|null $young_bank_man 收款人姓名
 * @property string|null $young_alipay 支付宝
 * @property string|null $young_note 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungAlipay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBankAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBankMan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBankNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBuyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBuyNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBuyOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungBuyUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungTotal($value)
 * @mixin \Eloquent
 */
class MatchOrderModel extends Model
{
    public $status = [
        10 => '待付款',
        20 => '待确认',
        30 => '完结',
    ];

    public $abn = [
        10 => '正常',
        20 => '异常',
    ];
}
