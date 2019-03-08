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
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"

    ></script>
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo" style="color:#fff;">君王战神管理系统</div>
        <div class="layui-layout-left">
            <ul class="layui-nav layui-op">
                <li class="layui-nav-item1"><a id='back' href="javascript:;"><i
                                class="layui-icon layui-icon-return"></i> 返回</a></li>
                <li class="layui-nav-item1"><a id='refresh' href="javascript:;"><i
                                class="layui-icon layui-icon-refresh"></i> 刷新</a></li>
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
                @if(in_array('system',$powers) || in_array('-1',$powers))
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-app"></i> 系统管理</a>
                        <dl class="layui-nav-child">
                            @if(in_array('set.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/set'><i
                                                class="layui-icon layui-icon-set-sm"></i> 系统设置</a></dd>
                            @endif
                            @if(in_array('prompt.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/prompt/index'><i
                                                class="layui-icon layui-icon-set-sm"></i> 提示文字</a></dd>
                            @endif
                            @if(in_array('notice.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/notice/index'><i
                                                class="layui-icon layui-icon-set-sm"></i> 公告列表</a></dd>
                            @endif
                            @if(in_array('bank.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/bank/index'><i
                                                class="layui-icon layui-icon-file"></i> 银行列表</a></dd>
                            @endif
                            @if(in_array('bank.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/master/index'><i
                                                class="layui-icon layui-icon-face-smile-fine"></i> 管理员列表</a></dd>
                            @endif
                        </dl>
                    </li>
                @endif
                @if(in_array('member',$powers) || in_array('-1',$powers))
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i> 会员管理</a>
                        <dl class="layui-nav-child">
                            @if(in_array('member.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/member/index'><i
                                                class="layui-icon layui-icon-user"></i> 会员列表</a></dd>
                            @endif
                            @if(in_array('rank.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/rank/index'><i
                                                class="layui-icon layui-icon-file"></i> 等级列表</a></dd>
                            @endif
                            @if(in_array('customer.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/customer/index'><i
                                                class="layui-icon layui-icon-file"></i> 客服列表</a></dd>
                            @endif
                        </dl>
                    </li>
                @endif

                @if(in_array('order',$powers) || in_array('-1',$powers))
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-console"></i> 订单管理</a>
                        <dl class="layui-nav-child">
                            @if(in_array('buy.index',$powers) || in_array('-1',$powers))
                                <dd class="layui-this"><a href="javascript:;" data-menu='/admin/buy/index'><i
                                                class="layui-icon layui-icon-log"></i> 采集列表</a></dd>
                            @endif
                            @if(in_array('sell.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/sell/index'><i
                                                class="layui-icon layui-icon-log"></i> 寄售列表</a></dd>
                            @endif
                            @if(in_array('match.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/match/index'><i
                                                class="layui-icon layui-icon-log"></i> 匹配列表</a></dd>
                            @endif
                            @if(in_array('trad.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/trad/index'><i
                                                class="layui-icon layui-icon-log"></i> 贡献点交易</a></dd>
                            @endif
                        </dl>
                    </li>
                @endif
                @if(in_array('bill',$powers) || in_array('-1',$powers))
                    <li class="layui-nav-item layui-nav-itemed">
                        <a class="" href="javascript:;"><i class="layui-icon layui-icon-username"></i> 统计</a>
                        <dl class="layui-nav-child">
                            @if(in_array('bill.index',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/bill/index'><i
                                                class="layui-icon layui-icon-set-sm"></i> 统计</a></dd>
                            @endif
                            @if(in_array('bill.match_simu',$powers) || in_array('-1',$powers))
                                <dd><a href="javascript:;" data-menu='/admin/match-simu/index'><i
                                                class="layui-icon layui-icon-set-sm"></i> 预匹配</a></dd>
                            @endif
                        </dl>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- 内容主体区域 -->
    <div class="layui-body" style='bottom:0;'>
        <!-- 默认地址 -->
        <iframe style="vertical-align:top;" id='iframeMain' name='iframeMain' src="/admin/buy/index" width='100%'
                height='100%' frameborder="0" class="layadmin-iframe"></iframe>
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