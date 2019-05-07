<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/19
 * Time: 下午10:26
 */

namespace App\Http\Classes\Admin\Wage;

use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class WageClass extends AdminClass
{
    public function index()
    {
        $where = [];

        $keywordType = \request()->get('keywordType');
        $keyword = \request()->get('keyword');
        switch ($keywordType) {
            case 'account' :
                $where[] = ['young_account', 'like', '%' . $keyword . '%'];
                break;
            case 'phone' :
                $where[] = ['young_phone', 'like', '%' . $keyword . '%'];
                break;
            case 'nickname' :
                $where[] = ['young_nickname', 'like', '%' . $keyword . '%'];
                break;
            default:
                break;
        }

        $where[] = ['young_wage', '>', 0];

        $orderBy = [
            'young_wage' => 'desc',
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
        ];

        return parent::list_page('member', $other);
    }

    public function edit($id)
    {
        $model = MemberModel::whereUid($id)->first();

        return parent::delete_prefix($model->toArray());
    }

    public function validator_wage(Request $request)
    {
        $rule = [
            'number|发放数量' => 'required|integer|between:-1000000,1000000',
        ];

        parent::validators_json($request->post(), $rule);
    }

    public function wage(Request $request)
    {
        \DB::beginTransaction();

        $master = parent::get_master();

        //寻找会员模型
        $member = MemberModel::whereUid($request->post('id'))->first();

        //判断
        if (is_null($member)) parent::error_json('会员不存在');

        //获取变化数值
        $number = 0 - $request->post('number');

        //初始化会员记录
        $wallet = new MemberWalletModel();
        if ($number < 0) {

            $record = '管理员『' . $master['nickname'] . '』发放了您的『';
        } else {

            $record = '管理员『' . $master['nickname'] . '』为您充值『';
        }

        $member->young_wage += $number;
        $record .= '工资';
        $changes = ['wage' => $number,];

        $number = ($number < 0) ? (0 - $number) : $number;
        $record .= '』：' . $number;

        $member->save();
        $wallet->store_record($member, $changes, 91, $record);

        \DB::commit();
    }

    //记录数据
    public function record_table(Request $request)
    {
        $where = [];

        $where[] = ['m.young_wage', '<>', 0];

        $startTime = $request->get('startTime');
        $endTime = $request->get('endTime');
        $type = $request->get('type');
        $keywordType = \request()->get('keywordType');
        $keyword = \request()->get('keyword');
        switch ($keywordType) {
            case 'account' :
                $where[] = ['u.young_account', 'like', '%' . $keyword . '%'];
                break;
            case 'phone' :
                $where[] = ['u.young_phone', 'like', '%' . $keyword . '%'];
                break;
            case 'nickname' :
                $where[] = ['u.young_nickname', 'like', '%' . $keyword . '%'];
                break;
            default:
                break;
        }

        if (!empty($startTime)) {
            $where[] = ['m.created_at', '>=', $startTime];
        }
        if (!empty($endTime)) {
            $where[] = ['m.created_at', '<', $endTime];
        }
        if (!empty($type)) {
            $where[] = ['m.young_type', '=', $type];
        }

        $orderBy = [
            'm.created_at' => 'desc'
        ];

        $leftJoin = [[
            'table' => 'member as u',
            'where' => ['u.uid', '=', 'm.uid'],
        ]];

        $other = [
            'select' => ['m.*', 'u.young_account', 'u.young_nickname','u.young_phone','u.young_rank_name'],
            'where' => $where,
            'orderBy' => $orderBy,
            'leftJoin' => $leftJoin,
        ];

        return parent::list_page('member_wallet as m', $other);
    }

    public function record_delete($ids)
    {
        MemberWalletModel::destroy($ids);
    }
}