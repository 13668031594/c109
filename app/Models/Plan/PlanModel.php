<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Plan\PlanModel
 *
 * @property int $id
 * @property string $young_type 任务类型
 * @property string $young_status 执行情况
 * @property string $young_record 文字记录
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereYoungRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan\PlanModel whereYoungType($value)
 * @mixin \Eloquent
 */
class PlanModel extends Model
{
    public $type = [
        'act' => '激活账号'
    ];

    public $status = [
        10 => '成功',
        20 => '失败',
    ];

    public function store_plan($type, $record, $status = 10)
    {
        $model = new self;
        $model->young_type = $type;
        $model->young_status = $status;
        $model->young_record = $record;
        $model->save();
    }
}
