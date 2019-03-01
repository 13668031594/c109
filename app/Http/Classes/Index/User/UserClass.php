<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\User;

use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\SmsClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class UserClass extends IndexClass
{
    //密码修改验证
    public function validator_phone(Request $request)
    {
        $member = parent::get_member();

        $request->request->add(['phone' => $member['phone']]);

        $class = new SmsClass();
        $class->validator_phone($request);
    }

    //密码修改验证
    public function validator_password(Request $request)
    {
        $term = [
//            'old|旧密码' => 'required|string|between:6,24',
            'new|新密码' => 'required|string|between:6,24',
//            'again|确认密码' => 'required|string|between:6,24',
        ];

        parent::validators_json($request->post(), $term);

//        $new = $request->post('new');
//        $again = $request->post('again');

//        if ($new != $again) parent::error_json('确认密码输入错误');
    }

    //密码修改
    public function password(Request $request)
    {
        $member = auth('api')->user();

//        if (!\Hash::check($request->post('old'), $member->password)) parent::error_json('旧密码输入错误');

        $member->password = \Hash::make($request->post('new'));
        $member->save();
    }

    //修改采集模式
    public function mode()
    {
        $member = parent::get_member();

        if ($member['mode'] == '20') parent::error_json('无法切换采集模式');

        MemberModel::whereUid($member['uid'])->update(['young_mode' => '20']);
    }

    //修改采集模式
    public function hosting()
    {
        $member = parent::get_member();

        $end = $member['hosting'] == '10' ? '20' : '10';

        MemberModel::whereUid($member['uid'])->update(['young_hosting' => $end]);
    }

    //修改自动买单开关
    public function auto()
    {
        $member = parent::get_member();

        $end = $member['auto_buy'] == '10' ? '20' : '10';

        MemberModel::whereUid($member['uid'])->update(['young_auto_buy' => $end]);
    }

    public function family_binding(Request $request)
    {
        $member = parent::get_member();

        if (!is_null($member['family_account'])) parent::error_json('您已经绑定过了');

        $time = \Cache::get($_SERVER["REMOTE_ADDR"] . 'family_binding', time());

        if (!empty($time) && ($time > time())) parent::error_json('操作过于频繁');

        //表单验证条件
        $term = [
            'account|账号' => 'required|between:6,24|unique:member_models,young_family_account',

            'password|密码' => 'required|between:6,24',
        ];

        parent::validators_json($request->post(), $term);

        $url = "http://family-api.ythx123.com/c109?account={$request->post('account')}&password={$request->post('password')}&gxd={$member['gxd']}&phone={$member['phone']}";
//        $url = "http://laravel.c104.cnm/c109-with?account={$request->post('account')}&password={$request->post('password')}&gxd={$member['gxd']}&phone={$member['phone']}";

        $result = parent::url_get($url);

        if ($result === false) parent::error_json('绑定失败');
        $result = json_decode($result, true);

        if ($result['status'] == 'files') {

            $fails = \Cache::get($_SERVER["REMOTE_ADDR"] . 'family_binding_fails', 0);
            $fails++;
            \Cache::put($_SERVER["REMOTE_ADDR"] . 'family_binding_fails', $fails, 60);
            if ($fails >= 3) \Cache::put($_SERVER["REMOTE_ADDR"] . 'family_binding', (time() + 60), 60);

            parent::error_json($result['message']);
        }

        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_gxd += $result['gxd'];
        $member->young_gxd_all += $result['gxd'];
        $member->young_family_account = $request->post('account');
        $member->young_family_binding = DATE;
        $member->save();

        $change = ['gxd' => $result['gxd']];
        $record = '与华夏宗亲家谱同步『' . $this->set['walletGxd'] . '』' . $result['gxd'];
        $model = new MemberWalletModel();
        $model->store_record($member, $change, 99, $record);
    }
}