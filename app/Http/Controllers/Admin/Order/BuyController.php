<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Classes\Admin\Order\BuyClass;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Order\BuyOrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyController extends AdminController
{
    private $classes;
    protected $view_dir = 'Order.Buy.';

    public function __construct()
    {
        $this->classes = new BuyClass();
    }

    public function index()
    {
        $result = [];
        $arrays = $this->classes->arrays();

        foreach ($arrays as $k => $v) $result[$k] = json_encode($v);
        $result['arrays'] = $arrays;

        return parent::views('index', $result);
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }

    //订单详情
    public function show(Request $request)
    {
        $id = $request->get('id');

        $result = $this->classes->arrays();

        $self = $this->classes->show($id);

        $result['self'] = $self;
        $result['match'] = $this->classes->match($id);

        return parent::views('buy', $result);
    }

    //清除异常状态
    public function abn(Request $request)
    {
        $id = $request->get('id');

        $this->classes->abn($id);

        return parent::success();
    }

    //编辑页面
    public function edit(Request $request)
    {
        $id = $request->get('id');

        $result = $this->classes->arrays();

        $self = $this->classes->show($id);

        $result['self'] = $self;

        return parent::views('edit', $result);
    }

    //编辑订单
    public function update($id, Request $request)
    {
        $this->classes->validator_update($id, $request);

        $this->classes->update($id, $request);

        return parent::success();
    }
}
