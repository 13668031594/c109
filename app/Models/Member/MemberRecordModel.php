<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberRecordModel
 *
 * @property int $id
 * @property int $uid 会员id
 * @property string $young_record 文字记录
 * @property string $young_type 变更类型
 * @property string $young_keyword 关键字
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereYoungKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereYoungRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberRecordModel whereYoungType($value)
 * @mixin \Eloquent
 */
class MemberRecordModel extends Model
{
    //变更类型
    public $type = [
        10 => '后台调整',
        20 => '收益状态',
        30 => '状态变更',
    ];

    //添加新的变更记录
    public function store_record(MemberModel $memberModel, $type, $record = '', $keyword = '')
    {
        //初始化模型
        $wallet = new self;

        //基础信息
        $wallet->uid = $memberModel->uid;
        $wallet->young_type = $type;
        $wallet->young_record = $record;
        $wallet->young_keyword = $keyword;

        //保存
        $wallet->save();
    }
}
