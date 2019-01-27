<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MemberWithdrawModel
 *
 * @property int $id
 * @property int $uid 会员uid
 * @property float $young_reward 上次提现
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberWithdrawModel whereYoungReward($value)
 * @mixin \Eloquent
 */
class MemberWithdrawModel extends Model
{
    //
}
