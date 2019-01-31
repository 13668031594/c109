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
use App\Models\Order\SellOrderModel;
use App\Models\Order\MatchOrderModel;
use Illuminate\Http\Request;

class SellClass extends AdminClass
{
    //对比数组
    public function arrays()
    {
        $model = new SellOrderModel();

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

        $result = parent::list_page('sell_order as a', $other);

        return $result;
    }

    //详情
    public function show($id)
    {
        $select = [
            'sell_order_models.*', 'u.young_nickname', 'u.young_phone', 'u.young_account', 'u.young_grade as u_grade',
            'u.young_referee_account', 'u.young_referee_nickname'
        ];

        $order = SellOrderModel::whereId($id)
            ->leftJoin('member_models as u', 'u.uid', '=', 'sell_order_models.uid')
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
            ['young_sell_id', '=', $id]
        ];

        $orderBy = [
            'created_at' => 'asc'
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
        ];

        $result = parent::list_all('match_order', $other);

        foreach ($result as &$v) $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST') . '/' . $v['pay']);

        return $result;
    }

    public function validator_update($id, Request $request)
    {
        $model = new SellOrderModel();

        $term = [
            'id' => 'required|exists:sell_order_models,id',
            'total|总金额' => 'required|numeric|between:0,100000000',
            'remind|剩余金额' => 'required|numeric|between:0,100000000',
            'status|状态' => 'required|in:' . implode(',', array_keys($model->status)),
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->post(),$term);
    }

    public function update($id, Request $request)
    {
        $data = $request->post();
        $sell = SellOrderModel::whereId($id)->first();

        $sell->young_total = $data['total'];
        $sell->young_remind = $data['remind'];
        $sell->young_status = $data['status'];
        $sell->save();
    }
}