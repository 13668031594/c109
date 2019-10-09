<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>注册</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css" media="all">
    <style>
        body {
            background: #fff;
        }

        .container {
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
        }

        .container-content {
            flex: 1;
            width: 800px;
        }

        .content {
            width: 500px;
        }

        .layui-input-inp {
            border: 0px;
        }

        .yz-inp {

            margin-right: 150px;
        }

        .layui-form-item {
            min-width: 300px;
            margin-left: -20px;
        }

        .code {
            position: relative;
        }

        .layui-btn-danger {
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .btn {
            max-width: 500px;
            margin: 0px auto;
        }

        .tip {
            color: #c2c2c2;
            margin: 10px 5px;
        }

        #djs {
            border: 0px;
            width: 15px;
            color: #c2c2c2;
        }
    </style>
</head>
<body>
<form class="layui-form" action="">
    <div class="container">
        <div class="container-content">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>个人资料</legend>
            </fieldset>

            <div class="layui-form-item">
                <label class="layui-form-label">手机</label>
                <div class="layui-input-inline">
                    <input type="text" name="phone" required lay-verify="phone" placeholder="请输入手机号码"
                           autocomplete="off" class="layui-input" id="phone">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">登录时的手机号码</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">验证码</label>
                <div class="layui-input-inline code">
                    <input type="text" name="code" required lay-verify="pass2" placeholder="验证码" autocomplete="off"
                           maxlength="5" class="layui-input yz-inp">
                    <input type="button" class="layui-btn layui-btn-danger" lay-filter="btn" id="code" value="获取验证码">
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                    <input type="text" name="password" placeholder="初始密码为123456" class="layui-input layui-input-inp">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">家谱密码</label>
                <div class="layui-input-inline">
                    <input type="text" name="family_password" class="layui-input layui-input-inp">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                    <input type="text" name="nickname" required placeholder="请输入会员昵称" autocomplete="off"
                           class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">显示的昵称名字</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">qq号码</label>
                <div class="layui-input-inline">
                    <input type="text" name="qq" placeholder="请输入会员qq号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入会员qq号</div>
            </div>
        </div>

        <div class="container-content">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                <legend>银行信息</legend>
            </fieldset>
            <div class="tip">收款信息用于会员提现，非必填</div>

            <div class="layui-form-item">
                <label class="layui-form-label">请选择银行</label>
                <div class="layui-input-inline">
                    <select name="bank_id">
                        <option value="">请选择银行</option>
                        @foreach($bank as $v)
                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请选择银行</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">持卡人姓名</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_man" placeholder="请输入持卡人姓名" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入持卡人姓名</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">支行名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_address" placeholder="请输入支行名称" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入支行名称</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">卡号</label>
                <div class="layui-input-inline">
                    <input type="text" name="bank_no" placeholder="请输入银行卡号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入银行卡号</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">支付宝</label>
                <div class="layui-input-inline">
                    <input type="text" name="alipay" placeholder="请输入支付宝号" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入支付宝号</div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-inline">
                    <input type="text" name="note" placeholder="请输入备注" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-hide-xs">请输入备注</div>
            </div>
        </div>
    </div>

    <div class="btn">
        <button type="button" class="layui-btn layui-btn-fluid" lay-filter="form" lay-submit>确认提交</button>
    </div>

</form>
<script src="{{$static}}layui/layui.js"></script>
<script>

    layui.config({base: '{{$static}}js/plugins/'})
        .use(['form', 'layer', 'jquery', 'mForm'], function () {
            var form = layui.form
                , layer = layui.layer
                , $ = layui.$;

            form.verify({
                pass: [
                    /^[\S]{6,12}$/
                    , '密码必须6到12位，且不能出现空格'
                ],
                pass2: [
                    /^[\S]{5,5}$/
                    , '请输入正确的验证码'
                ],
                pass3: [
                    /^[\S]{}$/
                    , '请输入昵称'
                ]
            });

            function waitTime(wait) {

                // 更改按钮状态
                code.classList.add("layui-btn-disabled");
                code.setAttribute('disabled', 'disabled');
                code.value = '已发送...' + wait + 's';
                var time = setInterval(function () {
                    if (wait == 0) {
                        localStorage.removeItem("times");
                        // 还原按钮状态
                        code.classList.remove("layui-btn-disabled");
                        code.removeAttribute('disabled');
                        code.value = '重新获取';
                        clearInterval(time);
                    } else {
                        wait--;
                        code.value = '已发送...' + wait + 's';
                        localStorage.setItem("times", wait);
                    }
                }, 1000);
            }

            $('#code').click(function () {
                var phone = document.getElementById('phone').value;
                if (!(/^1[0-9]{10}$/.test(phone))) {
                    layer.msg("请输入正确的手机号码");
                    return false;
                }

                $.getJSON('/sms/' + phone, function (res) {
                    if (res.status == 'success') {
                        var timestamp=new Date().getTime().toString();
                        timestamp = timestamp.substr(0,10);
                        var wait = res.data.time - timestamp;
//                        console.log(timestamp);
//                        console.log(wait);
                        waitTime(wait);
                    } else {
                        layer.msg(res.message);
                    }
                });
            });

            localStorage.getItem("times");
            if (localStorage.getItem("times") > 0) {
                var wait = localStorage.getItem("times");
                waitTime(wait);
            }
        });


</script>
</body>
</html>