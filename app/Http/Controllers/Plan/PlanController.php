<?php

namespace App\Http\Controllers\Plan;

use App\Http\Classes\Set\SetClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public $set;

    public function __construct()
    {
        $set = new SetClass();
        $this->set = $set->index();
    }
}
