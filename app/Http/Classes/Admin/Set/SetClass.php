<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/14
 * Time: 下午6:30
 */

namespace App\Http\Classes\Set;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Traits\ImageTrait;
use App\Models\Order\BuyOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetClass extends AdminClass
{
    use ImageTrait;

    public $file = 'item\Set\Set.txt';

    public function index()
    {
        //读取设定文件
        $set = Storage::has($this->file) ? Storage::get($this->file) : null;

        //获取默认配置
        $result = self::defaults();

        //设定文件存在，修改返回配置
        if (!is_array($set)) {

            //格式化配置信息
            $set = json_decode($set, true);

            //循环设定数据
            foreach ($result as $k => &$v) {

                //设定文件中有的设定，修改之
                if (isset($set[$k])) $v = $set[$k];
            }

//            $result['goodsCover'] = $this->ensure_url($result['goodsCover']);
        }

        //返回设定文件
        return $result;
    }

    //保存配置文件
    public function save(Request $request)
    {
        //获取提交的参数
        $set = $request->post();

        //获取原始配置
        $result = self::defaults();

        //循环修改
        foreach ($result as $k => &$v) {

            //设定文件中有的设定，修改之
            if (isset($set[$k])) {

                $v = $set[$k];
            }
        }

        //保存到文件
        Storage::put($this->file, json_encode($result));

        return $result;
    }

    //验证
    public function validator_save(Request $request)
    {
        $rule = [
            //账号设置
            'accountRegSwitch|账号注册开关' => 'required|in:on,off',//账号注册开关
            'accountRegGxd|账号注册消耗贡献点' => 'required|integer|between:0,100000000',//账号注册消耗贡献点
            'accountActSwitch|账号激活开关' => 'required|in:on,off',//账号激活开关
            'accountActNum|每天激活数量' => 'required|integer|between:-1,100000',//每天激活数量
            'accountActStart|抢激活开始时间' => 'required|date_format:"H:i"',//激活开始时间
            'accountActEnd|抢激活结束时间' => 'required|date_format:"H:i"|after:accountActStart',//激活结束时间
            'accountActResult|发放激活结果时间' => 'required|date_format:"H:i"|after:accountActEnd',//发放激活结果
            'accountActPoundage|激活收取手续费' => 'required|integer|between:0,100000000',//激活收取手续费
            'accountActPoundageNone|负手续费激活开关' => 'required|in:on,off',//负手续费激活开关
            'accountModeDefault|默认防撞模式' => 'required|in:10,20',//默认防撞模式
            'accountRegOut|禁止注册地区' => 'nullable|max:300',
            //删号设置
            'deleteIndexRegSwitch|自主注册不排单删号开关' => 'required|in:on,off',//自主注册不排单删号开关
            'deleteIndexRegTime|自主注册不排单删号时间' => 'required|integer|between:1,3650',//9天后删除
            'deleteAdminActSwitch|后台激活不排单删号开关' => 'required|in:on,off',//后台激活不排单删号开关
            'deleteAdminActTime|后台激活不排单删号时间' => 'required|integer|between:1,3650',//1天后删除
            //网站设置
            'webName|网站名称' => 'required|string|max:10',
            'webTitle|网站标题' => 'required|string|max:20',
            'webKeyword|关键字' => 'required|string|max:300',
            'webDesc|网站描述' => 'required|string|max:300',
            'webCopyright|底部版权' => 'required|string|max:300',
//            'webLoginActNone|未激活登录开关' => 'required|in:on,off',//未激活登录开关
            'webSwitch|网站开关' => 'required|in:on,off',//网站开关
            'webOpenTime|日常开网时间' => 'required_if:webSwitch,on|date_format:"H:i"',//日常开网时间
            'webCloseTime|日常闭网时间' => 'required_if:webSwitch,on|date_format:"H:i"|after:webOpenTime',//日常闭网时间
            'webCloseReason|闭站描述' => 'required_if:webSwitch,on|max:3000',//网站关闭原因
            'webCloseTxt|网站关闭原因' => 'required_if:webSwitch,off|max:3000',//网站关闭原因
            //钱包名称
            'walletGxd|贡献点别名' => 'required|string|max:40',//贡献点
            'walletPoundage|手续费别名' => 'required|string|max:40',//手续费
            'walletReward|奖励账户别名' => 'required|string|max:40',//奖励账户
            'walletBalance|余额别名' => 'required|string|max:40',//余额
            'walletIncite|鼓励账户别名' => 'required|string|max:40',//鼓励账户
            'walletPoundageBalance|手续费价值' => 'required|integer|between:1,100000000',//手续费价值（相对于余额）
            'walletGxdBalance|贡献点价值' => 'required|integer|between:1,100000000',//贡献点价值（相对于余额）
            //买单抢单
            'buySwitch|手动买入开关' => 'required|in:on,off',//手动买入开关
            'buyAutoSwitch|自动买入开关' => 'required|in:on,off',//自动买入开关
            'buyPoundage|每单收取手续费' => 'required|integer|between:0,100000000',//每单收取手续费
            'buyPoundageNone|负手续费买入开关' => 'required|in:on,off',//负手续费买入开关
            'buyTotalUpSwitch|买单金额递增开关' => 'required|in:on,off',//买单金额递增开关
            'robSwitch|抢单开关' => 'required|in:on,off',//抢单开关
            'robNum|每天发放抢单数' => 'required_if:robSwitch,on|integer|between:-1,100000000',//每天发放抢单数
            'robStartTime|抢单开始时间' => 'required_if:robSwitch,on|date_format:"H:i"',//抢单开始时间
            'robEndTime|抢单结束时间' => 'required_if:robSwitch,on|date_format:"H:i"|after:robStartTime',//抢单结束时间
            'robResultTime|发放结果时间' => 'required_if:robSwitch,on|date_format:"H:i"|after:robEndTime',//发放结果时间
//            'sellBase|卖出订单基数' => 'required|integer|between:0,100000000',//奖励提现基数
//            'sellTimes|卖出订单倍数' => 'required|integer|between:0,100000000',//奖励提现倍数
            //商品设置
            'goodsName|商品名称' => 'required|string|max:40',//商品名称
            'goodsTotal|商品金额' => 'required|integer|between:1,100000000',//商品金额
            'goodsCover|商品封面' => 'required|string',//商品封面
//            'goodsType0|防撞模式购买周期' => 'required|integer|between:1,100000000',//防撞模式购买周期
//            'goodsType1|未防撞模式购买周期' => 'required|integer|between:1,100000000',//未防撞模式购买周期
            'goodsTop0|防撞模式购买上限' => 'required|integer|between:1,100000000',//防撞模式购买上限
            'goodsTop1|未防撞模式购买上限' => 'required|integer|between:1,100000000',//未防撞模式购买上限
//            'goodsLower0|防撞模式收益时间下限' => 'required|integer|between:1,365',//防撞模式收益时间选项
//            'goodsCeil0|防撞模式收益时间上限' => 'required|integer|between:1,366',//防撞模式收益时间选项
            'goodsLower1|未防撞模式收益时间下限' => 'required|integer|between:1,365',//未防撞模式收益时间选项
            'goodsCeil1|未防撞模式收益时间上限' => 'required|integer|between:1,366',//未防撞模式收益时间选项
            //匹配设置
            'matchNewMember|新会员立即匹配数' => 'required|integer|between:1,100000000',//新会员立即匹配数
            'matchFirstStart|预付款匹配开始时间' => 'required|integer|between:1,100000000',//首付款匹配开始时间
            'matchTailStart|尾款匹配开始时间' => 'required|integer|between:1,100000000',//全款匹配开始时间
            'matchFirstPro|预付款百分比' => 'required|numeric|between:0,100',//预付款百分比
            //付款设置
            'payStart|付款开始时间' => 'required|date_format:"H:i"',//付款开始时间
            'payEnd|付款结束时间' => 'required|date_format:"H:i"|after:payStart',//付款结束时间
            'payRewardGxd|付款奖励贡献点' => 'required|integer|between:0,100000000',//奖励贡献点
            'payRewardStart|付款奖励开始时间' => 'required|date_format:"H:i"',//奖励开始时间
            'payRewardEnd|付款奖励结束时间' => 'required|date_format:"H:i"|after:payRewardStart',//奖励结束时间
            'payPunishGxd|付款惩罚贡献点' => 'required|integer|between:0,100000000',//惩罚贡献点
            'payPunishStart|付款惩罚开始时间' => 'required|date_format:"H:i"',//惩罚开始时间
            'payPunishEnd|付款惩罚结束时间' => 'required|date_format:"H:i"|after:payPunishStart',//惩罚结束时间
            //收款设置
            'inStart|收款开始时间' => 'required|date_format:"H:i"',//收款开始时间
            'inEnd|收款结束时间' => 'required|date_format:"H:i"|after:inStart',//收款结束时间
            'inOvertimeAuto|超时自动确认收款' => 'required|in:on,off',//超时自动确认收款
            'inOvertimePunishGxd|收款超时扣除贡献点' => 'required|integer|between:0,100000000',//超时扣除贡献点
            //订单提现
            'withdrawSwitch|负贡献点提现开关' => 'required|in:on,off',
            'withdrawPro|提现时扣除' => 'required|numeric|between:0,100',
            //奖励提现
            'rewardPro|下级买单奖励比例' => 'required|numeric|between:0,100',//下级买单奖励比例
            'rewardSwitch|奖励账户提现开关' => 'required|in:on,off',//奖励账户提现开关
//            'rewardBase|奖励提现基数' => 'required|integer|between:0,100000000',//奖励提现基数
//            'rewardTimes|奖励提现倍数' => 'required|integer|between:0,100000000',//奖励提现倍数
            'rewardDeposit|提现沉淀比例' => 'required|numeric|between:0,100',//提现沉淀比例
            'rewardPoundageNone|负手续费提现开关' => 'required|in:on,off',//负手续费提现开关
            'rewardGxd|奖励提现消耗贡献点' => 'required|integer|between:0,100000000',//老会员提现消耗贡献点
//            'rewardTime|提现禁止时间' => 'required|integer|between:1,365',//提现禁止时间
            //利率与状态
            'typePro0|静态利率' => 'required|numeric|between:0,100',//静态利率
            'typePro1|动态利率' => 'required|numeric|between:0,100',//动态利率
            'type10|动态转静态时间' => 'required|integer|between:1,100000000',//动态转静态时间
            'type01|静态转动态直推金额' => 'required|integer|between:0,100000000',//静态转动态直推金额
            'typeAllNum|永动状态推荐人数' => 'required|integer|between:1,100000000',//永动状态推荐人数
            'typeAllTotal|永动状态推荐人买单金额' => 'required|integer|between:1,100000000',//永动状态推荐人买单金额
            'typeOld|成为老会员时间' => 'required|integer|between:1,100000000',//成为老会员时间
            //挂售设置
            'consignBase|挂售基数' => 'required|integer|between:1,100000000',
            'consignTimes|挂售倍数' => 'required|integer|between:1,100000000',
            'consignPoundage|挂售手续费' => 'required|numeric|between:0,100',
            //在线更新
            'versionIos|IOS版本' => 'required|string|max:20',
            'versionAndroid|安卓版本' => 'required|string|max:20',
        ];

        parent::validators_json($request->post(), $rule);
    }

    //充值，删除配置文件
    public function reset()
    {
        Storage::delete($this->file);
    }

    //默认数据
    private function defaults()
    {
        return [
            //账号设置
            'accountRegSwitch' => 'on',//账号注册开关
            'accountRegGxd' => '100',//账号注册消耗贡献点
            'accountActSwitch' => 'on',//账号激活开关
            'accountActNum' => '9999',//每天激活数量
            'accountActStart' => '09:00',//激活开始时间
            'accountActEnd' => '09:04',//激活结束时间
            'accountActResult' => '09:14',//发放激活结果
            'accountActPoundage' => '2',//激活收取手续费
            'accountActPoundageNone' => 'on',//负手续费激活开关
            'accountModeDefault' => '10',//默认防撞模式
            'accountRegOut' => '',//禁止注册地区
            //删号设置
            'deleteIndexRegSwitch' => 'on',//自主注册不排单删号开关
            'deleteIndexRegTime' => '9',//9天后删除
            'deleteAdminActSwitch' => 'on',//后台激活不排单删号开关
            'deleteAdminActTime' => '1',//1天后删除
            //网站设置
            'webName' => '君王战神',
            'webTitle' => '君王战神',
            'webKeyword' => '君王战神',
            'webDesc' => '君王战神',
            'webCopyright' => '版权',
//            'webLoginActNone' => 'off',//未激活登录开关
            'webSwitch' => 'on',//网站开关
            'webOpenTime' => '07:00',//日常开网时间
            'webCloseTime' => '22:00',//日常闭网时间
            'webCloseReason' => '请明天7点打开网站',//网站关闭原因
            'webCloseTxt' => '网站维护中',//网站关闭原因
            //钱包名称
            'walletGxd' => '贡献点',//贡献点
            'walletPoundage' => '手续费',//手续费
            'walletReward' => '奖励账户',//奖励账户
            'walletBalance' => '余额',//余额
            'walletIncite' => '鼓励账户',//鼓励账户
            'walletPoundageBalance' => '10',//手续费价值（相对于余额）
            'walletGxdBalance' => '6',//贡献点价值（相对于余额）
            //买单抢单
            'buySwitch' => 'on',//手动买入开关
            'buyAutoSwitch' => 'on',//自动买入开关
            'buyPoundage' => '1',//每单收取手续费
            'buyPoundageNone' => 'on',//负手续费买入开关
            'buyTotalUpSwitch' => 'on',//买单金额递增开关
            'robSwitch' => 'on',//抢单开关
            'robNum' => '10',//每天发放抢单数
            'robStartTime' => '07:00',//抢单开始时间
            'robEndTime' => '07:10',//抢单结束时间
            'robResultTime' => '07:30',//发放结果时间
            'sellBase' => '100',//卖出基数
            'sellTimes' => '100',//卖出倍数
            'sellPoundageNone' => 'off',//负手续费卖出开关
            //商品设置
            'goodsName' => '测试商品',//商品名称
            'goodsTotal' => '1000',//商品金额
            'goodsCover' => '',//商品封面
            'goodsType0' => '15',//防撞周期
            'goodsType1' => '15',//未防撞周期
            'goodsTop0' => '5',//防撞模式购买上限
            'goodsTop1' => '20',//未防撞模式购买上限
//            'goodsLower0' => '7',//防撞模式收益时间下限
//            'goodsCeil0' => '15',//防撞模式收益时间上限
            'goodsLower1' => '7',//未防撞模式收益时间下限
            'goodsCeil1' => '12',//未防撞模式收益时间上限
            //匹配设置
            'matchNewMember' => '1',//新会员立即匹配数
            'matchFirstStart' => '2',//首付款匹配开始时间
            'matchTailStart' => '4',//全款匹配开始时间
            'matchFirstPro' => '20',//预付款百分比
            //付款设置
            'payStart' => '07:00',//付款开始时间
            'payEnd' => '12:00',//付款结束时间
            'payRewardGxd' => '1',//奖励贡献点
            'payRewardStart' => '07:00',//奖励开始时间
            'payRewardEnd' => '09:00',//奖励结束时间
            'payPunishGxd' => '100',//惩罚贡献点
            'payPunishStart' => '11:30',//惩罚开始时间
            'payPunishEnd' => '12:00',//惩罚结束时间
            'payPunishSealAccount' => '12:00',//未付款封号时间
            //收款设置
            'inStart' => '07:00',//收款开始时间
            'inEnd' => '15:00',//收款结束时间
            'inOvertimeAuto' => 'on',//超时自动确认收款
            'inOvertimePunishGxd' => '300',//超时扣除贡献点
            //订单提现
            'withdrawSwitch' => 'on',
            'withdrawPro' => '20',
            //奖励提现
            'rewardPro' => '5',//下级买单奖励比例
            'rewardSwitch' => 'on',//奖励账户提现开关
//            'rewardBase' => '100',//奖励提现基数
//            'rewardTimes' => '100',//奖励提现倍数
            'rewardDeposit' => '50',//提现沉淀比例
            'rewardPoundageNone' => 'on',//负手续费提现开关
            'rewardGxd' => '0',//老会员提现消耗贡献点
//            'rewardTime' => '365',//提现禁止时间
            //利率与状态
            'typePro0' => '0.6',//静态利率
            'typePro1' => '1',//动态利率
            'type10' => '90',//动态转静态时间
            'type01' => '3000',//静态转动态直推金额
            'typeAllNum' => '3',//永动状态推荐人数
            'typeAllTotal' => '3000',//永动状态推荐人买单金额
            'typeOld' => '90',//判断成为老会员的时间
            //挂售设置
            'consignBase' => '100',
            'consignTimes' => '100',
            'consignPoundage' => '15',
            //在线更新
            'versionIos' => '1.0.0',
            'versionAndroid' => '1.0.0',
        ];
    }

    public function images(Request $request, $name, $length = 100)
    {
        $term = [
            'images|图片' => 'required|file|image|max:1024',
        ];

        parent::validators_json($request->file(), $term);

        //获取上传图片
        $images = $request->file('images')->store('public/Set');

        $new = $this->cut($images, $length, 'public/Set/' . $name);

        return response()->json([
            'status' => 'success',
            'image' => Storage::url($new),
        ]);
    }
}