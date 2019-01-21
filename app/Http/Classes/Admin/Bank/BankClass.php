<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/19
 * Time: 下午3:03
 */

namespace App\Http\Classes\Bank;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\Bank\BankModel;
use App\Models\Member\MemberModel;
use Illuminate\Http\Request;

class BankClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'sort' => 'asc',
        ];

        $where = [
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('bank', $other);

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
        $model = new BankModel();
        $model->young_name = $request->post('name');
        $model->young_sort = $request->post('sort');
        $model->save();
    }

    public function edit($id)
    {
        $model = new BankModel();
        $bank = $model->find($id);

        if (is_null($bank)) parent::error_json('银行信息未找到');

        return parent::delete_prefix($bank->toArray());
    }

    public function update($id, Request $request)
    {
        $model = new BankModel();
        $bank = $model->find($id);
        $bank->young_name = $request->post('name');
        $bank->young_sort = $request->post('sort');
        $bank->save();

        $member = new MemberModel();
        $member->where('young_bank_id', '=', $id)->update(['young_bank_name' => $bank->young_name]);
    }

    public function destroy($id)
    {
        BankModel::destroy($id);
    }

    public function validator_store(Request $request)
    {
        $term = [
            'name|名称' => 'required|string|between:1,30|unique:bank_models,young_name',
            'sort|排序' => 'required|integer|between:0,100|unique:bank_models,young_sort'
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'name|名称' => 'required|string|between:1,30|unique:bank_models,young_name,' . $id . ',id',
            'sort|排序' => 'required|integer|between:0,100|unique:bank_models,young_sort,' . $id . ',id',
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
        $model = new MemberModel();
        $test = $model->whereIn('young_bank_id', $id)->first();
        if (!is_null($test)) parent::error_json('银行已被使用，无法删除');
    }

}