<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/30
 * Time: 下午2:54
 */

namespace App\Http\Classes\Admin\Order;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Order\BuyOrderModel;
use App\Models\Order\MatchOrderModel;
use Illuminate\Http\Request;

class BuyClass extends AdminClass
{
    //对比数组
    public function arrays()
    {
        $model = new BuyOrderModel();

        $arrays = $model->arrays();

        $member = new MemberModel();

        $arrays['grade'] = $member->arrays()['grade'];

        $match = new MatchOrderModel();
        $arrays['match_arrays'] = $match->arrays();

        return $arrays;
    }

    //列表
    public function index()
    {
        $where = [];

        $keywordType = \request()->get('keywordType');
        $keyword = \request()->get('keyword');
        $status = \request()->get('status');
        $abn = \request()->get('abn');
        $from = \request()->get('from');
        $begin = \request()->get('startTime');
        $end = \request()->get('endtime');


        switch ($keywordType) {
            case 'order' :
                $where[] = ['a.young_order', 'like', '%' . $keyword . '%'];
                break;
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
        if (!empty($status)) $where[] = ['a.young_status', '=', $status];
        if (!empty($abn)) $where[] = ['a.young_abn', '=', $abn];
        if (!empty($from)) $where[] = ['a.young_from', '=', $from];
        if (!empty($begin)) $where[] = ['a.young_in_over', '>=', $begin];
        if (!empty($end)) $where[] = ['a.young_in_over', '<=', $end];
        if (!empty($begin) || !empty($end)) $where[] = ['a.young_in_over', '<>', null];

        $orderBy = [
            'created_at' => 'desc'
        ];

        $leftJoin = [[
            'table' => 'member as u',
            'where' => ['a.uid', '=', 'u.uid'],
        ]];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => ["a.*", "u.young_nickname", 'u.young_account', 'u.young_phone'],
            'leftJoin' => $leftJoin
        ];

        $result = parent::list_page('buy_order as a', $other);

        return $result;
    }

    //详情
    public function show($id)
    {
        $select = [
            'buy_order_models.*', 'u.young_nickname', 'u.young_phone', 'u.young_account', 'u.young_grade as u_grade',
            'u.young_referee_account', 'u.young_referee_nickname'
        ];

        $order = BuyOrderModel::whereId($id)
            ->leftJoin('member_models as u', 'u.uid', '=', 'buy_order_models.uid')
            ->select($select)
            ->first();

        if (is_null($order)) exit('订单不存在');

        $order = parent::delete_prefix($order->toArray());

        return $order;
    }

    //匹配情况
    public function match($id)
    {
        $where = [
            ['young_buy_id', '=', $id]
        ];

        $orderBy = [
            'created_at' => 'asc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
        ];

        $result = parent::list_all('match_order', $other);

//        foreach ($result as &$v) $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . $v['pay']);
        foreach ($result as &$v) $v['image'] = 'http://jwzs.ythx123.com/storage/Order/31_400.jpeg';

        return $result;
    }

    //清除异常状态
    public function abn($id)
    {
        BuyOrderModel::whereId($id)->update(['young_abn' => '10']);
        MatchOrderModel::whereYoungBuyId($id)->update(['young_abn' => '10']);
    }

    public function validator_update($id, Request $request)
    {
        $model = new BuyOrderModel();

        $term = [
            'id' => 'required',
            'total|总金额' => 'required|numeric|between:0,100000000',
            'poundage|星伙' => 'required|numeric|between:0,100000000',
            'in|收益' => 'required|numeric|between:0,100000000',
            'gxd|贡献点' => 'required|numeric|between:0,100000000',
            'first_total|首付款' => 'required|numeric|between:0,100000000',
            'tail_total|尾款' => 'required|numeric|between:0,100000000',
            'tail_complete|尾款已匹配' => 'required|numeric|between:0,100000000',
            'status|状态' => 'required|in:' . implode(',', array_keys($model->status)),
            'from|来源' => 'required|in:' . implode(',', array_keys($model->from)),
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->post(), $term);
    }

    public function update($id, Request $request)
    {
        $data = $request->post();
        $buy = BuyOrderModel::whereId($id)->first();


        $buy->young_total = $data['total'];
        $buy->young_poundage = $data['poundage'];
        $buy->young_in = $data['in'];
        $buy->young_gxd = $data['gxd'];
        $buy->young_first_total = $data['first_total'];
        $buy->young_tail_total = $data['tail_total'];
        $buy->young_tail_complete = $data['tail_complete'];
        $buy->young_status = $data['status'];
        $buy->young_from = $data['from'];
        $buy->save();
    }
}