<?php

namespace App\Models\Master;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Master\MasterModel
 *
 * @property int $mid
 * @property string $young_nickname 昵称
 * @property string $young_account 账号
 * @property string $password 密码
 * @property string|null $young_phone 联系电话
 * @property int $young_login_times 登录次数
 * @property string|null $young_last_login_time 上次登录时间
 * @property string|null $young_this_login_time 本次登录时间
 * @property string|null $young_last_login_ip 上次登录ip
 * @property string|null $young_this_login_ip 本次登录ip
 * @property int $young_power_id 权限组id
 * @property string $young_power_name 权限组名称
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereMid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungLoginTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungPowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungPowerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungThisLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Master\MasterModel whereYoungThisLoginTime($value)
 * @mixin \Eloquent
 */
class MasterModel extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'mid';
}