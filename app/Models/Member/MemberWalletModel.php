<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberWalletModel
 *
 * @property int $id
 * @property int $uid 会员id
 * @property float $young_gxd 变动贡献点
 * @property float $young_gxd_now 当前贡献点
 * @property float $young_gxd_all 累计贡献点
 * @property float $young_reward 变动奖励账户
 * @property float $young_reward_now 当前奖励账户
 * @property float $young_reward_all 累计奖励账户
 * @property float $young_balance 变动余额
 * @property float $young_balance_now 当前余额
 * @property float $young_balance_all 累计余额
 * @property float $young_poundage 变动手续费
 * @property float $young_poundage_now 当前手续费
 * @property float $young_poundage_all 累计手续费
 * @property string $young_record 文字记录
 * @property string $young_type 变更类型
 * @property string $young_keyword 关键字
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalanceAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalanceNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxdAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxdNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundageAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundageNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungType($value)
 * @mixin \Eloquent
 */
class MemberWalletModel extends Model
{
    //变更类型
    public $type = [
        10 => '管理员调整'
    ];

    //添加新的变更记录
    public function store_record(MemberModel $memberModel, $changes = [], $type, $record = '', $keyword = '')
    {
        //初始化模型
        $wallet = new self;

        //基础信息
        $wallet->uid = $memberModel->uid;
        $wallet->young_type = $type;
        $wallet->young_record = $record;
        $wallet->young_keyword = $keyword;

        //钱包状态
        $wallet->young_balance_all = $memberModel->young_balance_all;
        $wallet->young_balance_now = $memberModel->young_balance;
        $wallet->young_poundage_all = $memberModel->young_poundage_all;
        $wallet->young_poundage_now = $memberModel->young_poundage;
        $wallet->young_reward_all = $memberModel->young_reward_all;
        $wallet->young_reward_now = $memberModel->young_reward;
        $wallet->young_gxd_all = $memberModel->young_gxd_all;
        $wallet->young_gxd_now = $memberModel->young_gxd;

        //变化信息
        $wallet->young_balance = isset($changes['balance']) ? $changes['balance'] : 0;
        $wallet->young_poundage = isset($changes['poundage']) ? $changes['poundage'] : 0;
        $wallet->young_reward = isset($changes['reward']) ? $changes['reward'] : 0;
        $wallet->young_gxd = isset($changes['gxd']) ? $changes['gxd'] : 0;

        //保存
        $wallet->save();
    }
}
