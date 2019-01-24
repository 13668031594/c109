<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberActModel
 *
 * @property int $id
 * @property int $uid 需要激活的会员id
 * @property int $young_referee_id 上级id
 * @property string $young_status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereYoungRefereeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberActModel whereYoungStatus($value)
 * @mixin \Eloquent
 */
class MemberActModel extends Model
{
    public $status = [
        '10' => '待摇号',
        '20' => '中选',
        '30' => '落选',
        '40' => '作废'
    ];
}
