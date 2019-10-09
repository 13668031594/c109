<?php

namespace App\Http\Controllers\Admin\Shopowner;

use App\Http\Classes\Shopowner\ShopownerClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use App\Models\Shopowner\ShopownerModel;
use Illuminate\Http\Request;

class ShopownerController extends AdminController implements ListInterface
{
    protected $view_dir = 'Shopowner.';
    private $classes;

    public function __construct()
    {
        $this->classes = new ShopownerClass();
    }

    public function index()
    {
        $result = [
            'status' => ShopownerModel::STATUS,
            'status_json' => json_encode(ShopownerModel::STATUS),
        ];

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
        $result = [
            'status' => ShopownerModel::STATUS,
        ];

        return parent::views('shopowner', $result);
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/shopowner/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $result = [
            'self' => $self,
            'status' => ShopownerModel::STATUS,
        ];

        return parent::views('shopowner', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/shopowner/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

}
