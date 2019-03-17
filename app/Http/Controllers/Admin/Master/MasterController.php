<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Classes\Admin\Master\MasterClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class MasterController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'Master.';

    public function __construct()
    {
        $this->classes = new MasterClass();
    }

    public function index()
    {
        return parent::views('index');
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
        $powers = $this->classes->powers();

        $result = [
            'power_list' => $powers
        ];

        return parent::views('master', $result);
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/master/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $powers = $this->classes->powers();

        $result = [
            'self' => $self,
            'power_list' => $powers
        ];

        return parent::views('master', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/master/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }
}
