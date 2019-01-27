<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberRankModel
 *
 * @property int $id
 * @property string $young_name 名称
 * @property int $young_sort 排序
 * @property int $young_child 升级所需的下级数
 * @property float $young_discount 充值折扣
 * @property float $young_wage 工资占比
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereYoungChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereYoungDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereYoungName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereYoungSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRankModel whereYoungWage($value)
 * @mixin \Eloquent
 */
class MemberRankModel extends Model
{
    //
}
