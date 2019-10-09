<?php

namespace App\Http\Middleware;

use App\Http\Classes\Admin\Master\MasterPowerClass;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取管理员模型
        $user = auth('web')->user();

        //获取路由信息
        $route = $request->route()->getAction()['as'];

        if (is_null($user)) {

            //没有登录信息
            //并不是到登录路由组，跳转到登录页
            if ($route != 'web.login') return redirect('/login');
        } else {

            //已经登录
            //重复到登录路由组,返回首页
            if ($route == 'web.login') return redirect('/');
        }

        return $next($request);
    }
}
