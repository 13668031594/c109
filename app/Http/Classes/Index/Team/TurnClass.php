<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/2/18
 * Time: 下午12:20
 */

namespace App\Http\Classes\Index\Team;


use App\Http\Classes\Index\IndexClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class TurnClass extends IndexClass
{
    public function validator_turn(Request $request)
    {
        $member = parent::get_member();

        $term = [
            'id|直系下级' => 'required|exists:member_models,uid,young_referee_id,' . $member['uid'],
            'poundage|转账星伙' => 'required|integer|between:1,100000000',
        ];

        parent::validators_json($request->post(), $term);

        if ($member['poundage'] < $request->post('poundage')) parent::error_json($this->set['walletPoundage'] . '不足');
    }

    public function turn(Request $request)
    {
        //转账星伙
        $poundage = $request->post('poundage');

        //获取本人模型，并扣除星伙
        $member = parent::get_member();
        $member = MemberModel::whereUid($member['uid'])->first();
        $member->young_poundage -= $poundage;
        $member->save();

        //获取下级模型，并添加星伙
        $child = MemberModel::whereUid($request->post('id'))->first();
        $child->young_poundage += $poundage;
        $child->young_poundage_all += $poundage;
        $child->save();

        //两人的钱包记录
        $member_change = ['poundage' => (0 - $poundage)];
        $member_record = "转款给下级：{$child->young_nickname}，转出{$this->set['walletPoundage']}：{$poundage}";
        $child_change = ['poundage' => $poundage];
        $child_record = "上级：{$member->young_nickname}转款，转入{$this->set['walletPoundage']}：{$poundage}";

        //添加两人的钱包记录
        $wallet = new MemberWalletModel();
        $wallet->store_record($member, $member_change, 31, $member_record);
        $wallet->store_record($child, $child_change, 31, $child_record);
    }
}