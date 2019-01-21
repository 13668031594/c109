<?php

namespace App\Http\Controllers\Admin\Set;

use App\Http\Classes\Set\SetClass;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class SetController extends AdminController
{
    private $classes;
    protected $view_dir = 'Set.';

    public function __construct()
    {
        $this->classes = new SetClass();
    }

    public function index()
    {
        $set = $this->classes->index();

        return parent::views('index', ['self' => $set]);
    }

    public function update(Request $request)
    {
        $this->classes->validator_save($request);

        $this->classes->save($request);

        return parent::success();
    }

    public function goods_cover(Request $request)
    {
        return $this->classes->images($request, 'goods');
    }
}
