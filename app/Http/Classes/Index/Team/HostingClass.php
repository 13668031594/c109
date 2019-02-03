<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/21
 * Time: 下午4:28
 */

namespace App\Http\Classes\Index\Team;

use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class HostingClass extends IndexClass
{
    /**
     * 验证托管资格
     *
     * @param Request $request
     * @return MemberModel
     */
    public function test(Request $request)
    {
        //自己
        $referee = parent::get_member();

        //切换到的会员
        $id = $request->post('id');
        $member = MemberModel::whereUid($id)->first();

        //验证
        if (is_null($member)) parent::error_json('没有找到该会员');
        if ($member->young_hosting != '20') parent::error_json('该会员已经关闭了托管模式');
        if ($member->young_status = '30') parent::error_json('该会员已经被封停');
        if ($member->young_referee_id != $referee['uid']) parent::error_json('只能切换到自己的直系下级');

        return $member;
    }

    public function delete_token(MemberModel $memberModel)
    {
        \DB::table('oauth_access_tokens')->where('user_id', '=', $memberModel->uid)->delete();
    }

    public function access_token(MemberModel $memberModel)
    {
        $token = $memberModel->createToken('hosting')->accessToken;

        return $token;
    }
}