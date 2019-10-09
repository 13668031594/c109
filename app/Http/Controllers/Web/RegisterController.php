<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Bank\BankClass;
use App\Http\Classes\Index\IndexClass;
use App\Http\Classes\Index\Team\RegClass;
use App\Models\Bank\BankModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends WebController
{
    protected $view_dir = 'Register.';

    public function register()
    {
        $class = new RegClass();

        $banks = $class->banks();

        return parent::views('register',['bank' => $banks]);
    }
}
