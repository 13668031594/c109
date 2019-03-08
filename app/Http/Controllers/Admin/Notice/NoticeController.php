<?php

namespace App\Http\Controllers\Admin\Notice;

use App\Http\Classes\Admin\Notice\NoticeClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class NoticeController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'Notice.';

    public function __construct()
    {
        $this->classes = new NoticeClass();
    }

    public function index()
    {
        $status = $this->classes->status();

        $result = [
            'status' => json_encode($status),
        ];

        return parent::views('index',$result);
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
        $status = $this->classes->status();

        $result = [
            'status' => $status,
        ];

        return parent::views('notice',$result);
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/notice/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $status = $this->classes->status();

        $result = [
            'self' => $self,
            'status' => $status,
        ];

        return parent::views('notice', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/notice/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }
}
