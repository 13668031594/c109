<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理员</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a href="javascript:;">管理员列表</a>
          <a><cite>{{isset($self) ? '编辑' : '添加'}}</cite></a>
        </span>
    </div>

    <form class="layui-form layui-form-min" action="/admin/master/{{isset($self) ? 'update/'.$self['mid'] : 'store'}}">

        <div class="layui-form-item">
            <label class="layui-form-label">管理员帐号</label>
            <div class="layui-input-block">
                <input type="text" name="account" lay-verify="account" placeholder="请输入管理员帐号" autocomplete="off"
                       class="layui-input" value='{{isset($self) ? $self['account'] : ''}}'
                       maxlength="20" {{isset($self) ? 'readonly' : null}}/>
                <!-- 编辑时 input 结束改为 readonly/>  -->
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nickname" required lay-verify="required" placeholder="请输入管理员昵称"
                       autocomplete="off" class="layui-input" value='{{isset($self) ? $self['nickname'] : ''}}'>
            </div>
        </div>

        <input type="hidden" name="power_id" value="100000">
        {{--<div class="layui-form-item">
            <label class="layui-form-label">管理员权限</label>
            <div class="layui-input-block">
                <select name="power">
                    @if(count($powers) >0)
                        @foreach($powers as $v)
                            <option value="{{$v['id']}}" {{(isset($self) && ($self['power_id'] == $v['id'])) ? 'selected' : ''}}>{{$v['name']}}
                        @endforeach
                    @endif
                </select>
            </div>
        </div>--}}

        @if (isset($self))
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <blockquote class="layui-elem-quote">如不修改密码，请勿操作密码</blockquote>
                </div>
            </div>
        @endif

        <div class="layui-form-item">
            <label class="layui-form-label">管理员密码</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="password" name="password" required lay-verify="pass" placeholder="请输入管理员密码"
                       autocomplete="off" class="layui-input" value="{{isset($self) ? 'sba___duia' : '123456'}}"
                       maxlength="20">
            </div>
            <div class="layui-form-mid layui-word-aux">初始密码为：123456</div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" id='submit' lay-submit lay-filter="*">立即提交</button>
                <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
            </div>
        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element'], function () {

    }); //加载入口
</script>
</body>

</html>