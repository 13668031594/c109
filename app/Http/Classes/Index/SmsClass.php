<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午5:57
 */

namespace App\Http\Classes\Index;

use App\Models\Member\MemberSmsModel;
use App\Vendor\Sms\SmsTrait;
use Illuminate\Http\Request;

class SmsClass extends IndexClass
{
    use SmsTrait;

    public function send($phone, $templateCode = 'SMS_138077711')
    {
        $time = time();

        //删除所有过期验证码
        self::delete_sms($time);

        //发送
        $end = self::send_sms_dxb($phone, $time, $templateCode);

        return $end;
    }

    /**
     * 删除过期验证码
     *
     * @param $time
     */
    public function delete_sms($time)
    {
        //删除所有超时验证码
        $model = new MemberSmsModel();
        $model->where('young_end', '<', $time)->delete();
    }

    /**
     * 发送验证码
     *
     * @param $phone
     * @param $time
     * @param string $templateCode
     * @return int
     */
    public function send_sms($phone, $time, $templateCode = 'SMS_138077711')
    {
        //生成验证码
        $code = rand(10000, 99999);

        //发送短信
        $result = $this->sendSms($phone, $code, $templateCode);

        //判断回执
        if (!isset($result->Message)) parent::error_json('请刷新重试(message)');

        //判断是否成功
        if ($result->Message != 'OK') {

            //根据状态吗报错
            switch ($result->Code) {

                case 'isv.BUSINESS_LIMIT_CONTROL':
                    $error = '每小时只能发送5条短信';
                    break;
                case 'isv.MOBILE_NUMBER_ILLEGAL':
                    $error = '非法手机号';
                    break;
                case 'isv.MOBILE_COUNT_OVER_LIMIT':
                    //账户不存在
                    $error = '手机号码数量超过限制';
                    break;
                default:
                    \Storage::put('public/sms_error.text', json_encode($result));
                    $error = '请刷新重试（code）';
                    break;
            }

            parent::error_json($error);
        }

        //生成结束时间
        $end = $time + 120;

        //添加到数据库
        $model = new MemberSmsModel();
        $model->young_phone = $phone;
        $model->young_end = $end;
        $model->young_code = $code;
        $model->save();

        return $end;
    }

    //发送短信
    public function send_sms_dxb($phone, $time, $type = 'reg')
    {
        //生成验证码
        $code = rand(10000, 99999);

        //发送短信
        $content = '【君王战神】';
        switch ($type) {
            case 'reset':
                $content .= '您正在使用手机找回密码';
                break;
            default:
                $content .= '您正在使用手机注册';

                break;
        }
        $content .= '，验证码为：' . $code . '，2分钟内有效!';

        $result = self::send_dxb($phone, $content);

        //判断回执
        if ($result != '0') parent::error_json('发送失败' . $result);

        //生成结束时间
        $end = $time + 120;

        //添加到数据库
        //添加到数据库
        $model = new MemberSmsModel();
        $model->young_phone = $phone;
        $model->young_end = $end;
        $model->young_code = $code;
        $model->save();

        return $end;
    }

    /**
     * @param $phone //电话
     * @param $content //内容
     * @return mixed|null
     */
    public function send_dxb($phone, $content)
    {
        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = "jy00795800"; //短信平台帐号
        $pass = md5("asdasd123"); //短信平台密码
        $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
        $result = file_get_contents($sendurl);
        return $result;
    }

    /**
     * 验证上次发送验证码时间
     *
     * @param $phone
     * @param $time
     */
    public function validator_sms_time($phone, $time)
    {
        //获取该电话号码最新的验证码
        $test_code = new MemberSmsModel();
        $test_code->where('young_phone', '=', $phone)->orderBy('created_at', 'desc')->first();

        //没有找到数据
        if (!is_null($test_code)) {

            //比较是否超时
            if ($time < $test_code->young_end) {

                $errors = [
                    'time' => $test_code->young_end,
                ];

                parent::error_json('上一个验证码尚未失效，无法再次发送', '000', $errors);
            }
        }
    }

    /**
     * 验证验证码输入是否正确
     *
     * @param Request $request
     */
    public function validator_phone(Request $request)
    {
        $term = [
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/',
            'code|验证码' => 'required|string|size:5',
        ];

        parent::validators_json($request->post(), $term);

        //获取该电话号码最新的验证码
        $test_code = new MemberSmsModel();
        $test_code = $test_code->where('young_phone', '=', $request->post('phone'))->orderBy('created_at', 'desc')->first();

        //没有找到数据
        if (is_null($test_code)) parent::error_json('验证码输入错误');

        //当前时间戳
        $now_time = time();

        //比较是否超时
        if ($now_time > $test_code->young_end) parent::error_json('验证码已经失效,请重新获取');

        //比较验证码是否正确
        if ($request->post('code') != $test_code->young_code) parent::error_json('验证码输入错误');
    }
}