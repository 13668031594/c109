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
        $result = $this->classes->arrays();

        foreach ($result as &$v) $v = json_encode($v);

        return parent::views('index', $result);
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }

    public function show(Request $request)
    {
        $id = $request->get('id');

        $result = $this->classes->arrays();

        $self = $this->classes->show($id);

        $result['self'] = $self;

        return parent::views('buy', $result);
    }
}
