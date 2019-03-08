<?php

namespace App\Models\Notice;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notice\NoticeModel
 *
 * @property int $id
 * @property string $young_title 标题
 * @property string $young_content 内容
 * @property string $young_man 发布人
 * @property int $young_sort 排序
 * @property string $young_status 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereYoungContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereYoungMan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereYoungSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notice\NoticeModel whereYoungTitle($value)
 * @mixin \Eloquent
 */
class NoticeModel extends Model
{
    const STATUS = [
        '10' => '显示',
        '20' => '隐藏',
    ];
}
