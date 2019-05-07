<?php

namespace App\Http\Controllers\Admin\Wage;

use App\Http\Classes\Admin\Wage\WageClass;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WageController extends AdminController
{
    private $classes;
    protected $view_dir = 'Wage.';

    public function __construct()
    {
        $this->classes = new WageClass();
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

    //发放页面
    public function wage(Request $request)
    {
        $result['self'] = $this->classes->edit($request->get('id'));

        return parent::views('wage', $result);
    }

    //工资发放
    public function post_wage(Request $request)
    {
        $this->classes->validator_wage($request);
        $this->classes->wage($request);
        return parent::success();
    }

    //记录页面
    public function wage_record()
    {
        return parent::views('record');
    }

    //记录数据
    public function wage_record_table(Request $request)
    {
        $result = $this->classes->record_table($request);

        return parent::tables($result);
    }

    //记录删除
    public function wage_record_delete(Request $request)
    {
        $ids = explode(',', $request->get('id'));

        $this->classes->record_delete($ids);

        return parent::success();
    }
}
