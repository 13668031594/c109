<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/30
 * Time: 下午2:54
 */

namespace App\Http\Classes\Admin\Trad;


use App\Http\Classes\Admin\AdminClass;
use App\Models\Member\MemberModel;
use App\Models\Trad\TradModel;
use Illuminate\Http\Request;

class TradClass extends AdminClass
{
    //对比数组
    public function arrays()
    {
        $model = new TradModel();

        $arrays = $model->arrays();

        $member = new MemberModel();

        $arrays['grade'] = $member->arrays()['grade'];

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
            case 'sell_account' :
                $where[] = ['s.young_account', 'like', '%' . $keyword . '%'];
                break;
            case 'sell_phone' :
                $where[] = ['s.young_phone', 'like', '%' . $keyword . '%'];
                break;
            case 'sell_nickname' :
                $where[] = ['s.young_nickname', 'like', '%' . $keyword . '%'];
                break;
            case 'buy_account' :
                $where[] = ['b.young_account', 'like', '%' . $keyword . '%'];
                break;
            case 'buy_phone' :
                $where[] = ['b.young_phone', 'like', '%' . $keyword . '%'];
                break;
            case 'buy_nickname' :
                $where[] = ['b.young_nickname', 'like', '%' . $keyword . '%'];
                break;
            default:
                break;
        }
        if (!empty($status)) $where[] = ['a.young_status', '=', $status];

        $orderBy = [
            'created_at' => 'desc'
        ];

        $leftJoin = [
            [
                'table' => 'member as s',
                'where' => ['a.young_sell_uid', '=', 's.uid'],
            ], [
                'table' => 'member as b',
                'where' => ['a.young_buy_uid', '=', 'b.uid'],
            ],
        ];

        $other = [
            'where' => $where,
            'orderBy' => $orderBy,
            'select' => ["a.*", 'b.young_account as buy_account', 'b.young_phone as buy_phone', 's.young_account as sell_account', 's.young_phone as sell_phone'],
            'leftJoin' => $leftJoin
        ];

        $result = parent::list_page('trad as a', $other);

        foreach ($result['message'] as &$v) $v['image'] = is_null($v['pay']) ? null : ('http://' . env('LOCALHOST'). $v['pay']);

        return $result;
    }

    //详情
    public function show($id)
    {
        $select = [
            'trad_models.*', 's.young_nickname as sell_nickname', 's.young_phone as sell_phone', 's.young_account as sell_account',
            's.young_grade as sell_grade', 's.young_referee_account as sell_referee_account', 's.young_referee_nickname as sell_referee_nickname',
            'b.young_nickname as buy_nickname', 'b.young_phone as buy_phone', 'b.young_account as buy_account',
            'b.young_grade as buy_grade', 'b.young_referee_account as buy_referee_account', 'b.young_referee_nickname as buy_referee_nickname',
        ];

        $order = TradModel::whereId($id)
            ->leftJoin('member_models as s', 's.uid', '=', 'trad_models.young_sell_uid')
            ->leftJoin('member_models as b', 'b.uid', '=', 'trad_models.young_buy_uid')
            ->select($select)
            ->first();

        if (is_null($order)) exit('订单不存在');

        $order = parent::delete_prefix($order->toArray());

        $order['image'] = is_null($order['pay']) ? null : ('http://' . env('LOCALHOST'). $order['pay']);

        return $order;
    }

    public function validator_update($id, Request $request)
    {
        $model = new TradModel();

        $term = [
            'id' => 'required|exists:trad_models,id',
            'gxd|贡献点' => 'required|numeric|between:0,100000000',
            'balance|价值' => 'required|numeric|between:0,100000000',
            'status|状态' => 'required|in:' . implode(',', array_keys($model->status)),
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->post(), $term);
    }

    public function update($id, Request $request)
    {
        $data = $request->post();
        $sell = TradModel::whereId($id)->first();

        $sell->young_gxd = $data['gxd'];
        $sell->young_balance = $data['balance'];
        $sell->young_status = $data['status'];
        $sell->save();
    }
}