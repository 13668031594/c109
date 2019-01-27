<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/19
 * Time: 下午10:26
 */

namespace App\Http\Classes\Member;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class WalletClass extends AdminClass
{
    public function validator_wallet(Request $request)
    {
        $rule = [
            'type|充值类型' => 'required|in:0,1,2,3',
            'number|充值数量' => 'required|integer|between:-1000000,1000000',
        ];

        parent::validators_json($request->post(), $rule);
    }

    public function wallet(Request $request)
    {
        \DB::beginTransaction();

        //寻找会员模型
        $member = MemberModel::whereUid($request->post('id'))->first();

        //判断
        if (is_null($member)) parent::error_json('会员不存在');

        //获取变化数值
        $number = $request->post('number');

        //初始化会员记录
        $wallet = new MemberWalletModel();
        $changes = [];
        if ($number < 0) {

            $record = '管理员扣除了您的『';
        } else {

            $record = '管理员为您充值『';
        }

        //按类型充值
        switch ($request->post('type')) {
            case '0':

                $member->young_balance += $number;
                $member->young_balance_all += $number;
                $record .= '余额';
                $changes = ['balance' => $number,];
                break;
            case '1':

                $member->young_poundage += $number;
                $member->young_poundage_all += $number;
                $record .= '手续费';
                $changes = ['poundage' => $number,];
                break;
            case '2':

                $member->young_reward += $number;
                $member->young_reward_all += $number;
                $record .= '奖励账户';
                $changes = ['reward' => $number,];
                break;
            case '3':

                $member->young_gxd += $number;
                $member->young_gxd_all += $number;
                $record .= '贡献点';
                $changes = ['gxd' => $number,];
                break;
            default:
                parent::error_json('充值类型错误');
                break;
        }
        $number = ($number < 0) ? (0 - $number) : $number;
        $record .= '』：' . $number;

        $member->save();
        $wallet->store_record($member, $changes, 10, $record);

        \DB::commit();
    }

    //记录数据
    public function record_table(Request $request)
    {
        $where = [];

        $where[] = ['uid', '=', $request->get('id')];

        switch ($request->get('wallet')) {
            case '0':
                $where[] = ['young_balance', '<>', 0];
                break;
            case '1':
                $where[] = ['young_poundage', '<>', 0];
                break;
            case '2':
                $where[] = ['young_reward', '<>', 0];
                break;
            case '3':
                $where[] = ['young_gxd', '<>', 0];
                break;
            default:
                break;
        }

        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');
        $type = $request->get('type');

        if (!empty($startTime)) {
            $where[] = ['created_at', '>=', $startTime];
        }
        if (!empty($endTime)) {
            $where[] = ['created_at', '<', $endTime];
        }
        if (!empty($type)) {
            $where[] = ['young_type', '=', $type];
        }

        $orderBy = [
            'id' => 'desc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy
        ];

        return parent::list_page('member_wallet', $other);
    }

    public function record_delete($ids)
    {
        MemberWalletModel::destroy($ids);
    }
}