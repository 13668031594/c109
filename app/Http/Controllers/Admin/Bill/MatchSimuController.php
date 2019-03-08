<?php

namespace App\Http\Controllers\Admin\Bill;

use App\Http\Classes\Admin\Bill\MatchSimuClass;
use App\Http\Controllers\Admin\AdminController;

class MatchSimuController extends AdminController
{
    private $classes;
    protected $view_dir = 'bill.';

    public function __construct()
    {
        $this->classes = new MatchSimuClass();
    }

    public function index()
    {
        return parent::views('match_simu');
    }

    public function table()
    {
        $result = $this->classes->index();

        return parent::tables($result);
    }
}
