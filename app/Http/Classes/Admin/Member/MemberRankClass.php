<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/18
 * Time: 下午4:12
 */

namespace App\Http\Classes\Admin\Member;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRankModel;
use Illuminate\Http\Request;

class MemberRankClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'young_sort' => 'asc',
        ];

        $where = [

        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('member_rank', $other);

        return $result;
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function edit($id)
    {
        $model = MemberRankModel::whereId($id)->first();

        return parent::delete_prefix($model->toArray());
    }

    public function update($id, Request $request)
    {
        \DB::beginTransaction();

        $model = MemberRankModel::whereid($id)->first();

        $model->young_name = $request->post('name');
        $model->young_child = $request->post('child');
        $model->young_discount = $request->post('discount');
        $model->young_wage = $request->post('wage');
        $model->save();

        MemberModel::whereYoungRankId($id)->update(['young_rank_name' => $model->young_name]);

        \DB::commit();
    }

    public function destroy($id)
    {
    }

    public function validator_store(Request $request)
    {
    }

    public function validator_update($id, Request $request)
    {
        if ($id == '1') parent::error_json('初始等级无法编辑');

        $term = [
            'name|等级名称' => 'required|string|max:30',
            'child|下级人数' => 'required|integer|between:1,100000000',
            'discount|充值折扣' => 'required|numeric|between:0,100',
            'wage|工资比例' => 'required|numeric|between:0,100',
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
    }
}