<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer\CustomerModel
 *
 * @property int $id
 * @property string $young_nickname 客服昵称
 * @property string $young_text 客服联系方式
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $young_switch 随机分配开关
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereYoungNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereYoungSwitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer\CustomerModel whereYoungText($value)
 * @mixin \Eloquent
 */
class CustomerModel extends Model
{
    public $switch = [
        10 => '开启',
        20 => '关闭',
    ];

    public function arrays()
    {
        return [
            'switch' => $this->switch
        ];
    }
}
