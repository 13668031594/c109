<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2018/6/20
 * Time: 下午6:09
 */

namespace App\Http\Classes\Index\Login;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class WebLoginClass extends IndexClass
{
    /**
     * @param Request $request
     * @return MemberModel
     */
    public function login(Request $request)
    {
        //表单验证条件
        $term = [
            'phone|手机号' => 'required|regex:/^1[3456789]\d{9}$/',
            'password|密码' => 'required|min:6',
        ];

        //进行表单验证
        parent::validators_json($request->post(), $term);


        //组合账号密码数组
        $attempt = [

            'young_phone' => $request->post('phone'),
            'password' => $request->post('password'),
        ];

        //进行账号密码登录验证
        if (!auth('web')->attempt($attempt)) {

            //反馈账号密码错误
            parent::error_json('手机号或密码错误', '000');
        }

        //验证通过

        //保存账号模型为变量
        return auth('web')->user();
    }

    /**
     * 修改会员登录信息
     *
     * @param MemberModel $member
     */
    public function member_change(MemberModel $member)
    {
        //修改会员登录资料
        $member->young_login_times += 1;
        $member->young_last_login_time = $member->young_this_login_time;
        $member->young_this_login_time = DATE;
        $member->young_last_login_ip = $member->young_this_login_ip;
        $member->young_this_login_ip = $_SERVER["REMOTE_ADDR"];
        $member->young_cid = \request()->post('cid');
        $member->save();
    }
}