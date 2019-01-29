<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Classes\Admin\Customer\CustomerClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class CustomerController extends AdminController implements ListInterface
{
    private $classes;
    protected $view_dir = 'Customer.';

    public function __construct()
    {
        $this->classes = new CustomerClass();
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
        return parent::views('customer');
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/customer/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $result = [
            'self' => $self,
        ];

        return parent::views('customer', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id,$request);

        $this->classes->update($id,$request);

        return parent::success('/admin/customer/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',',$request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

}
