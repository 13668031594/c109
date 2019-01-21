<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/12
 * Time: 下午1:55
 */

namespace App\Http\Classes\Admin\Prompt;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Http\Traits\FwbTrait;
use App\Models\Prompt\PromptModel;
use Illuminate\Http\Request;

class PromptClass extends AdminClass implements ListInterface
{
    use FwbTrait;

    public function index()
    {
        $result = parent::list_page('prompt');

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
        $model = new PromptModel();
        $model->young_title = $request->post('title');
        $model->young_keyword = $request->post('keyword');
        $model->young_content = $request->post('fwb-content');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');

        $this->store_fwb('prompt_' . $model->id, $model->young_content);
    }

    public function edit($id)
    {
        $self = PromptModel::find($id);

        return parent::delete_prefix($self->toArray());
    }

    public function update($id, Request $request)
    {
        $model = PromptModel::find($id);
        $model->young_content = $request->post('fwb-content');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');

        $this->store_fwb('prompt_' . $model->id, $model->young_content);
    }

    public function destroy($id)
    {
        PromptModel::destroy($id);
        foreach ($id as $v) $this->delete_fwb('prompt_' . $v);
    }

    public function validator_store(Request $request)
    {
        //超级管理员只能超级管理员修改
        $master = parent::get_master();
        if ($master['mid'] != '1') parent::error_json('您没有权限', '000');

        $term = [
            'title|标题' => 'required|string|between:1,10',
            'keyword|关键字' => 'required|string|between:1,30',
            'fwb-content|内容' => 'required|string|max:3000',
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'fwb-content|内容' => 'required|string|max:3000',
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->all(), $term);
    }

    public function validator_delete($id)
    {
        //超级管理员只能超级管理员修改
        $master = parent::get_master();
        if ($master['mid'] != '1') parent::error_json('您没有权限', '000');
    }
}