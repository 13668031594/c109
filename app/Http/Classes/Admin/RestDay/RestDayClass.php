<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/19
 * Time: 下午3:03
 */

namespace App\Http\Classes\RestDay;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Models\RestDayModel;
use Illuminate\Http\Request;

class RestDayClass extends AdminClass implements ListInterface
{
    public function index()
    {
        $orderBy = [
            'young_begin' => 'desc',
        ];

        $where = [
        ];

        $other = [
            'orderBy' => $orderBy,
            'where' => $where,
        ];

        $result = parent::list_page('rest_day', $other);

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
        $model = new RestDayModel();
        $model->young_name = $request->post('name');
        $model->young_begin = $request->post('begin');
        $model->young_end = $request->post('end');
        $model->save();
    }

    public function edit($id)
    {
        $model = new RestDayModel();
        $rest_day = $model->find($id);

        if (is_null($rest_day)) parent::error_json('休息日信息未找到');
        $self = parent::delete_prefix($rest_day->toArray());
        $self['begin'] = date('Y-m-d',strtotime($self['begin']));
        $self['end'] = date('Y-m-d',strtotime($self['end']));
        return $self;
    }

    public function update($id, Request $request)
    {
        $model = new RestDayModel();
        $rest_day = $model->find($id);
        $rest_day->young_name = $request->post('name');
        $rest_day->young_begin = $request->post('begin');
        $rest_day->young_end = $request->post('end');
        $rest_day->save();
    }

    public function destroy($id)
    {
        RestDayModel::destroy($id);
    }

    public function validator_store(Request $request)
    {
        $term = [
            'name|名称' => 'required|string|between:1,30',
            'begin|开始时间' => 'required|date_format:"Y-m-d"',//休息开始时间
            'end|结束时间' => 'required|date_format:"Y-m-d"|after:begin',//休息结束时间
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'name|名称' => 'required|string|between:1,30',
            'begin|开始时间' => 'required|date_format:"Y-m-d"',//休息开始时间
            'end|结束时间' => 'required|date_format:"Y-m-d"|after:begin',//休息结束时间
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_delete($id)
    {
    }

}