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
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use App\Models\Order\SellOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

class ApiLoginClass extends IndexClass
{
    /**
     * 账号密码登录,并颁发令牌
     *
     * @param Request $request
     * @return array
     */
    public function account_number_login(Request $request)
    {
        //验证账号密码是否符合规则
        $member = self::validator_account_number($request);

        //账号被停用
        if ($member->young_status == '3') parent::error_json('账号已被停用');

        //删除该账号历史登录令牌,以便获取新的令牌,并减少数据库负荷
        self::delete_old_token($member->id);

        //添加账号访问数据
        $add = ['username' => $member->young_account];

        //获取颁发令牌所需数据
        $request = self::add_passport_array($request, 'password', $add);

        //颁发新的访问令牌与刷新令牌
        $result = $this->get_token($request);

        //令牌获取失败
        if (empty($result)) parent::error_json('登录失败,请刷新重试');

        //修改会员登录信息
        self::member_change($member);

        $model = new MemberModel();
        $result['member'] = self::referee(parent::delete_prefix($member->toArray()));
        $result['contrast'] = $model->arrays();

        //返回令牌信息
        return $result;
    }

    /**
     * 刷新令牌登录,并颁发令牌
     *
     * @param Request $request
     * @return array
     */
    public function refresh_token_login(Request $request)
    {
        //添加刷新令牌
        $add = ['refresh_token' => $request->post('refresh_token')];

        //获取颁发令牌所需数据
        $request = self::add_passport_array($request, 'refresh_token', $add);

        //颁发新的访问令牌与刷新令牌
        $result = $this->get_token($request);

        //令牌获取失败,反馈信息
        if (empty($result)) parent::error_json('请重新登录');

        //返回令牌信息
        return $result;
    }



    /**
     * 公用方法
     */

    /**
     * 组合获取令牌所需的request信息
     *
     * @param Request $request
     * @param $grant_type
     * @param array $add
     * @return Request|static
     */
    private function add_passport_array(Request $request, $grant_type, $add = [])
    {
        //添加客户端信息与令牌获取模式
        $request->request->add([

            'grant_type' => $grant_type,
            'client_id' => env('CLIENT_ID_ADMIN'),
            'client_secret' => env('CLIENT_SECRET_ADMIN'),
            'scope' => '',
//            'guard' => 'api',
        ]);

        //添加其他信息(账号或令牌)
        if (!empty($add)) {

            $request->request->add($add);
        }

        //删除账号信息
        $request->request->remove('phone');

        //获取认证路由信息
        $request = $request::create('oauth/token', 'post');

        return $request;
    }

    /**
     * 返回新颁发的令牌信息
     *
     * @param Request $request
     * @return array
     */
    private function get_token(Request $request)
    {
        $result = Route::dispatch($request)->getContent();

        //进行令牌兑换
        $response = json_decode($result, true);

        //检查令牌兑换情况
        if (isset($response['access_token'])) {

            //兑换成功

            $return_array = [

                'access_token' => Arr::get($response, 'access_token'),
//                'refresh_token' => Arr::get($response, 'refresh_token'),
            ];
        } else {

            $return_array = [];
        }

        return $return_array;
    }



    /**
     * 账号登录所需方法
     */

