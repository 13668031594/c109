<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order\RobModel
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order\RobModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RobModel extends Model
{
    public $status = [
        '10' => '待摇号',
        '20' => '中选',
        '30' => '落选',
        '40' => '作废',
        '50' => '已下单'
    ];
}
