<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/18
 * Time: 下午4:12
 */

namespace App\Http\Classes\Member;


use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\Admin\Bill\BillClass;
use App\Http\Classes\ListInterface;
use App\Http\Classes\Set\SetClass;
use App\Models\Member\MemberAccountModel;
use App\Models\Member\MemberActModel;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRankModel;
use App\Models\Member\MemberRecordModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use Illuminate\Http\Request;

class MemberClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $where = [];

        $keywordType = \request()->get('keywordType');
        $keyword = \request()->get('keyword');
        $status = \request()->get('status');
        $act = \request()->get('act');
        $mode = \request()->get('mode');
        $grade = \request()->get('grade');
        $type = \request()->get('type');

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
        if (!empty($status)) $where[] = ['young_status', '=', $status];
        if (!empty($act)) $where[] = ['young_act', '=', $act];
        if (!empty($mode)) $where[] = ['young_mode', '=', $mode];
        if (!empty($grade)) $where[] = ['young_grade', '=', $grade];
        if (!empty($type)) $where[] = ['young_type', '=', $type];

        $orderBy = [
            'uid' => 'desc',
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('member', $other);

        foreach ($result['message'] as &$v) $v['id'] = $v['uid'];

        return $result;
    }

    public function show($id)
    {
        $member = MemberModel::whereUid($id)->first();

        return parent::delete_prefix($member->toArray());
    }

    public function create()
    {
        $model = new MemberModel();

        $result = $model->arrays();

        $bank = self::banks();

        $result['bank'] = $bank;

        return $result;
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();

        $model = new MemberModel();

        //添加客服信息
        $model = $model->rand_customer($model);
        //添加银行卡信息
        $model = $model->change_bank($model, $request);
        //添加推荐人信息
        $model = $model->referee($model, $request->post('referee'));
        //添加基础信息
        $model->young_account = 'hold';
        $model->young_phone = $request->post('phone');
        $model->young_email = $request->post('email');
        $model->password = \Hash::make($request->post('password'));
//        $model->young_pay_pass = \Hash::make($request->post('pay_pass'));
        $model->young_pay_pass = \Hash::make($request->post('password'));
        $model->young_nickname = $request->post('nickname');
        $model->young_status = $request->post('status');
        $model->young_type = $request->post('type');
        $model->young_mode = $request->post('mode');
        $model->young_grade = $request->post('grade');
        $model->save();
        //添加账号信息
        $model->new_account($model);

        \DB::commit();
    }

    public function edit($id)
    {
        $model = MemberModel::whereUid($id)->first();

        return parent::delete_prefix($model->toArray());
    }

    public function update($id, Request $request)
    {
        \DB::beginTransaction();

        $model = MemberModel::whereUid($id)->first();

        //添加银行卡信息
        $model = $model->change_bank($model, $request);
        //添加基础信息
        $model->young_phone = $request->post('phone');
        $model->young_email = $request->post('email');
        if ($request->post('password') != 'sba___duia') $model->password = \Hash::make($request->post('password'));
//        if ($request->post('pay_pass') != 'sba___duia') $model->young_pay_pass = \Hash::make($request->post('pay_pass'));
        $model->young_nickname = $request->post('nickname');
        if ($request->post('status') != $model->young_status) {

            $model->young_status = $request->post('status');
            $model->young_status_time = DATE;
        }
        if ($request->post('type') != $model->young_type) {

            $model->young_type = $request->post('type');
            $model->young_type_time = DATE;
        }
        if ($request->post('mode') != $model->young_mode) {

            $model->young_mode = $request->post('mode');
            $model->young_mode_time = DATE;
        }
        if ($request->post('grade') != $model->young_grade) {

            $model->young_grade = $request->post('grade');
            $model->young_grade_time = DATE;
        }
        $model->save();

        $model->referee_nickname($model);

        \DB::commit();
    }

    public function destroy($id)
    {
        MemberModel::destroy($id);

        $account = new MemberAccountModel();
        $account->whereIn('uid', $id)->update(['uid' => null]);
    }

    public function validator_store(Request $request)
    {
        $model = new MemberModel();
        $arrays = $model->arrays();

        $term = [
            'referee|推荐号' => 'nullable|exists:member_models,young_account',
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/|unique:member_models,young_phone',
            'email|邮箱' => 'required|string|max:30|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:member_models,young_email',
            'nickname|昵称' => 'required|string|between:1,10',
            'password|密码' => 'required|string|between:6,24',
//            'pay_pass|支付密码' => 'required|string|between:6,24',
            'bank_id|收款银行' => 'required|exists:bank_models,id',
            'bank_address|支行' => 'required|max:30',
            'bank_man|收款人' => 'required|max:30',
            'bank_no|收款账号' => 'required|max:30',
            'alipay|支付宝' => 'required|max:30',
            'note|备注' => 'nullable|max:40',
            'status|状态' => 'required|in:' . implode(',', array_keys($arrays['status'])),
            'mode|排单模式' => 'required|in:' . implode(',', array_keys($arrays['mode'])),
            'type|收益模式' => 'required|in:' . implode(',', array_keys($arrays['type'])),
            'grade|身份' => 'required|in:' . implode(',', array_keys($arrays['grade'])),
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $model = new MemberModel();
        $arrays = $model->arrays();

        $term = [
            'phone|手机号' => 'required|string|regex:/^1[3456789]\d{9}$/|unique:member_models,young_phone,' . $id . ',uid',
            'email|邮箱' => 'required|string|max:30|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:member_models,young_email,' . $id . ',uid',
            'password|密码' => 'required|string|between:6,24',
//            'pay_pass|支付密码' => 'required|string|between:6,24',
            'bank_id|收款银行' => 'required|exists:bank_models,id',
            'bank_address|支行' => 'required|max:30',
            'bank_man|收款人' => 'required|max:30',
            'bank_no|收款账号' => 'required|max:30',
            'alipay|支付宝' => 'required|max:30',
            'note|备注' => 'nullable|max:40',
            'status|状态' => 'required|in:' . implode(',', array_keys($arrays['status'])),
            'mode|排单模式' => 'required|in:' . implode(',', array_keys($arrays['mode'])),
            'type|收益模式' => 'required|in:' . implode(',', array_keys($arrays['type'])),
            'grade|身份' => 'required|in:' . implode(',', array_keys($arrays['grade'])),
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
        $model = new MemberModel();
        $test = $model->where('young_status', '<>', 40)->whereIn('uid', $id)->first();
        if (!is_null($test)) parent::error_json('只能删除封停状态的会员');
    }

    public function banks()
    {
        $other = [
            'orderBy' => [
                'young_sort' => 'asc'
            ]
        ];

        return parent::list_all('bank', $other);
    }

    //激活会员
    public function act($uid)
    {
        $member = MemberModel::whereUid($uid)->first();

        if (is_null($member)) exit('会员不存在');

        $member->young_act = 30;
        $member->young_act_from = 30;
        $member->young_act_time = DATE;
        $member->save();

        $wallet = new MemberRecordModel();
        $wallet->store_record($member, 10, '管理员激活了您的账号');

        //作废这个会员之前所有的激活记录
        MemberActModel::whereUid($uid)->update(['young_status' => '40']);
    }

    //记录数据
    public function record_table(Request $request)
    {
        $where = [];

        $where[] = ['uid', '=', $request->get('id')];

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

        return parent::list_page('member_record', ['where' => $where]);
    }

    public function record_delete($ids)
    {
        MemberRecordModel::destroy($ids);
    }


    public function team($member_id)
    {
        //结果数组
        $result = [
            'number' => 0,
            'team' => json_encode([]),
            'order_number' => 0,
            'order_total' => 0,
        ];

        $class = new BillClass();
        $times = $class->time_type('all');
        $begin = $times['begin'];
        $end = $times['end'];
        $where_all = [['created_at', '>=', $begin], ['created_at', '<', $end]];
        $result['type'] = $times['type2'];
        $result['begin'] = $begin;
        $result['end'] = $end;

        //初始化模型
        $model = new MemberModel();

        //获取下级信息
        $team = $model->where('young_families', 'like', '%' . $member_id . '%')
            ->orWhere('young_families', 'like', '%' . $member_id . ',%')
            ->orWhere('young_referee_id', '=', $member_id)
            ->get(['uid', 'young_referee_id', 'young_nickname']);

        //没有下级
        if (count($team) <= 0) return $result;

        $result['number'] = count($team);//下级总数

        //下级结果数组
        $fathers = [];
        $ids = [];

        foreach ($team as $v) {

            $fathers[$v['young_referee_id']][] = $v;
            $ids[] = $v['uid'];
        }

        $result['team'] = str_replace('"', "'", json_encode(self::get_tree($member_id, $fathers)));
        $result['order_number'] = self::team_order_number($ids, $where_all);
        $result['order_total'] = self::team_order_total($ids, $where_all);

        return $result;
    }

    public function get_tree($father_id, $team)
    {
        if (!isset($team[$father_id])) return [];

        $result = [];

        foreach ($team[$father_id] as $k => $v) {

            $result[$k]['name'] = $v['young_nickname'];
            if (isset($team[$v['uid']])) $result[$k]['children'] = self::get_tree($v['uid'], $team);
        }

        return $result;
    }

    public function rank($rank_id)
    {
        $rank = MemberRankModel::whereId($rank_id)->first();

        return parent::delete_prefix($rank->toArray());
    }

    public function set()
    {
        $class = new SetClass();

        return $class->index();
    }

    private function team_order_number($ids, $where_all)
    {
        $model = new BuyOrderModel();

        return $model->where($where_all)->whereIn('uid', $ids)->count();
    }

    private function team_order_total($ids, $where_all)
    {
        $model = new MatchOrderModel();

        return $model->where($where_all)->whereIn('young_buy_uid', $ids)->where('young_status', '=', '30')->sum('young_total');
    }
}