<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Member\MemberWalletModel
 *
 * @property int $id
 * @property int $uid 会员id
 * @property float $young_gxd 变动贡献点
 * @property float $young_gxd_now 当前贡献点
 * @property float $young_gxd_all 累计贡献点
 * @property float $young_reward 变动奖励账户
 * @property float $young_reward_now 当前奖励账户
 * @property float $young_reward_all 累计奖励账户
 * @property float $young_balance 变动余额
 * @property float $young_balance_now 当前余额
 * @property float $young_balance_all 累计余额
 * @property float $young_poundage 变动手续费
 * @property float $young_poundage_now 当前手续费
 * @property float $young_poundage_all 累计手续费
 * @property string $young_record 文字记录
 * @property string $young_type 变更类型
 * @property string $young_keyword 关键字
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $young_incite 变动鼓励账户
 * @property float $young_incite_now 当前鼓励账户
 * @property float $young_incite_all 累计鼓励账户
 * @property float $young_reward_freeze 变动奖励账户冻结资金
 * @property float $young_reward_freeze_now 当前奖励账户冻结资金
 * @property float $young_reward_freeze_all 累计奖励账户冻结资金
 * @property float $young_wage 变动工资
 * @property float $young_wage_now 当前工资
 * @property float $young_wage_all 累计工资
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalanceAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungBalanceNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxdAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungGxdNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungIncite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungInciteAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungInciteNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundageAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungPoundageNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardFreezeAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardFreezeNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungRewardNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungWageAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member\MemberWalletModel whereYoungWageNow($value)
 * @mixin \Eloquent
 */
class MemberWalletModel extends Model
{
    //变更类型
    public $type = [
        10 => '后台调整',
        20 => '注册账号',
        21 => '每日赠送',
        22 => '扣除赠送',
        30 => '激活账号',
        31 => '转款',
        40 => '买单',
        41 => '提现',
        42 => '抢单',
        50 => '卖单',
        51 => '收款超时',
        55 => '提现',
        60 => '付款奖励',
        70 => '付款惩罚',
        80 => '下级奖励',
        81 => '下级奖励解冻',
        83 => '店内佣金',
        90 => '钱包交易',
        91 => '工资发放',
        92 => '工资获得',
        99 => '家谱同步',
    ];

    //添加新的变更记录
    public function store_record(MemberModel $memberModel, $changes = [], $type, $record = '', $keyword = '')
    {
        //初始化模型
        $wallet = new self;

        //基础信息
        $wallet->uid = $memberModel->uid;
        $wallet->young_type = $type;
        $wallet->young_record = $record;
        $wallet->young_keyword = $keyword;

        //钱包状态
        $wallet->young_balance_all = $memberModel->young_balance_all;
        $wallet->young_balance_now = $memberModel->young_balance;
        $wallet->young_poundage_all = $memberModel->young_poundage_all;
        $wallet->young_poundage_now = $memberModel->young_poundage;
        $wallet->young_reward_all = $memberModel->young_reward_all;
        $wallet->young_reward_now = $memberModel->young_reward;
        $wallet->young_gxd_all = $memberModel->young_gxd_all;
        $wallet->young_gxd_now = $memberModel->young_gxd;
        $wallet->young_incite_all = $memberModel->young_incite_all;
        $wallet->young_incite_now = $memberModel->young_incite;
        $wallet->young_reward_freeze_all = $memberModel->young_reward_freeze_all;
        $wallet->young_reward_freeze_now = $memberModel->young_reward_freeze;
        $wallet->young_wage_all = $memberModel->young_wage_all;
        $wallet->young_wage_now = $memberModel->young_wage;

        //变化信息
        $wallet->young_balance = isset($changes['balance']) ? $changes['balance'] : 0;
        $wallet->young_poundage = isset($changes['poundage']) ? $changes['poundage'] : 0;
        $wallet->young_reward = isset($changes['reward']) ? $changes['reward'] : 0;
        $wallet->young_gxd = isset($changes['gxd']) ? $changes['gxd'] : 0;
        $wallet->young_incite = isset($changes['incite']) ? $changes['incite'] : 0;
        $wallet->young_reward_freeze = isset($changes['freeze']) ? $changes['freeze'] : 0;
        $wallet->young_wage = isset($changes['wage']) ? $changes['wage'] : 0;

        //保存
        $wallet->save();

        if (($type != 99) && ($wallet->young_gxd != 0) && !empty($memberModel->young_family_account)) self::to_c104($memberModel->young_family_account, $wallet->young_gxd);
    }

    //与家谱同步贡献点
    public function to_c104($account, $gxd)
    {
        $url = "http://family-api.ythx123.com/c109-with?account={$account}&gxd={$gxd}";
//        $url = "http://laravel.c104.cnm/c109-with?account={$account}&gxd={$gxd}";

        $result = self::url_get($url);
    }

    private function url_get($url)
    {
        //初始化一个curl会话
        $ch = curl_init();
        //初始化CURL回话链接地址，设置要抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //对认证证书来源的检查，FALSE表示阻止对证书的合法性检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //设置将获得的结果是否保存在字符串中还是输出到屏幕上，0输出，非0不输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //执行请求，获取结果
        $result = curl_exec($ch);
        //关闭会话
        curl_close($ch);

        //反馈结果
        return $result;
    }
}
