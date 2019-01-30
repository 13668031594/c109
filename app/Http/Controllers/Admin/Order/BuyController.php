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
        $model = new BuyOrderModel();

        $result = $model->arrays();

        foreach ($result as &$v) $v = json_encode($v);

        return parent::views('index', $result);
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }
}
