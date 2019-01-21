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

    //修改下单模式
    public function mode()
    {
        $member = parent::get_member();

        if ($member['mode'] == '20') parent::error_json('无法切换下单模式');

        MemberModel::whereUid($member['uid'])->update(['young_mode' => '20']);
    }

    //修改下单模式
    public function hosting()
    {
        $member = parent::get_member();

        $end = $member['hosting'] == '10' ? '20' : '10';

        MemberModel::whereUid($member['uid'])->update(['young_hosting' => $end]);
    }
}