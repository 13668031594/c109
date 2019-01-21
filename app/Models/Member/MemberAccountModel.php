<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberAccountModel
 *
 * @property int $id
 * @property int|null $uid 会员id
 * @property string $young_account 账号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberAccountModel whereYoungAccount($value)
 * @mixin \Eloquent
 */
class MemberAccountModel extends Model
{
    //
}
