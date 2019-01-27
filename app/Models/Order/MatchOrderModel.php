<?php

namespace App\Models\Order;

use App\Http\Classes\Set\SetClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRankModel;
use App\Models\Member\MemberWalletModel;
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
 * @property string|null $young_pay 付款凭证
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $young_abn 异常
 * @property string $young_type 类型
 * @property string|null $young_pay_time 打款时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungAbn($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungPayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungSellUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\MatchOrderModel whereYoungType($value)
 * @mixin \Eloquent
 */
class MatchOrderModel extends Model
{
    public $status = [
        10 => '待付款',
        11 => '重新付款',
        20 => '待确认',
        30 => '完结',
    ];

    public $abn = [
        10 => '正常',
        20 => '异常',
    ];

    public $type = [
        10 => '首付款',
        20 => '尾款',
    ];

    //匹配订单付款完结后的一系列操作
    public function match_end($id)
    {
        //寻找匹配订单
        $match = self::whereId($id)->first();

        if (is_null($match)) return;

        //根据匹配订单类型，触发不同操作
        if ($match->young_type == '10') self::status_10($match);
        if ($match->young_type == '20') self::status_20($match);
    }

    //首付款订单完结
    private function status_10(self $match)
    {
        //尝试完结挂售订单
        self::over_sell($match);

        $buy = BuyOrderModel::whereId($match->young_buy_id)->first();
        $buy->young_status = 40;//修改到等待尾款匹配状态
        $buy->young_first_end = DATE;//修改首付款完结时间
        $buy->save();
    }

    //完结购买订单
    private function status_20(self $match)
    {
        //尝试完结挂售订单
        self::over_sell($match);

        //寻找其他未完结的匹配订单
        $other = new MatchOrderModel();
        $other = $other->where('young_buy_id', '=', $match->young_buy_id)->where('young_status', '<>', 30)->first();

        //还有其他尾款未完结的匹配订单
        if (!is_null($other)) return;

        //将订单进入收益中状态
        $buy = BuyOrderModel::whereId($match->young_buy_id)->first();

        //判断订单是否全部匹配完成
        if ($buy->young_tail_complete < $buy->young_tail_total) return;
        $buy->young_status = 70;//修改收益中状态
        $buy->young_tail_end = DATE;//修改尾款完结时间
        $buy->young_in_over = date('Y-m-d H:i:s', strtotime('+ ' . $buy->young_days . 'day'));
        $buy->save();

        MemberModel::whereUid($buy->uid)->update(['young_formal' => '20']);

        //分佣给上级
        self::reward($buy);

        //尝试为上级提升等级
        self::rank_up($buy);
    }

    //完结挂售订单
    private function over_sell(self $match)
    {
        $other = new MatchOrderModel();
        $other = $other->where('young_sell_id', '=', $match->young_sell_id)->where('young_status', '<>', 30)->first();

        //还有其他尾款未完结的匹配订单
        if (!is_null($other)) return;

        //获取挂售订单信息
        $sell = SellOrderModel::whereId($match->young_sell_id)->first();

        //判断是否全部挂售完成
        if ($sell->young_remind > 0) return;
        $sell->young_status = 30;//修改收益中状态
        $sell->save();
    }

    //上级分佣
    public function reward(BuyOrderModel $model)
    {
        //查看设置信息
        $set = new SetClass();
        $set = $set->index();

        //获取手续费情况
        $poundage = $model->young_poundage;
        if ($poundage <= 0) return;

        //计算奖励金额
        $reward = number_format(($poundage * $set['rewardPro'] / 100), 2, '.', '');
        if ($reward <= 0) return;

        //寻找买单人
        $member = MemberModel::whereUid($model->uid)->first();
        if (is_null($member) || empty($member->young_referee_id)) return;

        //寻找买单人上级
        $referee = MemberModel::whereUid($member->young_referee_id)->first();
        if (is_null($referee)) return;

        //添加到奖励账户
        $referee->young_reward += $reward;
        $referee->save();

        //添加到钱包记录
        $wallet = new MemberWalletModel();
        $record = '下级『' . $member->young_nickname . '』，订单号『' . $model->young_order . '』，付款完结，获得『' . $this->set['walletReward'] . '』' . $reward;
        $keyword = $model->young_order;
        $change = ['reward' => $reward];
        $wallet->store_record($member, $change, 80, $record, $keyword);
    }

    //尝试提升上级等级
    private function rank_up(BuyOrderModel $model)
    {
        $member = MemberModel::whereUid($model->uid)->first();
        if (is_null($member) || empty($member->young_families)) return;

        $families = explode(',', $member->young_families);

        $rank = new MemberRankModel();
        $rank = $rank->orderBy('id', 'desc')->all();

        foreach ($families as $v) {

            $member = MemberModel::whereUid($v)->first();
            if (is_null($member)) continue;

            $child = new MemberModel();
            $child = $child->where('young_families', 'like', '%' . $v . '%')->where('young_formal', '=', '20')->count();

            foreach ($rank as $va) {

                if ($va->id <= $member->young_rank_id) break;

                if ($va->young_child <= $child) {

                    $member->young_rank_id = $rank->id;
                    $member->young_rank_name = $rank->young_name;
                    $member->save();
                }
            }
        }
    }
}
