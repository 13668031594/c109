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

    public function thaw($uid)
    {
        //之前的冻结资金
        $freeze = self::whereUid($uid)->where('young_status', '=', 10)->get();
        if (count($freeze) <= 0) return;

        //寻找会员
        $referee = MemberModel::whereUid($uid)->first();
        if (is_null($referee)) return;

        //查看设置信息
        $set = new SetClass();
        $set = $set->index();

        //初始化钱包信息
        $wallet = new MemberWalletModel();

        foreach ($freeze as $v) {

            $v->young_status = 20;
            $v->young_thaw = DATE;
            $v->save();

            //添加到钱包记录
            $record = '解冻『' . $set['walletReward'] . '』' . $v->young_freeze;
            $keyword = $v->young_order;
            $change = ['reward' => $v->young_freeze, 'freeze' => (0 - $v->young_freeze)];

            //添加到奖励账户
            $referee->young_reward_freeze -= $v->young_freeze;
            $referee->young_reward += $v->young_freeze;
            $referee->young_reward_all += $v->young_freeze;

            $wallet->store_record($referee, $change, 81, $record, $keyword);
        }

        $referee->save();
    }
}
