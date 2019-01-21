<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberSmsModel
 *
 * @property int $id
 * @property string $young_phone 电话
 * @property string $young_end 结束时间
 * @property string $young_code 验证码
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereYoungCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereYoungEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberSmsModel whereYoungPhone($value)
 * @mixin \Eloquent
 */
class MemberSmsModel extends Model
{
    //
}
