<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>主页</title>
    <link rel="stylesheet" href="{{$static}}layui/css/layui.css">
    <link rel="stylesheet" href="{{$static}}css/homepage.css">
    <link rel="stylesheet" href="{{$static}}css/common.css">
</head>
<body>
<div class="subject">
    <div class="head">
        <div class="layui-row">
            <div class="layui-col-sm6 layui-col-xs6" style="text-align: left">
                <a style="margin-left:20px;" href="###">专属客服：{{$customer['nickname']}},{{$customer['text']}}</a>
            </div>
            <div class="layui-col-sm6 layui-col-xs6" style="text-align: right">
                <ul class="layui-nav" lay-filter="">
                    <li class="layui-nav-item">
                        <a href="javascript:;">{{$member['nickname']}}</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;" onclick="page(this)" data-menu="self">个人资料</a></dd>
                            <dd><a href="javascript:;" onclick="out(this)">安全退出</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <!--<div class="layui-col-lg10 layui-col-xs6">
                <a href="javascript:;">点击专属客服：小蔡</a>
            </div>
            <div class="layui-col-lg1 layui-col-xs3 alignment">
                <a href="javascript:;">恭喜发财</a>
            </div>
            <div class="layui-col-lg1 layui-col-xs3 alignment">
                <div class="">
                    <a>退出</a>
                    <i class="layui-icon" style="font-size: 14px; color: #FF5722;margin-right:10px;">&#x1006</i>
                </div>
            </div>-->
        </div>
    </div>

    <div class="container">
        <div id="hide" onclick="hide(this)"></div>
        <div class="menu layui-show-sm-block layui-anim layui-anim-left layui-col-xs5 layui-col-lg2" id="menu">
            <ul class="layui-nav layui-nav-tree" lay-filter="test">
                <li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="/homepage">
                        <i class="layui-icon layui-icon-home"></i> 桌面
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="/market">
                        <i class="layui-icon layui-icon-diamond"></i> 交易市场
                    </a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="/wallet">
                        <i class="layui-icon layui-icon-rmb"></i> 钱包管理
                    </a>
                </li>
                <!--<li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="ddd">
                        <i class="layui-icon layui-icon-username"></i> 个人中心
                    </a>
                </li>-->
                <li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="/team">
                        <i class="layui-icon layui-icon-user"></i> 我的团队
                    </a>
                </li>
				
				<li class="layui-nav-item">
                    <a href="javascript:;" onclick="page(this)" data-menu="/register">
                        <i class="layui-icon layui-icon-add-1"></i> 新增推广员
                    </a>
                </li>
                <!-- <li class="layui-nav-item"><a href="">产品</a></li>
                 <li class="layui-nav-item"><a href="">大数据</a></li>
                 <li class="layui-nav-item layui-nav-itemed">
                     <dl class="layui-nav-child">
                         <dd><a href="javascript:;" onclick="page(this)" data-menu="index/homepage">首页</a></dd>
                         <dd><a href="javascript:;" onclick="page(this)" data-menu="bbb">贡献值</a></dd>
                         <dd><a href="javascript:;" onclick="page(this)" data-menu="index/qianbao">钱包</a></dd>
                         <dd><a href="javascript:;" onclick="page(this)" data-menu="ddd">我的</a></dd>
                     </dl>
                 </li>-->
            </ul>
        </div>
        <div class="introduce">
            <iframe src="/homepage" frameborder="0" style="width:100%;height:100%;" id="introduce"></iframe>
        </div>
    </div>
</div>

<div class="bottom-menu layui-hide-sm" onclick="bottom_menu(this)">
    <a>菜单</a>
</div>
</body>
<script src="{{$static}}layui/layui.js"></script>
<script src="{{$static}}js/index.js"></script>
<script>
    layui.use([ 'element','layer' ], function () {

    });
    function out(obj){
        layer.confirm('确定退出?', {icon: 3, title:'提示'}, function(index){
            window.location.href = 'logout';
            layer.close(index);
        });
    }
</script>
</html>
