<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>会员钱包</title>
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
          <a href="javascript:;">会员列表</a>
          <a href="javascript:;">{{$self['nickname']}}</a>
          <a><cite>钱包</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/admin/member/wallet">

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
                        <td>状态/身份</td>
                        <td>
                            <span class="layui-badge layui-bg-blue">{{$status[$self['status']]}}</span>
                            <span class="layui-badge layui-bg-blue">{{$act[$self['act']]}}</span>
                            <span class="layui-badge layui-bg-green">{{$mode[$self['mode']]}}</span>
                            <span class="layui-badge layui-bg">{{$grade[$self['grade']]}}</span>
                            <span class="layui-badge layui-bg-gray">{{$type[$self['type']]}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>余额/累计</td>
                        <td>{{$self['balance']}}/{{$self['balance_all']}}</td>
                    </tr>
                    <tr>
                        <td>手续费/累计</td>
                        <td>{{$self['poundage']}}/{{$self['poundage_all']}}</td>
                    </tr>
                    <tr>
                        <td>奖励账户/累计</td>
                        <td>{{$self['reward']}}/{{$self['reward_all']}}</td>
                    </tr>
                    <tr>
                        <td>贡献点/累计</td>
                        <td>{{$self['gxd']}}/{{$self['gxd_all']}}</td>
                    </tr>
                    <tr>
                        <td>银行信息</td>
                        <td>{{$self['bank_name']}}/{{$self['bank_man']}}/{{$self['bank_no']}}</td>
                    </tr>
                    <tr>
                        <td>注册时间</td>
                        <td>{{$self['created_at']}}</td>
                    </tr>
                    <tr>
                        <td>激活时间</td>
                        <td>
                            @if(empty($self['act_time']))

                                <a class="layui-btn layui-btn-xs layui-btn-normal" id="act" data-id="{{$self['uid']}}"
                                   href="javascript:;">立即激活</a>
                            @else
                                {{$self['act_time']}}/{{$act_from[$self['act_from']]}}
                            @endif
                        </td>

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
                                <select name="type" lay-filter="type">
                                    <option value="0">余额</option>
                                    <option value="1">手续费</option>
                                    <option value="2">奖励账户</option>
                                    <option value="3">贡献点</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">充值数量</label>
                            <div class="layui-input-block">
                                <input type="text" name="number" required title="充值数量" lay-verify="required|number"
                                       placeholder="请输入充值数量"
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
        form.on('select(type)', function (data) {
            console.log(data);
            if (data.value == 0) {
                $("#assetTypeContainer").show();
            } else {
                $("#assetTypeContainer").hide();
            }
        });

        $("#act").on('click', function () {

            var id = $(this).data('id');

            layer.confirm('您确认要激活吗?该操作不可逆', function (index) {
                layer.close(index);
                window.location.href = '/admin/member/act?id=' + id
            });
        });
    });
</script>
</body>
</html>