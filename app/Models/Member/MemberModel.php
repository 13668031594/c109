<?php

namespace App\Models\Member;

use App\Models\Bank\BankModel;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Member\MemberModel
 *
 * @property int $uid
 * @property string $young_account 账号
 * @property string $young_phone 联系电话
 * @property string $young_email 联系邮箱
 * @property string $password 密码
 * @property string $young_pay_pass 支付密码
 * @property string $young_nickname 昵称
 * @property string $young_level 所在层级
 * @property string $young_families 上级缓存
 * @property string $young_referee_id 上级id
 * @property string $young_referee_account 上级账号
 * @property string $young_referee_nickname 上级昵称
 * @property string|null $young_family_account 家谱绑定账号
 * @property string|null $young_family_binding 绑定时间
 * @property float $young_balance 余额
 * @property float $young_balance_all 累计余额
 * @property float $young_gxd 贡献点
 * @property float $young_gxd_all 累计贡献点
 * @property float $young_reward 奖励账户
 * @property float $young_reward_all 累计奖励账户
 * @property float $young_poundage 手续费
 * @property float $young_poundage_all 累计手续费
 * @property string $young_status 账号状态
 * @property string|null $young_status_time 账号状态变更时间
 * @property string $young_mode 账号模式
 * @property string|null $young_mode_time 账号模式变更时间
 * @property string $young_type 收益模式
 * @property string|null $young_type_time 收益模式变更时间
 * @property string $young_liq 清算模式
 * @property string|null $young_liq_time 清算模式变更时间
 * @property string $young_grade 身份
 * @property string|null $young_grade_time 身份变更时间
 * @property string $young_act 激活
 * @property string|null $young_act_time 激活时间
 * @property string $young_act_from 激活方式
 * @property string|null $young_first_buy_time 首次排单时间
 * @property float $young_first_buy_total 首次排单金额
 * @property string|null $young_last_buy_time 上次排单时间
 * @property float $young_last_buy_total 上次排单金额
 * @property float $young_all_buy_total 总排单金额
 * @property float $young_all_in_total 总收益金额
 * @property string|null $young_first_sell_time 首次卖单时间
 * @property float $young_first_sell_total 首次卖单金额
 * @property string|null $young_last_sell_time 上次卖单时间
 * @property float $young_last_sell_total 上次卖单金额
 * @property float $young_all_sell_total 总卖单金额
 * @property int|null $young_bank_id 银行id
 * @property string|null $young_bank_name 银行名称
 * @property string|null $young_bank_address 支行
 * @property string|null $young_bank_no 银行卡号
 * @property string|null $young_bank_man 收款人姓名
 * @property string|null $young_alipay 支付宝
 * @property string|null $young_note 备注
 * @property int $young_login_times 登录次数
 * @property string|null $young_last_login_time 上次登录时间
 * @property string|null $young_this_login_time 本次登录时间
 * @property string|null $young_last_login_ip 上次登录ip
 * @property string|null $young_this_login_ip 本次登录ip
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $young_hosting 托管
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungActFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungActTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAlipay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAllBuyTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAllInTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungAllSellTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBalanceAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBankAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBankMan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungBankNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFamilies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFamilyAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFamilyBinding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFirstBuyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFirstBuyTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFirstSellTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungFirstSellTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungGradeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungGxdAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungHosting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastBuyTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastBuyTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastSellTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLastSellTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLiq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLiqTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungLoginTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungModeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungPayPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungPoundageAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungRefereeAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungRefereeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungRefereeNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungRewardAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungStatusTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungThisLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungThisLoginTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberModel whereYoungTypeTime($value)
 * @mixin \Eloquent
 */
class MemberModel extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'uid';

    public function findForPassport($username)
    {
        return self::where('young_account', $username)->first();
    }

    //账号状态
    public $status = [
        10 => '正常',
        20 => '冻结',
        30 => '封停',
    ];

    //账号模式
    public $mode = [
        10 => '防撞',
        20 => '未防撞',
    ];

    //收益模式
    public $type = [
        10 => '动态',
        20 => '静态',
        30 => '永久动态',
    ];

    //激活
    public $act = [
        10 => '未激活',
        20 => '激活中',
        30 => '已激活',
    ];

    //激活方式
    public $act_from = [
        10 => '待激活',
        20 => '上级激活',
        30 => '后台激活',
    ];

    //清算模式
    public $liq = [
        10 => '未清算',
        20 => '清算中',
        30 => '清算完结',
    ];

    //身份
    public $grade = [
        10 => '新会员',
        20 => '老会员'
    ];

    //托管
    public $hosting = [
        10 => '开启',
        20 => '关闭',
    ];

    //所有对比数组
    public function arrays()
    {
        $result = [
            'status' => $this->status,
            'type' => $this->type,
            'mode' => $this->mode,
            'act_from' => $this->act_from,
            'liq' => $this->liq,
            'grade' => $this->grade,
            'act' => $this->act,
        ];

        return $result;
    }

    //修改银行卡信息
    public function change_bank(self $memberModel, Request $request)
    {
        $memberModel->young_bank_address = $request->post('bank_address');
        $memberModel->young_alipay = $request->post('alipay');
        $memberModel->young_note = $request->post('note');
        $memberModel->young_bank_man = $request->post('bank_man');
        $memberModel->young_bank_no = $request->post('bank_no');
        $memberModel->young_bank_id = null;
        $memberModel->young_bank_name = null;

        $bank_id = $request->post('bank_id');
        if (!is_null($bank_id)) {

            $bank = new BankModel();
            $bank = $bank->find($bank_id);

            if (!is_null($bank)) {

                $memberModel->young_bank_id = $bank->id;
                $memberModel->young_bank_name = $bank->young_name;
            }
        }

        return $memberModel;
    }

    //配置推荐人信息
    public function referee(self $memberModel, $referee_account = null)
    {
        if (empty($referee_account)) return $memberModel;

        $test = new MemberModel();
        $referee = $test->where('young_account', '=', $referee_account)->first();

        $families = empty($referee->young_families) ? $referee->uid : ($referee->young_families . ',' . $referee->uid);

        $memberModel->young_families = $families;//上级缓存
        $memberModel->young_referee_id = $referee->uid;//上级id
        $memberModel->young_referee_account = $referee->young_account;//上级账号
        $memberModel->young_referee_nickname = $referee->young_nickname;//上级昵称
        $memberModel->young_level = $referee->young_level + 1;//自身层级

        return $memberModel;
    }

    //配置账号信息
    public function new_account(self $memberModel)
    {
        //获取闲置的系统账号
        $model = new MemberAccountModel();
        $account = $model->where('uid', '=', null)->orderBy('young_account', 'asc')->first();

        //没有找到限制的系统账号
        if (is_null($account)) {

            $last = $model->orderBy('young_account', 'desc')->first();
            $new = is_null($last) ? '100000' : ($last->young_account + 1);

            $account = new MemberAccountModel();
            $account->young_account = $new;
        }
        $account->uid = $memberModel->uid;
        $account->save();

        $memberModel->young_account = $account->young_account;

        $memberModel->save();

        return $memberModel;
    }

    //上级昵称修改
    public function referee_nickname(self $memberModel)
    {
        MemberModel::whereYoungRefereeId($memberModel->uid)->update(['young_referee_nickname' => $memberModel->young_nickname]);
    }
}
