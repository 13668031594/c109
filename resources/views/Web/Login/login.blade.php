<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>登录页</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css" media="all">
    <style>
        body {
            background: #ededed;
        }

        .logo {
            width: 200px;
            height: 200px;
            /*border: 1px solid #000;*/
        }

        .container {
            margin: 0px auto;
            margin-top: 100px;
        }

        .login-container {
            max-width: 400px;
            margin: 0px auto;
        }

        .center {
            margin: 0px auto;
        }
		.layui-row{
			position: relative;
		}
		.return{
			position: absolute;
			right:10px;
			top:55px;
			cursor: pointer;
		}
        .img{
            width:200px;
            height:200px;
        }
    </style>
</head>
<body>
<div class="layui-container">
    <div class="login-container">
        <div class="logo container">
            <img src="{{$static}}img/123.png" class="img">
        </div>
        <form class="layui-form" action="/login">

            <div class="layui-row">
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-block">
                        <input type="text" name="phone" placeholder="请输入手机号"
                               autocomplete="off" class="layui-input" lay-verify="phone">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"></label>
                    <div class="layui-block">
                        <input type="password" name="password" placeholder="请输入密码"
                               autocomplete="off" class="layui-input" lay-verify="pass">
                    </div>
                </div>
            </div>

            <div class="layui-row">
                <button lay-filter="form" class="layui-btn layui-btn-fluid"
                        lay-submit>
                    确认登录
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({ base: '{{$static}}js/plugins/' })
        .use([ 'form', 'layer', 'jquery', 'mForm' ], function () {
            var form = layui.form
                , layer = layui.layer
                , $ = layui.$;

            form.verify({
                pass: [
                    /^[\S]{6,12}$/
                    , '密码必须6到12位，且不能出现空格'
                ]
            });
        });
</script>
</body>
</html>
