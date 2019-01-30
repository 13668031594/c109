<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>君王战神管理系统</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}res/css/common.css">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" >
        <div class="layui-logo" style="color:#fff;">君王战神管理系统</div>
        <div class="layui-layout-left">
            <ul class="layui-nav layui-op">
                <li class="layui-nav-item1"><a id='back' href="javascript:;"><i class="layui-icon layui-icon-return"></i> 返回</a></li>
                <li class="layui-nav-item1"><a id='refresh' href="javascript:;"><i class="layui-icon layui-icon-refresh"></i> 刷新</a></li>
            </ul>
        </div>
        <div class="layui-layout-right">
            <ul class="layui-nav">
                <li class="layui-nav-item">
                    <a href="#">{{$master['nickname']}}</a>
                    <dl class="layui-nav-child">
                        <dd><a href="/admin/master/edit?id={{$master['mid']}}">修改资料</a></dd>
                        <dd><a id='loginout' href="javascript:;">退出系统</a></dd>
                    </dl>
                </li>
               <!-- <li class="layui-nav-item">
                    <a href="###" id='loginout'><i class="layui-icon layui-icon-close-fill"></i> 退出</a>
                </li>-->
            </ul>
        </div>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-app"></i> 系统管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-menu='/admin/set'><i class="layui-icon layui-icon-set-sm"></i> 系统设置</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/prompt/index'><i class="layui-icon layui-icon-set-sm"></i> 提示文字</a></dd>
                        <!--<dd><a href="javascript:;" data-menu='/admin/express/index'><i class="layui-icon layui-icon-engine"></i> 快递列表</a></dd>-->
                        <!--<dd><a href="javascript:;" data-menu='/admin/avatar/index'><i class="layui-icon layui-icon-theme"></i> 头像列表</a></dd>-->
                        <dd><a href="javascript:;" data-menu='/admin/bank/index'><i class="layui-icon layui-icon-file"></i> 银行列表</a></dd>
                        {{--<dd><a href="javascript:;" data-menu='/admin/welfare/index'><i class="layui-icon layui-icon-file"></i> 福利奖列表</a></dd>--}}
                        {{--<dd><a href="javascript:;" data-menu='/admin/notice/index'><i class="layui-icon layui-icon-file"></i> 公告列表</a></dd>--}}
                        {{--<dd><a href="javascript:;" data-menu='/admin/adv/index'><i class="layui-icon layui-icon-file"></i> 广告列表</a></dd>--}}
                        <dd class="layui-this"><a href="javascript:;" data-menu='/admin/master/index'><i class="layui-icon layui-icon-face-smile-fine"></i> 管理员列表</a></dd>
                    </dl>
                </li>

                <!--<li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-tabs"></i> 页面设置</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-menu='/admin/banner/index'><i class="layui-icon layui-icon-picture"></i> banner</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/adv/index'><i class="layui-icon layui-icon-link"></i> 广告管理</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="javascript:;" data-menu='/admin/notice/index'><i class="layui-icon layui-icon-notice"></i> 公告管理</a></li>
                <li class="layui-nav-item"><a href="javascript:;" data-menu='/admin/article/index'><i class="layui-icon layui-icon-survey"></i> 文章管理</a></li>
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-layouts"></i> 导航管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-menu='/admin/nav/index'><i class="layui-icon layui-icon-set-sm"></i> 导航设置</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/link/index'><i class="layui-icon layui-icon-spread-left"></i> 快捷导航</a></dd>
                    </dl>
                </li>-->
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i> 会员管理</a>
                    <dl class="layui-nav-child">
                        <!--<dd><a href="javascript:;" data-menu='/admin/member_grade/index'><i class="layui-icon layui-icon-set-sm"></i> 等级管理</a></dd>-->
                        <dd><a href="javascript:;" data-menu='/admin/member/index'><i class="layui-icon layui-icon-user"></i> 会员列表</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/rank/index'><i class="layui-icon layui-icon-file"></i> 等级列表</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/customer/index'><i class="layui-icon layui-icon-file"></i> 客服列表</a></dd>
                    </dl>
                </li>
                <!--<li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-cart-simple"></i> 商品管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-menu='/admin/goods_class/index'><i class="layui-icon layui-icon-tips"></i> 商品分类</a></dd>
                        <dd><a href="javascript:;" data-menu='/admin/goods/index'><i class="layui-icon layui-icon-cart"></i> 商品列表</a></dd>
                    </dl>
                </li>-->
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;"><i class="layui-icon layui-icon-console"></i> 订单管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-menu='/admin/buy/index'><i class="layui-icon layui-icon-log"></i> 采集列表</a></dd>
                        {{--<dd><a href="javascript:;" data-menu='/admin/withdraw/index'><i class="layui-icon layui-icon-log"></i> 提现记录</a></dd>--}}
                        {{--<dd><a href="javascript:;" data-menu='/admin/exchange/index'><i class="layui-icon layui-icon-log"></i> 兑换列表</a></dd>--}}
                        {{--<dd><a href="javascript:;" data-menu='/admin/trade/index'><i class="layui-icon layui-icon-log"></i> 交易记录</a></dd>--}}
                        <!--<dd><a href="javascript:;" data-menu='/admin/send/index'><i class="layui-icon layui-icon-log"></i> 发货列表</a></dd>-->
                        <!--<dd><a href="javascript:;" data-menu='/admin/send/bat'><i class="layui-icon layui-icon-util"></i> 批量发货</a></dd>-->
                    </dl>
                </li>
                {{--<li class="layui-nav-item layui-nav-itemed">
                <a class="" href="javascript:;"><i class="layui-icon layui-icon-layouts"></i> 统计</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" data-menu='/admin/bill/total'><i class="layui-icon layui-icon-spread-left"></i> 销售额</a></dd>
                    <dd><a href="javascript:;" data-menu='/admin/bill/member'><i class="layui-icon layui-icon-spread-left"></i> 会员新增</a></dd>
                    <dd><a href="javascript:;" data-menu='/admin/bill/withdraw'><i class="layui-icon layui-icon-spread-left"></i> 会员新增</a></dd>
                </dl>
                </li>--}}

            </ul>
        </div>
    </div>

    <!-- 内容主体区域 -->
    <div class="layui-body" style='bottom:0;'>
        <!-- 默认地址 -->
        <iframe style="vertical-align:top;" id='iframeMain' name='iframeMain' src="/admin/master/index" width='100%' height='100%' frameborder="0" class="layadmin-iframe"></iframe>
    </div>

</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'jquery', 'layer'], function () {
        var element = layui.element
            , layer = layui.layer;

        $("#loginout").on('click', function () {
            layer.confirm('您确认要退出吗?', function (index) {
                layer.close(index);
                window.location.href = '/admin/logout'
            });
        });

        $("#back").on('click', function () {
            window.history.back();
        })

        $("#refresh").on('click', function () {
            $('#iframeMain').attr('src', $('#iframeMain').prop('src'));
        })

    });
    $(".layui-side-scroll li a").on('click', function () {
        if ($(this).data('menu')) {
            $("#iframeMain").prop('src', $(this).data('menu'));
        }
    });
</script>
</body>

</html>