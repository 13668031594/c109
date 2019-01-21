<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Classes\Admin\Login\LoginClass;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Traits\ModelTrait;
use Illuminate\Http\Request;

class LoginController extends AdminController
{
    use ModelTrait;

    protected $view_dir = 'Login.';
    public $classes;

    public function __construct()
    {
        $this->classes = new LoginClass();
    }

    //登录页面
    public function login()
    {
        return parent::views('login');
    }

    //验证登录
    public function auth(Request $request)
    {
        $this->classes->validator_login($request);

        $this->classes->login($request);

        return parent::success('/admin');
    }

    //注销
    public function logout()
    {
        $this->classes->logout();

        return redirect('/admin/login');
    }

    //首页
    public function index()
    {
        $master = $this->classes->get_master();

        return parent::views('index', ['master' => $master]);
    }
}
