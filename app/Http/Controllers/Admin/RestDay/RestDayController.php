<?php

namespace App\Http\Controllers\Admin\RestDay;

use App\Http\Classes\RestDay\RestDayClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class RestDayController extends AdminController implements ListInterface
{
    protected $view_dir = 'RestDay.';
    private $classes;

    public function __construct()
    {
        $this->classes = new RestDayClass();
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
        return parent::views('rest_day');
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/rest_day/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $result = [
            'self' => $self,
        ];

        return parent::views('rest_day', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/rest_day/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

}
