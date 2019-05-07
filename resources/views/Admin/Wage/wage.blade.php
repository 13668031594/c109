<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>工资</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{$static}}res/js/jquery.js"

            ></script>
</head>

<div class="layui-fluid">

    <div class="layui-row m-breadcrumb">
        <span class="layui-breadcrumb" lay-separator="/">
          <a href="javascript:;">首页</a>
          <a href="javascript:;">工资</a>
          <a href="javascript:;">{{$self['nickname']}}</a>
          <a><cite>工资发放</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/wage/wage">

        <div class="layui-row">
            <div class="layui-col-sm5">
                <table class="layui-table">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                    </colgroup>
                    <tbody>
                    <tr>
                        <td>帐号</td>
                        <td>{{$self['account']}}</td>
                    </tr>
                    <tr>
                        <td>手机</td>
                        <td>{{$self['phone']}}</td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td>{{$self['email']}}</td>
                    </tr>
                    <tr>
                        <td>昵称</td>
                        <td>{{$self['nickname']}}</td>
                    </tr>
                    <tr>
                        <td>工资/累计</td>
                        <td>{{$self['wage']}}/{{$self['wage_all']}}</td>
                    </tr>
                    <tr>
                        <td>银行信息</td>
                        <td>{{$self['bank_name']}}/{{$self['bank_man']}}/{{$self['bank_no']}}</td>
                    </tr>
                    <tr>
                        <td>注册时间</td>
                        <td>{{$self['created_at']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @if(in_array('member.wallet_change',$powers) || in_array('-1',$powers))
                <div class="layui-col-sm7 layui-anim layui-anim-upbit">
                    <div style="max-width:400px;margin-top:10px;">

                        <!-- 编辑时写入id -->
                        <input type='hidden' id='id' name="id" value='{{$self["uid"]}}'/>

                        <div class="layui-form-item">
                            <label class="layui-form-label">操作类型</label>
                            <div class="layui-input-block">
                                <select id="select" name="type" lay-filter="type">
                                    <option value="0">工资</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">充值数量</label>
                            <div class="layui-input-block">
                                <input id="number" type="text" name="number" required title="发放数量"
                                       lay-verify="required|number"
                                       placeholder="请输入发放数量"
                                       autocomplete="off" class="layui-input" value='0'/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" id='submit' lay-submit lay-filter="*">立即提交</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    layui.config({
        base: '{{$static}}res/js/common/'
    }).use(['mForm', 'layer', 'jquery', 'element', 'form'], function () {

        var form = layui.form;
    });
</script>
</body>
</html>