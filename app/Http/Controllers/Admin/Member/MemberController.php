<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Classes\Member\MemberClass;
use App\Http\Classes\Member\WalletClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use App\Models\Member\MemberModel;
use App\Models\Member\MemberRecordModel;
use App\Models\Member\MemberWalletModel;
use Illuminate\Http\Request;

class MemberController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'Member.';

    public function __construct()
    {
        $this->classes = new MemberClass();
    }

    public function index()
    {
        $model = new MemberModel();

        $result = [];
        $arrays = $model->arrays();
        foreach ($arrays as $k => &$v) $result[$k] = json_encode($v);
        $result['arrays'] = $arrays;

        return parent::views('index', $result);
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }

    public function show(Request $request)
    {
        // TODO: Implement show() method.
    }

    public function create()
    {
        $result = $this->classes->create();

        return parent::views('member', $result);
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/member/index');
    }

    public function edit(Request $request)
    {
        $result = $this->classes->create();
        $result['self'] = $this->classes->edit($request->get('id'));

        return parent::views('member', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/member/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

    //钱包页面
    public function wallet(Request $request)
    {
        $result = $this->classes->create();
        $result['self'] = $this->classes->edit($request->get('id'));

        return parent::views('wallet', $result);
    }

    //钱包充值
    public function post_wallet(Request $request)
    {
        $class = new WalletClass();
        $class->validator_wallet($request);
        $class->wallet($request);
        return parent::success();
    }

    //记录页面
    public function wallet_record(Request $request)
    {
        $model = new MemberWalletModel();

        $result['self'] = $this->classes->edit($request->get('id'));
        $result['type'] = $model->type;
        $result['type_json'] = json_encode($model->type);

        return parent::views('wallet_record', $result);
    }

    //记录数据
    public function wallet_record_table(Request $request)
    {
        $class = new WalletClass();

        $result = $class->record_table($request);

        return parent::tables($result);
    }

    //记录删除
    public function wallet_record_delete(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $class = new WalletClass();

        $class->record_delete($ids);

        return parent::success();
    }

    //后台激活
    public function act(Request $request)
    {
        $id = $request->get('id');

        $this->classes->act($id);

        return redirect('/admin/member/record?id=' . $id);
    }

    public function record(Request $request)
    {
        $model = new MemberRecordModel();

        $result['self'] = $this->classes->edit($request->get('id'));
        $result['type'] = $model->type;
        $result['type_json'] = json_encode($model->type);

        return parent::views('record', $result);
    }

    //记录数据
    public function record_table(Request $request)
    {
        $result = $this->classes->record_table($request);

        return parent::tables($result);
    }

    //记录删除
    public function record_delete(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->record_delete($ids);

        return parent::success();
    }
}
