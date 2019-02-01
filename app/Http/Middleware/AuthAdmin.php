<?php

namespace App\Http\Middleware;

use App\Http\Classes\Admin\Master\MasterPowerClass;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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
        define('DCP', env('DB_COLUMN_PREFIX'));

        //获取管理员模型
//        $user = Auth::guard('master')->user();
        $user = auth('master')->user();

        //获取路由信息
        $route = $request->route()->getAction();
//dump($route);
        //没有路由别名
        if (!isset($route['as'])) abort(403, '没有权限!');

        //替换添加路由
        $route = str_ireplace('.store', '.create', $route['as']);

        //替换编辑路由
        $route = str_ireplace('.update', '.edit', $route);

        //替换列表路由
//        $route = str_ireplace('.show', '.index', $route);

        //未登录，且不是去登录的时候，跳转到登录路由
        if (is_null($user)) {

            if ($route != 'login.login')
                return redirect('/admin/login');
            else
                return $next($request);
        }

        //已登录，且去登录路由，跳转到首页
        if ($route == 'login.login') return redirect('/admin');

        //有模型，且id为1（超级管理员）,无需验证权限
        if ($user->mid == '1') return $next($request);

        //已登录去注销
        if ($route == 'login.logout') return $next($request);

        //前往首页，无需验证
        if ($route == 'login.index') return $next($request);

        //初始化权限组类
        $power_model = new MasterPowerClass();

        //获取管理员权限组权限
        $powers = $power_model->get_storage_power($user->young_power_id);

        //进行权限判定,全权限与针对权限
        if ((!in_array('-1', $powers)) && !in_array($route, $powers)) {

            //未通过

            //没有权限报错
            abort(403, '没有权限');
        }

        return $next($request);
    }
}
