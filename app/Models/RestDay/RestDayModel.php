<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RestDayModel
 *
 * @property int $id
 * @property string $young_name 休息原因
 * @property string|null $young_begin 休息开始时间
 * @property string|null $young_end 休息结束时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereYoungBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereYoungEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RestDayModel whereYoungName($value)
 * @mixin \Eloquent
 */
class RestDayModel extends Model
{
    //
}
