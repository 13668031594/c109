<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/11
 * Time: 下午3:03
 */

namespace App\Http\Classes\Admin\Login;

use App\Http\Classes\Admin\AdminClass;
use Illuminate\Http\Request;

class LoginClass extends AdminClass
{
    //登录验证
    public function validator_login(Request $request)
    {
        $rules = [
            'code|验证码' => 'required|captcha',
            'account|账号' => 'required|alpha_dash|between:6,24',
            'password|密码' => 'required|alpha_dash|between:6,24',
        ];

        parent::validators_json($request->post(), $rules);
    }

    //登录
    public function login(Request $request)
    {
        //验证失败，报错
        if (!auth('master')->attempt([DCP . 'account' => $request->post('account'), 'password' => $request->post('password')], 1)) parent::error_json('账号或密码错误');

        //更新登录信息
        $master = auth('master')->user();
        $master->young_login_times += 1;
        $master->young_last_login_time = $master->young_this_login_time;
        $master->young_this_login_time = date('Y-m-d H:i:s');
        $master->young_last_login_ip = $master->young_this_login_ip;
        $master->young_this_login_ip = $_SERVER["REMOTE_ADDR"];
        $master->save();

//        Session::save();
    }

    //注销
    public function logout()
    {
        auth('master')->logout();
    }
}