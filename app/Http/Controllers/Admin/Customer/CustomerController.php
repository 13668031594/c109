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
        $switch = $this->classes->create();

        $result = [
            'switch_json' => json_encode($switch),
            'switch' => $switch,
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
        $array = $this->classes->create();

        $result = [
            'switch' => $array,
        ];

        return parent::views('customer',$result);
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

        $array = $this->classes->create();

        $result = [
            'self' => $self,
            'switch' => $array,
        ];

        return parent::views('customer', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/customer/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

}
