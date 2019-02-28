<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\System\SystemWalletModel
 *
 * @property int $id
 * @property float $young_gxd 变动贡献点
 * @property float $young_reward 变动奖励账户
 * @property float $young_balance 变动余额
 * @property float $young_poundage 变动手续费
 * @property string $young_record 文字记录
 * @property string $young_type 变更类型
 * @property string $young_keyword 关键字
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\System\SystemWalletModel whereYoungType($value)
 * @mixin \Eloquent
 */
class SystemWalletModel extends Model
{
    //变更类型
    public $type = [
        10 => '订单星伙',
    ];

    //添加新的变更记录
    public function store_record($changes = [], $type, $record = '', $keyword = '')
    {
        //初始化模型
        $wallet = new self;

        //基础信息
        $wallet->young_type = $type;
        $wallet->young_record = $record;
        $wallet->young_keyword = $keyword;

        //变化信息
        $wallet->young_balance = isset($changes['balance']) ? $changes['balance'] : 0;
        $wallet->young_poundage = isset($changes['poundage']) ? $changes['poundage'] : 0;
        $wallet->young_reward = isset($changes['reward']) ? $changes['reward'] : 0;
        $wallet->young_gxd = isset($changes['gxd']) ? $changes['gxd'] : 0;

        //保存
        $wallet->save();
    }
}
