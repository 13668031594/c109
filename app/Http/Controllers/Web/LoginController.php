<?php

namespace App\Http\Controllers\Web;

use App\Http\Classes\Index\Login\WebLoginClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends WebController
{
    protected $view_dir = 'Login.';

    public function to_login()
    {
        return parent::views('login');
    }

    public function login(Request $request)
    {
        $class = new WebLoginClass();

        $member = $class->login($request);

        $class->member_change($member);

        return parent::success('/');
    }

    public function logout()
    {
        auth('web')->logout();

        return redirect('/');
    }
}
