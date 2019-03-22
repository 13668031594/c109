<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>君王战神管理登录</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/login.css">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{$static}}res/js/jquery.js"
            ></script>
</head>

<body>
<!-- 你的HTML代码 -->
<div class='layui-container login-container layui-anim layui-anim-up'>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>君王战神管理登录</legend>
    </fieldset>
    <form class="layui-form">
        <div class="layui-form-item">
            <input type="text" name="account" id='username' lay-verType='tips' lay-verify="username" autocomplete="off"
                   placeholder="请输入管理员帐号" class="layui-input" maxlength="20">
        </div>
        <div class="layui-form-item">
            <input type="password" name="password" lay-verType='tips' lay-verify="pass" autocomplete="off"
                   placeholder="请输入管理员密码" class="layui-input" maxlength="20">
        </div>
        <div class="layui-row">
            <div class="layui-col-sm6">
                <div class="layui-form-item">
                    <input type="text" name="code" lay-verType='tips' lay-verify="number|code" autocomplete="off"
                           placeholder="验证码" class="layui-input" maxlength="5">
                </div>
            </div>
            <div class="layui-col-sm6">
                <div class="layui-form-item login-code">
                    <a href='###' title='点击刷新' onclick="javascript:document.getElementById('imageCode').src='{{captcha_src()}}'+'?'+Math.random();">
                        <img id='imageCode' src='{{captcha_src()}}' alt='图片验证码' />
                    </a>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <button id='submit' class="layui-btn layui-btn-fluid" lay-filter="*" lay-submit>确认登录</button>
        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/modules/'
    }).use('login'); //加载入口
</script>
</body>
</html>