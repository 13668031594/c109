<?php

namespace App\Models\Message;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message\MessageModel
 *
 * @property int $id
 * @property int $uid 会员uid
 * @property string $young_status 状态
 * @property string $young_type 消息类型
 * @property string $young_message 消息内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereYoungMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message\MessageModel whereYoungType($value)
 * @mixin \Eloquent
 */
class MessageModel extends Model
{
    public $type = [
        10 => '挂售订单',
        20 => '采集订单',
    ];

    public $status = [
        10 => '未读',
        20 => '已读',
    ];
}
