<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/19
 * Time: 下午3:03
 */

namespace App\Http\Classes\Shopowner;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Shopowner\ShopownerModel;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class ShopownerClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'created_at' => 'desc',
        ];

        $select = [
            's.*',
            'm.young_nickname',
            'm.young_account',
        ];

        $leftJoin = [
            [
                'table' => 'member as m',
                'where' => ['m.uid','=','s.uid'],
            ]
        ];

        $where = [
        ];

        $other = [
            'leftJoin' => $leftJoin,
            'select' => $select,
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('shopowner as s', $other);

        return $result;
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store(Request $request)
    {
        $member = MemberModel::whereYoungPhone($request->post('phone'))->first();
//dd($member);
        $status = $request->post('status');
        if ($status == '10') self::validators_shopowner($member->uid, explode(',', $member->young_families));

        $reward = number_format($request->post('reward'), 4, '.', '');

        $model = new ShopownerModel();
        $model->uid = $member->uid;
        $model->young_reward = $reward;
        $model->young_status = $status;
        $model->save();
    }

    public function edit($id)
    {
        $model = new ShopownerModel();
        $shopowner = $model->find($id);

        if (is_null($shopowner)) parent::error_json('店长信息未找到');

        $member = MemberModel::whereUid($shopowner->uid)->first();

        $shopowner = $shopowner->toArray();
        $shopowner['member'] = $member->toArray();

        return parent::delete_prefix($shopowner);
    }

    public function update($id, Request $request)
    {
        $model = new ShopownerModel();
        $model = $model->find($id);

        //若状态由停用改为激活
        $status = $request->post('status');
        if ($status == '10' && $model->young_status != '10') {
            $member = MemberModel::whereUid($model->uid)->first();
            self::validators_shopowner($member->uid, explode(',', $member->young_families));
            $model->uid = $member->uid;
        }

        $reward = number_format($request->post('reward'), 4, '.', '');

        $model->young_reward = $reward;
        $model->young_status = $status;
        $model->save();
    }

    public function destroy($id)
    {
        ShopownerModel::destroy($id);
    }

    public function validator_store(Request $request)
    {
        $term = [
            'phone|会员手机号' => 'required|string|between:1,30|exists:member_models,young_phone',
            'reward|奖励比例' => 'required|numeric|between:0,10000',
            'status|状态' => 'required|in:' . implode(',', array_keys(ShopownerModel::STATUS)),
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'id|店长id' => 'required|string|between:1,30|exists:shopowner_models,id',
            'reward|奖励比例' => 'required|numeric|between:0,10000',
            'status|状态' => 'required|in:' . implode(',', array_keys(ShopownerModel::STATUS)),
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
    }

    public function validators_shopowner($uid, $families)
    {
        $member = \DB::table('member_models as m')
            ->leftJoin('shopowner_models as s', 's.uid', '=', 'm.uid')
            ->where(function ($querys) use ($uid, $families) {
                $querys->where(function ($query) use ($uid) {
                    $query->where('m.young_families', 'like', '%' . $uid . '%')
                        ->orWhere('m.young_families', 'like', '%' . $uid . ',%')
                        ->orWhere('m.young_referee_id', '=', $uid);
                })->orWhereIn('s.uid', $families);
            })
            ->where('s.young_status', '=', 10)
            ->first();

        if (!is_null($member)) parent::error_json('该会员的上下线中，有会员：' . $member->young_nickname . '，是激活中的店长，该会员无法成功激活为店长');
    }
}