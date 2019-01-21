<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\User;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class UserClass extends IndexClass
{
    //密码修改验证
    public function validator_password(Request $request)
    {
        $term = [
            'old|旧密码' => 'required|string|between:6,24',
            'new|新密码' => 'required|string|between:6,24',
            'again|确认密码' => 'required|string|between:6,24',
        ];

        parent::validators_json($request->post(), $term);

        $new = $request->post('new');
        $again = $request->post('again');

        if ($new != $again) parent::error_json('确认密码输入错误');
    }

    //密码修改
    public function password(Request $request)
    {
        $member = auth('api')->user();

        if (!\Hash::check($request->post('old'), $member->password)) parent::error_json('旧密码输入错误');

        $member->password = \Hash::make($request->post('new'));
        $member->save();
    }

    //团队，1级
    public function team($member_id, $tree = false)
    {
        //结果数组
        $result = [
            'number' => 0,
            'team' => json_encode([]),
        ];

        //获取下级信息
        $other = [
            'where' => [
                ['young_families', 'like', '%' . $member_id . '%']
            ],
        ];
        $team = parent::list_all('member', $other);

        //没有下级
        if (count($team) <= 0) return $result;

        $result['number'] = count($team);//下级总数

        //下级结果数组
        $fathers = [];

        foreach ($team as $v) {

            $fathers[$v['referee_id']][] = $v;
        }

        $result['team'] = self::get_tree($member_id, $fathers, $tree);

        return $result;
    }

    //读取会员信息
    public function read($uid)
    {
        $member = MemberModel::whereUid($uid)->first();

        return parent::delete_prefix($member->toArray());
    }

    //下级信息格式组合
    public function get_tree($father_id, $team, $tree)
    {
        if (!isset($team[$father_id])) return [];

        $result = [];

        foreach ($team[$father_id] as $k => $v) {

            $result[$k]['uid'] = $v['uid'];
            $result[$k]['nickname'] = $v['nickname'];
            $result[$k]['status'] = $v['status'];

            if (!$tree) {

                $result[$k]['hosting'] = $v['hosting'];
                $result[$k]['phone'] = $v['phone'];
                $result[$k]['last_buy_time'] = $v['last_buy_time'];
                $result[$k]['created_at'] = $v['created_at'];
            }
//            if (isset($team[$v['id']])) $result[$k]['children'] = self::get_tree($v['id'], $team);
        }

        return $result;
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