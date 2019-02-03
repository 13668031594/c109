<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Classes\Admin\Order\MatchClass;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class MatchController extends AdminController
{
    private $classes;
    protected $view_dir = 'Order.Match.';

    public function __construct()
    {
        $this->classes = new MatchClass();
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

        $result['self'] = $this->classes->show($id);

        return parent::views('match', $result);
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
