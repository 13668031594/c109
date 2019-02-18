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

    <form class="layui-form" action="/admin/member/team" method="get">
        <div class="layui-form-item form-radio-type" style='height:60px;'>
            <input type="hidden" name="type" value="4"/>
            <input type="hidden" name="id" value="{{$member['uid']}}"/>
            <ul id="order-type">
                <li lang="1" @if($type=='today')class="choice"@endif><a href="/admin/member/team?id={{$member['uid']}}&type=today">今日</a></li>
                <li lang="2" @if($type=='yesterday')class="choice"@endif><a
                            href="/admin/member/team?id={{$member['uid']}}&type=yesterday">昨日</a></li>
                <li lang="3" @if($type=='4')class="choice"@endif>时间段</li>
                <li lang="4" @if($type=='1')class="choice"@endif><a href="/admin/member/team?id={{$member['uid']}}&type=1">本月</a></li>
                <li lang="" @if($type=='all')class="choice"@endif><a href="/admin/member/team?id={{$member['uid']}}&type=all">全部</a></li>
            </ul>
            <div class="layui-inline time-interval" @if($type!='4')style="overflow: hidden; display:none;"@endif>
                <label class="layui-form-label" style="width: 70px;">选择时间段</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-start" name="startTime"
                           placeholder="开始时间" @if($type=='4')value="{{$begin}}"@endif>
                </div>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" id="time-end" name="endTime" placeholder="结束时间"
                           @if($type=='4')value="{{$end}}"@endif>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit lay-filter="count">搜索</button>
                </div>
            </div>
        </div>
    </form>

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

    layui.use(['layer', 'element', 'tree', 'laydate'], function () {
        var tree = layui.tree;

        var laydate = layui.laydate;

        $('#order-type li').click(function () {
            $('#order-type li').each(function () {
                $(this).prop('class', '');
            });
            $('#time-type').val($(this).prop('lang'));
            $(this).prop('class', 'choice');
            if ($(this).prop('lang') == '3') {
                $('.time-interval').show();
            } else {
                $('.time-interval').hide();
            }
        });

        $('#order-type2 li').click(function () {
            $('#order-type2 li').each(function () {
                $(this).prop('class', '');
            });
            $('#time-type2').val($(this).prop('lang'));
            $(this).prop('class', 'choice');
            if ($(this).prop('lang') == '4') {
                $('.time-interval2').show();
            } else {
                $('.time-interval2').hide();
            }

            MyChart.setWhere({
                startTime: '',
                endTime: '',
                type: $("#time-type2").val()
            });

            MyChart.refreshCharts();
        });

        $("#chartClick").click(function () {
            MyChart.setWhere({
                startTime: $("#time-start2").val(),
                endTime: $("#time-end2").val(),
                type: $("#time-type2").val()
            });
            MyChart.refreshCharts();
        });

        laydate.render({
            elem: '#time-start', //指定元素
//            format: 'HH:mm',
//            type:'time',
        });

        laydate.render({
            elem: '#time-end', //指定元素
        });

        laydate.render({
            elem: '#time-start2', //指定元素
        });

        laydate.render({
            elem: '#time-end2', //指定元素
        });

        MyChart.init(myEChart);
        MyChart.create();

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