    /**
     * 验证账号密码是否正确,并返回相应数据
     *
     * @param Request $request
     * @return mixed
     */
    private function validator_account_number(Request $request)
    {
        //获取失败次数
//        $fails_times = self::fails_times();
        //添加失败次数
//        self::fails_add($fails_times);
        //失败返还
//        $other = self::captcha_fils();

        //表单验证条件
        $term = [
            'phone|手机号' => 'required|regex:/^1[3456789]\d{9}$/',
            'password|密码' => 'required|min:6',
        ];

        //失败超过3次，需要验证验证码
        /*if ($fails_times >= 3) {

            $term['code|验证码'] = 'required';
            $term['code_number'] = 'required';
        }

        $result_term = self::bail_term($term);

        $result = self::validators($request->post(), $result_term); // TODO: Change the autogenerated stub

        if ($result) self::error_json($result, '000', $other);*/

        //进行表单验证
        parent::validators_json($request->post(), $term);

        //失败超过3次，需要验证验证码
        /*if ($fails_times >= 3) {

            //验证验证码
            if (!app('apiCaptcha')->check([

                'code' => $request->post('code'),
                'code_number' => $request->post('code_number'),
            ])) {

                //验证码错误
                parent::error_json('验证码错误', '000', $other);
            };
        }*/

        //组合账号密码数组
        $attempt = [

            'young_phone' => $request->post('phone'),
            'password' => $request->post('password'),
        ];

        //进行账号密码登录验证
        if (!Auth::guard('web')->attempt($attempt)) {

            //反馈账号密码错误
            parent::error_json('手机号或密码错误', '000');
        }

        //验证通过

        //保存账号模型为变量
        $member = \Auth::guard('web')->user();

        //删除auth中的账号模型
        \Auth::logout();

        //反馈登陆者模型
        return $member;
    }

    /**
     * 修改会员登录信息
     *
     * @param MemberModel $member
     */
    private function member_change(MemberModel $member)
    {
        //修改会员登录资料
        $member->young_login_times += 1;
        $member->young_last_login_time = $member->young_this_login_time;
        $member->young_this_login_time = DATE;
        $member->young_last_login_ip = $member->young_this_login_ip;
        $member->young_this_login_ip = $_SERVER["REMOTE_ADDR"];
        $member->save();
    }

    /**
     * 删除相同账号的历史令牌,减少数据库负荷
     *
     * @param $user_id
     */
    public function delete_old_token($user_id)
    {
//        $user_id = 'member_api-' . $user_id;

        $result = DB::table('oauth_access_tokens')
            ->where('client_id', '=', env('CLIENT_ID_ADMIN'))
            ->where('user_id', '=', $user_id)
            ->get();

        if (count($result) > 0) {

            $id = array_pluck($result->toArray(), 'id');

            DB::table('oauth_access_tokens')->whereIn('id', $id)->delete();
            DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $id)->delete();
        }
    }

    public function logout()
    {
        $member = parent::get_member();

        self::delete_old_token($member['uid']);
    }

    /**
     * 验证码相关
     */

    /**
     * 返回api登录时需要的二维码
     *
     * @return mixed
     */
    public function captcha()
    {
        return app('apiCaptcha')->src();
    }

    public function fails_times()
    {
        $name = $_SERVER["REMOTE_ADDR"] . 'captcha';

        return Cache::get($name, 0);
    }

    public function fails_add($times)
    {
        $name = $_SERVER["REMOTE_ADDR"] . 'captcha';

        Cache::put($name, ($times + 1), 60);

    }

    public function captcha_fils()
    {
        //失败次数
        $fails_times = self::fails_times();

        //验证码
        $captcha = ($fails_times >= 3) ? self::captcha() : null;

        //结果集
        return [
            'fails_times' => $fails_times,
            'captcha' => $captcha,
        ];
    }

    //获取上级信息
    public function referee($member)
    {
        $member['referee_phone'] = '无';
        $member['referee_email'] = '无';

        if (!empty($member['referee_id'])) {

            $referee = MemberModel::whereUid($member['referee_id'])->first();

            if (!is_null($referee)) {

                $member['referee_phone'] = $referee->young_phone;
                $member['referee_email'] = $referee->young_email;
            }
        }

        return $member;
    }


    public function contrast()
    {
        $result = [];

        $buy = new BuyOrderModel();
        $result['buy'] = [
            'status' => $buy->status,
            'from' => $buy->from,
            'abn' => $buy->abn,
        ];

        $sell = new SellOrderModel();
        $result['sell'] = [
            'status' => $sell->status
        ];

        $match = new MatchOrderModel();
        $result['match'] = [
            'status' => $match->status,
            'abn' => $match->abn

        ];

        return $result;
    }
}