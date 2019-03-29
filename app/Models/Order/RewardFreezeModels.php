<?php

namespace App\Models\Order;

use App\Http\Classes\Set\SetClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\RewardFreezeModels
 *
 * @property int $id
 * @property int $uid 会员id
 * @property string $young_order 来源订单号
 * @property float $young_freeze 冻结金额
 * @property string $young_status 状态 10未解冻，20已解冻
 * @property string|null $young_thaw 解冻时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereYoungFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereYoungOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RewardFreezeModels whereYoungThaw($value)
 * @mixin \Eloquent
 */
class RewardFreezeModels extends Model
{
    public $status = [
        10 => '冻结中',
        20 => '已解冻'
    ];

    public function freeze($uid, $order, $freeze)
    {
        $model = new self;
        $model->uid = $uid;
        $model->young_order = $order;
        $model->young_freeze = $freeze;
        $model->young_status = 10;
        $model->save();
    }

    public function thaw($order)
    {
        //之前的冻结资金
        $freeze = self::whereYoungOrder($order)->where('young_status', '=', 10)->first();
        if (is_null($freeze)) return;

        //寻找会员
        $referee = MemberModel::whereUid($freeze->uid)->first();
        if (is_null($referee)) return;

        //查看设置信息
        $set = new SetClass();
        $set = $set->index();

        //初始化钱包信息
        $wallet = new MemberWalletModel();

        $freeze->young_status = 20;
        $freeze->young_thaw = DATE;
        $freeze->save();

        //添加到钱包记录
        $record = '解冻『' . $set['walletReward'] . '』' . $freeze->young_freeze . '，来源订单『' . $order . '』';
        $keyword = $freeze->young_order;
        $change = ['reward' => $freeze->young_freeze, 'freeze' => (0 - $freeze->young_freeze)];

        //添加到奖励账户
        $referee->young_reward_freeze -= $freeze->young_freeze;
        $referee->young_reward += $freeze->young_freeze;
        $referee->young_reward_all += $freeze->young_freeze;

        $wallet->store_record($referee, $change, 81, $record, $keyword);

        $referee->save();
    }
}
