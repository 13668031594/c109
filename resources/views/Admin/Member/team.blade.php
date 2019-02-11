<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>团队信息</title>
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
          <a><cite>团队信息</cite></a>
        </span>
    </div>

    <form class="layui-form" action="/">
        <input type="hidden" id="id" name="id" value=""/>

        <div class="layui-form-item">
            <label class="layui-form-label">推荐人</label>
            <div class="layui-form-mid">
                <span class="layui-badge layui-bg-green">{{$member['referee_account']}}</span> -
                <span class="layui-badge layui-bg-green">{{$member['referee_nickname']}}</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">会员信息</label>
            <div class="layui-form-mid">
                <span class="layui-badge layui-bg-green">{{$member['phone']}}</span> -
                <span class="layui-badge layui-bg-green">{{$member['nickname']}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">团队人数</label>
            <div class="layui-form-mid">
                <span class="layui-badge layui-badge">{{$number}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">团队订单数</label>
            <div class="layui-form-mid">
                <span class="layui-badge layui-badge">{{$order_number}}</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">团队业绩</label>
            <div class="layui-form-mid">
                <span class="layui-badge layui-badge">{{$order_total}}</span>
            </div>
        </div>

        <hr>
        <div id="tree"></div>

    </form>
</div>
<script src="{{$static}}layui/layui.js"></script>
<script>
    /*var data = [{ //节点数据
        name: '妮可妮可'
        , children: [{
            name: '哇啦哇啦'
            , children: [{
                name: '黑路哦嘿'
                , children: [{
                    name: '问啦问啦'
                    , children: [{
                        name: '阿卡阿卡'
                    }]
                }]
            }]
        }]
    }, {
        name: '挖了挖了'
        , children: [{
            name: '咳咳咳咳'
        }, {
            name: '是少数'
        }]
    }];*/
    var data = {!! $team !!};
//    var data = [{"name":"\u5c0f\u6d0b\u6d0b"}];

    layui.use(['layer', 'element', 'tree'], function () {
        var tree = layui.tree;
        layui.tree({
            elem: '#tree'
            , nodes: data
            , click: function (node) {
                console.log(node) //node即为当前点击的节点数据
            }
        });

        $(function () {
            $(".layui-tree-branch").html(" ");
            $(".layui-tree-spread").on('click', function () {
                $(".layui-tree-branch").html(" ");
            });
        });
    }); //加载入口
</script>
</body>

</html>