<?php

namespace App\Models\Shopowner;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shopowner\ShopownerModel
 *
 * @property int $id
 * @property int $uid 会员id
 * @property float $young_reward 奖励百分比
 * @property float $young_reward_all 累计奖励
 * @property string $young_status 状态，10正常，20停用
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereYoungReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereYoungRewardAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shopowner\ShopownerModel whereYoungStatus($value)
 * @mixin \Eloquent
 */
class ShopownerModel extends Model
{
    const STATUS = [
        10 => '激活',
        20 => '停用',
    ];
}
