<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2019/1/12
 * Time: 下午1:55
 */

namespace App\Http\Classes\Admin\Notice;

use App\Http\Classes\Admin\AdminClass;
use App\Http\Classes\ListInterface;
use App\Http\Traits\FwbTrait;
use App\Models\Notice\NoticeModel;
use Illuminate\Http\Request;

class NoticeClass extends AdminClass implements ListInterface
{
    use FwbTrait;

    public function index()
    {
        $orderBy = [
            'young_sort' => 'asc'
        ];

        $other = [
            'orderBy' => $orderBy,
        ];

        $result = parent::list_page('notice',$other);

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
        $model = new NoticeModel();
        $model->young_title = $request->post('title');
        $model->young_content = $request->post('fwb-content');
        $model->young_status = $request->post('status');
        $model->young_sort = $request->post('sort');
        $model->young_man = $request->post('man');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');

        $this->store_fwb('notice_' . $model->id, $model->young_content);
    }

    public function edit($id)
    {
        $self = NoticeModel::whereId($id)->first();

        return parent::delete_prefix($self->toArray());
    }

    public function update($id, Request $request)
    {
        $model = NoticeModel::whereId($id)->first();
        $model->young_title = $request->post('title');
        $model->young_content = $request->post('fwb-content');
        $model->young_status = $request->post('status');
        $model->young_sort = $request->post('sort');
        $model->young_man = $request->post('man');

        //反馈前台操作结果
        if (!$model->save()) parent::error_json('请重试', '000');

        $this->store_fwb('notice_' . $model->id, $model->young_content);
    }

    public function destroy($id)
    {
        NoticeModel::destroy($id);
        foreach ($id as $v) $this->delete_fwb('notice_' . $v);
    }

    public function validator_store(Request $request)
    {
        $term = [
            'title|标题' => 'required|string|between:1,10',
            'fwb-content|内容' => 'required|string|max:20000',
            'status|状态' => 'required|in:' . implode(',', array_keys(NoticeModel::STATUS)),
            'man|发布人' => 'required|string|between:1,20',
            'sort|排序' => 'required|integer|between:0,100',
        ];

        parent::validators_json($request->post(), $term);
    }

    public function validator_update($id, Request $request)
    {
        $term = [
            'id' => 'required|exists:notice_models,id',
            'title|标题' => 'required|string|between:1,10',
            'fwb-content|内容' => 'required|string|max:20000',
            'status|状态' => 'required|in:' . implode(',', array_keys(NoticeModel::STATUS)),
            'man|发布人' => 'required|string|between:1,20',
            'sort|排序' => 'required|integer|between:0,100',
        ];

        $request->request->add(['id' => $id]);

        parent::validators_json($request->all(), $term);
    }

    public function validator_delete($id)
    {
    }

    public function status()
    {
        return NoticeModel::STATUS;
    }
}