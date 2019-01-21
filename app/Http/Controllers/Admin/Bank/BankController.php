<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Classes\Bank\BankClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListInterface;
use Illuminate\Http\Request;

class BankController extends AdminController implements ListInterface
{
    protected $view_dir = 'Bank.';
    private $classes;

    public function __construct()
    {
        $this->classes = new BankClass();
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
        return parent::views('bank');
    }

    public function store(Request $request)
    {
        $this->classes->validator_store($request);

        $this->classes->store($request);

        return parent::success('/admin/bank/index');
    }

    public function edit(Request $request)
    {
        $self = $this->classes->edit($request->get('id'));

        $result = [
            'self' => $self,
        ];

        return parent::views('bank', $result);
    }

    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success('/admin/bank/index');
    }

    public function destroy(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->validator_delete($ids);

        $this->classes->destroy($ids);

        return parent::success();
    }

}
